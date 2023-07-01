<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Section;
class Product extends Model
{
    use HasFactory;
    protected $fillable=['name','description','section_id']; 



    function section(){
        return $this->belongsTo(Section::class);
    }
}
