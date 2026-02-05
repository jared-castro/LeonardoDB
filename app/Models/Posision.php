<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posision extends Model
{
use HasFactory;

    protected $table = 'leonardoposicion';

    protected $primaryKey = 'id_posicion';

    public $timestamps = false;

    protected $fillable = [
        'id_tabla',
        'pos_x',
        'pos_y',
    ];

    public function tabla()
    {
        return $this->belongsTo(Data::class, 'id_tabla', 'id_tabla');
    }

    

}
