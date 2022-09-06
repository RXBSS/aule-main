<?php include('01_init.php');





if ($_GET['task'] && $_GET['task'] == 'test') {

    $doc = new AngebotDoc(1);
    $test = $doc->create();

    die();

    // $doc = new AngebotDoc(1);
    // $doc->start(true);
    // $doc->build();
    // $doc->open();
}



$_page = [
    'title' => "Test Dokument"
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



            <?php

                print_r($test);
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