<?php
$servername='localhost';
$username='root';
$password='';
$dbname = "test1";
$conn=mysqli_connect($servername,$username,$password,"$dbname");
if(!$conn){
   die('Could not Connect My Sql:' .mysql_error());
}
?>