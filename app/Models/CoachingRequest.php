<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingRequest extends Model
{
    use HasFactory;
    protected $table = 'coaching_requests';
    protected $fillable = [
        'id',
        'coaching_id',
        'user_id',
        'r_text',        
        'r_tag_id',
        'r_status',
        
    ];
    protected $primaryKey = 'id';    
    public $timestamps = true;
}
