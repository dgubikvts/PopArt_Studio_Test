<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    use HasFactory;

    public function advertisement(){
        return $this->belongsTo(Advertisement::class);
    }

    public function create($name, $size, $path, $ad_id){
        $this->name = $name;
        $this->size = $size;
        $this->path = $path;
        $this->advertisement_id = $ad_id;
        return $this->save();
    }
}
