<?php
namespace MediaMath;

use Carbon\Carbon;
use PHPUnit_Framework_TestCase;

class DateEstimatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * BASIC FUNCTIONALITY
     */

    public function testMeetingDates() {
        $date = Carbon::create(2015, 02, 01);
        $estimator = new DateEstimator($date);

        /** @var Carbon[] $result */
        $results = $estimator->getMeetingsDates();

        static::assertEquals(6, count($results));
        foreach ($results as $item) {
            /** @var Carbon $item */
            if ($item->day !== 14) {
                static::assertTrue(Carbon::create($item->year, $item->month, 14)->isWeekend());
                static::assertEquals(Carbon::MONDAY, $item->dayOfWeek, "Following date: {$item->toFormattedDateString()} is not Monday");
            }
            static::assertTrue($item->isWeekday(), "Following date: {$item->toFormattedDateString()} is a weekend");
        }
    }

    public function testTestingDates()
    {
        $date = Carbon::create(2015, 02, 01);
        $estimator = new DateEstimator($date);

        $results = $estimator->getTestingDates();
        static::assertEquals(6, count($results));
        foreach ($results as $item) {
            /** @var Carbon $item */
            static::assertTrue($item->isWeekday(), "Following date: {$item->toFormattedDateString()} is a weekend");
            static::assertNotEquals(Carbon::FRIDAY, $item->dayOfWeek, "Following date: {$item->toFormattedDateString()} is Friday");
        }
    }

    public function testGeneratedMonths()
    {
        $date = Carbon::create(2015, 02, 01);
        $estimator = new DateEstimator($date);

        $expectedMonths = [2, 3, 4, 5, 6, 7];

        $results = $estimator->getMonths();
        static::assertEquals(6, count($results));
        static::assertEquals($expectedMonths, $results);
    }

    /**
     * EDGE CASES
     */

    public function testMeetingDatesBetweenTwoYears() {
        $date = Carbon::create(2015, 10, 01);
        $estimator = new DateEstimator($date);

        /** @var Carbon[] $result */
        $results = $estimator->getMeetingsDates();

        static::assertEquals(6, count($results));
        foreach ($results as $item) {
            /** @var Carbon $item */
            if ($item->day !== 14) {
                static::assertTrue(Carbon::create($item->year, $item->month, 14)->isWeekend());
                static::assertEquals(Carbon::MONDAY, $item->dayOfWeek, "Following date: {$item->toFormattedDateString()} is not Monday");
            }
            static::assertTrue($item->isWeekday(), "Following date: {$item->toFormattedDateString()} is a weekend");
        }
    }

    public function testMeetingDatesOnALeapYear() {
        $date = Carbon::create(2000, 05, 01);
        $estimator = new DateEstimator($date);

        /** @var Carbon[] $result */
        $results = $estimator->getMeetingsDates();

        static::assertEquals(6, count($results));
        foreach ($results as $item) {
            /** @var Carbon $item */
            if ($item->day !== 14) {
                static::assertTrue(Carbon::create($item->year, $item->month, 14)->isWeekend());
                static::assertEquals(Carbon::MONDAY, $item->dayOfWeek, "Following date: {$item->toFormattedDateString()} is not Monday");
            }
            static::assertTrue($item->isWeekday(), "Following date: {$item->toFormattedDateString()} is a weekend");
        }
    }

    public function testTestingDatesBetweenTwoYears()
    {
        $date = Carbon::create(2015, 10, 01);
        $estimator = new DateEstimator($date);

        $results = $estimator->getTestingDates();
        static::assertEquals(6, count($results));
        foreach ($results as $item) {
            /** @var Carbon $item */
            static::assertTrue($item->isWeekday(), "Following date: {$item->toFormattedDateString()} is a weekend");
            static::assertNotEquals(Carbon::FRIDAY, $item->dayOfWeek, "Following date: {$item->toFormattedDateString()} is Friday");
        }
    }

    public function testTestingDatesOnALeapYear()
    {
        $date = Carbon::create(2000, 05, 01);
        $estimator = new DateEstimator($date);

        $results = $estimator->getTestingDates();
        static::assertEquals(6, count($results));
        foreach ($results as $item) {
            /** @var Carbon $item */
            static::assertTrue($item->isWeekday(), "Following date: {$item->toFormattedDateString()} is a weekend");
            static::assertNotEquals(Carbon::FRIDAY, $item->dayOfWeek, "Following date: {$item->toFormattedDateString()} is Friday");
        }
    }

    public function testGeneratedMonthsBetweenTwoYears()
    {
        $date = Carbon::create(2015, 10, 01);
        $estimator = new DateEstimator($date);

        $expectedMonths = [10, 11, 12, 1, 2, 3];

        $results = $estimator->getMonths();
        static::assertEquals(6, count($results));
        static::assertEquals($expectedMonths, $results);
    }

    public function testGeneratedMonthsOnALeapYear()
    {
        $date = Carbon::create(2000, 05, 01);
        $estimator = new DateEstimator($date);

        $expectedMonths = [5, 6, 7, 8, 9, 10];

        $results = $estimator->getMonths();
        static::assertEquals(6, count($results));
        static::assertEquals($expectedMonths, $results);
    }

}
