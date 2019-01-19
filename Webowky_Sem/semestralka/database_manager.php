<?php
$username = 'Rando';
$password = 'rando';
$host = 'localhost';
$dbname = 'sem_databaze';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


//PDO has three error handling modes.
//
//PDO::ERRMODE_SILENT acts like mysql_* where you must check each result and then look at $db->errorInfo(); to get the error details.
//PDO::ERRMODE_WARNING throws PHP Warnings
//PDO::ERRMODE_EXCEPTION throws PDOException. In my opinion this is the mode you should use. It acts very much like or die(mysql_error()); when it isn't caught, but unlike or die() the PDOException can be caught and handled gracefully if you choose to do so.







?>