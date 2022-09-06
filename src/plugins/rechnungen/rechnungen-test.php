<?php include('01_init.php');

$_page = [
    'title' => "Rechnungen Test"
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid"><?php

            echo "<pre>";


            // 
            $rechnungen = new Rechnungen();

            $result = $rechnungen->create([
                'adresse_id' => 2,
                'herkunft' => 'vertrag',
                'referenz_id' => 1,
                'netto' => 5000
            ]);

            
    

            print_r($result);


            ?>
        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        // Do Something
    });
</script>
</html>