<?php
   $conf['error_level'] = 2;  // Show all messages on your screen, 2 = ERROR_REPORTING_DISPLAY_ALL.
   error_reporting(E_ALL);
   ini_set('display_startup_errors', TRUE);
   ini_set('display_errors',1);
// Check for the admin cookie
$is_admin = 0;
   if (isset($_COOKIE['Calendar'])){
   $is_admin = (($_COOKIE['Calendar'] == "Admin") ? 1 : 0);
   }
$is_admin = 1;
$text_file = "bottom_text.php";
date_default_timezone_set('America/Los_Angeles');
include "/var/www/northshore/htdocs/calendar/db.php";
$db=mysql_connect("localhost",$SQLuser, $SQLpass);
mysql_select_db("cubberley",$db);

$months = array("","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
$args = $_GET;
$current_month_number = (isset($_GET['mn']) ? $current_month_number=$_GET['mn'] :  date("n"));
$current_year         = (isset($_GET['yr']) ? $current_year        =$_GET['yr'] :  date("Y"));
$curr_month =  $months[$current_month_number];

$prev_month_year  =  $current_year;   // Year of the previous month
$prev_month       = $current_month_number - 1;
   if ($prev_month < 1){
   $prev_month = 12;
   $prev_month_year = $current_year - 1;
   }
$prev_month_name = $months[$prev_month];

$next_month_year = $current_year;
$next_month = $current_month_number + 1;
   if ($next_month > 12){
   $next_month = 1;
   $next_month_year = $current_year + 1;
   }
$next_month_name = $months[$next_month];
$xx = "";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title><?php echo $curr_month . "'s";?> Dance Calendar</title>
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style.css">

<style type="text/css">
th.dayname {
   color: black;
   width: 14.286%;
   font-size: 14pt;
   font-family: Arial, Helvetica;
   font-weight: bold;
   text-align: center;
   vertical-align: top;
   background-color: #87cefa;
}

h1.title{
  text-align:center;
  color: white;
  font-family: Arial, Helvetica;
  font-size: 32px;
  white-space: nowrap;
}

td.calbox{
  vertical-align: top;
  background-color: white;
  height: 80px;
}

td.calbox_today{
  vertical-align: top;
//  background-color: red;
  height: 80px;
}


td.calprevnext {
  vertical-align: middle;
  text-align:center;
  background-color: black;
}
p {
  color:white;
}

a.calnavlink{
  color: #87cefa;
  text-decoration: none;
  font-family: Arial, Helvetica;
  font-size: 24px;
}

a.calnavlink:hover{
  color: #87cefa;
  text-decoration: underline;
}


.daynumber{
  color: black;
  font-size: 16px;
  font-family: Arial, Helvetica;
  font-weight: 700;
}

.daynumber_today{
  color: red;
  font-size: 16px;
  font-family: Arial, Helvetica;
  font-weight: 800;
}

p.eventLine{
  color: black;
  font-size: 10pt;
  font-family: Arial, Helvetica;
}

div.calsub{
  font-weight: 400;
  font-size: 10pt;
}

div.caladmin{
  font-size: 8pt;
  vertical-align: bottom;
  float:right;
  position: relative;
  color: blue;
  top: 60px;
}

p.caladminlink{
  color: blue;
  cursor:pointer;
  font-family = Arial, Helvetica;
  font-size: 8pt;
}
</style>
</head>
<body style="background-color:black;">
<IMG SRC="/image/dance.gif"  ALIGN=BOTTOM><IMG SRC="/image/calbanner.gif">

<a name="calendar"></a>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td width="33%">&nbsp;</td><td><h1 class="title"><?php echo "$curr_month Dance Calendar";?></h1></td><td width="33%"><img src="http://api.usno.navy.mil/imagery/moon.png" style="position:relative:left:50%;width:75px;height:75px;"></td></tr>

</table>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr><td style="background-color: #ccffcc;width:14%;">&nbsp;</td><td TITLE="http://www.fridayatthepav.com">&nbsp;<i>Dance lessons and parties hosted by Judy and Samy</i></td></tr>
<tr><td style="background-color:white;">&nbsp;&nbsp;</td><td>&nbsp;<i>Dance lessons and parties hosted by Phil Mast</i> </td></tr>
<tr><td>&nbsp;</td><td><small>&nbsp; &nbsp; &nbsp; (Click on any date for more information.)</small></td></tr>
</table>

<table border="1" cellpadding="4" cellspacing="0" cols="7" width="100%" style="background-color:white;">
<tr>
<th class="dayname">Sunday</th><th class="dayname">Monday</th><th class="dayname">Tuesday</th>
<th class="dayname">Wednesday<div class="calsub">6:45-8:30 Lesson<br>8:30-9:45 Dance</div></th>
<th class="dayname">Thursday</th>
<th class="dayname">Friday<div class="calsub">8-9 Lesson<br>9-12 Dance</div></th>
<th class="dayname">Saturday<div class="calsub">8-9 Lesson<br>9-11:45 Dance</div></th>
</tr>

<?php
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month_number, $current_year);
$jdate_first_of_month = cal_to_jd(CAL_GREGORIAN, $current_month_number, 1, $current_year);
$month_begins_on = jddayofweek ($jdate_first_of_month, 0);
echo "<tr>";
   for ($daynum = 1; $daynum <= $month_begins_on; $daynum++){
   echo "<td>&nbsp;</td>";
   }

   for ($daycounter = 1; $daycounter <= $days_in_month; $daycounter++){
   // Print the calendar box and events
   $events = getEvents($daycounter, $current_month_number, $current_year, $db);
   $is_today = (($daycounter == date("j")) AND ($current_month_number == date("n")));
   $td_class = ($is_today ? "calbox_today" : "calbox");
   $daynum_class = ($is_today ? "daynumber_today" : "daynumber");
   $daynum_style = (($daynum==6) ?  " style=\"background-color: #ccffcc;\" " : "");
   $this_jdate=cal_to_jd(CAL_GREGORIAN, $current_month_number, $daynum, $current_year);
   $edit_link = (($is_admin) ? "<div class=\"caladmin\"><p class=\"caladminlink\" onclick=\"window.open('admin/update.php?n=$this_jdate','targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=500%,height=600%,screenX=50%,screenY=50%')\">Edit</p></div>" : "");
   // Display the calendar date cell
   echo "<td class=\"$td_class\" $daynum_style>$edit_link<span class=\"$daynum_class\">$daycounter</span><p class=\"eventLine\">$events</p></td>";

      if ((++$daynum > 7) AND ($daycounter != $days_in_month)) {
      $daynum=1;
      echo "</tr>\n<tr>";
      }

   }
   if ($daynum > 1){
     for ($end_of_month = $daynum; $end_of_month<=7; $end_of_month++){
     echo "<td>&nbsp;</td>";
     }
   }

