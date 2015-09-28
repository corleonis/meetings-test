<?php
namespace MediaMath\Datum;

/**
 * Interface for data object to pass data to CSV writer.
 * @package MediaMath\Datum
 */
interface Datum
{
    /**
     * Returns the data required to be written to CSV.
     * @return array
     */
    public function getData();
}
