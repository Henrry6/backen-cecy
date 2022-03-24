<?php

namespace App\Models\Cecy;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Core\Career;
use App\Models\Core\File;
use App\Models\Core\Image;
use App\Traits\FileTrait;
use App\Traits\ImageTrait;

class DetailPlanification extends Model implements Auditable
{
    use Auditing;
    use FileTrait;
    use HasFactory;
    use ImageTrait;
    use SoftDeletes;

    protected $table = 'cecy.detail_planifications';

    protected $fillable = [
        'ended_time',
        'observations',
        'plan_ended_at',
        'registrations_left',
        'started_time',
    ];

    protected $casts = [
        'observations' => 'array',
    ];

    // Relationships
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    
    public function certificates()
    {
        return $this->morphMany(Certificate::class, 'certificateable');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function day()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'cecy.detail_planification_instructor', 'detail_planification_id', 'instructor_id');
    }

    public function parallel()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function planification()
    {
        return $this->belongsTo(Planification::class);
    }

    public function photographicRecords()
    {
        return $this->hasMany(PhotographicRecord::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function workday()
    {
        return $this->belongsTo(Catalogue::class);
    }

    // Scopes
    //revisar
    public function scopeEndedTime($query, $endedTime)
    {
        if ($endedTime) {
            return $query->orWhere('ended_time', $endedTime);
        }
    }
    
    public function scopeObservations($query, $observations)
    {
        if ($observations) {
            return $query->orWhere('observations', 'iLike', "%$observations%");
        }
    }

    //revisar
    public function scopePlanEndedAt($query, $planEndedAt)
    {
        if ($planEndedAt) {
            return $query->orWhere('plan_ended_at', $planEndedAt);
        }
    }
    
    //revisar
    public function scopePlanification($query, $planification)
    {
        if ($planification) {
            return $query->orWhere('planification_id', $planification->id);
        }
    }
    
    //revisar
    public function scopeRegistrationsLeft($query, $registrationsLeft)
    {
        if ($registrationsLeft) {
            return $query->orWhere('registrations_left', $registrationsLeft);
        }
    }

    //revisar
    public function scopeStartedTime($query, $startedTime)
    {
        if ($startedTime) {
            return $query->orWhere('started_time', $startedTime);
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

    // Accesors
    public function getScheduleAttribute()
    {
        return $this->attributes['started_time'] . '-' . $this->attributes['ended_time'];
    }
    
}