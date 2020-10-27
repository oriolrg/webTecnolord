<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projecte extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'descripcio',
        'user_id',
        'finished_at',
    ];
    public function usuari()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
