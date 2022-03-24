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

class AdditionalInformation extends Model implements Auditable
{
    use Auditing;
    use FileTrait;
    use HasFactory;
    use ImageTrait;
    use SoftDeletes;

    protected $table = 'cecy.additional_informations';

    protected $fillable = [
        'company_activity',
        'company_address',
        'company_email',
        'company_name',
        'company_phone',
        'company_sponsored',
        'contact_name',
        'course_follows',
        'course_knows',
        'worked',
    ];

    protected $casts = [
        'course_follows' => 'array',
        'course_knows' => 'array'
    ];

    // Relationships

    public function levelInstruction()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    // Mutators
    public function setCompanyActivityAttribute($value)
    {
        $this->attributes['company_activity'] = strtoupper($value);
    }

    public function setCompanyAddressAttribute($value)
    {
        $this->attributes['company_address'] = strtoupper($value);
    }

    public function setCompanyEmailAttribute($value)
    {
        $this->attributes['company_email'] = strtoupper($value);
    }

    public function setContactNameAttribute($value)
    {
        $this->attributes['contact_name'] = strtoupper($value);
    }

    public function setCompanyNameAttribute($value)
    {
        $this->attributes['company_name'] = strtoupper($value);
    }

    public function setCompanyPhoneAttribute($value)
    {
        $this->attributes['company_phone'] = strtoupper($value);
    }


    // Scopes
    public function scopeCompanyActivity($query, $companyActivity)
    {
        if ($companyActivity) {
            return $query->where('company_activity', 'iLike', "%$companyActivity%");
        }
    }

    public function scopeCompanyAddress($query, $companyAddress)
    {
        if ($companyAddress) {
            return $query->orWhere('company_address', 'iLike', "%$companyAddress%");
        }
    }

    public function scopeCompanyEmail($query, $companyEmail)
    {
        if ($companyEmail) {
            return $query->orWhere('company_email', 'iLike', "%$companyEmail%");
        }
    }

    public function scopeCompanyName($query, $companyName)
    {
        if ($companyName) {
            return $query->orWhere('company_name', 'iLike', "%$companyName%");
        }
    }

    public function scopeContactName($query, $contactName)
    {
        if ($contactName) {
            return $query->orWhere('contact_name', 'iLike', "%$contactName%");
        }
    }

    public function scopeCompanyPhone($query, $companyPhone)
    {
        if ($companyPhone) {
            return $query->orWhere('company_phone', 'iLike', "%$companyPhone%");
        }
    }
    
    //revisar
    public function scopeLevelInstruction($query, $levelInstruction)
    {
        if ($levelInstruction) {
            return $query->orWhere('level_instruction', $levelInstruction);
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
