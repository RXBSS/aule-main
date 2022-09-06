<?php include('01_init.php');

$_page = [
    'title' => "<i class='fa-solid fa-laptop-house'></i> Ident",
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
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div id="ident-pickliste"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        
        ident.init();
    });
</script>
</html>