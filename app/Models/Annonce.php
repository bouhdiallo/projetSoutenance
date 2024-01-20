<?php

// Annonce.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $fillable = [
        'description',
        'date_activite',
        'lieu',
        'images',
        // ... autres colonnes de votre table Annonce
    ];

    /**
     * The users that belong to the annonce.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_id'); // 'commentaires' est la table pivot
    }

    /**
     * The comments associated with the annonce.
     */
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'commentaire_id');
    }
}

