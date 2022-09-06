<?php include('01_init.php');

$_page = [
    'title' => "Bedarfsmeldungen",
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
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fa-solid fa-inbox"></i> Bedarfsmeldungen</h4>

                </div>
            </div>
        </div>
    </div>

    <div class="fab-container">
         <button class="btn btn-primary"><i class="fa-solid fa-plus"></i></button>
    </div>


</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

    });
</script>
</html>