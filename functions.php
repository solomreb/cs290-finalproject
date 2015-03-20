<?php
function displayDogs($mysqli, $query){
	echo "<br><table>
	    <col width='40%'> <col width='20%'> <col width='10%'> <col width='10%'> <col width='10%'><col width='10%'>
  		<tr><th>Dog</th>
  		<th>Client</th>
  		<th>Address</th>
  		<th>Phone</th>
  		<th></th></tr>";

	if (!($stmt = mysqli_query($mysqli, $query))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}


	while ($row = mysqli_fetch_array($stmt)) {
		echo "<tr>" ;
		echo "<td>" . $row['dog_name'] . "</td>";
		echo "<td>" . $row['client_fname'] . " " . $row['client_lname'] ."</td>";
		echo "<td>" . $row['address'] . "</td>";
		echo "<td>" . $row['phone'] . "</td>";
		
		echo "<td><form method=\"GET\" action=\"edit.php\">";
		echo "<input type=\"hidden\" name=\"nameid\" value=\"".$row['id']."\">";
		echo "<input type=\"submit\" value=\"Edit\">";
		echo "</form> </td>";
		
		echo "<td><form method=\"GET\" action=\"delete.php\">";
		echo "<input type=\"hidden\" name=\"nameid\" value=\"".$row['id']."\">";
		echo "<input type=\"submit\" value=\"delete\">";
		echo "</form> </td>";
		echo "</tr>";
	}
	echo "</table><br>";
	}
	
	?>