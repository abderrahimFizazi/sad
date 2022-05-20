<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Responsable_filiere;
use \App\Models\Module;
use \App\Models\Moyenne;

class Filiere extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'designation',
        'id_responsable',
        
    ];
    protected $with = ['responsable_filiere'];
    public function Responsable_filiere(){
        return $this->belongsTo(Responsable_filiere::class , 'id_responsable' , 'id');
    }
    public function Module(){
        return $this->hasMany(Module::class ,'id_filiere' , 'id');
    }
    public function moyenne(){
        return $this->hasMany(Moyenne::class );
    }
   
}
