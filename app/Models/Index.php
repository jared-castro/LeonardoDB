<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Index extends Model
{
  use HasFactory;

    protected $table = 'leonardorindex';

    protected $primaryKey = 'id_index';

    public $timestamps = false;

    protected $fillable = [
        'id_tabla',
        'id_columna',
    ];

    public function tabla()
    {
        return $this->belongsTo(Data::class, 'id_tabla', 'id_tabla');
    }

    public function columna()
    {
        return $this->belongsTo(Columna::class, 'id_columna', 'id_columna');
    }
}