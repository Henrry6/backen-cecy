<?php

namespace App\Models\Cecy;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Authentication\User;


class Participant extends Model implements Auditable
{
    use Auditing;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cecy.participants';

    protected $fillable = [];

    protected $casts = [
        // 'observations' => 'array',
    ];

    // Relationships

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function type()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //Scopes
    //revisar
    public function scopeType($query, $type)
    {
        if ($type) {
            return $query->orWhere('type_id', $type->id);
        }
    }

    //REVISAR
    public function scopeUser($query, $userSearch)
    {
        if ($userSearch) {
            return $query->whereHas('user', function ($user) use ($userSearch) {
                $user->where('username', 'iLike', "%$userSearch%")
                    ->orWhere('name', 'iLike', "%$userSearch%");
            });
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
