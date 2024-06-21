<?php
//LOCALHOT*****************
$host="localhost";
$user="root";
$pass="";
$db="verdemas";

//HOSTING******************
/*

$host="localhost";
$user="";
$pass="";
$db="";
*/
try{
    $conexion=new PDO("mysql:host=$host;dbname=$db",$user,$pass);
    //echo "SIIII conecto";
}catch(PDOException $e){
    echo "ERROR no puedo conectar".$e->getMessage();
}

