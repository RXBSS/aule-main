<?php include('01_init.php');

$_page = [
    'title' => "Zählerstände Anleitung - Vorschau"
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>

    <style>
        body {
            padding: 20px;
        }

        .editor-content p {
            margin: 0;
        }
    </style>
</head>

<body>
    
    <?php

    $_api = new ZaehlerstaendeAnleitungen();
    $_api->printHtml($_GET['id']);

    $data = $_api->get($_GET['id']);
    ?>


    <hr>

    <p class="mb-0"><?php echo $data['data']['bezeichnung']." (".$data['data']['status_bezeichnung'].")"; ?></p>
    <a href="javascript:location.reload();"><i class="fa-solid fa-refresh"></i> Aktualisieren</a> | 
    <a href="javascript:location.reload();"><i class="fa-solid fa-print"></i> Als PDF generieren</a> | 
    <a href="javascript:window.close();"><i class="fa-solid fa-times"></i> Schließen</a>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        // Do Something
    });
</script>
</html>