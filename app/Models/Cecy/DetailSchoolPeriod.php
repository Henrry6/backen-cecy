<?php

namespace App\Models\Cecy;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailSchoolPeriod extends Model implements Auditable
{
    use Auditing;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cecy.detail_school_periods';

    protected $fillable = [
        'especial_ended_at',
        'especial_started_at',
        'extraordinary_ended_at',
        'extraordinary_started_at',
        'nullification_ended_at',
        'nullification_started_at',
        'ordinary_ended_at',
        'ordinary_started_at',
    ];

    // Relationships
    public function planifications()
    {
        return $this->hasMany(Planification::class);
    }

    public function schoolPeriod()
    {
        return $this->belongsTo(SchoolPeriod::class);
    }

    // Scopes
    public function scopeEspecialEndedAt($query, $especialEndedAt)
    {
        if ($especialEndedAt) {
            return $query->orWhere('especial-ended-at', 'iLike', "%$especialEndedAt%");
        }
    }

    public function scopeEspecialStartedAt($query, $especialStartedAt)
    {
        if ($especialStartedAt) {
            return $query->orWhere('especial-started-at', 'iLike', "%$especialStartedAt%");
        }
    }

    public function scopeExtraordinaryEndedAt($query, $extraordinaryEndedAt)
    {
        if ($extraordinaryEndedAt) {
            return $query->orWhere('extraordinary-ended-at', 'iLike', "%$extraordinaryEndedAt%");
        }
    }

    public function scopeExtraordinaryStartedAt($query, $extraordinaryStartedAt)
    {
        if ($extraordinaryStartedAt) {
            return $query->orWhere('extraordinary-started-at', 'iLike', "%$extraordinaryStartedAt%");
        }
    }

    public function scopeNullificationEndedAt($query, $nullificationEndedAt)
    {
        if ($nullificationEndedAt) {
            return $query->orWhere('nullification-ended-at', 'iLike', "%$nullificationEndedAt%");
        }
    }

    public function scopeNullificationStartedAt($query, $nullificationStartedAt)
    {
        if ($nullificationStartedAt) {
            return $query->orWhere('nullification-started-at', 'iLike', "%$nullificationStartedAt%");
        }
    }

    public function scopeOrdinaryEndedAt($query, $ordinaryEndedAt)
    {
        if ($ordinaryEndedAt) {
            return $query->orWhere('ordinary-ended-at', 'iLike', "%$ordinaryEndedAt%");
        }
    }

    public function scopeOrdinaryStartedAt($query, $ordinaryStartedAt)
    {
        if ($ordinaryStartedAt) {
            return $query->orWhere('ordinary-started-at', 'iLike', "%$ordinaryStartedAt%");
        }
    }

    // Revisar
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
