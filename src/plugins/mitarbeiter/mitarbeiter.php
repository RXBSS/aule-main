<?php include('01_init.php');

$_page = [
    'title' => "<i class='fa-solid fa-home'></i> Mitarbeiter",
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

                            <div id="mitarbeiter-pickliste"></div>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fab-container">
        <button id="modal-mitarbeiter-open" class="btn btn-primary btn-something-add"><i class="fa-solid fa-plus"></i></button>
    </div>

    <!-- Modal für Mitarbeiter -->

    <div class="modal" id="modal-mitarbeiter" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Hinzufügen</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="modal-mitarbeiter-form">

                    <div class="alert alert-warning duplettenpruefung"></div>

                    <br><br>

                    <div class="row first-row">
                        <div class="col col-lg-1 icon-col">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="col col-lg-11 input-col"> 
                       
                            <div class="row">
                                <div class="col col-lg-2">
                                    <div class="form-group form-floating">
                                        <input type="number" autocomplete="off" name="nummer" class="form-control editable" placeholder="Nummer">
                                        <label>Nr</label>
                                    </div>
                                </div>
                                <div class="col col-lg-5">
                                    <div class="form-group form-floating">
                                        <input type="text" autocomplete="off" name="vorname" class="form-control editable" placeholder="Vorname" required>
                                        <label>Vorname</label>
                                    </div>
                                </div>
                                <div class="col col-lg-5">
                                    <div class="form-group form-floating">
                                        <input type="text" autocomplete="off" name="nachname" class="form-control editable" placeholder="Nachname" required>
                                        <label>Nachname</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="row">
                        <div class="col col-lg-1 icon-col">
                            <i class="fa-solid fa-map-marker-alt"></i>
                        </div>
                        <div class="col col-lg-11 input-col">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group form-floating">
                                        <input type="text" autocomplete="nope" name="strasse" class="form-control editable" placeholder="Straße" required>
                                        <label>Straße</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-lg-4">
                                    <div class="form-group form-floating">
                                        <select class="form-select init-quickselect" id="select-laender" name="laender" data-qs-name="laender" placeholder="Länder" required>
                                            
                                        </select>
                                        <label>Länder</label>
                                    </div>

                                </div>

                                <div class="col col-lg-4">
                                    <div class="form-group form-floating">
                                        <input type="text" name="plz" autocomplete="nope" class="form-control editable" placeholder="PLZ" required>
                                        <label>PLZ</label>
                                    </div>

                                </div>
                                <div class="col col-lg-4">
                                    <div class="form-group form-floating">
                                        <input type="text" name="ort"  autocomplete="nope" class="form-control editable" placeholder="Ort" required>
                                        <label>Ort</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="row">
                        <div class="col col-lg-1 icon-col">
                            <i class="fa-solid fa-phone-alt"></i>
                        </div>
                        <div class="col col-lg-11 input-col">
                            <div class="row">
                                <div class="col col-lg 6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="telefon" autocomplete="nope" class="form-control editable" placeholder="Telefon" autocomplete="off" >
                                        <label>Telefon</label>
                                    </div>
                                </div>
                                <div class="col col-lg 6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="mobiltelefon"autocomplete="nope"  class="form-control editable" placeholder="Mobiltelefon" autocomplete="off" >
                                        <label>Mobiltelefon</label>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>
                   
                    <div class="row">
                        <div class="col col-lg-1 icon-col">
                            <i class="fa-solid fa-mail-bulk"></i>
                        </div>
                        <div class="col col-lg-11 input-col">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="email" autocomplete="nope"  class="form-control editable" placeholder="E-Mail" autocomplete="off" >
                                        <label>E-Mail</label>
                                    </div>
                                </div>
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="email_geschaeftlich" autocomplete="nope"class="form-control editable" placeholder="E-Mail Geschäftlich" autocomplete="off" >
                                        <label>E-Mail Geschäftlich</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col">
                            <a href="javascript:void(0);" id="mehr-anzeigen-toggler" class="">Mehr anzeigen</a>
                        </div>
                    </div>

                    <br>
                    <br>

                    <div id="mehr-anzeigen">
                    
                        <input type="hidden" name="trigger-on-off" class="trigger-on-off">

                        <div class="row">
                            <div class="col col-lg-1 icon-col">
                                <i class="fa-solid fa-calendar-alt"></i>
                            </div>
                            <div class="col col-lg-11 input-col">
                                <div class="row">
                                    <div class="col col-lg-4">
                                        <div class="form-group form-floating">
                                            <input type="date" name="geburtstag" class="form-control editable" placeholder="Geburtstag" autocomplete="off" >
                                            <label>Geburtstag</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-4">
                                        <div class="form-group form-floating">
                                            <input type="date" name="eintrittsdatum" class="form-control editable" placeholder="Eintrittsdatum" autocomplete="off" >
                                            <label>Eintrittsdatum</label>
                                        </div>

                                    </div>
                                    <div class="col col-lg-4">
                                        <div class="form-group form-floating">
                                            <input type="date" name="austrittsdatum" class="form-control editable" placeholder="Austrittsdatum" autocomplete="off" >
                                            <label>Austrittsdatum</label>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>

                        <br>
                        <br>

                        <div class="row">
                            <div class="col col-lg-1 icon-col">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                            <div class="col col-lg-11 input-col">
                                <div class="row">
                                    <div class="col col-lg-4 mt-lg-4">
                                        <div class="form-group form-floating-check">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="aktiv" name="aktiv" />
                                                <label class="form-check-label" for="aktiv">Aktiv</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-lg-4 mt-lg-4">
                                        <div class="form-group form-floating-check">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="auszubildender" name="auszubildender" />
                                                <label class="form-check-label" for="auszubildender">Auszubildender</label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col col-lg-4">
                                        <div class="form-group form-floating">
                                            <select class="form-select editable" name="geschlecht" placeholder="Anrede">
                                                <option value="">bitte wählen</option>
                                                <option value="H">Herr</option>
                                                <option value="F">Frau</option>
                                                <option value="D">Divers</option>
                                            </select>
                                            <label>Anrede</label>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>    
            
            </div>
            <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        // Init Mitarbeite wird aufgerufen
        mtr.init();

        template.init();

        var temp = new mehrAnzeigen('#mehr-anzeigen', '#mehr-anzeigen-toggler', '.trigger-on-off', "ZEIG MIR WENIGER AN DU BIMBO");
        
    });
</script>
</html>