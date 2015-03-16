
<?php
if (!$mysqli->query("DROP TABLE IF EXISTS walkers") ||
    !$mysqli->query("CREATE TABLE walkers
(id int PRIMARY KEY AUTO_INCREMENT,
fname VARCHAR(255) NOT NULL,
lname VARCHAR(255) NOT NULL,
phone VARCHAR(255))") 

 ){
    echo "Walkers table creation failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
}
if (!$mysqli->query("DROP TABLE IF EXISTS clients") ||
    !$mysqli->query("CREATE TABLE clients
(id int PRIMARY KEY AUTO_INCREMENT,
fname VARCHAR(255) NOT NULL,
lname VARCHAR(255) NOT NULL,
phone VARCHAR(255),
address VARCHAR(255),
city VARCHAR(255))") 

 ){
    echo "Clients table creation failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
}
if (!$mysqli->query("DROP TABLE IF EXISTS dogs") ||
    !$mysqli->query("CREATE TABLE dogs
(id int PRIMARY KEY AUTO_INCREMENT,
fname VARCHAR(255) NOT NULL,
lname VARCHAR(255) NOT NULL,
phone VARCHAR(255))") 

 ){
    echo "Dogs table creation failed: (" . $mysqli->errno . ") " . $mysqli->error . "<br>";
}
?>