<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Eleve;
use \App\Models\Element_module;
class note extends Model
{
    use HasFactory;
    protected $fillable = [
        'note',
        'eleve_id',
        'element_module_id'
    ];
    protected $with = ['element_module' , 'eleve'];
    public function eleve(){
        return $this->belongsTo(Eleve::class );
    }
    public function element_module(){
        return $this->belongsTo(Element_module::class);
    }
}
