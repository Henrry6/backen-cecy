<?php

namespace App\Models\Cecy;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailAttendance extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'cecy.detail_attendances';

    protected $fillable = [
        'ended_time',
        'observations',
        'plan_ended_at',
        'registrations_left',
        'started_time',
        'duration',
    ];

    // Relationships
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }


    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    // Mutators


    // Scopes
    public function scopeObservations($query, $observations)
    {
        if ($observations) {
            return $query->orWhere('observations', 'iLike', "%$observations%");
        }
    }
    
    //revisar
    public function scopeRegistration($query, $registration)
    {
        if ($registration) {
            return $query->orWhere('registration_id', $registration->id);
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
