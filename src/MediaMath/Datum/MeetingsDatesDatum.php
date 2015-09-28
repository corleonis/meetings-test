<?php
namespace MediaMath\Datum;

use Carbon\Carbon;
use InvalidArgumentException;

class MeetingsDatesDatum implements Datum
{
    /**
     * @var Carbon[]
     */
    private $meetingDates = [];

    /**
     * @var Carbon[]
     */
    private $testingDates = [];

    private $months = [];

    /**
     * Dates headers
     */
    private static $CSV_HEADERS = array('Month', 'Mid of Month Meeting', 'End of Month Testing');

    /**
     * @param array $meetingDates list of meeting dates
     * @param array $testingDates list of testing dates
     * @param array $months list of month
     * @throws InvalidArgumentException if input array differ in count
     */
    public function __construct(array $meetingDates, array $testingDates, array $months)
    {
        $count = count($meetingDates);
        if ($count !== count($testingDates) || $count !== count($months))
        {
            throw new InvalidArgumentException('Meeting, Testing dates and Months should have same count!');
        }

        $this->meetingDates = $meetingDates;
        $this->testingDates = $testingDates;
        $this->months = $months;
    }


    /**
     * Normalise the input data.
     * @return array
     */
    public function getData()
    {
        $data = [];
        $data[] = static::$CSV_HEADERS;

        $count = count($this->meetingDates);
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                $this->months[$i],
                $this->meetingDates[$i]->toDateString(),
                $this->testingDates[$i]->toDateString(),
            ];
        }

        return $data;
    }
}
