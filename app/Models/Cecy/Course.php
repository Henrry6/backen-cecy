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

class Course extends Model implements Auditable
{
    use Auditing;
    use FileTrait;
    use HasFactory;
    use ImageTrait;
    use SoftDeletes;

    protected $table = 'cecy.courses';

    protected $fillable = [
        'abbreviation',
        'alignment',
        'approved_at',
        'bibliographies',
        'code',
        'cost',
        'duration',
        'evaluation_mechanisms',
        'expired_at',
        'free',
        'name',
        'needs',
        'needed_at',
        'record_number',
        'learning_environments',
        'local_proposal',
        'objective',
        'observations',
        'practice_hours',
        'proposed_at',
        'project',
        'public',
        'setec_name',
        'summary',
        'target_groups',
        'teaching_strategies',
        'techniques_requisites',
        'theory_hours'
    ];

    protected $casts = [
        'bibliographies' => 'array',
        'evaluation_mechanisms' => 'array',
        'needs' => 'array',
        'learning_environments' => 'array',
        'observations' => 'array',
        'target_groups' => 'array',
        'teaching_strategies' => 'array',
        'techniques_requisites' => 'array',
    ];

    // Relationships
    public function academicPeriod()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function area()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function entityCertification()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function catalogues()
    {
        return $this->belongsToMany(Catalogue::class, 'cecy.participant_course', 'course_id', 'catalogue_id');
    }

    public function category()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function certifiedType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function complianceIndicator()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function control()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function courseType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function formationType()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function frequency()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function modality()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function meansVerification()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function planifications()
    {
        return $this->hasMany(Planification::class);
    }

    public function planification()
    {
        return $this->belongsTo(Planification::class);
    }

    public function prerequisites()
    {
        return $this->hasMany(Prerequisite::class);
    }

    public function profileInstructorCourses()
    {
        return $this->hasMany(ProfileInstructorCourses::class);
    }

    public function responsible()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function speciality()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function state()
    {
        return $this->belongsTo(Catalogue::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }


    // Mutators
    public function setAbbreviationAttribute($value)
    {
        $this->attributes['abbreviation'] = strtoupper($value);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    public function setLocalProposalAttribute($value)
    {
        $this->attributes['local_proposal'] = strtoupper($value);
    }

    public function setObjectiveAttribute($value)
    {
        $this->attributes['objective'] = strtoupper($value);
    }

    public function setProjectAttribute($value)
    {
        $this->attributes['project'] = strtoupper($value);
    }

    public function setRecordNumberAttribute($value)
    {
        $this->attributes['record_number'] = strtoupper($value);
    }

    public function setSetecNameAttribute($value)
    {
        $this->attributes['setec_name'] = strtoupper($value);
    }

    public function setSummaryAttribute($value)
    {
        $this->attributes['summary'] = strtoupper($value);
    }

    // Scopes
    // Revisar
    public function scopeAcademicPeriod($query, $academicPeriod)
    {
        if ($academicPeriod) {
            return $query->orWhere('academic_period_id', $academicPeriod->id);
        }
    }

    public function scopeAbbreviation($query, $abbreviation)
    {
        if ($abbreviation) {
            return $query->where('abbreviation', 'iLike', "%$abbreviation%");
        }
    }

    public function scopeAlignment($query, $alignment)
    {
        if ($alignment) {
            return $query->orWhere('alignment', $alignment);//ilike
        }
    }

    public function scopeCatalogue($query, $catalogue)
    {
        if ($catalogue) {
            return $query->Where('catalogue_id', $catalogue);
        }
    }

    public function scopeCategory($query, $category)
    {
        if ($category) {
            return $query->Where('category_id', $category->id);
        }
    }

    public function scopeCareer($query, $career)
    {
        if ($career) {
            return $query->orWhere('career_id', $career->id);
        }
    }

    public function scopeCode($query, $code)
    {
        if ($code) {
            return $query->orWhere('code', $code);
        }
    }

    public function scopeFree($query, $free)
    {
        if ($free) {
            return $query->orWhere('free', $free);
        }
    }

    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->Where('name', 'iLike', "%$name%");
        }
    }

    public function scopeRecordNumber($query, $recordNumber)
    {
        if ($recordNumber) {
            return $query->orWhere('record_number', $recordNumber);
        }
    }

    public function scopeLocalProposal($query, $localProposal)
    {
        if ($localProposal) {
            return $query->orWhere('local_proposal', $localProposal);
        }
    }

    public function scopeObjective($query, $objective)
    {
        if ($objective) {
            return $query->orWhere('objective', $objective);//ilike
        }
    }

    public function scopeObservation($query, $observation)
    {
        if ($observation) {
            return $query->orWhere('observation', $observation);//ilike
        }
    }

    public function scopeProject($query, $project)
    {
        if ($project) {
            return $query->orWhere('project', $project);
        }
    }

    public function scopePublic($query, $public)
    {
        if ($public) {
            return $query->orWhere('public', $public);
        }
    }

    public function scopeSetecName($query, $setec_name)
    {
        if ($setec_name) {
            return $query->orWhere('setec_name', $setec_name);
        }
    }

    public function scopeState($query, $state)
    {
        if ($state) {
            return $query->orWhere('state_id', $state);
        }
    }

    public function scopeSummary($query, $summary)
    {
        if ($summary) {
            return $query->orWhere('summary', $summary);
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

    // Accesors
    public function getTotalHoursAttribute()
    {
        return $this->attributes['theory_hours'] + $this->attributes['practice_hours'];
    }
}
