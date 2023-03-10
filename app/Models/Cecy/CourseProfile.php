<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseProfile extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'cecy.course_profiles';

    protected $fillable = [
        'required_experiences',
        'required_knowledges',
        'required_skills',
    ];

    protected $casts = [
        'required_experiences' => 'array',
        'required_knowledges' => 'array',
        'required_skills' => 'array'
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }

    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'cecy.course_profile_instructor');
    }

    // Mutators


    // Scopes
    public function scopeCourse($query, $courseId)
    {
        if ($courseId) {
            return $query->orWhere('course_id', $courseId);
        }
    }

    public function scopeCustomOrderBy($query, $sorts)
    {
        if (!empty($sorts[0])) {
            foreach ($sorts as $sort) {
                $field = explode('-', $sort);
                if (empty($field[0]) && in_array($field[1], $this->fillable)) {
                    $query = $query->orderByDesc($field[1]);
                } else if (in_array($field[0], $this->fillable)) {
                    $query = $query->orderBy($field[0]);
                }
            }
            return $query;
        }
    }

    public function scopeCustomSelect($query, $fields)
    {
        if (!empty($fields)) {
            $fields = explode(',', $fields);
            foreach ($fields as $field) {
                $fieldExist = array_search(strtolower($field), $fields);
                if ($fieldExist == false) {
                    unset($fields[$fieldExist]);
                }
            }

            array_unshift($fields, 'id');
            return $query->select($fields);
        }
    }
}
