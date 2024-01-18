<?php

namespace App\Models;

use App\Models\User;
use App\Models\Annonce;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commentaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'user_id',
        'annonce_id'
    ];
    		
    public function user(){
        return ($this->belongsTo(User::class,'user_id'));
    }

    public function Annonce(){
        return ($this->belongsTo(Annonce::class,'annonce_id'));
    }
}
