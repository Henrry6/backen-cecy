<?php

namespace App\Models\Cecy;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class PhotographicRecord extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'cecy.photographic_records';

    protected $fillable = [
        'description',
        'image',
        'number_week',
        'registered_at'
    ];

    // Relationships
    public function detailPlanification()
    {
        return $this->belongsTo(DetailPlanification::class);
    }

    public function images() //revisar image o images
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    // Mutators

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtoupper($value);
    }

    // Scopes

    public function scopeDescription($query, $description)
    {
        if ($description) {
            return $query->orWhere('description','iLike', "%$description->id%");
        }
    }

    public function scopeImage($query, $image)
    {
        if ($image) {
            return $query->orWhere('image','iLike', "%$image->id%");
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
