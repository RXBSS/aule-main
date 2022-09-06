<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-file-import\"></i> Wareneingang",
    'breadcrumbs' => ['Prozesse']
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

            <!-- Liste der Wareneingänge -->
            <div id="pickliste-wareneingaenge"></div> 

        </div>
    </div>

    <div class="fab-container">
        <button id="wareneingang-neu" class="btn btn-primary"><i class="fa-solid fa-plus"></i></button>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        
        
        var list = new Picklist("#pickliste-wareneingaenge", "wareneingaenge");

        // Auswahl einer Position
        list.on('pick', function(el, data) {
            app.redirect('wareneingaenge-details?id=' + data[1]);
        });

        
        // Neuen Wareneingang anlegen
        $('#wareneingang-neu').on('click', function() {

            // Simple App Request
            app.simpleRequest("neuer-wareneingang", "wareneingaenge-handle", null, function(response) {
                app.redirect('wareneingaenge-details?id=' + response.data);
            });
        });
    });
</script>

</html>