<?php include('01_init.php');

$_page = [
    'title' => '<i class="fa-solid fa-star"></i> Angebote',
    'breadcrumbs' => ['<i class="fa-solid fa-cogs"></i> Prozesse']
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
            <div id="picklist-angebote"></div>
        </div>
    </div>
    <div class="fab-container">
         <button class="btn btn-primary btn-neues-angebot"><i class="fas fa-plus"></i></button>
    </div>

</body>

<?php include('04_scripts.php'); ?>


</html>