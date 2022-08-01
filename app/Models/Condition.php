<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    use HasFactory;

    public function advertisements(){
        return $this->hasMany(Advertisement::class, 'condition');
    }
    
    public function newCondition($name){
        $this->name = $name;
        return $this->save();
    }
}