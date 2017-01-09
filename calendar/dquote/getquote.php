#!/usr/bin/php
<?php
include ("../db.php");
$mysqli = new mysqli("localhost",$SQLuser, $SQLpass, "cubberley");

if ($mysqli->connect_errno) {
    echo "Error: " . $mysqli->connect_error . "\n";
    die;
}

$result = $mysqli->query("SELECT COUNT(*) as count FROM dquote");
$row = $result->fetch_assoc();
$count = $row['count'];

$offset = rand(0,$count);
$result = $mysqli->query("SELECT * FROM dquote LIMIT 1 OFFSET $offset");
$row = $result->fetch_assoc();
$quote = $row['quote'];

echo $quote;

