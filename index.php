<?php
    include_once "dbConnect.php";
   /*  include_once "dbUpdate.php"; */


?>


<!DOCTYPE html>
<html>
    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-57XW73T1VK"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-57XW73T1VK');
        </script>
        <!-- Google tag ends -->


        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&family=Signika+Negative:wght@600&display=swap" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css2?family=Rowdies&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="pop_dan_css.css">
        <!-- <script src="pop_dan_js.js"></script> -->

        <title>pop_Dan</title>
    </head>

    <body>
        <?php
           
            $counterQ = mysqli_query($dbConnection, "SELECT * FROM DATA WHERE id = 1");
            $thing = mysqli_fetch_assoc($counterQ) ;
            /*$orgScore = 0;*/
            $orgScore = $thing['count'];

            $counterQ = mysqli_query($dbConnection, "SELECT * FROM DATA WHERE id = 2");
            $thing = mysqli_fetch_assoc($counterQ) ;
            $loginTime = $thing['count'] +1;
        
            $sql = 'UPDATE data SET count='."$loginTime".' WHERE id = 2';
            mysqli_query($dbConnection, $sql);
        ?>
            <br>webpage visited time: <?php echo $loginTime; ?>



            <div class="container">
                
                <h1 id="title">POP_DAN</h1>
                

                <p id="score">              
                    <?php echo $orgScore."<br>"; ?>   
                </p>
            
            </div>
            <div style="text-align: center;">
                <img id="image" src="pics/closed mouth.png" class="img_c" alt="ops, sth is wrong" >
            </div>




        <script>
            window.onload = function(){


                var a = 0;
                var counter = 0;
                var pic = document.getElementById("image");
                var counting = document.getElementById("score");

                var sound1 = new Audio("audio/pop sound1.mp3");
                var sound2 = new Audio("audio/pop sound2.mp3");

                var touch_screen = 0;
                if(window.matchMedia("(pointer: coarse)").matches) {
                    touch_screen = 1;
                }

                function increase_count(){
                    a++;
                    if(a%2==0){
                        sound1.play();
                    }else{
                        sound2.play();
                    }
                    
                    counter++;
                    counting.innerText = counter + <?php echo $orgScore; ?>;
                    pic.src = "pics/opened mouth.png";
                    
                    updateData();
                }
                
                function updateData(){
                    var req = new XMLHttpRequest();
                    req.open("get", "dbUpdate.php");
    /*                 req.onload=function(){
                        
                    } */
                    req.send();

                }  

                
                if(touch_screen) {
                    
                    pic.addEventListener("touchstart", increase_count);
                    pic.addEventListener("touchend", function(){
                        pic.src = "pics/closed mouth.png";
                    });
                }else{
                    
                    pic.addEventListener("mousedown", increase_count);
                    pic.addEventListener("mouseup", function(){
                        pic.src = "pics/closed mouth.png";
                    });

                }
        }
        </script>

    </body>
</html>