<?php
include_once "config.php";

$id=$_POST['id'];
$email=$_POST['email'];
$password=$_POST['password'];
$full_name=$_POST['full_name'];

global $db;
// $data = $db->real_escape_string($data);
$res = db_query( "INSERT INTO `users` (`id`, `email`, `password`, `full_name`) VALUES ('$id', '$email', '$password', '$full_name')");  
return $res;


?>
