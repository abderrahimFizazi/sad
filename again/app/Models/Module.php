<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Filiere;
use \App\Models\Element_module;
class Module extends Model
{
    use HasFactory;
    protected $fillable = [
        "code",
        "designation",
        "niveau",
        "semestre",
        "id_filiere"
    ];
    protected $with = ['filiere'];
    public function Filiere(){
        return $this->belongsTo(Filiere::class , 'id_filiere' , 'id');
    }
    public function module(){
        return $this->hasMany(Element_module::class , 'id_mdule' , 'id');
    }
}
