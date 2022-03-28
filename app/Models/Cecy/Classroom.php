<?php

namespace App\Models\Cecy;

use App\Models\Authentication\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'cecy.classrooms';

    protected $fillable = [
        'description',
        'capacity',
        'code',
        'name',
    ];

    // Relationships
    public function detailPlanifications()
    {
        return $this->hasMany(DetailPlanification::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    // Mutators
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtoupper($value);
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
    
    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orWhere('description', 'iLike', "%$description%");
        }
    }

    public function scopeType($query, $classroom)
    {
        if ($classroom) {
            return $query->orWhere('type_id', $classroom->type);
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
