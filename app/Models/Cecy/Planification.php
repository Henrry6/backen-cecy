<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planification extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'cecy.planifications';

    protected $fillable = [
        'code',
        'ended_at',
        'needs',
        'number_days',
        'observations',
        'started_at'
    ];

    // Relationships
    public function area()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function responsibleCourse()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function responsibleCecy()
    {
        return $this->belongsTo(Authority::class);
    }

    public function detailSchoolPeriod()
    {
        return $this->belongsTo(DetailSchoolPeriod::class);
    }

    public function sector()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function detailplanifications()
    {
        $this->hasMany(DetailPlanification::class);
    }

    //Mutators
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    //Scopes
    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->orWhere('category', $code);
        }
    }

    public function scopeResponsibleCourse($query, $responsibleCourse)
    {
        if ($responsibleCourse) {
            return $query->orWhere('responsible_course_id', $responsibleCourse->id);
        }
    }

    public function scopeCourse($query, $course)
    {
        if ($course) {
            return $query->orWhere('course_id', $course->id);
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
}
