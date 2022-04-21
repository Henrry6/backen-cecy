<?php

namespace App\Models\Cecy;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Core\State;

class Planification extends Model implements Auditable
{
    use Auditing;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cecy.planifications';

    protected $fillable = [
        'aproved_at',
        'code',
        'ended_at',
        'needs',
        'observations',
        'started_at'
    ];

    protected $casts = [
        'needs' => 'array',
        'observations' => 'array',
    ];
    
    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function detailPlanifications()
    {
        return $this->hasMany(DetailPlanification::class);
    }

    public function detailSchoolPeriod()
    {
        return $this->belongsTo(DetailSchoolPeriod::class);
    }
    
    public function responsibleCourse()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function responsibleOcs()
    {
        return $this->belongsTo(Authority::class);
    }

    public function responsibleCecy()
    {
        return $this->belongsTo(Authority::class);
    }
    
    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function vicerector()
    {
        return $this->belongsTo(Authority::class);
    }

    //Mutators
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    //Scopes
    //revisar
    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->orWhere('code', 'iLike', "%$code%");
        }
    }

    public function scopeState($query, $search)
    {
        if ($search) {
            return $query->whereHas('state', function ($state) use ($search) {
                $state->where('name', 'iLike', "%$search%");
            });
        }
    }

    public function scopeCourse($query, $course)
    {
        if ($course) {
            return $query->orWhere('course_id', $course->id);
        }
    }

    //revisar, no es ilike es between
    public function scopeStartedAt($query, $started_at)
    {
        if ($started_at) {
            return $query->orWhere('started_at', 'ilike', "%$started_at%");
        }
    }

    public function scopeKpi($query, $planifications, $state)
    {
        return $query->orWhere('state_id', $planifications->$state);
    }

    public function scopeResponsibleCourse($query, $responsibleCourse)
    {
        if ($responsibleCourse) {
            return $query->orWhere('responsible_course_id', $responsibleCourse->id);
        }
    }
    public function scopeResponsibleCecy($query, $responsibleCecy)
    {
        if ($responsibleCecy) {
            return $query->orWhere('responsible_cecy_id', $responsibleCecy->id);
        }
    }
    public function scopeDetailSchoolPeriod($query, $detailSchoolPeriod)
    {
        if ($detailSchoolPeriod) {
            return $query->orWhere('detail_school_period_id', $detailSchoolPeriod->id);
        }
    }

    //revisar
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
