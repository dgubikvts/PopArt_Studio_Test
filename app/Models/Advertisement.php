<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCondition(){
        return $this->belongsTo(Condition::class, 'condition');
    }

    public function getCategory(){
        return $this->belongsTo(Category::class, 'category');
    }

    public function images(){
        return $this->hasMany(AdImage::class, 'advertisement_id');
    }

    public function createAd($title, $description, $price, $location, $phone, $category, $condition, $user_id){
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->location = $location;
        $this->phone = $phone;
        $this->category = $category;
        $this->condition = $condition;
        $this->user_id = $user_id;
    }
}
