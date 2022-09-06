<?php include('01_init.php');

$_page = [
    'title' => '<i class="fa-solid fa-handshake"></i> Akquise',
    'breadcrumbs' => ['<i class="fa-solid fa-gears"></i> Prozesse']
];

// $akquiseAktion = new Akquise();

// $data = $akquiseAktion->getAkquiseAktionen();

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
    <link rel="stylesheet" href="../css/pagelevel/adressen-google.css">
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">

            <!-- Filter und Akquise Aktionen -->
            <form id="filter">
                <div class="row">
                    <div class="col-lg-8">

                        <div class="row">
                            <div class="col-lg-6">

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating-radio">
                                            <div class="form-radio">
                                                <input type="radio" class="form-check-input editable" id="meineAnzeigen" name="meineOderAlle" value="<?php echo $_SESSION['user']['id'] ?>" checked/>
                                                <label class="form-check-label" for="meineAnzeigen"> <i class="fa-solid fa-user"></i> Meine Anzeigen </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group form-floating-radio">
                                            <div class="form-radio">
                                                <input type="radio" class="form-check-input editable" id="nurFaelligeAnzeigen" name="alleOderFaellige" value="1" checked />
                                                <label class="form-check-label" for="nurFaelligeAnzeigen"> <i class="fa-solid fa-calendar-times"></i> Nur Fällige anzeigen </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row status-margin-top">
                                    <div class="col">
                                        <div class="form-group form-floating-radio">
                                            <div class="form-radio">
                                                <input type="radio" class="form-check-input editable" id="alleAnzeigen" name="meineOderAlle" value="" />
                                                <label class="form-check-label" for="alleAnzeigen"> <i class="fa-solid fa-users"></i> Alle Anzeigen </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group form-floating-radio">
                                            <div class="form-radio">
                                                <input type="radio" class="form-check-input editable" id="alleAnzeigenFaellige" name="alleOderFaellige" value="alle"  />
                                                <label class="form-check-label" for="alleAnzeigenFaellige"> <i class="fa-solid fa-calendar-check"></i> Alle Anzeigen </label>
                                            </div>
                                        </div>
                                    </div>


                                    



                                </div>

                            </div>
                            <div class="col-lg-6">

                                <div class="row">

                                    <div class="col">
                                        <div class="form-group form-floating-check">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input editable status-filter" id="offen" name="offen" value="0" checked/>
                                                <label class="form-check-label" for="offen"><i class="fa-solid fa-hourglass text-info"></i> Offen</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group form-floating-check">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input editable status-filter" id="erfolgreich" name="erfolgreich" value="1" />
                                                <label class="form-check-label" for="erfolgreich"><i class="fa-solid fa-thumbs-up text-primary"></i> Angenommen</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row status-margin-top">

                                    <div class="col">
                                        <div class="form-group form-floating-check">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input editable status-filter" id="geloescht" name="geloescht" value="3" />
                                                <label class="form-check-label" for="geloescht"><i class="fa-solid fa-trash text-secondary"></i> Gelöscht</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group form-floating-check">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input editable status-filter" id="nicht_erfolgreich" name="nicht_erfolgreich" value="2" />
                                                <label class="form-check-label" for="nicht_erfolgreich"><i class="fa-solid fa-thumbs-down text-danger"></i> Abgelehnt</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        

                    </div>

                    <div class="col-lg-4">
                        <a href="akquise-aktionen" target="_self">
                            <div class="alert alert-secondary">
                            <h4 class="alert-heading" id="countEntries"></h4>
                            <small>Akquise Aktionen</small>
                            </div>
                        </a>
                    </div>
                </div>
            </form>

            <!-- Pickliste Akquise -->
            <div id="akquise-pickliste"></div>

        </div>
    </div>


    <!-- Fab Button zum hinzufügen -->
    <div class="fab-container">
         <button class="btn btn-primary btn-kunde-akquise-add"><i class="fa-solid fa-plus"></i></button>
    </div>

    <?php include('./akquise-modal.php') ?>
    <?php include('./akquise-timeline-modal.php') ?>
    <?php include('./adressen-visitenkarten-ansicht.php')  ?>
    <?php include('./adressen-neu-modal.php')  ?>
    <?php include('./kontakte-neu-modal.php')  ?>


</body>




<?php include('04_scripts.php'); ?>

<script src="../js/pagelevel/akquise-a.js"></script>
<script src="../js/pagelevel/adressen-neu.js"></script>
<script src="../js/pagelevel/kontakte-neu.js"></script>

<!-- Sortable Funktion Meilensteine -->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>


<!-- Für die Automatische Google Suche -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcz5vCR6GMcbQtHfK_ImcU3yQwgmAVfa8&libraries=places&v=weekly&channel=2&"></script>

<script>
    $(document).on('app:ready', function() {
        // Do Something

        akquise = Object.assign(kontakte_neu, akquise);
        akquise = Object.assign(adressen_neu, akquise);
        akquise = Object.assign(akquise_both, akquise);
        // akquise = Object.assign(adressen_neu, akquise);

        akquise.init();

    });
</script>
</html>