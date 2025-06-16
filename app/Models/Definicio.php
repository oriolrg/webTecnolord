<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Resposta;

class Definicio extends Model
{
    protected $connection = 'mysql';
    protected $table = 'diccionari';
    protected $fillable = [
 
       'categoria',
 
       'paraula',
 
       'definicio',
 
    ];
    protected $primaryKey = 'id';
}
