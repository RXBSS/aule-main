<?php include('01_init.php');

$_page = [
    'title' => "Kommissionieren",
    'breadcrumbs' => ['Prozesse','<a href="auftraege">Aufträge</a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>

    <style>
        .video-box {
            width: 100%;
            background: #eee;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            border-radius: 2px;
        }

        #video-info {
            padding: 20px;
        }
    </style>

</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <div class="card">
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="tab-nav-uebersicht">
                                    <button class="nav-link active" id="tab-nav-uebersicht-allgemein" data-bs-toggle="tab" data-bs-target="#tab-content-uebersicht-allgemein" type="button">Übersicht</button>
                                    <button class="nav-link" id="tab-nav-uebersicht-video" data-bs-toggle="tab" data-bs-target="#tab-content-uebersicht-video" type="button">Barcode</button>
                                </div>
                            </nav>
                            <br>
                            <div class="tab-content" id="tab-content-uebersicht">
                                <div class="tab-pane show active" id="tab-content-uebersicht-allgemein">

                                    <div class="row">
                                        <div class="col-6">
                                            <p>
                                                <strong>Henkel und Reis</strong><br>
                                                Harmerzer Straße 24<br>
                                                DE 36041 Fulda
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <strong>Nummer</strong> 100000<br>
                                            <strong>Datum</strong> 22.11.2021<br>

                                        </div>
                                    </div>



                                </div>
                                <div class="tab-pane fade" id="tab-content-uebersicht-video">



                                    <div style="max-height: 200px;overflow:hidden;">
                                        <video id="video-content" class="video-box" style="width:100%;"></video>
                                        <div id="video-info" class="video-box"></div>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-box"></i> Positionen</h4>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Artikel</th>
                                        <th>Menge</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="position-table">
                                    <tr>
                                        <td colspan="4"><i class="fa-solid fa-circle-notch fa-spin"></i> Positionen werden geladen</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 d-grid">
                            <button class="btn btn-secondary btn-block"><i class="fa-solid fa-forward"></i> Überspringen</button>
                        </div>
                        <div class="col-6 d-grid">
                            <button class="btn btn-primary" id="auftrag-abschliessen" disabled><i class="fa-solid fa-check"></i> Erledigt!</button>
                        </div>
                    </div>
                   

                </div>

            </div>





            <div class="fab-container">
                <button class="btn btn-success btn-toggle-scan"><i class="fa-solid fa-barcode"></i></button>
            </div>


        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>

<!-- TODO: Muss noch als NPM übernommen werden -->
<script type="text/javascript" src="./js/optionals/zxing.min.js"></script>
<script>

    // 
    $(document).on('app:ready', function() {


        k.init();

        /*





        $('.btn-toggle-scan').on('click', function() {

            // Starten
            if ($(this).hasClass('btn-success')) {
                var el = $(this);

                el.html('<i class="fa-solid fa-circle-notch fa-spin"></i>').prop('disabled', true);

                startReader();


                setTimeout(function() {
                    el.html('<i class="fa-solid fa-barcode"></i>').removeClass('btn-success').addClass('btn-danger').prop('disabled', false);
                   

                }, 3000);


                // Stoppen
            } else {
                $(this).removeClass('btn-danger').addClass('btn-success');

            }
        });

        */




    });

    function startReader() {




    }
</script>

</html>