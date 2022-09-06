<?php include('01_init.php');

$_page = [
    'title' => "Artikel Test"
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
            <?php
            

            echO "<pre>";
            $api = new Artikel();
  
            $result = $api->getAttributesText(100000);

            print_r($result);

            ?>
        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        // Do Something
    });
</script>

</html>