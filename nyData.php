<?php

/*
 *Superconsulta 
 *  */

//Global variables
$manhattan = 0;
$brooklyn = 0;
$queens = 0;
$bronx = 0;
$stateIsland = 0;

//REQUEST variables
$days = array();
$months = array();
$initialHour;
$finishedHour;
$initialYear;
$finishedYear;
$offenses = array();

//asignacion de variables
if(isset($_REQUEST["dayOfWeek"])){
    $days = $_REQUEST["dayOfWeek"];
}

if(isset($_REQUEST["months"])){
    $months = $_REQUEST["months"];
}

if(isset($_REQUEST["initialHour"])){
    $initialHour = $_REQUEST["initialHour"];
}

if(isset($_REQUEST["finishedHour"])){
    $finishedHour = $_REQUEST["finishedHour"];
}

if(isset($_REQUEST["initialYear"])){
    $initialYear = $_REQUEST["initialYear"];
}

if(isset($_REQUEST["finishedYear"])){
    $finishedYear = $_REQUEST["finishedYear"];
}

if(isset($_REQUEST["offense"])){
    $offenses = $_REQUEST["offense"];
}

$flag = true;

$queryWord = "SELECT * from crime ";

if(count($days) > 0){
  for($i = 0; $i < count($days); $i++){
      if($flag){
          $queryWord = $queryWord." WHERE DayOfWeek='".$days[$i]."' ";
          $flag = false;
      }else{
          $queryWord = $queryWord." OR DayOfWeek='".$days[$i]."' ";
      }
  }  
}

if(count($months) > 0){
    for($i = 0 ; $i < count($months); $i++){
        if($flag){
            $queryWord = $queryWord." WHERE OcurrenceMonth='".$months[$i]."' ";
            $flag = false;
        }else{
            $queryWord = $queryWord." OR OcurrenceMonth='".$months[$i]."' ";
        }
    }
}

if(count($offenses) > 0){
    for($i = 0 ; $i < count($offenses); $i++){
        if($flag){
            $queryWord = $queryWord." WHERE OffenseClasification='".$offenses[$i]."' ";
            $flag = false;
        }else{
            $queryWord = $queryWord." OR OffenseClasification='".$offenses[$i]."' ";
        }
    }
}

if(isset($_REQUEST["initialHour"])&&isset($_REQUEST["finishedHour"])&&$initialHour!=""
        &&$finishedHour!=""){
    if($flag){
        $queryWord = $queryWord." WHERE OcurrenceHour>=".$initialHour." AND OcurrenceHour<=".$finishedHour;
        $flag = false;
    }else{
        $queryWord = $queryWord." OR OcurrenceHour>=".$initialHour." AND OcurrenceHour<=".$finishedHour;
    }
}

if(isset($_REQUEST["initialYear"])&&isset($_REQUEST["finishedYear"])&&$initialYear!=""
        &&$finishedYear!=""){
    if($flag){
        $queryWord = $queryWord." WHERE OcurrenceYear>=".$initialYear." AND OcurrenceYear<=".$finishedYear;
        $flag = false;
    }else{
        $queryWord = $queryWord." OR OcurrenceYear>=".$initialYear." AND OcurrenceYear<=".$finishedYear;
    }
}

echo $queryWord."<br>";

$markers = "[";
$markers_array = array();

$host = "127.0.0.1";
$user = "root";
$password = "";
$database = "mydb";
$link = mysqli_connect($host, $user, $password, $database) or die(mysqli_error($link));
//$link = mysqli_connect("mysql.hostinger.es", "u917846440_root", "8160-RaK", "u917846440_mydb")
  //      or die(mysqli_error($link));
$query = mysqli_query($link, $queryWord) or die(mysqli_error($link));
while($lista = mysqli_fetch_assoc($query)){
    
    $icon = "red-dot";
               switch($lista["Borough"]){
                   case "MANHATTAN":
                       $manhattan++;
                       break;
                   case "BROOKLYN":
                       $icon = "blue-dot";
                       $brooklyn++;
                       break;
                   case "QUEENS":
                       $icon = "yellow-dot";
                       $queens++;
                       break;
                   case "BRONX":
                       $icon = "green-dot";
                       $bronx++;
                       break;
                   case "STATEN ISLAND":
                       $icon = "orange-dot";
                       $stateIsland++;
                       break;
                   default : break;
               }
    
               array_push($markers_array, "['".$lista["OffenseClasification"]."',"
                       . "".$lista["Longitude"].",".$lista["Latitude"].",'./img/".$icon.".png']");
               
    //echo $lista["Borough"]." ".$lista["Offense"]."<br>";
}

for($i = 0; $i < count($markers_array); $i++){
               if($i != count($markers_array) -1){
                   $markers = $markers."".$markers_array[$i].",";
               }
               else{
                   $markers = $markers."".$array_markers[$i];
               }
           }
           
           $markers = $markers."]";
           
           //caso markers
           session_start();
           $_SESSION["markers"] = $markers;

//echo var_dump($_REQUEST["dayOfWeek"])."<br>";
//echo var_dump($_REQUEST["months"])."<br>";

header("Location: index.php?manhattan=".$manhattan."&brooklyn=".$brooklyn."&bronx=".$bronx.""
       . "&queens=".$queens."&stateIsland=".$stateIsland);

mysqli_close($link);