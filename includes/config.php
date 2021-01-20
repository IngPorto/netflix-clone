<?php
// Activa el almacenamiento en búfer de salida. Se ejecuta antes de mostrar
// cualquier contenido en el navegador. Se puede user para modificar la 
// información que se va a imprimir antes de que se muestre
ob_start(); 

session_start();

date_default_timezone_set('America/Bogota');

try{
    $connexion = new PDO("mysql:dbname=netflix_clone;host=localhost", "root", "");
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch(PDOException $e){
    exit('Connection failed: ' . $e->getMessage());
}