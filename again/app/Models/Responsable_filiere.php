<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \App\Models\Filiere;

class Responsable_filiere extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'departement',
        'user_id',
        'image'
    ];
    protected $with = ['user' , 'filiere'];

    public function filiere(){
        return $this->hasOne(Filiere::class , 'id_responsable' , 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
