<?php
//Global variables
$manhattan = 0; $brooklyn = 0; $queens = 0; $bronx = 0; $stateIsland = 0;
$markers = "[";
$array_markers = array();
if(isset($_REQUEST["manhattan"])&&isset($_REQUEST["brooklyn"])&&
        isset($_REQUEST["queens"])&&isset($_REQUEST["bronx"])&&
        isset($_REQUEST["stateIsland"])){
    
    $manhattan = $_REQUEST["manhattan"];
    $brooklyn = $_REQUEST["brooklyn"];
    $queens = $_REQUEST["queens"];
    $bronx = $_REQUEST["bronx"];
    $stateIsland = $_REQUEST["stateIsland"];
    
    //caso marcadores
    session_start();
    $markers = $_SESSION["markers"];
    
        }else{
           $link = mysqli_connect("127.0.0.1", "root", "", "mydb") or die(mysqli_error($link));
           //$link = mysqli_connect("mysql.hostinger.es", "u917846440_root", "8160-RaK", "u917846440_mydb")
             //      or die(mysqli_error($link));
            $query = mysqli_query($link, "SELECT * from crime") or die(mysqli_error($link));
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
               
               array_push($array_markers, "['".$lista["OffenseClasification"]."',"
                       . "".$lista["Longitude"].",".$lista["Latitude"].",'./img/".$icon.".png']");
           }
           
           for($i = 0; $i < count($array_markers); $i++){
               if($i != count($array_markers) -1){
                   $markers = $markers."".$array_markers[$i].",";
               }
               else{
                   $markers = $markers."".$array_markers[$i];
               }
           }
           
           $markers = $markers."]";
        }

?>

<!DOCTYPE html>
<html>
<head>
  <title>New York Crimes</title>
  <link rel="stylesheet" href="jquery-jvectormap-2.0.3.css" type="text/css" media="screen"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="jquery-jvectormap-2.0.3.min.js"></script>
  <script src="ny.js"></script>
   <script src="src/vector-canvas.js"></script>
  <script src="src/simple-scale.js"></script>
  <script src="src/ordinal-scale.js"></script>
  <script src="src/numeric-scale.js"></script>
  <script src="src/color-scale.js"></script>
  <script src="src/legend.js"></script>
  <script src="src/data-series.js"></script>
  <script src="src/proj.js"></script>

</head>
<body>
<center><h1>
        Crime Visualization of New York City
    </h1></center>
