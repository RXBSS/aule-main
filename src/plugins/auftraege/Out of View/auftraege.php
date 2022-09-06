<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-layer-group\"></i> Aufträge",
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

            <!-- Pickliste -->
            <div id="auftraege-pickliste"></div>

            <!-- FAB-->
            <div class="fab-container">
                <button class="btn btn-primary" id="btn-neuer-auftrag"><i class="fa-solid fa-plus"></i></button>
            </div>

            <?php

            $auftrag = new Auftrag();

            // $result = $auftrag->new();

            // print_r($result);

            ?>

        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
    



</html>