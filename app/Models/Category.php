<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    use HasFactory;

    protected $table = 'coaching_categories';
    protected $primaryKey = 'id';

    public function tag() {
        return $this->belongsTo(Tag::class, 'id', 'category_id')->withCount(['coaching_tags']);
    }

    public function coachings() {
        return $this->hasManyThrough(CoachingTags::class, Tag::class);
    }

}
