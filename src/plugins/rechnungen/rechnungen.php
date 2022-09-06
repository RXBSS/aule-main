<?php include('01_init.php');

$_page = [
    'title' => "Rechnungen"
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
            
            <p>
                Was soll man hier machen können?<br>
                - Rechnungsübersicht<br>
                - Mahnungen
            </p>


            <!-- Pickliste Rechnungen -->
            <div id="pickliste-rechnungen"></div>

            
        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        
        // List
        var list = new Picklist("#pickliste-rechnungen", "rechnungen", {
            
        });


    });
</script>
</html>