<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Eleve;
use \App\Models\Filiere;
class Moyenne extends Model
{
    use HasFactory;
    protected $fillable = [
        'eleve_id',
        'filiere_id',
        'moyenne',
        'niveau'
    ];
    protected $with = ['eleve' , 'filiere'];
    public function eleve(){
        return $this->belongsTo(Eleve::class);
    }
    public function filiere(){
        return $this->belongsTo(Filiere::class);
    }

}
