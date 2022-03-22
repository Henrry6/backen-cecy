<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\DetailPlanification;
use App\Models\Cecy\Planification;
use DateTime;

class StoreParallelRule implements Rule
{
    /**
     * Data under validation.
     *
     */
    protected $planificationId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($planificationId)
    {
        $this->planificationId = $planificationId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->checkParallel($value);
        // return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //86 87 500
        return 'Nombre paralelo del aula o clase ya existe';
    }

    public function checkParallel($parallelId)
    {
        $parallelSelected = Catalogue::find($parallelId);

        $detailPlanifications = DetailPlanification::where('planification_id', $this->planificationId)
            ->with('parallel')
            ->get();

        //current parallels
        $parallels = $detailPlanifications->map(function ($item, $key) {
            return $item->parallel;
        });

        // si se quiere crear uno nuevo
        return $parallels->doesntContain(function ($value, $key) use ($parallelSelected) {
            return $value->name === $parallelSelected->name;
        });
    }
}
