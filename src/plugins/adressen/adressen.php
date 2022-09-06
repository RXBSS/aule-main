<?php include('01_init.php');

$_page = [
    'title' => "<i class='fa-regular fa-address-card'></i> Adressen",
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
                            

                            <div id="adressen-pickliste"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fab-container">
        <button id="modal-adressen-open" class="btn btn-primary btn-something-add"><i class="fa-solid fa-plus"></i></button>
    </div>

    <?php include("./adressen-google-modal.php") ?> 

</body>




<?php include('04_scripts.php'); ?>

<script src="./js/pagelevel/adressen-details-oeffnungzeiten.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcz5vCR6GMcbQtHfK_ImcU3yQwgmAVfa8&libraries=places&v=weekly&channel=2&"></script>

<script>



    // adressen.initAutoComplete();

    $(document).on('app:ready', function() {
        
        adressen.init();

        template.init();

        var temp = new mehrAnzeigen('#mehr-anzeigen', '#mehr-anzeigen-toggler', '.trigger-on-off', "Weniger anzeigen");


        $('.oeffnungszeiten-container').hide();

    });

    
</script>

</html>