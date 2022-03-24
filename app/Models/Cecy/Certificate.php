<?php

namespace App\Models\Cecy;


use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Certificate extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'cecy.certificates';
    protected $table2 = 'authentication.users';

    protected $fillable = [
        'code',
        'issued_at',
        'certificateable_type', //revisar 
        'certificateable_id',
        'state_id',
    ];

    protected $user = [

        'username',

    ];

    public function certificateable()
    {
        return $this->morphTo();
    }

    // Relationships

    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    // Mutators

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    // Scopes

    public function scopeCodeSources($query, $code)
    {
        if ($code) {
            return $query->orWhere('code','iLike', "%$code&");
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
