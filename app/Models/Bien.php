<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'caracteristique',
        'contact',
        'images',
        'statut',
        'user_id'
    ];

    public function user(){
        return ($this->belongsTo(User::class,'user_id'));
    }

}
