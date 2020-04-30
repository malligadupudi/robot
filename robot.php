<?php
/**
 * @author Malli
 * @copyright 2020 Valuelabs
 */
require_once __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Console\Application;
use App\Command\RobotCommand;

$app = new Application('Robot App', 'v1');
$app -> add(new RobotCommand());
$app->run();
