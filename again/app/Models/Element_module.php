<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Module;
class Element_module extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        "code",
        "designation",
        "vh",
        "poids",
        "id_module"
    ];
    protected $with = ['module'];
    public function Module(){
        return $this->belongsTo(Module::class , 'id_module' , 'id');
    }
}
