<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cim extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'lat', 'lng', 'elevation'];
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('completed_at');
    }
}
