<?PHP
//index.php
session_start();

if (!(isset($_SESSION['username']) && $_SESSION['username'] != '')) {
header ("Location: signin.html");
}
else {
	$walker_id = $_SESSION['walker_id'];
	$username = $_SESSION['username'];
}
include 'storedInfo.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "solomreb-db", $myPassword,"solomreb-db");
if (!$mysqli || $mysqli->connect_errno){
    echo "Connection error " . $mysqli->connect_errno . " " . $mysqli->connect_error;
    }
 
?>

<!DOCTYPE html>
<html>
<head>
  	<title>Dog Walking Database</title>
  	<meta charset="utf-8">
  	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</head>

<body>
    <div class="container">
      <h2>Dog Walking Database</h2>
        <p class="navbar-text navbar-right"><?php echo "Logged in as " . $username . " | ";?><a href="logout.php" class="navbar-link">Log out</a></p>       

    </div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Update Contact Info</h3>
  </div>
  <div class="panel-body">

<?php

$query = "SELECT * FROM walkers WHERE walker_id = '$walker_id'";
	if (!($stmt = mysqli_query($mysqli, $query))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
echo "<form name='walkerInfo' method='get' action='editContactInfo.php' class='form-inline'><table>";
while ($row = mysqli_fetch_array($stmt)) {
	echo "<tr><td>" . $row['fname'] . " " . $row['lname'] ."</td></tr>";
	echo "<tr><td>Phone<input type='tel' name='phone' value='" . $row['phone'] . "'>";
	echo "<td>Email<input type='email' name='email' value='" . $row['email'] . "'>";
}

echo "<td><input type='submit' value='Save'></td></tr></tbody></table></form></div>";
$stmt->close();
?>

</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Update Your Availability</h3>
  </div>
  <div class="panel-body">
<?php

$query = "SELECT time_id FROM walkers_time WHERE walker_id = '$walker_id'";

	if (!($stmt = mysqli_query($mysqli, $query))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
echo <<<END
<hr><form name="walkerAvailabiity" method="get" action="editAvailability.php">
	<table>
		<thead>
			<tr style="height: 30px">
				<th style="width: 10%;"></th>
				<th style="width: 10%;">Sunday</th>
				<th style="width: 10%;">Monday</th>
				<th style="width: 10%;">Tuesday</th>
				<th style="width: 10%;">Wednesday</th>
				<th style="width: 10%;">Thursday</th>
				<th style="width: 10%;">Friday</th>
				<th style="width: 10%;">Saturday</th>
			</tr>
		</thead>
		<tbody> 
END;
	echo "<tr height='25px'><td>Morning</td>";
$avail = [];
while ($row = mysqli_fetch_array($stmt)) {
	$slot = $row['time_id'];
	$avail[$slot] = 1;
}
for($i=1; $i<22; $i+=3){
	if (array_key_exists($i, $avail)){
		echo "<td><input type='checkbox' checked name='" . $i . "' value='" . $i . "'></td>";
	}
	else {
		echo "<td><input type='checkbox' name='" . $i . "' value='" . $i . "'></td>";
	}
}
	echo "</tr><tr height='25px'><td>Afternoon</td>";
for($i=2; $i<22; $i+=3){
	if (array_key_exists($i, $avail)){
		echo "<td><input type='checkbox' checked name='" . $i . "' value='" . $i . "'></td>";
	}
	else {
		echo "<td><input type='checkbox' name='" . $i . "' value='" . $i . "'></td>";
	}
}
	echo "</tr><tr height='25px'><td>Evening</td>";
for($i=3; $i<22; $i+=3){
	if (array_key_exists($i, $avail)){
		echo "<td><input type='checkbox' checked name='" . $i . "' value='" . $i . "'></td>";
	}
	else {
		echo "<td><input type='checkbox' name='" . $i . "' value='" . $i . "'></td>";
	}
}
echo <<<END
				</tr><tr height='35px'>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><input type="submit" class="btn btn-primary" value="Save"></td>
			</tr>
		</tbody>
	</table>
</form>
</div>
END;
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">My Dogs</h3>
  </div>
  
<div class="container-fluid" id ="assign">
<form action="matchDogsWalkers.php">
<input type="submit" value="Assign me to dogs" class="btn btn-primary">
</form>
<?php

$query = "SELECT DISTINCT d.dog_id, t.day_of_week, t.time_of_day, d.name, c.fname, c.lname, c.address, c.phone FROM clients c INNER JOIN " . 
	"dogs d ON c.client_id = d.owner_id INNER JOIN " .
	"dogs_time dt ON d.dog_id = dt.dog_id INNER JOIN " .
	"time_slots t ON dt.time_id = t.time_id INNER JOIN " .
	"walkers_time wt ON t.time_id = wt.time_id INNER JOIN " .
	"walkers w ON w.walker_id = w.walker_id INNER JOIN " .
	"dogs_walkers dw ON w.walker_id = dw.walker_id " .
	"WHERE w.walker_id = '$walker_id'";

	if (!($stmt = mysqli_query($mysqli, $query))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

echo " <table class='table table-hover'>	
		<thead>	
			<tr style='height: 30px'>	
				<th style='width: 20%;'>Time</th>
				<th style='width: 10%;'>Dog</th>
				<th style='width: 10%;'>Client</th>
				<th style='width: 10%;'>Address</th>
				<th style='width: 10%;'>Phone</th>
				<th style='width: 10%;'>
			</tr>
		</thead>
		<tbody>"; 


while ($row = mysqli_fetch_array($stmt)) {
		
		echo "<tr>";
		echo "<td>" . $row['day_of_week'] . " " . $row['time_of_day'] . "</td>";
		echo "<td>" . $row['name'] . "</td>";
		echo "<td>" . $row['fname'] . " " . $row['lname'] ."</td>";
		echo "<td>" . $row['address'] . "</td>";
		echo "<td>" . $row['phone'] . "</td>";
		
		echo "<td><form method=\"GET\" action=\"viewDog.php\">";
		echo "<input type=\"hidden\" name=\"dogid\" value=\"".$row['dog_id']."\">";
		echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"View Details\">";
		echo "</form> </td><tr>";


}
echo" </tbody>
	</table>
</div>";
?>
</div>

</div>
</body>
</html>