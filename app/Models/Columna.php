<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Columna extends Model
{
use HasFactory;

    protected $table = 'leonardocolumna';

    protected $primaryKey = 'id_columna';

    public $timestamps = false;

    protected $fillable = [
        'id_tabla',
        'nombre_columna',
        'tipo_columna',
        'longitud_columna',
        'cotejamiento_columna',
        'nulo_columna',
        'auto_incrementar',
        'indice_tipo',
        'descripcion_columna',
        'fecha_registro',
    ];

    public function tabla()
    {
        return $this->belongsTo(Data::class, 'id_tabla', 'id_tabla');
    }

}
