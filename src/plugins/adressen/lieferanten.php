<?php include('01_init.php');

$_page = [
    'title' => "Lieferanten"
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
                            <h4 class="card-title"><i class="fa-regular fa-address-card"></i> Lieferanten</h4>
                            <div id="lieferanten-pickliste"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fab-container">
        <button id="modal-adressen-open" class="btn btn-primary btn-something-add"><i class="fa-solid fa-plus"></i></button>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        var list = new Picklist("#lieferanten-pickliste", "lieferanten", {
            card: false
        });

    });
</script>

</html>