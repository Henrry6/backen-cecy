<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DateTime;
use App\Models\Cecy\Catalogue;

class WorkdayRule implements Rule
{
    /**
     * Data under validation.
     *
     * @var string
     */
    protected $endedTime;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($endedTime)
    {
        $this->endedTime = $endedTime;
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
        return $this->checkWorkday($value);
        // return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La jornada es incorrecta';
    }

    public function checkWorkday($workdayId)
    {
        $workday = Catalogue::where('id', $workdayId)->first();

        switch ($workday->name) {
            case 'VESPERTINA':
                if (
                    new DateTime($this->endedTime) <= new DateTime('18:00:00')
                    && new DateTime($this->endedTime) > new DateTime('12:00:00')
                ) {
                    return true;
                }
                return false;
                break;
            case 'MATUTINA':
                if (
                    new DateTime($this->endedTime) <= new DateTime('12:00:00')
                    && new DateTime($this->endedTime) > new DateTime('6:00:00')
                ) {
                    return true;
                }
                return false;
                break;
            case 'NOCTURNA':
                if (
                    new DateTime($this->endedTime) > new DateTime('18:00:00')
                ) {
                    return true;
                }
                return false;
                break;

            default:
                return false;
                break;
        }
    }
}
