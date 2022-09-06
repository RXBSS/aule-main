<?php include('01_init.php');

$_page = [
    'title' => "Test"
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body data-page="angebote">
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">
            <?php

                $angebot = new Angebote();
            

                // $result = $angebot->pos->shiftById(1, 'bottom', [51, 41, 45]);
                $result = $angebot->pos->getAllById(1);
                // $result = $angebot->pos->orderIds($pos['data'], [51, 41, 45]);


                echo "<pre>";
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