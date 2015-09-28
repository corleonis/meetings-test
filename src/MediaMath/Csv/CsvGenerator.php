<?php
namespace MediaMath\Csv;

use MediaMath\Datum\Datum;

interface CsvGenerator
{
    const CSV_DELIMITER = ',';

    /**
     * Creates CSV writer with data array and file path.
     * If the file doesn't exists on disk it's created.
     * If it exists all data will be overwritten.
     * @param Datum $data
     * @param string $filePath
     */
    public function __construct(Datum $data, $filePath);

    /**
     * Writes the given data to a CSV file on disk.
     * @return boolean
     */
    public function write();
}
