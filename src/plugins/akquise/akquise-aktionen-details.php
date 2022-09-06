<?php include('01_init.php');

$_page = [
    'title' => '<i class="fa-solid fa-handshake"></i> <custom class="akquise-title"></custom>',
    'breadcrumbs' => ['<i class="fa-solid fa-gears"></i> Prozesse <i class="divider fas fa-angle-right"></i> <a href="akquise"><i class="fa-solid fa-handshake"></i> Akquise</a>', '<a href="akquise-aktionen"> <i class="fa-solid fa-handshake"></i> Akquise Aktionen</a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
    <link rel="stylesheet" href="./css/pagelevel/akquise.css">
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">

            

            <div class="row">
                <div class="col-lg-6">

                    <!-- Details zur Aktion -->
                    <div class="card" id="akquise-aktion-stammdaten">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-circle-info"></i> Details zur Aktion</h4>
                    

                            <form id="form-akquise-details">  
                                
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <input type="text" name="name" class="form-control editable" placeholder="Name der Aktion" autocomplete="off" >
                                            <div class="form-unit">Aktion</div>
                                            <label>Name</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group form-floating-radio">
                                            <label class="form-label">Status der Aktion</label><br>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="entwurf" name="entwurf" value="0">
                                                <label class="form-check-label" for="entwurf">Entwurf</label>
                                            </div>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="aktiv" name="entwurf" value="1">
                                                <label class="form-check-label" for="aktiv">Aktiv</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group form-floating-check">
                                            <label class="form-label">Standard Meilensteine</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="standard_meilensteine" name="standard_meilensteine" disabled/>
                                                <label class="form-check-label" for="standard_meilensteine">Ja</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">

                                        <div class="row">
                                            <div class="col">
                                                <input type="hidden" name="ersteller_id">
                                                <div class="form-group form-floating">
                                                    <div class="form-group form-floating">
                                                        <input type="text" name="ersteller_text" class="form-control" placeholder="Bezeichnung" autocomplete="off" readonly>
                                                        <label>Ersteller</label>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group form-floating">
                                                    <input type="date" name="zeitstempel" class="form-control" placeholder="Erstellt am" autocomplete="off" readonly>
                                                    <label>Erstellt am</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">

                                        <div class="activation-input-container">
                                            <div class="form-group form-floating-check">
                                                <label class="form-label"></label>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input editable" id="cb-aktivieren" name="cb-aktivieren" >
                                                    <label class="form-check-label" for="cb-aktivieren">Benutzerdef.</label>
                                                </div>
                                            </div>
                                            <div class="form-group form-floating">
                                                <input type="text" name="wiedervorlage_nach" class="form-control editable" placeholder="Wiedervorlage nach" value=" ">
                                                <div class="form-unit">Tage</div>
                                                <label>Wiedervorlage nach</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            
                        </div>
                    </div>

                    <!-- Alle Meilensteine zu dieser Aktion anzeigen -->
                    <div class="card">
                        <div class="card-body">
                            <!-- <div class="actions">
                                <a class="action-item btn-add-meilenstein" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Hinzufügen eines Meilensteins"><i class="fa-solid fa-plus"></i></a>
                            </div> -->
                            <h4 class="card-title"><i class="fa-solid fa-flag"></i> Meilensteine</h4>
                            
                    
                            <h6 class="subtext">Alle Meilensteine die zu der <custom id="name_aktion"></custom> gehören, werden hier aufgeführt und können eingesehen werden.</h6>
                    
                            <div id="pickliste-meilensteine"></div>


                            <!-- Meilenstein Modal -->
                            <?php include('akquise-meilenstein-modal.php') ?>

                        </div>
                    </div>
                </div>


                <div class="col-lg-6">

                        <nav>
                        <div class="nav nav-tabs" id="tab-nav-name">
                            <button class="nav-link active" id="tab-nav-details" data-bs-toggle="tab" data-bs-target="#tab-content-details" type="button"><i class="fa-solid fa-user"></i> Kunden der Aktion</button>
                            <button class="nav-link" id="tab-nav-statistik" data-bs-toggle="tab" data-bs-target="#tab-content-statistik" type="button"><i class="fa-solid fa-arrow-trend-up"></i> Statistik</button>
                        </div>
                    </nav>
                    <br>
                    <div class="tab-content" id="tab-content-name">
                        <div class="tab-pane show active" id="tab-content-details">
                            <!-- CONTENT 1 -->
                        
                            <div class="card" id="akquise-aktionen-kunden">
                                <div class="card-body">

                                    <h4 class="card-title"><i class="fa-solid fa-user"></i> Kunden der Aktion</h4>

                                    <h6 class="subtext">Hier sind alle Kunden aufgelistet die in der Akquisen Aktion beteiligt sind!</h6>
                            
                                    <div id="akquise-kunden-pickliste"></div>

                                </div>
                            </div>

                    </div>
                        <div class="tab-pane" id="tab-content-statistik">
                            <!-- CONTENT 2 -->

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fas fa-arrow-trend-up"></i> Statistik</h4>
                            
                                    <h6 class="subtext">
                                        <!-- Hier ist eine Übersicht der Statistik. Es wird sichtbar sein wie viele Akquise Aktionen Erfolgreich bzw. Nicth Erfolgreich sind.
                                        Außerdem kann man auch vergleichen wie viele Akquise Aktionen noch Offen, damit man in diese mehr Aufwand stecken kann. -->
                                    </h6>

                                    <div class="row">
                                        <div class="col">
                                            <div class="error-message-chart"></div>
                                            <div class="chart-container" style="position: relative; height:300px">
                                                <canvas id="pie-chart" ></canvas>
                                            </div>
                                        </div>
                                    </div>
                            

                            
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>


    <?php include('./akquise-timeline-modal.php') ?>

</body>




<?php include('04_scripts.php'); ?>

<script src="../js/pagelevel/akquise.js"></script>
<script src="../js/pagelevel/akquise-a.js"></script>

<!-- Sortable Funktion Meilensteine -->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<script>
    $(document).on('app:ready', function() {
        // Do Something

        akquise_details = Object.assign(akquise_both, akquise_details);

        akquise_details.init();

        // Mergen


        // ak.init();
    });
</script>
</html>