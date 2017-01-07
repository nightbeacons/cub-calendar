<?php
   $conf['error_level'] = 2;  // Show all messages on your screen, 2 = ERROR_REPORTING_DISPLAY_ALL.
   error_reporting(E_ALL);
   ini_set('display_startup_errors', TRUE);
   ini_set('display_errors',1);
date_default_timezone_set('America/Los_Angeles');

// Check for the admin cookie
$is_admin = 0;
   if (isset($_COOKIE['Calendar'])){
   $is_admin = (($_COOKIE['Calendar'] == "Admin") ? 1 : 0);
   }
include "/var/www/northshore/htdocs/calendar/db.php";
$db=mysql_connect("localhost",$SQLuser, $SQLpass);
mysql_select_db("cubberley",$db);

   // Check if the user is an admin. If not, redirect out 
   if ($is_admin){

      if (isset($_POST['jdate'])){
      processForm($db);
      } else {
      showForm($db);
      }

   } else {
   header("Location: http://www.cubberleyballroom.com/");
   }

/**
 *  Display the form
 */

function showForm($db){

$months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$alldays = array("","Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
$jdate = (isset($_GET['n']) ? $_GET['n'] :  date("n"));
$dateAry = cal_from_jd($jdate, CAL_GREGORIAN);
$current_month_number = $dateAry['month'];
$current_year         = $dateAry['year'];
$day                  = $dateAry['day'];
$curr_month           = $dateAry['monthname'];
$dayname              = $dateAry['dayname'];
$title = "Editing Dance Calendar Information for $dayname - $curr_month $day, $current_year";


$dateArg = "$current_year-" . sprintf('%02d', $current_month_number) . "-" . sprintf('%02d', $day);
$dance1=$dance2=$html=$position="";
$query = "SELECT dance1, dance2, html, position from calendar WHERE date=\"$dateArg\"";
$r = mysql_query($query, $db);
   while($myrow=mysql_fetch_assoc($r)){
   $dance1 = $myrow['dance1'];
   $dance2 = $myrow['dance2'];
   $html   = trim(base64_decode($myrow['html']));
   $position = $myrow['position'];
   }
   if ($position=="") $position="B";
if (strlen(mysql_error($db)) > 0) echo "<br>MySQL error: " . mysql_error($db);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title><?php echo $title;?></title>
<style type="text/css">
h2.title {
  font-family: Arial, Helvetica;
  text-align: center;
}
</style>

<script type="text/javascript">
window.onload=function(){
var form = document.getElementById("danceform");
   document.getElementById("updatebutton").addEventListener("click", function () {
   form.submit();
   });
   }
</script>

</head>
<?php
//<body onunload="window.opener.reload();">
?>
<body> 


<?php
//echo "<h2 class=\"title\">Editing Dance Calendar Information for<br>$dayname - $curr_month $day, $current_year</h2>";
?>  

<form method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" id="danceform" >
<table width="85%" border="0" cellpadding="9">
<tr><td>Dance&nbsp;#1:</td><td><?php selectMenu('dance1', $dance1);?></td></tr>
<tr><td>Dance&nbsp;#2:</td><td><?php selectMenu('dance2', $dance2);?></td></tr>
<tr><td valign="top">Optional Markup:</td><td><textarea name="html" cols="40" rows="9"><?php echo trim($html);?></textarea></td></tr>
<tr><td>Placement:</td><td><input type="radio" name="position" value="T" <?php if ($position=="T") echo " checked ";?>> Top
                           <input type="radio" name="position" value="B" <?php if ($position=="B") echo " checked ";?>> Bottom
</td></tr> 
<tr><td colspan="2" style="text-align:center;"><input type="button" name="button" id="updatebutton" value="Update Calendar"></td></tr>
<tr><td colspan="2" style="text-align:center;"><input type="button" name="cancel"  value="Cancel" onclick="self.close();"></td></tr>

</table><input type="hidden" name="jdate" value="<?php echo $jdate; ?>">

</body>
</html>
<?php }
//   End of showForm();



/**
 * create Select menu 
 */
function selectMenu($whichDance, $defaultValue){
$selectMenu = "<select name=\"$whichDance\">
   <option value=\"\"> - none - </option>\n";
$dances = array("Argentine Tango",
                "Bachata",
                "Bolero",
                "Cha Cha",
                "Country Two Step",
                "East Coast Swing",
                "Foxtrot",
                "Lindy Hop",
                "Merengue",
                "Nightclub Two Step",
                "Paso Doble",
                "Quickstep",
                "Rumba",
                "Salsa",
                "Salsa Rueda",
                "Samba",
                "Tango",
                "Viennese Waltz",
                "Waltz",
                "West Coast Swing",
               );
sort($dances);
  foreach($dances as $dance){
  $is_selected = (($dance == $defaultValue) ? " SELECTED " : "");
  $selectMenu .= "   <option value=\"$dance\" $is_selected>$dance</option>\n";
  }
$selectMenu .= "</select>\n";

echo $selectMenu;
}


/**
 * Process the submitted form
 */

function processForm($db){

$dance1   = $_POST['dance1'];
$dance2   = $_POST['dance2'];
$html     = base64_encode(trim($_POST['html']));
$position = $_POST['position'];
$jdate    = $_POST['jdate'];

$dateAry = cal_from_jd($jdate, CAL_GREGORIAN);
$date = $dateAry['year'] . "-" . sprintf('%02d', $dateAry['month']) . "-" . sprintf('%02d', $dateAry['day']);

$query = "INSERT INTO calendar (date, dance1, dance2, html, position) VALUES(\"$date\", \"$dance1\", \"$dance2\", \"$html\", \"$position\")
ON DUPLICATE KEY UPDATE dance1=\"$dance1\", dance2=\"$dance2\", html=\"$html\", position=\"$position\"";

$result = mysql_query($query, $db); 
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body onload="window.opener.location.reload(true);self.close();" >
</body>
</html>
<?php

}

