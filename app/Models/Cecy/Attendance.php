<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as Auditing;
use OwenIt\Auditing\Contracts\Auditable;

class Attendance extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
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
    public function detailAttendance()
    {
        return $this->hasOne(DetailAttendance::class);
    }

    public function detailPlanification()
    {
        return $this->belongsTo(DetailPlanification::class);
    }

    public function photographicRecords()
    {
        return $this->hasMany(PhotographicRecord::class);
    }
    // Mutators


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
}
