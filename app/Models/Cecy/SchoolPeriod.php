<?php

namespace App\Models\Cecy;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolPeriod extends Model implements Auditable
{
    use Auditing;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cecy.school_periods';

    protected $fillable = [
        'code',
        'ended_at',
        'minimum_note',
        'name',
        'started_at',
    ];

    // Relationships
    //revisar
    public function detailSchoolPeriods()
    {
        $this->hasMany(DetailSchoolPeriod::class);
    }

    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    // Mutators
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    // Scopes
    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->orWhere('code', 'iLike', "%$code%");
        }
    }
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->orWhere('name', 'iLike', "%$name%");
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
