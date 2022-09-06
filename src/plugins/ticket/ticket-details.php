<?php include('01_init.php');

$_page = [
    'title' => "Ticket Details",
    'breadcrumbs' => ['Prozesse', "<a href='tickets'>Tickets</a>"]
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
                
                <!-- Card Informationen zum Ticket -->
                <div class="col-lg-9">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-ticket"></i> Allgemeine Informationen </h4>
                    
                            <h6 class="subtext">Hier sind die allgemeinen Informationen zu einem Ticket.</h6>

                            <form id="form-ticket-infos">

                                <div class="row">

                                    <div class="col-lg-4">

                                        <div class="form-group form-floating">
                                            <input type="text" name="titel" class="form-control" placeholder="Bezeichnung" autocomplete="nope" disabled>
                                            <label>Projekt</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">

                                        <div class="form-group form-floating">
                                            <input type="text" name="ersteller_name" class="form-control" placeholder="Bezeichnung" autocomplete="nope" readonly disabled>
                                            <label>Eröffnet Benutzer</label>
                                        </div>

                                        <!-- Ersteller ID Input -->
                                        <input type="hidden" name="ersteller_id">

                                        
                                    </div>
                                    <div class="col-lg-4">

                                        <div class="form-group form-floating">
                                            <input type="text" name="erstellt" class="form-control" placeholder="Bezeichnung" autocomplete="nope" readonly disabled>
                                            <label>Eröffnet Datum</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-4">

                                        <div class="form-group form-floating-check">
                                            <label class="form-label">Internes Ticket</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="id" name="name" value="1" disabled />
                                                <label class="form-check-label" for="id">Aktivieren</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect" name="adressen" placeholder="label" disabled>
                                                <option value="">Bitte wählen</option>
                                            </select>
                                            <label>Kunde</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        
                                        <div class="form-group form-floating">
                                            <input type="text" name="name" class="form-control" placeholder="Bezeichnung" autocomplete="nope" disabled>
                                            <label>Ident</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group form-range" style="margin-top:8px;">
                                            <label for="prioritaet" class="form-label">Priorität: <span id="prioritaet-label"></span></label>
                                            <input type="range" name="prioritaet" class="form-range editable" id="prioritaet" min="1" max="3" value="2">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>  

                    <hr>

                    <!-- Controlle zum Öffnen der Card -->
                    <div id="controller">
                        <button class="btn btn-primary neue-antwort"><i class="fa-solid fa-comment"></i> Antwort hinzufügen</button>
                        <button type="button" class="btn btn-primary"><i class="fa-solid fa-calendar"></i> Termin planen</button>
                    </div>

                    <div class="card card-timeline-eintrag">
                        <div class="card-body">
                    
                            <form id="timeline-eintrag-form">

                                <div class="actions">
                                    <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Zeit erfassen"><i class="fa-solid fa-clock"></i></a>
                                    <a class="action-item abbruch-eintrag" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Verwerfen"><i class="fa-solid fa-xmark"></i></a>
                                </div>


                                <h4 class="card-title"><i class="fa-solid fa-pencil"></i> Neuen Beitrag verfassen</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating-radio">
                                            <label class="form-label">Veröffentlichung</label><br>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="veroeffentlichen-1" name="veroeffentlichen" value="1" required>
                                                <label class="form-check-label" for="veroeffentlichen-1"><i class="fa-solid fa-user-group"></i> Öffentlich</label>
                                            </div>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="veroeffentlichen-2" name="veroeffentlichen" value="2">
                                                <label class="form-check-label" for="veroeffentlichen-2"><i class="fa-solid fa-user-shield"></i> Intern</label>
                                            </div>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="veroeffentlichen-3" name="veroeffentlichen" value="3">
                                                <label class="form-check-label" for="veroeffentlichen-3"><i class="fa-solid fa-pen-ruler"></i> Entwurf</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating-radio">
                                            <label class="form-label">Status</label><br>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="status-1" name="status" value="0" required>
                                                <label class="form-check-label" for="status-1"><i class="fa-solid fa-pencil"></i> In Bearbeitung</label>
                                            </div>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="status-2" name="status" value="1">
                                                <label class="form-check-label" for="status-2"><i class="fa-solid fa-flag-checkered"></i> Gelöst markieren</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <br>

                                <div class="">
                                    <div class="form-group form-floating">

                                        <textarea class="summernote form-control editable" name="text" placeholder="Bezeichnung" required></textarea>

                                        <!-- <label>Bezeichnung</label> -->
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <button class="btn btn-primary" id="add-summernote-timeline">Senden</button>
                                        <button type="button" class="btn btn-secondary abbruch-eintrag">Abbrechen</button>
                                    </div>
                                    <div class="col-md-6" style="text-align:right;">
                                        <a href="javascript:void(0);"><em class="text-danger">Keine Zeit erfasst</em></a>
                                    </div>
                                </div>


                            </form>
                    
                        </div>
                    </div>


                    <!-- Tinmeline -->
                    <div class="my-3" id="ticket-timeline"></div>

                </div>

                <!-- Status - Personen - Service - Dateien -->
                <div class="col-md-3">


                    <h5><i class="fa-solid fa-flag"></i> Status</h5>

                    <div class="px-4 py-2">
                        <span class="badge bg-warning text-dark" id="status-ticket"></span>


                        <br>
                        <br>
                        <i class="fa-solid fa-clock-rotate-left"></i> <span id="letzte-aktivitaet">21.05.2022 09:35</span><br>
                        <i class="fa-solid fa-clock"></i> Summe: <span id="">01:23</span><br>
                    </div>

                    <hr>

                    <h5><i class="fas fa-users"></i> Personen</h5>

                    <div class="px-4 py-2">

                        <!-- Per JS geladen -->
                        <div id="ticket-personen"></div>

                        <div class="mt-3">
                            <a href="javascript:void(0);" style="color:grey;" id="add-ticket-kontakte"><i class="fa-solid fa-user-plus" ></i> Benutzer hinzufügen</a>
                        </div>
                    </div>

                    <hr>

                    <h5><i class="fa-solid fa-folder-open"></i> Dateien</h5>
                    <div class="px-4 py-2">

                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fa-solid fa-file"></i> 05-final-document.pdf</span>
                                <span><span class="badge bg-primary rounded-pill">32 kb</span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fa-solid fa-file"></i> Screenshot 2022-05-19 102356.jpg</span>
                                <span>
                                    <span class="badge bg-primary rounded-pill">137 kb</span>
                                </span>
                            </li>
                        </ul>
                        <div class="mt-3">
                            <a href="javascript:void(0);" style="color:grey;" id="add-file-ticket"><i class="fa-solid fa-file-circle-plus"></i> Datei/en hinzufügen</a>
                        </div>
                    </div>

                    <hr>
                    <h5><i class="fa-solid fa-wrench"></i> Service</h5>
                    <div class="px-4 py-2">

                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fa-solid fa-wrench"></i> Service 262955</span>
                                <span><span class="badge bg-warning rounded-pill"><i class="fa-solid fa-hourglass"></i></span></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fa-solid fa-wrench"></i> Service 230202</span>
                                <span>
                                    <span class="badge bg-primary rounded-pill"><i class="fa-solid fa-check"></i></span>
                                </span>
                            </li>
                        </ul>
                        <div class="mt-3">
                            <a href="javascript:void(0);" style="color:grey;" id="service-planung-ticket"><i class="fa-solid fa-plus"></i> Service planen</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <?php include('./ticket-file-modal.php') ?>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {


        // Init Object
        ticket_details.init();


    });
</script>

</html>