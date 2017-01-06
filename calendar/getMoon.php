#!/usr/bin/php
<?php

$moon_url  = "http://api.usno.navy.mil/imagery/moon.png";
$image_dir = "/var/www/northshore/htdocs/calendar/";
$size      = "75x75";
$uagent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36";
$wget_cmd = "/usr/bin/wget -q -t3 --random-wait 2 --user-agent=\"$uagent\"  -O " . $image_dir . "moon.png $moon_url";
$resize_cmd = "/usr/bin/convert " .  $image_dir . "moon.png -geometry $size PNG24:" . $image_dir . "moon_" . $size . ".png";

$tmp=`$wget_cmd`;
$tmp=`$resize_cmd`;
//  convert newmoon.png -fuzz 25%  -transparent black test24.png

