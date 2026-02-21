<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Proyecto;
use App\Models\Data;
use App\Models\Columna;
use App\Models\Relacion;
use App\Models\Posision;

class ImportarController extends Controller
{
    public function importar(Request $request)
{
    try {
        $request->validate([
            'sql'         => 'required|string',
            'tipo_db'     => 'required|string|in:MYSQL,POSTGRED',
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $sql  = $request->sql;
        $tipo = $request->tipo_db;

        if ($tipo === 'MYSQL') {
            $tablasParsadas = $this->parsearMySQL($sql);
        } else {
            $tablasParsadas = $this->parsearPostgreSQL($sql);
        }

        if (empty($tablasParsadas)) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron tablas válidas en el SQL'
            ], 400);
        }

        $proyecto = Proyecto::create([
            'nombre'         => $request->nombre,
            'descripcion'    => $request->descripcion ?? 'Importado desde ' . $tipo,
            'tipo_db'        => $tipo,
            'estado'         => 1,
            'id_usuario'     => $user->id_usuario,
            'creado_por'     => $user->id_usuario,
            'fecha_registro' => now(),
        ]);

        $posX = 100;
        $posY = 100;
        $columnasMap = [];

        foreach ($tablasParsadas as $tablaData) {
            $tabla = Data::create([
                'nombre_tabla'   => $tablaData['nombre'],
                'color_tabla'    => sprintf(
                    '#%02X%02X%02X',
                    mt_rand(0, 120),
                    mt_rand(0, 120),
                    mt_rand(0, 120)
                ),
                'id_proyecto'    => $proyecto->id_proyecto,
                'fecha_registro' => now(),
            ]);

            Posision::create([
                'id_tabla' => $tabla->id_tabla,
                'pos_x'    => $posX,
                'pos_y'    => $posY,
            ]);

            $posX += 320;
            if ($posX > 1200) {
                $posX = 100;
                $posY += 250;
            }

            foreach ($tablaData['columnas'] as $colData) {
                $columna = Columna::create([
                    'nombre_columna'       => $colData['nombre'],
                    'descripcion_columna'  => $colData['descripcion'] ?? $colData['nombre'],
                    'tipo_columna'         => $colData['tipo'],
                    'longitud_columna'     => $colData['longitud'] ?? null,
                    'cotejamiento_columna' => $colData['cotejamiento'] ?? null,
                    'nulo_columna'         => $colData['nulo'] ?? true,
                    'auto_incrementar'     => $colData['auto_incrementar'] ?? false,
                    'indice_tipo'          => $colData['indice'] ?? null,
                    'id_tabla'             => $tabla->id_tabla,
                    'fecha_registro'       => now(),
                ]);

                $columnasMap[$tablaData['nombre']][$colData['nombre']] = $columna->id_columna;
            }
        }

        foreach ($tablasParsadas as $tablaData) {
            if (empty($tablaData['foreign_keys'])) continue;

            foreach ($tablaData['foreign_keys'] as $fk) {
                $idColumnaOrigen  = $columnasMap[$tablaData['nombre']][$fk['columna']] ?? null;
                $idColumnaDestino = $columnasMap[$fk['tabla_ref']][$fk['columna_ref']] ?? null;

                if (!$idColumnaOrigen || !$idColumnaDestino) continue;

                Relacion::create([
                    'id_columna_1'   => $idColumnaOrigen,
                    'id_columna_2'   => $idColumnaDestino,
                    'color_relacion' => '#8b5cf6',
                ]);
            }
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Base de datos importada correctamente',
            'id_proyecto' => $proyecto->id_proyecto,
            'tablas'      => count($tablasParsadas)
        ], 201);

    } catch (\Exception $e) {
        \Log::error('Error al importar DB: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al importar: ' . $e->getMessage()
        ], 500);
    }
}

    private function parsearMySQL($sql)
{
    $tablas = [];

    preg_match_all(
        '/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?[`"]?(\w+)[`"]?\s*\((.*?)\)\s*(?:ENGINE|;)/si',
        $sql,
        $matches,
        PREG_SET_ORDER
    );

    foreach ($matches as $match) {
        $nombreTabla = $match[1];
        $cuerpo      = $match[2];
        $columnas    = [];
        $foreignKeys = [];

        $lineas = explode("\n", $cuerpo);

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (empty($linea)) continue;

            if (preg_match('/FOREIGN\s+KEY\s*\([`"]?(\w+)[`"]?\)\s+REFERENCES\s+[`"]?(\w+)[`"]?\s*\([`"]?(\w+)[`"]?\)/i', $linea, $fkMatch)) {
                $foreignKeys[] = [
                    'columna'     => $fkMatch[1],
                    'tabla_ref'   => $fkMatch[2],
                    'columna_ref' => $fkMatch[3],
                ];
                continue;
            }

            if (preg_match('/^\s*PRIMARY\s+KEY/i', $linea)) continue;
            if (preg_match('/^\s*UNIQUE\s+KEY/i', $linea)) continue;
            if (preg_match('/^\s*KEY\s+/i', $linea)) continue;
            if (preg_match('/^\s*CONSTRAINT/i', $linea)) continue;

            if (preg_match('/^[`"]?(\w+)[`"]?\s+(\w+)(\([\d,]+\))?(.*)/i', $linea, $colMatch)) {
                $nombreCol = $colMatch[1];
                $tipoCol   = strtoupper($colMatch[2]);
                $longitud  = isset($colMatch[3]) ? trim($colMatch[3], '()') : null;
                $resto     = strtoupper($colMatch[4] ?? '');

                $nulo          = !str_contains($resto, 'NOT NULL');
                $autoIncrement = str_contains($resto, 'AUTO_INCREMENT');
                $indice        = null;

                if (str_contains($resto, 'PRIMARY KEY') || str_contains($resto, 'AUTO_INCREMENT')) {
                    $indice = 'PRIMARY KEY';
                }

                $descripcion = $nombreCol;
                if (preg_match("/COMMENT\s+'([^']+)'/i", $linea, $commentMatch)) {
                    $descripcion = $commentMatch[1];
                }

                $columnas[] = [
                    'nombre'          => $nombreCol,
                    'tipo'            => $tipoCol,
                    'longitud'        => $longitud,
                    'nulo'            => $nulo,
                    'auto_incrementar'=> $autoIncrement,
                    'indice'          => $indice,
                    'descripcion'     => $descripcion,
                ];
            }
        }

        $tablas[] = [
            'nombre'      => $nombreTabla,
            'columnas'    => $columnas,
            'foreign_keys'=> $foreignKeys,
        ];
    }

    preg_match_all(
        '/ALTER\s+TABLE\s+[`"]?(\w+)[`"]?\s+ADD\s+CONSTRAINT\s+[`"]?\w+[`"]?\s+FOREIGN\s+KEY\s*\([`"]?(\w+)[`"]?\)\s+REFERENCES\s+[`"]?(\w+)[`"]?\s*\([`"]?(\w+)[`"]?\)/si',
        $sql,
        $alterMatches,
        PREG_SET_ORDER
    );

    foreach ($alterMatches as $alter) {
        $nombreTabla  = $alter[1];
        $columnaOrigen = $alter[2];
        $tablaRef      = $alter[3];
        $columnaRef    = $alter[4];

        foreach ($tablas as &$tabla) {
            if ($tabla['nombre'] === $nombreTabla) {
                $tabla['foreign_keys'][] = [
                    'columna'     => $columnaOrigen,
                    'tabla_ref'   => $tablaRef,
                    'columna_ref' => $columnaRef,
                ];
                break;
            }
        }
        unset($tabla);
    }

    return $tablas;
}