<center><table>
        <tr>
            <td align="center">
                <input type="button" onclick="showTreeMap()" value="TreeMap">
                <input type="button" onclick="showGoogleMap()" value="MapView">
            </td>
            <td></td>
        </tr>
        <tr>
            <td>
                <div id="mapview">
                    <div id="world-map"></div> 
                    <div id="map" style="display: none;"></div>
                </div>
                
            </td>
            <td>
                <form action="nyData.php">
               <div id="controllers" style="width: 200px; height: 400px; border:2px;
                    border-color: rgba(0,0,0,0.9);
                    opacity: 0.9; border-radius: 2px;
                    overflow: scroll;"> 
               
                   <div id="dayOfWeekControlers" align="center" style="border: 2px; border-color: black; 
                        border-radius: 2px;">
                       <h3 style="color: #FFFFF;">D&iacute;as de la semana</h3>
                       <ul style="list-style-type: none;">
                           <li>
                               <input type="checkbox" name="dayOfWeek[]" value="Monday" 
                                      style="color: #FFFFF;"> Lunes 
                           </li>
                           <li>
                               <input type="checkbox" name="dayOfWeek[]" value="Tuesday" 
                                      style="color: #FFFFF;"> Martes
                           </li>
                           <li>
                               <input type="checkbox" name="dayOfWeek[]" value="Wednesday"
                                       style="color: #FFFFF;"> Mi&eacute;rcoles
                           </li>
                           <li>
                               <input type="checkbox" name="dayOfWeek[]" value="Thursday"
                                      style="color: #FFFFF;"> <font style="color: #FFFFF;">Jueves <font>
                           </li>
                           <li>
                               <input type="checkbox" name="dayOfWeek[]" value="Friday"
                                       style="color: #FFFFF;"> Viernes
                           </li>
                           <li>
                               <input type="checkbox" name="dayOfWeek[]" value="Saturday"
                                       style="color: #FFFFF;"> S&aacute;bado
                           </li>
                           <li>
                               <input type="checkbox" name="dayOfWeek[]" value="Sunday"
                                       style="color: #FFFFF;"> Domingo
                           </li>
                       </ul>                     
                   </div>
                   
                   <div align="center" id="Months">
                       
                       <h3>
                           Meses del a&ntilde;o
                       </h3>
                       
                       <ul style="list-style-type: none;">
                           <li>
                               <input type="checkbox" value="Jan" name="months[]"> Enero
                           </li>
                           <li>
                               <input type="checkbox" value="Feb" name="months[]"> Febrero
                           </li>
                           <li>
                               <input type="checkbox" value="Mar" name="months[]"> Marzo
                           </li>
                           <li>
                               <input type="checkbox" value="Apr" name="months[]"> Abril
                           </li>
                           <li>
                               <input type="checkbox" value="May" name="months[]"> Mayo
                           </li>
                           <li>
                               <input type="checkbox" value="Jun" name="months[]"> Junio
                           </li>
                           <li>
                               <input type="checkbox" value="Jul" name="months[]"> Julio
                           </li>
                           <li>
                               <input type="checkbox" value="Aug" name="months[]"> Agosto
                           </li>
                           <li>
                               <input type="checkbox" value="Sep" name="months[]"> Septiembre
                           </li>
                           <li>
                               <input type="checkbox" value="Oct" name="months[]"> Octubre
                           </li>
                           <li>
                               <input type="checkbox" value="Nov" name="months[]"> Noviembre
                           </li>
                           <li>
                               <input type="checkbox" value="Dec" name="months[]"> Diciembre
                           </li>
                       </ul>
                   </div>
                   <div id="hours">
                       <h3>
                           Intervalo de Horas
                       </h3>
                       Hora de Inicio:<input type="number" min="0" max="23" name="initialHour" />
                       Hora de Termino: <input type="number" min="0" max="23" name="finishedHour" />
                   </div>
                   <div id="years">
                       <h3>
                           Filtro de a&ntilde;os
                       </h3>
                       Inicio: <input type="number" min="1999" max="2016" 
                                                    name="initialYear" />
                       T&eacute;rmino: <input type="number" min="1999" max="2016" 
                                                            name="finishedYear" />
                   </div>
                   <div id="offenses">
                       <h3>
                           Listado de Delitos
                       </h3>
                       <ul style="list-style-type: none;">
                           <li>
                               <input type="checkbox" value="BURGLARY" name="offense[]" /> Asalto a casa
                           </li>
                           <li>
                               <input type="checkbox" value="FELONY ASSAULT" 
                                      name="offense[]" /> Asalto con violiencia
                           </li>
                           <li>
                               <input type="checkbox" value="GRAND LARCENY" 
                                      name="offense[]" /> Hurto
                           </li>
                           <li>
                               <input type="checkbox" value="GRAND LARCENY OF MOTOR VEHICLE" 
                                      name="offense[]" /> Hurto de vehiclulo
                           </li>
                           <li>
                               <input type="checkbox" value="RAPE" name="offense[]" /> Violaci&oacute;n
                           </li>
                           <li>
                               <input type="checkbox" value="ROBBERY" name="offense[]" /> Robo
                           </li>
                       </ul>
                   </div>
                   <div id="interact" align="center">
                       <input type="Submit" value="Aplicar Filtros">
                   </div>
               </div>
                </form>
            </td>
        </tr>
              
    </table></center>
  <script>
    $(function(){
      $('#world-map').vectorMap({
          map: 'us-ny-newyork_mill',
          markers: <?php echo$markers; ?>,
      series: {
          regions: [{
            scale: ['#C8EEFF', '#0071A4'],
            attribute: 'fill',
            normalizeFunction: 'polinomial',
            values: {
              '1': <?php echo$manhattan; ?>, //Manhattan
                '2': <?php echo$bronx; ?>, //Bronx
                '3': <?php echo$brooklyn; ?>, //Brooklyn
                '4': <?php echo$queens; ?>, //Queens
                '5': <?php echo$stateIsland; ?> //State Island
            }
          }]
        }
      });
      
      
    });

  </script>
  
  <script language="javascript">
      var map;
      function showTreeMap(){
          
          $('#world-map').show();
          $('#map').hide();
          google.maps.event.trigger(map, 'resize');
      }
      function showGoogleMap(){
      $('#world-map').hide();
      $('#map').css('display','block');
      initMap();
      }

function initMap() {
    //var myLatLng = {lat: 40.70, lng: -73.90};
    
    var crimes = <?php echo$markers; ?>;
    
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 40.7127, lng: -73.985428},
    zoom: 10
  });
  
  for(var i = 0; i < crimes.length; i++){
      var point = crimes[i];
      var marker = new google.maps.Marker({
    position: {lat: point[1], lng: point[2]},
    map: map,
    title: point[0],
    icon: point[3]
  });
  }
  
  
}
  </script>
  <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6wujKEgU393c3BPD1m2OABJ35hygenXU&callback=initMap">
    </script>
  <style>
      #world-map{
          width: 600px;
          height: 400px;
          margin-top: 2px;
          border-radius: 2px;
      }
      #map{
          width: 600px;
          height: 400px;
      }
  </style>
</body>
</html>