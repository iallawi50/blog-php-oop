<?php

use App\Models\User;

require "./vendor/autoload.php";
session_start();


use App\App;
use App\Middleware\Auth;
use Symfony\Component\Dotenv\Dotenv;
use Carbon\Carbon;

Carbon::setLocale("ar");

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');
App::set("config", require "config.php");


// // create a log channel
// $log = new Logger('name');
// $log->pushHandler(new StreamHandler('queries.log', Level::Debug));

use App\DBConnection;
use App\QueryBuilder;

QueryBuilder::make(DBConnection::make());
