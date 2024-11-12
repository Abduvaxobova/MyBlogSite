<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
      'path'  
    ];
    public function immeagable(){
        return $this->morphTo();
    }
}
