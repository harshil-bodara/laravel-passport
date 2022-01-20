<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    use HasFactory;

    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = [
        "tag_name",
        "category_id",
        "tag_description",
        "tag_language",
    ];

    /**
     * ManyToMany Relation
     * One Tag with many coaching
     * one coaching with Many Tags
     * @return type
     */
    public function coaching_tags() {
        return $this->hasMany(CoachingTags::class);
    }

}
