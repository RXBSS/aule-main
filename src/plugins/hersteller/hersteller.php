<?php include('01_init.php');

$_page = [
    'title' => '<i class="fa-solid fa-industry"></i> Hersteller',
    'breadcrumbs' => ['Stammdaten']
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
            <div id="hersteller-pickliste"></div>
        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        // Do Something
        hersteller.init();
    });
</script>
</html>