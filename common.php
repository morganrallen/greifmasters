<?
session_start ();
require_once "config.php";
require_once 'inc/functions.inc.php';

function __autoload($class_name) {
    require_once 'inc/classes/' . $class_name . '.class.php';
}

?>
