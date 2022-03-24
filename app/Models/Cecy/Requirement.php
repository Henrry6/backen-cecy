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

class Requirement extends Model implements Auditable
{
    use Auditing;
    use FileTrait;
    use HasFactory;
    use ImageTrait;
    use SoftDeletes;

    protected $table = 'cecy.requirements';

    protected $fillable = [
        'name',
        'required',
    ];

    // Relationships

    public function registrations()
    {
        return $this->belongsToMany(Registration::class, 'cecy.registration_requirement', 'requirement_id', 'registration_id');
    }

    //revisar
    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    // Mutators
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = strtoupper($value);
    }

    // Scopes
    //revisar
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->orWhere('name', 'iLike', "%$name%");
        }
    }

    //revisar
    public function scopeState($query, $requirement)
    {
        if ($requirement) {
            return $query->orWhere('state_id', $requirement->state);
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
