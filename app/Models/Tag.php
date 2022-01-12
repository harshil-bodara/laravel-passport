<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $table = 'coaching_tags';
    protected $primaryKey = 'id';
    protected $hidden = array('created_at','updated_at');
}
