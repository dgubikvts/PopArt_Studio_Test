<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    public function advertisements(){
        return $this->hasMany(Advertisement::class, 'category');
    }

    public function children(){
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getChildren(){
        return $this->children()->with('getChildren');
    }

    public function addCategory($name, $parent_id = null){
        $this->name = $name;
        if(isset($parent_id)) $this->parent_id = $parent_id;
        $this->slug = Str::slug($name);
        $this->save();
    }
}
