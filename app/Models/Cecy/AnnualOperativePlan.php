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

class AnnualOperativePlan extends Model implements Auditable
{
    use Auditing;
    use FileTrait;
    use HasFactory;
    use ImageTrait;
    use SoftDeletes;

    //Constants
    const MINIMUM_HOURS = 40;

    protected $table = 'cecy.annual_operative_plans';

    protected $fillable = [
        'trade_number',
        'year',
        'official_date_at',
        'activities'
    ];

    protected $casts = [];

    // Relationships
    public function planifications()
    {
        return $this->hasMany(Planification::class);
    }

    // Mutators


    // Scopes
    // Revisar

}
