<?php

namespace App\Models\Cecy;

use App\Models\Core\Career;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Authentication\User;
use App\Models\Core\Institution;
use App\Models\Core\State;

class Authority extends Model implements Auditable
{
    use Auditing;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cecy.authorities';

    protected $fillable = [
        'electronic_signature',
        'position_started_at',
        'position_ended_at'
    ];

    // Relationships
    public function careers()
    {
        return $this->morphToMany(Career::class,'core.careerable');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'id','institution_id');
    }

    public function planifications()
    {
        return $this->hasMany(Planification::class, 'responsible_cecy_id');
    }

    public function position()
    {
        return $this->belongsTo(State::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mutators


    // Scopes
    //revisar
    public function scopePositionStartedAt($query, $positionStartedAt)
    {
        if ($positionStartedAt) {
            return $query->orWhere('position_started_at', $positionStartedAt);
        }
    }

    public function scopePositionEndedAt($query, $positionEndedAt)
    {
        if ($positionEndedAt) {
            return $query->orWhere('position_ended_at', $positionEndedAt);
        }
    }
    public function scopeFirm($query, $electronicSignature)
    {
        if ($electronicSignature) {
            return $query->orWhere('electronic_signature', $electronicSignature);
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
