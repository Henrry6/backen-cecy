<?php

namespace App\Models\Cecy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as Auditing;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRegistration extends Model implements Auditable
{
    use HasFactory;
    use Auditing;
    use SoftDeletes;

    protected $table = 'cecy.detail_registrations';

    protected $fillable = [
        'final_grade',
        'grade1',
        'grade2',
        'observations',
    ];

    // Relationships
    public function detail_planification()
    {
        return $this->belongsTo(detailPlanification::class);
    }
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
    public function state_certificate()
    {
        return $this->belongsTo(Catalogue::class);
    }
    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

 
    
    // Mutators

    //Mis campos son de tipo JSON

    // Scopes
    
    // Mis campos son de  tipo JSON 
    

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
