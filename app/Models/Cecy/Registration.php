<?php

namespace App\Models\Cecy;

use App\Models\Core\File;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FileTrait;
use App\Traits\ImageTrait;

class Registration extends Model implements Auditable
{
    use Auditing;
    use FileTrait;
    use HasFactory;
    use ImageTrait;
    use SoftDeletes;

    protected $table = 'cecy.registrations';

    protected $fillable = [
        'final_grade',
        'grade1',
        'grade2',
        'number',
        'observations',
        'registered_at',
    ];

    protected $casts = [
        'observations' => 'array',
    ];

    public function additionalInformation()
    {
        return $this->hasOne(AdditionalInformation::class);
    }

    public function additionalInformations()
    {
        return $this->hasMany(AdditionalInformation::class);
    }

    public function certificates()
    {
        return $this->morphMany(Certificate::class, 'certificateable');
    }
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
    // Relationships

    public function detailAttendances()
    {
        return $this->hasMany(DetailAttendance::class);
    }

    public function detailPlanification()
    {
        return $this->belongsTo(DetailPlanification::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    //revisar
    public function requirements()
    {
        return $this->belongsToMany(Requirement::class, 'cecy.registration_requirement', 'registration_id', 'requirement_id')
        ->withPivot(['url']);
    }

    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function stateCourse()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function typeParticipant()
    {
        return $this->belongsTo(Catalogue::class, 'type_participant_id');
    }


    // Scopes
    //revisar
    public function scopeDetailPlanification($query, $detailPlanification)
    {
        if ($detailPlanification) {
            return $query->orWhere('detail_planification_id', $detailPlanification->id);
        }
    }

    public function scopeNumber($query, $number)
    {
        if ($number) {
            return $query->orWhere('number', 'iLike', "%$number%");
        }
    }

    //revisar
    public function scopeParticipant($query, $participant)
    {
        if ($participant) {
            return $query->orWhere('participant_id', $participant->id);
        }
    }
    public function scopeParticipantUsername($query, $participantUserName)
    {
        if ($participantUserName) {
            return $query->whereHas('participant.user',function($q) use($participantUserName){
                $q->where('username','like','%'.$participantUserName.'%');
            });
        }
    }

    //revisar
    public function scopeState($query, $state)
    {
        if ($state) {
            return $query->orWhere('state_id', $state->id);
        }
    }

    //revisar
    public function scopeStateCourse($query, $stateCourse)
    {
        if ($stateCourse) {
            return $query->orWhere('state_course_id', $stateCourse->id);
        }
    }

    //revisar
    public function scopeType($query, $type)
    {
        if ($type) {
            return $query->orWhere('type_id', $type->id);
        }
    }

    //revisar
    public function scopeTypeParticipant($query, $typeParticipant)
    {
        if ($typeParticipant) {
            return $query->orWhere('type_participant_id', $typeParticipant->id);
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

