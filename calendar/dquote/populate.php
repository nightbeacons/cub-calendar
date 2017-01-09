#!/usr/bin/php
<?php
include ("../db.php");
$db=mysqli_connect("localhost",$SQLuser, $SQLpass, "cubberley");

$string = file_get_contents("quotes.txt");

$quotes = explode("%", $string);

foreach($quotes as $onequote){
   $onequote=trim($onequote);
   if (strlen($onequote) > 1) {
   $s = "'" . mysqli_real_escape_string($db, $onequote) . "'";
   $q = "INSERT INTO dquote (quote) VALUES($s)";
   $r = mysqli_query($db, $q);
    if (strlen(mysqli_error($db)) > 0) echo "<br>MySQL error: " . mysqli_error($db);
   }

}


