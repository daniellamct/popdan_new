<?php
$dbConnection = mysqli_connect("localhost", "root", "", "popdan");

if(mysqli_connect_errno()){
    echo "failed to connect to database: ". mysqli_connect_errno();
    exit();
}

echo "successfully connected to database";

?>


