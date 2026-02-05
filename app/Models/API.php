<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class API extends Model
{
    use HasFactory;

    protected $table = 'leonardoapi';
    protected $primaryKey = 'id_api';
    public $timestamps = false;

    protected $fillable = [
        'api_key',
        'end_point',
        'modelo',
        'id_usuario'
    ];

    protected $hidden = [
        'api_key'
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}