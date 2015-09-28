<?php
require __DIR__.'/vendor/autoload.php';

use MediaMath\Commands\PlanningCommand;
use Symfony\Component\Console\Application;

define('BASE_DIR', __DIR__);

$application = new Application();
$application->add(new PlanningCommand());
$application->run();