<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Fee;

class Coaching extends Model {

    use HasFactory;

    protected $fillable = [
        'user_id',
        'c_is_active',
        'c_title',
        'c_country',
        'c_country_code',
        'c_city',
        'c_phone',
        'c_description',
        'c_banner_img',
        'c_language_primary',
        'c_language_secondary',
        'c_type_online',
        'c_type_offline',
        'c_type_inhouse',
        'c_avail_morning',
        'c_avail_afternoon',
        'c_avail_evening',
        'c_quotation',
        'c_quotation_from',
        'c_time_zone'
    ];
    protected $table = 'coachings';
    protected $primaryKey = 'id';
    protected $hidden = array('created_at', 'updated_at');

//    public function tags() {
//        return $this->hasMany(CoachingTags::class)
//        ->join('coaching_categories','coaching_tags.id','=','coaching_categories.id')
//        ->join('tags','coaching_tags.tag_id','=','tags.id')
        /* ->select(['coaching_tags.*','tags.tag_name','coaching_categories.category_name_en','coaching_tags.category_id']) */
//        ;
//    }

    public function coaching_tags() {
        return $this->hasMany(CoachingTags::class);
    }

    public function fees() {
        return $this->hasMany(Fee::class);
    }

}
