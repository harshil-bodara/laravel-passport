<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;
    protected $table = 'coaching_qualifications';
    protected $primaryKey = 'id';    
    public $timestamps = false;
}
