<?php
        $servername="localhost";
        $username="root";
        $password="Tan@1204";
        $db="qlbantour";
        $conn= mysqli_connect($servername,$username,$password,$db);
        if(!$conn){
            die("Couldn't connect:" .mysqli_connect_error($conn));
        }
?>