private function parsearPostgreSQL($sql)
{
    $tablas = [];

    preg_match_all(
        '/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?"?(\w+)"?\s*\((.*?)\);/si',
        $sql,
        $matches,
        PREG_SET_ORDER
    );

    foreach ($matches as $match) {
        $nombreTabla = $match[1];
        $cuerpo      = $match[2];
        $columnas    = [];
        $foreignKeys = [];

        $lineas = explode("\n", $cuerpo);

        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if (empty($linea)) continue;

            if (preg_match('/FOREIGN\s+KEY\s*\("?(\w+)"?\)\s+REFERENCES\s+"?(\w+)"?\s*\("?(\w+)"?\)/i', $linea, $fkMatch)) {
                $foreignKeys[] = [
                    'columna'     => $fkMatch[1],
                    'tabla_ref'   => $fkMatch[2],
                    'columna_ref' => $fkMatch[3],
                ];
                continue;
            }

            if (preg_match('/^\s*PRIMARY\s+KEY/i', $linea)) continue;
            if (preg_match('/^\s*CONSTRAINT/i', $linea)) continue;
            if (preg_match('/^\s*UNIQUE/i', $linea)) continue;

            if (preg_match('/^"?(\w+)"?\s+(\w+(?:\s+\w+)?)(\([\d,]+\))?(.*)/i', $linea, $colMatch)) {
                $nombreCol = $colMatch[1];
                $tipoRaw   = strtoupper(trim($colMatch[2]));
                $tipoCol   = explode(' ', $tipoRaw)[0];

                if ($tipoCol === 'TIMESTAMP' && str_contains($tipoRaw, 'WITH')) {
                    $tipoCol = 'TIMESTAMP WITH TIME ZONE';
                } elseif ($tipoCol === 'TIME' && str_contains($tipoRaw, 'WITH')) {
                    $tipoCol = 'TIME WITH TIME ZONE';
                } elseif ($tipoCol === 'DOUBLE' && str_contains($tipoRaw, 'PRECISION')) {
                    $tipoCol = 'DOUBLE PRECISION';
                }

                $longitud = isset($colMatch[3]) ? trim($colMatch[3], '()') : null;
                $resto    = $colMatch[4] ?? '';

                $lineaCompleta = $tipoRaw . ' ' . strtoupper($resto);
                $nulo   = !preg_match('/NOT\s+NULL/i', $lineaCompleta);
                $indice = null;

                if (in_array($tipoCol, ['SERIAL', 'BIGSERIAL', 'SMALLSERIAL'])) {
                    $indice = 'PRIMARY KEY';
                }

                if (preg_match('/PRIMARY\s+KEY/i', $lineaCompleta)) {
                    $indice = 'PRIMARY KEY';
                }

                $columnas[] = [
                    'nombre'          => $nombreCol,
                    'tipo'            => $tipoCol,
                    'longitud'        => $longitud,
                    'nulo'            => $nulo,
                    'auto_incrementar'=> in_array($tipoCol, ['SERIAL', 'BIGSERIAL', 'SMALLSERIAL']),
                    'indice'          => $indice,
                    'descripcion'     => $nombreCol,
                ];
            }
        }

        $tablas[] = [
            'nombre'      => $nombreTabla,
            'columnas'    => $columnas,
            'foreign_keys'=> $foreignKeys,
        ];
    }

    preg_match_all(
        '/ALTER\s+TABLE\s+"?(\w+)"?\s+ADD\s+CONSTRAINT\s+"?\w+"?\s+FOREIGN\s+KEY\s*\("?(\w+)"?\)\s+REFERENCES\s+"?(\w+)"?\s*\("?(\w+)"?\)/si',
        $sql,
        $alterMatches,
        PREG_SET_ORDER
    );

    foreach ($alterMatches as $alter) {
        $nombreTabla   = $alter[1];
        $columnaOrigen = $alter[2];
        $tablaRef      = $alter[3];
        $columnaRef    = $alter[4];

        foreach ($tablas as &$tabla) {
            if ($tabla['nombre'] === $nombreTabla) {
                $tabla['foreign_keys'][] = [
                    'columna'     => $columnaOrigen,
                    'tabla_ref'   => $tablaRef,
                    'columna_ref' => $columnaRef,
                ];
                break;
            }
        }
        unset($tabla);
    }

    return $tablas;
}
}