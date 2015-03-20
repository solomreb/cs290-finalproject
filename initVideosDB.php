
<?php
if (!$mysqli->query("DROP TABLE IF EXISTS videos") ||
    !$mysqli->query("CREATE TABLE videos
(id int PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(255) NOT NULL UNIQUE,
category VARCHAR(255),
length INT UNSIGNED,
rented INT NOT NULL default 0)") 
//||    !$mysqli->query("INSERT INTO videos(id, name, category, length, rented)
//     VALUES (1, 'apple', 'comedy', 90, 0)")
 ){
    echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
}
?>