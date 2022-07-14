<?php

namespace App\Models\Cecy;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Authentication\User;

class Instructor extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'cecy.instructors';

    protected $fillable = [];

    // Relationships
    public function certificates()
    {
        return $this->morphMany(Certificate::class, 'certificateable');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function detailPlanifications()
    {
        return $this->belongsToMany(DetailPlanification::class, 'cecy.detail_planification_instructor', 'instructor_id', 'detail_planification_id')->withPivot('topic_id');;
    }

    public function planifications()
    {
        return $this->hasMany(Planification::class);
    }

    public function courseProfiles()
    {
        return $this->belongsToMany(CourseProfile::class, 'cecy.course_profile_instructor');
    }

    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Mutators

    // Scopes

    public function scopeType($query, $type)
    {
        if ($type) {
            return $query->orWhere('type', $type->id);
        }
    }

    public function scopeUser($query, $search)
    {
        if ($search) {
            return $query->whereHas('user', function ($user) use ($search) {
                $user->name($search)
                    ->lastname($search)
                    ->username($search);
            });
        }
    }

    public function scopeState($query, $state)
    {
        if ($state) {
            return $query->orWhere('state', $state->id);
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

    public function hasCourseProfile(int $courseProfileId): int
    {
        return $this->courseProfiles()
            ->where('course_profile_id', $courseProfileId)
            ->count();
    }
}
