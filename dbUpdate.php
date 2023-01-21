


<?php
    include_once "dbConnect.php";

    
        global $dbConnection;
        $counterQ = mysqli_query($dbConnection, "SELECT * FROM DATA WHERE id = 1");
        $thing = mysqli_fetch_assoc($counterQ) ;
        /*$score = 0;*/
        $score = $thing['count'] +1;
        $sql = 'UPDATE data SET count='."$score".' WHERE id = 1';
        mysqli_query($dbConnection, $sql);
        
    

   

?>


