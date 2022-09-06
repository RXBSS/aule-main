<?php include('01_init.php'); 

    $test = "Mein Text hat einen \\ und ein \" usw.";

    
    

    echo $test;

    echo "<br>";

    $test2 = $db->real_escape_string($test);

    echo $test2;

    echo "<br>";

    echo $db->real_escape_string($test2);


?>