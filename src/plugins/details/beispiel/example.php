<?php include('01_init.php');

$_page = [
    'title' => "Demo-Seite Positionen",
    'breadcrumb' => ['<a href="example"></a>Beispiel']
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

            <a href="details-dokumentation">Zur Dokumentation</a>


    
            <p>Hierbei handelt es sich um eine Beispiel-Seite. Sie dient als Vorlage und zur Entwicklung der für die einzelnen Detail-Unterseiten</p>




            <div id="pickliste-positionen">

            </div>



        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        
        




    });
</script>
</html>