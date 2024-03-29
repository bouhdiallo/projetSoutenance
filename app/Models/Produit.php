<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;


    protected $fillable = [
        'nom_produit',
        'prix',
        'contact',
        'images',
        'user_id'
    ];


    public function user(){
        return ($this->belongsTo(User::class,'user_id'));
    }
}
