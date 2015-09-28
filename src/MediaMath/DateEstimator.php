<?php
namespace MediaMath;

use Carbon\Carbon;

class DateEstimator
{

    /**
     * For simplification this is hardcoded as a constant.
     * If needed this can be passed as a constructor param
     * so we could generate different list size from 6.
     */
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

    /**
     * Calculates all possible dates to have mid-month meeting.
     * Normally the meeting should happen on 14th of each month
     * but if the day falls on a Weekend we have to find first
     * Monday after that day.
     * @param Carbon $date Date to check
     * @return Carbon meeting date
     */
    public function getMeetingDate(Carbon $date)
    {
        $meetingDate = Carbon::createFromDate($date->year, $date->month, 14);
        if ($meetingDate->isWeekend()) {
            $meetingDate->next(Carbon::MONDAY);
        }
        return $meetingDate;
    }

    /**
     * Calculates all available meeting dates in the date range.
     * @return Carbon[]
     */
    public function getMeetingsDates()
    {
        $meetingDates = [];
        foreach ($this->dates as $date) {
            $meetingDates[] = $this->getMeetingDate($date);
        }

        return $meetingDates;
    }

    /**
     * Calculates last possible day of the month for testing.
     * If the day is Weekend or Friday we return the previous
     * Thursday in same week.
     * @param Carbon $date Date to check
     * @return Carbon testing date
     */
    public function getTestingDate(Carbon $date)
    {
        $testingDate = Carbon::createFromDate($date->year, $date->month, $date->daysInMonth);
        if ($testingDate->dayOfWeek === Carbon::FRIDAY || $testingDate->isWeekend()) {
            $testingDate->previous(Carbon::THURSDAY);
        }

        return $testingDate;
    }

    /**
     * Calculates all available testing dates in the date interval
     * @return Carbon[] testing dates
     */
    public function getTestingDates()
    {
        $meetingDates = [];
        foreach ($this->dates as $date) {
            $meetingDates[] = $this->getTestingDate($date);
        }

        return $meetingDates;
    }

    /**
     * Gets all available monthe in the defined interval.
     * @return int[] List of month numbers
     */
    public function getMonths() {
        $months = [];
        foreach ($this->dates as $date) {
            $months[] = $this->getMonth($date);
        }

        return $months;
    }

    /**
     * Extract the month from a date
     * @param Carbon $date
     * @return int Month number 1-12
     */
    public function getMonth(Carbon $date) {
        return $date->month;
    }
}