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

            <?php

                
                // echo "<pre>";
                // print_r($_SESSION);
                // echo "</pre>";
                // die();

            // 
            // $pos = new Positionen("akquise_meilenstein");

            // $req = new Request();

            // $req->getMultiQuery("SELECT * FROM `akquise_meilenstein` WHERE `aktion_id` = 3");

            // $positionen = $req->answer();


            // echo "<div class='row'><div class='col-6'><pre>";
            // print_r($positionen['data']);
            // echo "</pre></div><div class='col-6'><pre>";

            // $pos->shift($positionen['data'], 'down', 6);

            // // print_r($positionen_danch);
            // echo "</pre></div></div>";

            ?>


            <div class="card">
                <div class="card-body">
                    <div class="actions">
                        <a class="action-item btn-pos-delete" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Löschen"><i class="fa-solid fa-trash"></i></a>
                        <a class="action-item btn-pos-shift" data-shift="up" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hoch"><i class="fa-solid fa-chevron-up"></i></a>
                        <a class="action-item btn-pos-shift" data-shift="down" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Runter"><i class="fa-solid fa-chevron-down"></i></a>
                        <a class="action-item btn-pos-add" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Neu"><i class="fa-solid fa-plus"></i></a>
                    </div>

                    <h4 class="card-title"><i class="fa-solid fa-layer-group"></i> Positionen</h4>



                </div>
            </div>
        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {


        detailHelper.addPosListner();

        // 
        // detailHelper.initPos();

    });
</script>

</html>