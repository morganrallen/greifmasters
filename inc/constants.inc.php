<?php

include 'db.inc.php';

define ('BASE', '/greifmasters/admin');
define ('PAGE_ROOT', '/greifmasters');

$query = ("SELECT * FROM settings");
$result = mysql_query($query) or die(mysql_error());
$settings = mysql_fetch_assoc($result);

unset($query, $result);

// database stuff

define ('DB_HOST',$settings['db_host']);
define ('DB_USER',$settings['db_pass']);
define ('DB_PASS',$settings['db_user']);
define ('DB_NAME',$settings['db_name']);



// date and time settings

define ('LOCAL_DATE_FORMAT',$settings['local_date_format']);
define ('LOCAL_TIME_FORMAT',$settings['local_time_format']);
define ('DATE_SEPERATOR',$settings['date_seperator']);


// include paths

define ('TPL_INCLUDE_PATH', 'inc/tpl/');



// grafics

define ('GFX_PATH','/gfx');

define ('TEAM_LOGOS_PATH', PAGE_ROOT.'/gfx/team_logos');


define ('GFX_EDIT','edit.gif');
define ('GFX_DELETE','delete.gif');
define ('GFX_VIEW','view.gif');

?>
