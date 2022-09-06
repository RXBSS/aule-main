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
                <div class="col-md-9">

                    <div class="card">
                        <div class="card-body">

                            <form id="form-ticket-infos">
                                
                                        <!-- <h4 class="card-title"><i class="fas fa-icon"></i> Titel</h4> -->
                                
                                        <!-- <h6 class="subtext">Das ist der Subtext</h6> -->
                                
                                <div class="row">

                                    <div class="col-lg-4">

                                        <div class="form-group form-floating">
                                            <input type="text" name="title" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope" >
                                            <label>Projekt</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">

                                        <div class="form-group form-floating">
                                            <input type="text" name="ersteller_id" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope">
                                            <label>Eröffnet Benutzer</label>
                                        </div>

                                        
                                    </div>
                                    <div class="col-lg-4">

                                        <div class="form-group form-floating">
                                            <input type="text" name="erstellt" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope" >
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
                            <!-- <div class="col-md-6"> -->

                                <!-- <form id="">

                                    <div class="card">
                                        <div class="card-body pt-0">
                                            <div class="form-group form-floating-check"> *******
                                                <label class="form-label">Internes Ticket</label>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="id" name="name" value="1" disabled />
                                                    <label class="form-check-label" for="id">Aktivieren</label>
                                                </div>
                                            </div>
                                            <div class="form-group form-floating"> ******
                                                <select class="form-select init-quickselect" name="adressen" placeholder="label" disabled>
                                                    <option value="">Bitte wählen</option>
                                                </select>
                                                <label>Kunde</label>
                                            </div>
                                            <div class="form-group form-floating"> ******
                                                <input type="text" name="name" class="form-control" placeholder="Bezeichnung" autocomplete="nope" disabled>
                                                <label>Ident</label>
                                            </div>
                                        </div>
                                    </div>
                                </form> -->
                            <!-- </div> -->
                            <!-- <div class="col-md-6">

                                <form id="form-ticket-infos">

                                    <div class="card">
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-floating"> ********
                                                        <input type="text" name="ersteller_id" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope">
                                                        <label>Eröffnet Benutzer</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-floating"> **********
                                                        <input type="text" name="erstellt" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope" >
                                                        <label>Eröffnet Datum</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-floating"> ******
                                                        <input type="text" name="verantwortlicher_id" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope" >
                                                        <label>Verantwortlicher</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-range" style="margin-top:8px;">
                                                        <label for="prioritaet" class="form-label">Priorität: <span id="prioritaet-label"></span></label>
                                                        <input type="range" name="prioritaet" class="form-range editable" id="prioritaet" min="1" max="3" value="2">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-floating"> ********
                                                        <input type="text" name="title" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope" >
                                                        <label>Projekt</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div> -->
                        <!-- </div> -->

                    <hr>

                    <div id="controller">
                        <button class="btn btn-primary neue-antwort"><i class="fa-solid fa-comment"></i> Antwort hinzufügen</button>
                        <button class="btn btn-primary"><i class="fa-solid fa-calendar"></i> Termin planen</button>
                    </div>


                    <div id="antwort" style="display:none;padding-left:115px;">

                        <div class="card">
                            <div class="card-body">
                                <form id="timeline-eintrag-form">

                            
                                    <div class="actions">
                                        <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Zeit erfassen"><i class="fa-solid fa-clock"></i></a>
                                        <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Verwerfen"><i class="fa-solid fa-xmark"></i></a>
                                    </div>


                                    <h4 class="card-title"><i class="fa-solid fa-pencil"></i> Neuen Beitrag verfassen</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-floating-radio">
                                                <label class="form-label">Veröffentlichung</label><br>
                                                <div class="form-radio form-check-inline">
                                                    <input class="form-check-input editable" type="radio" id="veroeffentlichen-1" name="veroeffentlichen" value="1">
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
                                                    <input class="form-check-input editable" type="radio" id="status-1" name="status" value="0">
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
                                        <textarea class="summernote form-control editable" name="name" placeholder="Bezeichnung" required></textarea>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-primary" id="add-summernote-timeline">Senden</button>
                                            <button class="btn btn-secondary">Abbrechen</button>
                                        </div>
                                        <div class="col-md-6" style="text-align:right;">
                                            <a href="javascript:void(0);"><em class="text-danger">Keine Zeit erfasst</em></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                    <!-- <hr>

                    <i class="fa-solid fa-calendar"></i> Stand: <?php echo date('d.m.Y H:i'); ?> -->


                    <div class="my-3" id="ticket-timeline"></div>


                </div>

                <!-- Seitenleiste -->
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



            <!-- <div id="test">
                <div class="p-1">
                    <p>Guten Morgen Herr Pitzer,</p>
                    <p>beim Testen der Anwendung sind mir folgende Punkte aufgefallen, bzw. sollten angepasst werden:</p>

                    <p>- Das Starten der Freigabe für Anlagen funktioniert nicht
                        <br>- Der Titel in der Baumansicht der Anlagen sollte sichtbar sein
                        <br>- Alle Dokumente sollten im Volltext aufgenommen werden
                        <br>- Bei der Benachrichtigung zur Kenntnisnahme fehlt die Dokumentennummer. Wäre es möglich auch den Kurztitel mitzugeben(bei allen Benachrichtigungen)?
                        <br>- Beim Vorschaudokument könnten die Version und das Erstelldatum eingetragen werden. Könnten Sie an den Stellen, wo das Datum noch unbekannt ist statt TT.MM.JJJJ ‚tbd.‘ einsetzen? Die Änderungshistorie ist fehlerhaft. Beispieldokument im Anhang.<br>- Könnten Sie bitte die Reiter im QS-Quelldokument umbenennen in Erstellung, Freigabe, Inkraftsetzung?<br>- Bei der Kenntnisnahme stimmt die Versionsnummer im Feed nicht<br>- Bitte den Button bei der Kenntnisnahme in ‚Kenntnisnahme bestätigt‘ ändern<br>- Bitte den Button bei der Inkraftsetzung in ‚In Kraft setzen‘ ändern<br>- Bitte die Buttons ‚Abbrechen‘ bei den Workflows in ‚Zurückweisen‘ ändern<br>- Wenn im Workflow bei den Aufgaben die Zusammenfassung angezeigt wird, kann dort auch die Historie oder der Änderungseintrag zu der Version angezeigt werden?
                        <br>- Bei der Ersteller-Freigabe von Dokument 232.PB.001 erscheint eine Fehlermeldung (siehe Anhang)
                    </p>
                    <p>
                        Wir können die obengenannten Punkte gerne noch einmal in einer Teams-Sitzung durchgehen. Wann würde es Ihnen passen?</p>

                    <ul>
                        <li>05-final-document.pdf</li>
                        <li>Screenshot 2022-05-19 102356.jpg</li>
                    </ul>


                </div>
            </div> -->



        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {


        // Init Object
        ticket_details.init();

        // var test = $('#test').html();

        // console.log(test);

        // $('#test').remove();

        // Beispiel Datensatz
        // var dataSet = [{
        //     'timestamp': '2021-05-06 10:20:00',
        //     'icon': 'fa fa-comment',
        //     'content': test,
        //     'precontent': '<i class="fa-solid fa-user"></i> Lothar Lüchau'
        // }];

        // Erstellen
        // var timeline = new Timeline('#ticket-timeline');

        // Daten setzen
        // timeline.setData(dataSet);

        // Write Data
        // timeline.render();


       

        // Neue Antwort
        // $('.neue-antwort').on('click', function() {
        //     $('#antwort').show();
        //     $('#controller').hide();
        // });


        // var form = new Form('#form-ticket-infos');

        // form.initValidation();

        // form.qs['ident'].setFilter('liste_a', el.val());


        // $('input[name=prioritaet]').on('input', function(e) {
        
        //     var value = $(this).val();

        //     setClass = {
        //         1: 'slider-danger',
        //         2: 'slider-warning',
        //         3: 'slider-success'
        //     };

        //     $(this).removeClass('slider-danger slider-warning slider-success').addClass(setClass[value]);



        // });


    });
</script>

</html>