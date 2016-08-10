<?php
$dbhost = 'localhost';
$dbuser = 'adminlogin';
$dbpass = 'letmein1!';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
mysql_select_db('logindemo') or die("Database not exists");
?>
