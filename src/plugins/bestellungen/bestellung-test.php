<?php include('01_init.php');

$_page = [
    'title' => "Template"
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

        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>

<script src="js/optionals/EloixClient.js"></script>

<script>
    $(document).on('app:ready', function() {
        // Simplify namespace access
        // (all ELOix symbols are member of de.elo.ix.client)
        var IX = de.elo.ix.client;

        // Indexserver URL
        // Since cross domain requests are not supported, Indexserver must be reachable
        // via the same server from where this example HTML file is loaded.
        var ixUrl = "https://elo.buerosystemhaus.de:9093/ix-dms/ix";

        try {
            
            // Get Indexserver connection
            var connFact = new IX.IXConnFactory(ixUrl, "GetDoc", "1.0");
            var conn = connFact.create("t.pitzer", "xxxx");

        } catch (ex) {
            // Show message box with error text.
            alert(ex.toString());
        } finally {
            // Skip logout in this example.
            // Otherwise the document URL might not be valid when the browser loads it.
        }
    });
</script>

</html>