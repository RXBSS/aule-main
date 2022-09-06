<?php include('01_init.php');

$_page = [
    'title' => "<i class='fa-regular fa-address-book'></i> Kontakte",
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
                        
                                <div id="kontakte-pickliste"></div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fab-container">
        <button id="modal-kontakte-open" class="btn btn-primary btn-something-add"><i class="fa-solid fa-plus"></i></button>
    </div>

    <!-- Kontaktemaske Modal -->
    <?php include("./kontakte-modal.php") ?>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        // Do Something
        kontakte.init();
    });
</script>
</html>