<?php

namespace App\Models;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ressource extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'nature',
        'user_id',
        'admin_id'
    ];
    		

    public function user(){
        return ($this->belongsTo(User::class,'user_id'));
    }

    public function admin(){
        return ($this->belongsTo(Admin::class,'admin_id'));
    }
}
