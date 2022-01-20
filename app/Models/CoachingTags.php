<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of CoachingTags
 *
 * @author Kamlesh Jha <mailtojhajee@gmail.com>
 */
class CoachingTags extends Model {

    protected $fillable = [
        "tag_id",
        "coaching_id"
    ];

    public function tags() {
        return $this->belongsTo(Tag::class,'tag_id','id');
    }

}
