<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relacion extends Model
{
    use HasFactory;

    protected $table = 'leonardorelacion';
    protected $primaryKey = 'id_relacion';
    public $timestamps = false;

    protected $fillable = [
        'id_columna_1',
        'id_columna_2',
        'color_relacion',
    ];

    public function columnaOrigen()
    {
        return $this->belongsTo(
            Columna::class,
            'id_columna_1',
            'id_columna'
        );
    }

    public function columnaDestino()
    {
        return $this->belongsTo(
            Columna::class,
            'id_columna_2',
            'id_columna'
        );
    }
}
