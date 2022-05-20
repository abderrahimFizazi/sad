<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;
use \App\Models\Filiere;
use \App\Models\Moyenne;

class Eleve extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prenom',
        'niveau',
        'filiere_id',
        'user_id',
        'image'
    ];
    protected $with = ['user' , 'filiere'];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }
    public function moyenne(){
        return $this->hasOne(Moyenne::class);
    }


}
