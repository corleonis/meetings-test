<?php
namespace MediaMath\Csv;

use MediaMath\Datum\Datum;

class MeetingsCsvGenerator implements CsvGenerator
{
    /**
     * @var resource file pointer
     */
    private $file;

    /**
     * @var array Data to be written
     */
    private $data = [];

    public function __construct(Datum $data, $filePath)
    {
        $this->data = $data->getData();
        $this->file = fopen(BASE_DIR . '/' . $filePath, 'w');
    }

    public function write()
    {
        $writeResult = true;
        foreach ($this->data as $row) {
            $result = fputcsv($this->file, $row, static::CSV_DELIMITER);
            $writeResult = $writeResult && !($result === false);
        }
        return $writeResult;
    }

    public function __destruct()
    {
        fclose($this->file);
    }
}
