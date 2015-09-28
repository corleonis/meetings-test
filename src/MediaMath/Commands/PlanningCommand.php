<?php
namespace MediaMath\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use MediaMath\Csv\MeetingsCsvGenerator;
use MediaMath\DateEstimator;
use MediaMath\Datum\MeetingsDatesDatum;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PlanningCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('meeting:planning')
            ->setDescription('Meeting planner. For given date "Y-m-d", will generate CSV file with all possible dates for meetings.')
            ->addArgument(
                'date',
                InputArgument::REQUIRED,
                'Starting date?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startDate = $input->getArgument('date');

        $dateEstimator = new DateEstimator(Carbon::createFromFormat('Y-m-d', $startDate));
        $meetingsDates = $dateEstimator->getMeetingsDates();
        $testingDates = $dateEstimator->getTestingDates();
        $months = $dateEstimator->getMonths();

        $datum = new MeetingsDatesDatum($meetingsDates, $testingDates, $months);
        $csvWrite = new MeetingsCsvGenerator($datum, 'dates.csv');
        $result = $csvWrite->write();

        if ($result) {
            $text = 'File written successfully';
        } else {
            $text = 'There was an error while writing the file';
        }

        $output->writeln($text);
    }
}