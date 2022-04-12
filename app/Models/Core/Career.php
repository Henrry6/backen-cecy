<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Cecy\Authority;
use App\Models\Cecy\Course;

class Career extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'core.careers';

    protected $fillable = [
        'acronym',
        'code',
        'description',
        'name',
        'resolution_number',
        'title',
    ];

    // Relationships
    // public function careerable()
    // {
    //     return $this->morphTo();
    // }

    public function authorities()
    {
        return $this->morphedByMany(Authority::class, 'careerable');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function modality()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function scopeAcronym($query, $acronym)
    {
        if ($acronym) {
            return $query->orWhere('acronym', 'ILIKE', "%$acronym%");
        }
    }

    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orWhere('description', 'ILIKE', "%$description%");
        }
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->orWhere('name', 'ILIKE', "%$name%");
        }
    }

    public function scopeResolutionNumber($query, $resolutionNumber)
    {
        if ($resolutionNumber) {
            return $query->orWhere('resolutionNumber', 'ILIKE', "%$resolutionNumber%");
        }
    }

    public function scopeTitle($query, $title)
    {
        if ($title) {
            return $query->orWhere('title', 'ILIKE', "%$title%");
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
