<html>
<head>
<title>
polygon direction
</title>
</head>
<style>
body{
  background-color:orange;}
input[type=text]{
  background-color:yellow;
  padding:20px;
  font-family:arial;
  border-color:red;
  font-style:italic;
  width:100px;
  height:20px;
}
input[type=submit]{
  background-color:blue;
  padding:20px;
  font-family:arial;
  border-color:red;
  font-style:italic;
  width:100px;
  height:20px;}
</style>
<body>
<form action="mapd.php" method="POST">
latitude 1:<input type="text" name="latitude1" value=" ">
longitude1:<input type="text" name="longitude1" value=" "><br>
latitude 2:<input type="text" name="latitude2" value=" ">
longitude2:<input type="text" name="longitude2" value=" "><br>
latitude 3:<input type="text" name="latitude3" value=" ">
longitude3:<input type="text" name="longitude3" value=" "><br>
zoom :<input type="text" name="zoom" value=" ">
submit:<input type="submit" name="polygonmap" value="polygonmap ">
</form>
<?php
$servername="localhost";
$username="root";
$password="";
$dbname="mapdirection";
if(isset($_POST['polygonmap'])){
$latitude1=$_POST['latitude1'];
$longitude1=$_POST['longitude1'];
$latitude2=$_POST['latitude2'];
$longitude2=$_POST['longitude2'];
$latitude3=$_POST['latitude3'];
$longitude3=$_POST['longitude3'];
$zoom=$_POST['zoom'];
$nexthour=time()+(60*60);
$timestamp=date('H:i:s');
$time1=date('H:i:s',$nexthour);
if(!empty($latitude1)&&!empty($longitude1)&&!empty($latitude2)&&!empty($longitude2)&&!empty($latitude3)&&!empty($longitude3)&&!empty($zoom)){
$conn=new mysqli("localhost","root","","mapdirection");
if($conn->connect_error)
{ die("connection failed:".$conn->connect_error);}
$sql="SELECT * FROM mydb WHERE lat1=$latitude1 AND long1=$longitude1 AND lat2=$latitude2 AND long2=$longitude2 AND lat3=$latitude3 AND long3=$longitude3 AND zoom=$zoom";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==0)
{$sql2="INSERT INTO mydb(lat1,long1,lat2,long2,lat3,long3,zoom,time) VALUES ('$latitude1','$longitude1','$latitude2','$longitude2','$latitude3','$longitude3','$zoom','$timestamp')";

if($conn->query($sql2)==TRUE)
{
 echo "new record created";
}}
else { echo "error";}}}

if($timestamp>=$time1)
{ $sql3="UPDATE mydb SET time=date('H:i:s') WHERE lat1=$latitude1 AND long1=$longitude1 AND lat2=$latitude2 AND long2=$longitude2 AND lat3=$latitude3 AND long3=$longitude3 AND zoom=$zoom";
  if ($conn->query($sql2) === TRUE) 
                 {
              echo " record updated successfully";
                }
            else {
                   echo "Error: " . $sql2 . "<br>" . $conn->error;
                  }}
?>
<div id="googleMap" style="width:500px; height:380px;">
</div>
<script src="http://maps.googleapis.com/maps/api/js">
</script>
<script type="text/javascript">
var x=new google.maps.LatLng(<?php echo $latitude1;?>,<?php echo $longitude1;?>);
var stavanger=new google.maps.LatLng(<?php echo $latitude2;?>,<?php echo $longitude2;?>);
var amsterdam=new google.maps.LatLng(<?php echo $latitude1;?>,<?php echo $longitude1;?>);
var london=new google.maps.LatLng(<?php echo $latitude3;?>,<?php echo $longitude3;?>);
function initialize()
{
var mapProp = {
  center:x,
  zoom:<?php echo $zoom;?>,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var myTrip=[stavanger,amsterdam,london,stavanger];
var flightPath=new google.maps.Polygon({
  path:myTrip,
  strokeColor:"#0000FF",
  strokeOpacity:0.8,
  strokeWeight:2,
  fillColor:"#0000FF",
  fillOpacity:0.4
  });

flightPath.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</body>
</html>
