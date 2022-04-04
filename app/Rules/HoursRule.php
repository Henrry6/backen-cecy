<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Cecy\Catalogue;
use App\Models\Cecy\Planification;

use DateInterval;
use DatePeriod;
use DateTime;

class HoursRule implements Rule
{
    /**
     * Data under validation.
     *
     */
    protected $dayId;
    protected $endedTime;
    // protected $customMessage;
    protected $startedTime;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(
        $dayId,
        $startedTime,
        $endedTime
    ) {
        $this->dayId = $dayId;
        $this->startedTime = $startedTime;
        $this->endedTime = $endedTime;
        // $this->customMessage = '';
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
        return $this->checkHours($value);
        // return false;
        // return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Las horas seleccionadas no deben superar las horas de curso planificadas';
        // return $this->customMessage;
        // return $this->checkHours(3);
    }

    public function checkHours($planificationId)
    {
        $planification = Planification::find($planificationId);
        $course = $planification->course()->first();
        $day = Catalogue::find($this->dayId);
        $courseHours = $course->duration;

        $dayNames = $this->getDayNames($planification->started_at, $planification->ended_at);
        $numberOfDays = $this->getNumberOfDays($day[0]->code, $dayNames);
        $endedTime = new DateTime($this->endedTime);
        $startedTime = new DateTime($this->startedTime);
        $numberOfSelectedHours = $endedTime->getTimestamp() - $startedTime->getTimestamp();
        $numberOfSelectedHours = ($numberOfSelectedHours / 3600);


        $totalHoursSelected = $numberOfDays * $numberOfSelectedHours;

        return $totalHoursSelected <= $courseHours;
        // if ($totalHoursSelected === $courseHours) {
        //     return true;
        // } elseif ($totalHoursSelected < $courseHours) {
        //     $this->customMessage = 'Las horas seleccionadas son inferiores a las horas de curso planificadas. Añada una observación';
        //     return false;
        // } else {
        //     $this->customMessage = 'Las horas seleccionadas no deben superar las horas de curso planificadas';
        //     return false;
        // }
    }

    private function getDayNames($begin, $end)
    {
        $begin = new DateTime($begin);
        $end = new DateTime($end);
        $end = $end->modify('+1 day');
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);

        $days = [];

        foreach ($daterange as $date) {
            array_push($days, strtoupper($date->format("l")));
        }
        return $days;
    }

    private function getNumberOfDays(string $day, array $dayNames)
    {
        $numberOfDays = 0;

        switch ($day) {
            case 'MONDAY-FRIDAY':
                foreach ($dayNames as $dayName) {
                    if (
                        $dayName === 'MONDAY' ||
                        $dayName === 'TUESDAY' ||
                        $dayName === 'WEDNESDAY' ||
                        $dayName === 'THURSDAY' ||
                        $dayName === 'FRIDAY'
                    ) {
                        $numberOfDays++;
                    }
                }
                break;

            case 'MONDAY-SUNDAY':
                foreach ($dayNames as $dayName) {
                    if (
                        $dayName === 'MONDAY' ||
                        $dayName === 'TUESDAY' ||
                        $dayName === 'WEDNESDAY' ||
                        $dayName === 'THURSDAY' ||
                        $dayName === 'FRIDAY' ||
                        $dayName === 'SUNDAY'
                    ) {
                        $numberOfDays++;
                    }
                }
                break;

            case 'SUNDAYS':
                foreach ($dayNames as $dayName) {
                    if ($dayName === 'SUNDAY') {
                        $numberOfDays++;
                    }
                }
                break;

            case 'SATURDAYS':
                foreach ($dayNames as $dayName) {
                    if ($dayName === 'SATURDAY') {
                        $numberOfDays++;
                    }
                }
                break;

            default:
                return 0;
                break;
        }

        return $numberOfDays;
    }

    private function checkDay()
    {
        $timestamp = strtotime('2022-03-26');

        $day = date('l', $timestamp);

        return $day;

        // var_dump($day);
    }
}