?>
</tr>
<tr><td class="calprevnext"><a class="calnavlink" href="/calendar/<?php echo "?mn=" . $prev_month . "&yr=" . $prev_month_year . "#calendar\">" . $prev_month_name . "<br>Calendar</a></td>";?>
<td colspan="5" class="calprevnext">&nbsp;</td>
<td class="calprevnext"><a class="calnavlink" href="/calendar/<?php echo "?mn=" . $next_month . "&yr=" . $next_month_year . "#calendar\">" . $next_month_name . "<br>Calendar</a></td>";?>
</tr>
</table>
<?php
include($text_file);
echo "</body></html>";



/**
 *  Fetch dance events from DB, format, and return as a string
 */
function getEvents($day, $month, $year, $db){
$events = $dance1 = $dance2 = $html = $position = "";

$dateArg = "$year-" . sprintf('%02d', $month) . "-" . sprintf('%02d', $day);
$query = "SELECT dance1, dance2, html, position from calendar WHERE date=\"$dateArg\"";
$r = mysql_query($query, $db);
   while($myrow=mysql_fetch_assoc($r)){
   $dance1 = $myrow['dance1'];
   $dance2 = $myrow['dance2'];
   $html   = trim($myrow['html']);
   $position = $myrow['position']; 
   }

   if($position == '') $position="B";
$events = $dance1;

   if(strlen($dance2) > 0)  $events .= " / $dance2";

   if(strlen($html) > 0) {
      if ($position == "T") $events = $html . "<br>" . $events;
      if ($position == "B") $events .= "<br>" . $html;
   }

return($events);
}


?>
