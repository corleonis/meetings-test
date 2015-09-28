<?php
namespace MediaMath;

use Carbon\Carbon;

class DateEstimator
{

    const GENERATION_PERIOD_LENGTH_MONTHS = 6;

    /**
     * @var Carbon[]
     */
    private $dates = [];

    public function __construct(Carbon $startDate)
    {
        for ($i=0; $i < static::GENERATION_PERIOD_LENGTH_MONTHS; $i++) {
            $this->dates[] = Carbon::create($startDate->year, $startDate->month, $startDate->day, 0, 0, 0);
            $startDate->addMonth();
        }
    }

    public function getMeetingsDates()
    {
        $meetingDates = [];
        foreach ($this->dates as $date) {
            $tmpDate = Carbon::createFromDate($date->year, $date->month, 14);
            if ($tmpDate->isWeekend()) {
                $tmpDate->next(Carbon::MONDAY);
            }
            $meetingDates[] = $tmpDate;
        }

        return $meetingDates;
    }

    public function getTestingDates()
    {
        $meetingDates = [];
        foreach ($this->dates as $date) {
            $tmpDate = Carbon::createFromDate($date->year, $date->month, $date->daysInMonth);
            if ($tmpDate->dayOfWeek === Carbon::FRIDAY || $tmpDate->isWeekend()) {
                $tmpDate->previous(Carbon::THURSDAY);
            }
            $meetingDates[] = $tmpDate;
        }

        return $meetingDates;
    }
}