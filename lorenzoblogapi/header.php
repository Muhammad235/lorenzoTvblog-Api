<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

require('../config/conn.php');

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable(__DIR__ . '../');
$dotenv->load();

