<?php include('01_init.php');

$_page = [
    'title' => "Auftrag Test"
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">

            <div id="pickliste-auftrag"></div>


            <?php

            echo "<pre>";






            $auftrag = new Auftrag();    

            $id = 300003;


            // Ergebnis
            $result = $auftrag->rechnungErstellen($id);
            
            //          
            print_r($result);



            
            ?>




        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        /*
        var list = new Picklist("#pickliste-auftrag", "auftraege_positionen", {
            config: {
                file: 'config-beliefern.json',
                mode: 'overwrite'
            },
            data: 100003
        });

        */
    });
</script>

</html>