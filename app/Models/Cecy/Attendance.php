<?php

namespace App\Models\Cecy;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model implements Auditable
{
    use Auditing;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cecy.attendances';

    protected $fillable = [
        'duration',
        'registered_at',
    ];

    // Relationships
    public function detailAttendances()
    {
        return $this->hasMany(DetailAttendance::class);
    }
    //revisar
    public function detailAttendance()
    {
        return $this->hasOne(DetailAttendance::class);
    }

    public function detailPlanification()
    {
        return $this->belongsTo(DetailPlanification::class);
    }


    // Scopes
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
