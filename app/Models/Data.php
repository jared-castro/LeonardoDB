<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $table = 'leonardotablas';

    protected $primaryKey = 'id_tabla';

    public $timestamps = false;

    protected $fillable = [
        'nombre_tabla',
        'color_tabla',
        'id_proyecto',
        'fecha_registro',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }


public function columnas()
{
    return $this->hasMany(Columna::class, 'id_tabla', 'id_tabla');
}

public function posiciones()
{
    return $this->hasMany(Posision::class, 'id_tabla', 'id_tabla');
}


}