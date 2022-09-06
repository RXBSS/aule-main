<?php include('01_init.php');

$_page = [
    'title' => "Verträge Details",
    'breadcrumbs' => ['Prozesse', '<a href="vertraege"> Verträge </a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper loading">
        <!-- loading -->
        <div class="container-fluid">

            <!-- <form id="vertraege-form"> -->
            <div class="row">

                <!-- ************************************************* -->
                <!-- Vertrag Adressen -->
                <!-- ************************************************* -->
                <div class="col-md-4">


                    <div class="card" id="card-adressen">
                        <div class="card-body">
                            <form id="form-vertraege-adressen">




                                <!-- Actions ITEM  -->
                                <!-- <div class="actions"> -->
                                <!-- <a class="action-item" id="adressen-details-suchen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Suchen"><i class="fa-solid fa-search"></i></a> -->
                                <!-- <a class="action-item" id="adressen-details-erstellen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Neu Erstellen"><i class="fa-solid fa-plus"></i></a> -->
                                <!-- <a class="action-item" id="adressen-details-bearbeiten" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Editieren"><i class="fa-solid fa-address-card"></i></a> -->
                                <!-- <a class="action-item" id="adressen-details-schliessen" data-status="2" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Nicht Speichern"><i class="fa-solid fa-close"></i></a> -->
                                <!-- <a class="action-item" id="adressen-details-speichern" data-status="2" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Speichern"><i class="fa-solid fa-save"></i></a> -->
                                <!-- </div> -->




                                <h4 class="title"><i class="fa-solid fa-users"></i> Vertragsnehmer</h4>



                                <br>

                                <!-- Warnung wenn Kunde GESPERRT -->
                                <div id="rechnungsempfaenger-ist-gesperrt" class="alert alert-danger my-2" style="display:none;">
                                    <i class="fa-solid fa-exclamation-triangle"></i> <strong>Der Kunde ist gesperrt!</strong> <span class="detail-text"></span>
                                </div>

                                <!-- <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <select class="form-select editable init-quickselect" data-qs-name="adressen" id="vertrags_standort" name="geraete_standort_id" placeholder="label">
                                                <option value="">bitte wählen</option>
                                            </select>
                                            <label>Geräte Standort</label>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- Rechnungadresse -->

                                <div class="row">
                                    <div class="col">


                                        <div class="qs-buttons d-flex justify-content-between">

                                            <div class="form-group form-floating form-select2-multi-column flex-grow-1">
                                                <select class="form-select init-quickselect editable" name="vn_adresse" data-qs-name="adressen" placeholder="Kunde" required>
                                                    <option value="">bitte wählen</option>
                                                </select>
                                                <label>Vertragsnehmer</label>
                                            </div>

                                            <!-- '<a class="action-item" id="adressen-details-erstellen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Neu Erstellen"><i class="fa-solid fa-plus"></i></a>' -->
                                            <!-- + '<a class="action-item" id="adressen-details-bearbeiten" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Editieren"><i class="fa-solid fa-address-card"></i></a>'); -->


                                            <div class="btn-group align-self-start pt-4 ps-2 quickselect-buttons">
                                                <button type="button" id="adressen-details-suchen" data-action="search" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Suchen"><i class="fa-solid fa-search"></i></button>
                                                <button type="button" id="adressen-details-erstellen" data-action="add" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Neu Erstellen"><i class="fa-solid fa-plus"></i></button>
                                                <button type="button" id="adressen-details-bearbeiten" data-action="edit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Editieren"><i class="fa-solid fa-edit"></i></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="form-group form-floating">
                                    <input type="text" name="vn_strasse" class="form-control" placeholder="Straße" readonly>
                                    <label>Straße</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group form-floating">
                                            <input type="text" name="vn_land" class="form-control" placeholder="Land" readonly>
                                            <label>Land</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-floating">
                                            <input type="text" name="vn_plz" class="form-control" placeholder="PLZ" readonly>
                                            <label>PLZ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group form-floating">
                                            <input type="text" name="vn_ort" class="form-control" placeholder="Ort" readonly>
                                            <label>Ort</label>
                                        </div>
                                    </div>

                                </div>


                                <!-- <nav>
                                    <div class="nav nav-tabs" id="tab-nav-name">
                                        <button class="nav-link active" id="tab-nav-name-1" data-bs-toggle="tab" data-bs-target="#tab-content-name-1" type="button"><i class="fa-solid fa-users"></i> Vertagsnehmer</button>
                                        <button class="nav-link" id="tab-nav-name-2" data-bs-toggle="tab" data-bs-target="#tab-content-name-2" type="button"> <i class="fa-solid fa-truck-loading"></i> Lieferadresse</button>
                                    </div>
                                </nav>
                                <br> -->
                                <!-- <div class="tab-content" id="tab-content-name">
                                    <div class="tab-pane show active" id="tab-content-name-1">
                                        CONTENT 1

                                        <div class="mb-3" id="separate-lf-info"><em>Es wurde eine separate Lieferadresse gewählt!</em></div>

                                        Rechnungadresse
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" name="vn_adresse" data-qs-name="adressen" placeholder="Kunde" required>
                                                <option value="">bitte wählen</option>
                                            </select>
                                            <label>Vertragsnehmer</label>
                                        </div>

                                        <div class="form-group form-floating">
                                            <input type="text" name="vn_strasse" class="form-control" placeholder="Straße" readonly>
                                            <label>Straße</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="vn_land" class="form-control" placeholder="Land" readonly>
                                                    <label>Land</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="vn_plz" class="form-control" placeholder="PLZ" readonly>
                                                    <label>PLZ</label>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="vn_ort" class="form-control" placeholder="Ort" readonly>
                                                    <label>Ort</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-content-name-2">
                                        CONTENT 2

                                        <div id="lieferadresse">

                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input editable" id="adresse-lieferadresse" name="lf_gleich_re" value="1" checked="">
                                                <label class="form-check-label" for="adresse-lieferadresse">Identisch mit Rechnungsadresse</label>
                                            </div>

                                            Lieferadresse
                                            <div class="form-group form-floating">
                                                <select class="form-select init-quickselect editable" name="lf_adresse" data-qs-name="adressen" placeholder="Kunde">
                                                    <option value="">bitte wählen</option>
                                                </select>
                                                <label>Lieferadresse</label>
                                            </div>

                                            <div class="form-group form-floating">
                                                <input type="text" name="lf_strasse" class="form-control" placeholder="Straße" readonly>
                                                <label>Straße</label>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group form-floating">
                                                        <input type="text" name="lf_land" class="form-control" placeholder="Land" readonly>
                                                        <label>Land</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group form-floating">
                                                        <input type="text" name="lf_plz" class="form-control" placeholder="PLZ" readonly>
                                                        <label>PLZ</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group form-floating">
                                                        <input type="text" name="lf_ort" class="form-control" placeholder="Ort" readonly>
                                                        <label>Ort</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div> -->



                            </form>
                        </div>
                    </div>


                </div>

                <!-- ************************************************* -->
                <!-- Vertrag Stammdaten -->
                <!-- ************************************************* -->
                <div class="col-md-4">

                    <div class="card w-100" id="card-stammdaten">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-file-contract"></i> Verträge Stammdaten</h4>

                            <form id="form-vertraege-stammdaten">

                                <!-- Vertragsvorlage -->
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <select class="form-select editable init-quickselect" id="vertrags_vorlagen" name="vorlagen_id" placeholder="label">
                                                <option value="">bitte wählen</option>
                                            </select>
                                            <label>Vertragsvorlage</label>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <input type="text" name="sachbearbeiter_id" class="form-control" placeholder="Sachbearbeiter Vertrag" autocomplete="nope" disabled>
                                            <label>Sachbearbeiter Vertrag</label>
                                        </div>
                                    </div>
                                    <div class="col" id="authorisierte_person">
                                        <div class="form-group form-floating">
                                            <input type="text" class="form-control" id="authorisierer_" name="authorisierer_id_" placeholder="Authorisiert" disabled>
                                            <label>Authorisierte Person</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col">

                                        <div class="qs-buttons d-flex justify-content-between">
                                            <div class="form-group form-floating form-select2-multi-column flex-grow-1">
                                                <select class="form-select editable init-quickselect adressen_kontakte" id="authorisiert" name="sachbearbeiterkunde_id" placeholder="Authorisiert">
                                                    <option value="">bitte wählen</option>
                                                </select>
                                                <label>Sachbearbeiter Kunde</label>
                                            </div>

                                            <div class="btn-group align-self-start pt-4 ps-2 quickselect-buttons">
                                                <button type="button" class="btn btn-primary button-kontakt-hinzufuegen" data-action="add" data-validate="single" data-bs-toggle="tooltip" data-bs-placement="top" title="Kontakt hinzufügen"><i class="fas fa-plus"></i></button>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="row" id="kunden_unterschrift">
                                    <div class="col">
                                        <div class="form-group form-floating-check">
                                            <label class="form-label">Kunden Unterschrift</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input editable" id="kunden_unterschrift_input" name="kunden_unterschrift" value="1" />
                                                <label class="form-check-label" for="kunden_unterschrift_input">Vorhanden</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Data -->
                                <input type="hidden" name="id">

                            </form>


                        </div>
                    </div>
                </div>

                <!-- ************************************************* -->
                <!-- Vertrag Status -->
                <!-- ************************************************* -->
                <div class="col-md-4">

                    <!-- Status 1 - Entwurf -->
                    <div id="status-1" class="alert alert-soft-warning detail-status" data-status="1">
                        <div class="detail-status-inner">
                            <div class="d-flex h-100 flex-column justify-content-between">
                                <div>
                                    <h4 class="alert-header entwurf-header"><i class="fa-solid fa-edit"></i> Vertrag ist ein Entwurf</h4>
                                    <ul class="status-unorder-list">

                                    </ul>
                                </div>
                                <div>
                                    <button type="button" id="btn-vertrag-aktivieren" class="btn btn-dark btn-vertrag-erstellen"><i class="fa-solid fa-check"></i> Vertrag erstellen</button>
                                    <!-- <button type="button" class="btn btn-dark btn-entwurf-speichern"><i class="fa-solid fa-save"></i> Entwurf speichern</button> -->
                                    <button type="button" id="btn-entwurf-loeschen" class="btn btn-danger btn-entwurf-loeschen"><i class="fa-solid fa-trash"></i> Entwurf löschen</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Status 2 - Aktiv -->
                    <div id="status-2-0" class="alert alert-soft-secondary detail-status" data-status="2" data-substatus="0">
                        <div class="detail-status-inner">
                            <div class="d-flex h-100 flex-column justify-content-between">
                                <div>
                                    <h4 class="alert-header status-header"><i class="fa-solid fa-hourglass-half"></i> Vertrag ist Aktiv</h4>

                                    <ul class="status-unorder-list">

                                    </ul>


                                    <!-- <a href=""><i class="fa-solid fa-file-pdf"></i> Auftragsbestätigung</a> - 26.01.2022<br> -->

                                </div>
                                <div>
                                    <button id="btn-vertrag-neue-version" class="btn btn-primary btn-vertrag-neue-version" type="button"><i class="fa-solid fa-code-branch"></i> Neue Version</button>
                                    <!-- <button class="btn btn-danger btn-vertrag-kuendigen" type="button"><i class="fa-solid fa-close"></i> Vertrag Kündigen</button> -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>



            <nav>
                <div class="nav nav-tabs" id="tab-nav-vertraege">
                    <button class="nav-link " id="tab-nav-vertraege-1" data-bs-toggle="tab" data-bs-target="#tab-content-vertraege-1" type="button"><i class="fa-solid fa-calendar"></i> Laufzeit & Kosten</button>
                    <button class="nav-link active" id="tab-nav-vertraege-2" data-bs-toggle="tab" data-bs-target="#tab-content-vertraege-2" type="button"><i class="fa-solid fa-list-ul"></i> Positionen</button>
                    <button class="nav-link " id="tab-nav-vertraege-3" data-bs-toggle="tab" data-bs-target="#tab-content-vertraege-3" type="button"><i class="fa-solid fa-gavel"></i> Klauseln</button>
                    <button class="nav-link " id="tab-nav-vertraege-4" data-bs-toggle="tab" data-bs-target="#tab-content-vertraege-4" type="button"><i class="fa-solid fa-file-invoice-dollar"></i> Abrechnung</button>
                </div>
            </nav>
            <br>
            <div class="tab-content" id="tab-content-vertraege" style="min-height: 75vh;">
                <div class="tab-pane " id="tab-content-vertraege-1">


                    <div class="row">

                        <!-- ********************************************************************* -->
                        <!-- Laufzeiten Verträge -->
                        <!-- ********************************************************************* -->
                        <div class="col-lg-6">

                            <div class="card" id="card-laufzeiten">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fa-solid fa-clock"></i> Laufzeit</h4>

                                    <form id="form-laufzeiten">
                                        <!-- Vertragsbeginn -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group form-floating">
                                                    <input type="date" name="vertragsbeginn" class="form-control editable" placeholder="Vertragsbeginn" autocomplete="off">
                                                    <label>Vertragsbeginn</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 laufzeit-body" id="vertragsende-input">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="vertragsende" class="form-control" placeholder="Vertragsende" disabled>
                                                    <label>Vertragsende</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Laufzeit Befristet oder Unbefristet -->
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group form-floating-check">
                                                    <label class="form-label">Befristet</label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input editable" id="laufzeit" name="laufzeit-trigger" />
                                                        <label class="form-check-label" for="laufzeit">Befristet</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 laufzeit-body">
                                                <div class="row">
                                                    <div class="col-lg-4">

                                                        <div class="form-group form-floating">
                                                            <input type="number" name="laufzeit" class="form-control editable" placeholder="Laufzeit in Monaten" autocomplete="off">
                                                            <!-- <div id="unbefristet_laufzeit_interval" class="form-unit " style="visibility: initial; opacity:1">Monate</div> -->
                                                            <label>Laufzeit</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group form-floating">
                                                            <select class="form-select set-data-unit editable" data-selector-unit="unbefristet_laufzeit_interval" name="laufzeit_interval" placeholder="Interval" disabled>
                                                                <option value="">bitte wählen</option>
                                                                <option value="d">Tag/e</option>
                                                                <option value="M" selected>Monat/e</option>
                                                                <option value="Y">Jahr/e</option>
                                                            </select>
                                                            <label>Interval</label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div id="verlaengerung_kuendigung_ebene">

                                            <!-- Automatische Verlängerung -->
                                            <div id="automatische-verlaengerung">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group form-floating-check">
                                                            <label class="form-label">Verlängerung</label>
                                                            <div class="form-check form-switch">
                                                                <input type="checkbox" class="form-check-input editable" id="verlaengerung" name="verlaengerung-trigger" />
                                                                <label class="form-check-label" for="verlaengerung">Verlängerung</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 verlaengerung-body">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group form-floating">
                                                                    <input type="number" name="verlaengerung_laufzeit" class="form-control editable" placeholder="Laufzeit in Monaten" autocomplete="off">
                                                                    <!-- <div id="verlaengerung_laufzeit_interval" class="form-unit " style="visibility: initial; opacity:1">Monate</div> -->
                                                                    <label>Laufzeit</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group form-floating">
                                                                    <select class="form-select set-data-unit editable" data-selector-unit="verlaengerung_laufzeit_interval" name="verlaengerung_laufzeit_interval" placeholder="Interval">
                                                                        <option value="">bitte wählen</option>
                                                                        <option value="d">Tag/e</option>
                                                                        <option value="M" selected>Monat/e</option>
                                                                        <option value="Y">Jahr/e</option>
                                                                    </select>
                                                                    <label>Interval</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group form-floating">
                                                                    <input type="text" name="verlaengerung_ende" class="form-control " placeholder="Ende" autocomplete="nope" disabled>
                                                                    <label>Ende</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Kündigungsfrist -->
                                            <div id="kuendigung_frist">
                                                <div id="automatische-verlängerung">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <div class="form-group form-floating-check">
                                                                <label class="form-label">Kündigungsfrist</label>
                                                                <div class="form-check form-switch">
                                                                    <input type="checkbox" class="form-check-input editable" id="kuendigungsfrist" name="kuendigungsfrist-trigger" />
                                                                    <label class="form-check-label" for="kuendigungsfrist">Kündigungsfrist</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 kuendigungsfrist-body laufzeit-body">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group form-floating">
                                                                        <input type="number" name="kuendigungsfrist_laufzeit" class="form-control editable" placeholder="Laufzeit in Monaten" autocomplete="off">
                                                                        <!-- <div id="kuendigungsfrist_laufzeit_interval" class="form-unit" style="visibility: initial; opacity:1">Monate</div> -->
                                                                        <label>Laufzeit</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group form-floating">
                                                                        <select class="form-select set-data-unit editable" data-selector-unit="kuendigungsfrist_laufzeit_interval" name="kuendigungsfrist_laufzeit_interval" placeholder="Interval">
                                                                            <option value="">bitte wählen</option>
                                                                            <option value="d">Tag/e</option>
                                                                            <option value="M" selected>Monat/e</option>
                                                                            <option value="Y">Jahr/e</option>
                                                                        </select>
                                                                        <label>Interval</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group form-floating">
                                                                        <input type="text" name="kuendigungsfrist_ende" class="form-control " placeholder="Ende" autocomplete="nope" disabled>
                                                                        <label>Ende</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="vertraege-progress-bar" class="progress mt-3">
                                            <div class="progress-bar bg-success" data-id="laufzeit" role="progressbar" style="width: 60%;" data-bs-toggle="tooltip" data-bs-placement="top" title="Vertragslaufzeit vom: "></div>
                                            <div class="progress-bar bg-warning" data-id="verlaengerung" role="progressbar" style="width: 20%;" data-bs-toggle="tooltip" data-bs-placement="top" title="Kündigungsfrist bis:"></div>
                                            <div class="progress-bar progress-bar-striped bg-danger" data-id="kuendigungsfrist" role="progressbar" style="width: 20%;" data-bs-toggle="tooltip" data-bs-placement="top" title="Vertragsverlängerung bis: "></div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- ********************************************************************* -->
                        <!-- Kosten Verträge -->
                        <!-- ********************************************************************* -->
                        <div class="col-lg-6">
                            <div class="card" id="card-kosten">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fas fa-dollar"></i> Kosten</h4>
                                    <form id="form-kosten">

                                        <input type="hidden" name="vertragsAbrechnungID">

                                        <div class="row">
                                            <div class="col-md-4" >
                                                <div class="form-group form-floating-check">
                                                    <label class="form-label">Pauschale</label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input editable" id="pauschale" name="pauschale" value="1" />
                                                        <label class="form-check-label" for="pauschale"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 pauschale-body">
                                                <div class="form-group form-floating">
                                                    <select class="form-select init-select2 editable" name="pauschale_abrechnung_interval" data-kalendarium="pauschale-kalendarium" placeholder="Abrechnung" required>
                                                        <option value="">Bitte wählen</option>
                                                        <option value="M">Monatlich</option>
                                                        <option value="Q">Quartal</option>
                                                        <option value="Y">Jährlich</option>
                                                        <option value="K">Nach Kalendarium</option>
                                                    </select>
                                                    <label>Abrechnung</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 ">
                                                <div class="form-group form-floating">
                                                    <select class="form-select init-select2 editable pauschale-body" name="kosten_interval" placeholder="Interval">
                                                        <option value="">Bitte wählen</option>
                                                        <option value="M">Monatlich</option>
                                                        <option value="Q">Quartal</option>
                                                        <option value="Y">Jährlich</option>
                                                    </select>
                                                    <label>Kosteninterval</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 pauschale-body offset-md-4">
                                                <div class="form-group form-floating" id="pauschale-kalendarium">
                                                    <select class="form-select init-select2 editable" name="pauschale_abrechnung_kalendarium" placeholder="Kalendarium">
                                                        <option value="">Bitte wählen</option>
                                                        <option value="K1">Kalendarium 1</option>
                                                        <option value="K2">Kalendarium 2</option>
                                                        <option value="">...</option>
                                                    </select>
                                                    <label>Kalendarium</label>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-floating-check pauschale-body">
                                                    <label class="form-label">Gesamtpauschale</label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input editable" id="gesamtpauschale" name="gesamtpauschale-trigger" value="1" />
                                                        <label class="form-check-label label-info" for="gesamtpauschale" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Die Preise aus den Positionen werden damit überschrieben">Aktiviert</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 gesamtpauschale-body">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="gesamtpauschale_preis" class="form-control editable " placeholder="Preis" autocomplete="nope">
                                                    <label>Preis</label>
                                                </div>
                                            </div>
                                        </div>


                                        <hr>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-floating-check">
                                                    <label class="form-label">Zähler</label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input editable" id="zaehler" name="zaehler" value="1" />
                                                        <label class="form-check-label" for="zaehler"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 zaehler-body">
                                                <div class="form-group form-floating">
                                                    <select class="form-select init-select2 editable" name="zaehler_abrechnung_interval" data-kalendarium="zaehler-kalendarium" placeholder="Abrechnung">
                                                        <option value="">Bitte wählen</option>
                                                        <option value="Q">Quartal</option>
                                                        <option value="M">Monatlich</option>
                                                        <option value="Y">Jährlich</option>
                                                        <option value="K">Nach Kalendarium</option>
                                                    </select>
                                                    <label>Abrechnung</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 zaehler-body">
                                                <div class="form-group form-floating" id="zaehler-kalendarium">
                                                    <select class="form-select init-select2 editable" name="zaehler_abrechnung_kalendarium" placeholder="Kalendarium">
                                                        <option value="">Bitte wählen</option>
                                                        <option value="K1">Kalendarium 1</option>
                                                        <option value="K2">Kalendarium 2</option>
                                                        <option value="">...</option>
                                                    </select>
                                                    <label>Kalendarium</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row zaehler-body">
                                            <div class="col-md-4">
                                                <div class="form-group form-floating-check">
                                                    <label class="form-label">Einheitliche Preise</label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input editable" id="zaehler_einheitlich" name="zaehler_einheitlich" value="1" />
                                                        <label class="form-check-label label-info" for="zaehler_einheitlich" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Die Preise werden pro Position eingestellt, dürfen aber nicht abweichen!">Aktiviert</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div><div id="zaehler-einheitliche-preise">A</div></div>
                                        </div>

                                        <div class="row">
                                            <div class="col">

                                                <div class="form-group form-floating-check">
                                                    <label class="form-label">Freimenge </label>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input editable" id="zaehler_freimenge" name="zaehler_freimenge" value="1" />
                                                        <label class="form-check-label" for="zaehler_freimenge">Aktiviert <a href="javascript:void(0);"><i class="fa-solid fa-link"></i></a></label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="tab-pane show active" id="tab-content-vertraege-2">
                    <!-- ************************************************************************ -->
                    <!-- Positionen -->
                    <!-- ************************************************************************ -->
                    <div class="row">
                        <div class="col-lg-8">

                            <div class="card">
                                <div class="card-body">

                                    <div class="actions">
                                        <!-- <a class="action-item btn-pos-delete" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Löschen"><i class="fa-solid fa-trash"></i></a> -->
                                        <!-- <a class="action-item btn-pos-shift" data-shift="up" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hoch"><i class="fa-solid fa-chevron-up"></i></a> -->
                                        <!-- <a class="action-item btn-pos-shift" data-shift="down" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Runter"><i class="fa-solid fa-chevron-down"></i></a> -->
                                        <!-- <a class="action-item btn-pos-add" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Neu"><i class="fa-solid fa-plus"></i></a> -->
                                    </div>

                                    <h4 class="card-title"><i class="fa-solid fa-user-plus"></i> Vertragspositionen</h4>


                                    <div id="pickliste-positionen"></div>


                                </div>
                            </div>

                        </div>

                        <!-- Position Form -->
                        <div class="col-lg-4">
                            <?php include('vertraege-details-positionen-form.php'); ?>
                        </div>

                    </div>
                </div>
                <div class="tab-pane " id="tab-content-vertraege-3">

                    <div class="form-group form-floating-check">
                        <label class="form-label">Benutzerdefinierter Vertrag</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input editable" id="benuzterdefinierter-vertrag" name="benuzterdefinierter-vertrag" value="1"  />
                            <label class="form-check-label" for="benuzterdefinierter-vertrag">Aktivieren</label>
                        </div>
                    </div>

                    <!-- Benutzer Definierte Klauseln -->
                    <!-- <div class="card" id="benutzerdefinierte-klausel-card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">

                                    <div class="form-group form-floating">
                                        <select class="form-select editable init-quickselect" name="vertraegegruppen_id" data-qs-name="vertraege_gruppen" placeholder="Verträgegruppen">
                                            <option value="">bitte wählen</option>
                                        </select>
                                        <label>Verträgegruppen</label>
                                    </div>

                                </div>
                                <div class="col">

                                    <div class="form-group form-floating">
                                        <textarea class="form-control editable" name="text" placeholder="Klausel"></textarea>
                                        <label>Klausel</label>
                                    </div>

                                </div>
                            </div>

                            <br>
                            <br>
                            <br>

                            <div class="position-relative">

                                <div class="position-absolute bottom-0 end-0">
                                    <button class="btn btn-secondary btn-benutzerdefinierte-klausel-abbruch text-end">Abbrechen</button>
                                    <button class="btn btn-primary btn-benutzerdefinierte-klausel">Speichern</button>

                                </div>
                            </div>

                        </div>
                    </div> -->


                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" id="card-klauseln-pickliste">
                                <div class="card-body">
                                    <div id="vertraege-klauseln-pickliste"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="card" id="card-klauseln">
                                <div class="card-body">

                                    <!-- ********************************************************************** -->
                                    <!-- Paragraphen und Klauseln -->
                                    <!-- ********************************************************************** -->
                                    <div class="row">
                                        <div id="paragraphen-klauseln"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vergleich was anders ist -->

                </div>
                <div class="tab-pane " id="tab-content-vertraege-4">


                    <div class="row">
                        <div class="col-lg-8">

                            <div id="abrechnungen-pickliste"></div>

                            <!-- <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fas fa-dollar"></i> Abrechnung</h4>

                                    <h6 class="subtext">Das ist der Subtext</h6>

                                    <table class="table table-sm table-striped table-hover" id="abrechnungsTable">
                                        <tr>
                                            <th>Abrechnungsdatum</th>
                                            <th>Abrechnungskosten</th>
                                            <th>Pauschale | Zähler</th>
                                            <th>Fälligkeit</th>
                                        </tr>
                                    </table>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-lg-4">

                        </div>
                    </div>



                </div>



            </div>









            <!-- Status 1 -->
            <div class="fab-container detail-status" data-status="1">
                <button type="button" class="btn btn-danger btn-sm fab-children btn-entwurf-loeschen" data-label="Entwurf Löschen"><i class="fa-solid fa-trash"></i></button>
                <button type="button" class="btn btn-primary btn-sm fab-children btn-vertrag-erstellen" data-label="Vertrag erstellen"><i class="fa-solid fa-check"></i></button>
                <button type="button" class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
            </div>
            <!-- </form> -->

        </div>
    </div>
</body>

<!-- ******************************************************* -->
<!-- Vertrag Kündigen Modal -->
<!-- ******************************************************* -->
<div class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Vertrag Kündigen</h5>
                <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">

                <form id="vertrag-kuendigen-form">


                    <p>
                        Ein Vetrag kann jederzeit gekündigt werden, sobald die Laufzeit vollständig durchlaufen ist.
                        <br>
                        Es muss ein Grund, Datum und Auftraggeber angegeben werden. <br>
                    </p>

                    <div class="alert alert-soft-info"> Hier müssen die Daten eingetragen werden, welche von dem Kunden gesendet werden.</div>


                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <select class="form-select editable init-quickselect" id="kuendigung-auftraggeber" name="gekuendigt_kontakt_id" placeholder="Auftraggeber" required>
                                    <option value="">bitte wählen</option>
                                </select>
                                <label>Auftraggeber</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group form-floating">
                                <input type="date" name="gekuendigt_am" class="form-control editable" placeholder="Kündigungsdatum" autocomplete="nope" required>
                                <label>Kündigungsdatum</label>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="form-group form-floating">
                                <textarea class="form-control editable" name="gekuendigt_grund" placeholder="Kündigungsgrund"></textarea>
                                <label>Kündigungsgrund</label>
                            </div>
                        </div>
                    </div>


                </form>

            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<!-- Vertrags Angebot Erstellen & Verschicken -->

<!-- Modal zum Erstellen -->
<div class="modal" id="angebot-erstellen-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <form id="vertraege-erstellen-form">


                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Vertrag Erstellen & Verschicken</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body pt-0">


                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <select class="form-select editable init-quickselect" data-qs-name="mitarbeiter" id="authorisierer" name="authorisierer_id" placeholder="Authorisiert" required>
                                    <option value="">bitte wählen</option>
                                </select>
                                <label>Authorisierte Person</label>
                            </div>
                        </div>
                    </div>

                    <!-- Auswahl der Versandart -->
                    <div class="form-group form-floating-radio">
                        <label class="form-label">Versenden an den Kunden</label>
                        <div class="form-radio">
                            <input type="radio" class="form-check-input editable" value="email" id="vertrag-versandart-1" name="versandart" checked />
                            <label class="form-check-label" for="vertrag-versandart-1"><i class="fa-solid fa-envelope"></i> Per E-Mail verschicken</label>
                        </div>
                        <div class="form-radio">
                            <input type="radio" class="form-check-input editable" value="print" id="vertrag-versandart-2" name="versandart" />
                            <label class="form-check-label" for="vertrag-versandart-2"><i class="fa-solid fa-print"></i> Ausdrucken</label>
                        </div>
                    </div>


                    <!-- Nur bei E-Mail -->
                    <div class="vertrag-erstellen-versandart" data-values="email">
                        <div class="form-group form-floating">
                            <input type="text" name="mail_absender" class="form-control editable" value="t.pitzer@buerosystemhaus.de" placeholder="Absender" autocomplete="nope" required>
                            <label>Absender</label>
                        </div>

                        <div class="form-group form-floating">
                            <input type="text" name="mail_empfaenger" class="form-control editable" value="empfaenger@buerosystemhaus.de" placeholder="Empfänger" autocomplete="nope" required>
                            <label>Empfänger</label>
                        </div>
                    </div>

                    <!-- <div class="angebot-erstellen-versandart" data-values="print">
                            Ich werde nur beim Drucken angezeigt!
                        </div> -->

                    <div class="form-group form-floating-check">
                        <label class="form-label">Prüfen</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input editable" id="vertrag-erstellen-geprueft" name="auf_fehler_geprueft" value="1" required />
                            <label class="form-check-label" for="vertrag-erstellen-geprueft">Auf Fehler geprüft</label>
                        </div>
                    </div>

                    <div class="form-group form-floating-check vertrag-erstellen-versandart" data-values="print">
                        <label class="form-label">Prüfen</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input editable" id="vertrag-erstellen-gedruckt" name="kunden_gesendet" value="1" required />
                            <label class="form-check-label" for="vertrag-erstellen-gedruckt">Gedruckt und an Kunden versendet</label>
                        </div>
                    </div>

                    <!-- Vorschau Dokument -->
                    <a href="javascript:void(0);" data-document="vt" class="btn btn-primary mt-3 btn-show-document btn-print-preview action-item" style="margin-left: -4px;"><i class="fa-solid fa-file-pdf"></i> Vorschau Dokument</a>

                </div>
                <div class="modal-footer"></div>

            </form>
        </div>
    </div>
</div>



<?php include('./adressen-neu-modal.php')  ?>
<?php include('./kontakte-neu-modal.php')  ?>
<?php include("./rechnungs-lieferadresse-modal.php") ?>


<?php include('04_scripts.php'); ?>

<!-- Google API Script -->
<?php include("googleapis.php"); ?>

<script src="../js/pagelevel/adressen-neu.js"></script>
<script src="../js/pagelevel/kontakte-neu.js"></script>
<script src="../js/pagelevel/vertraege-details-adressen.js"></script>
<script src="../js/pagelevel/vertraege-details-abrechnung.js"></script>
<script src="../js/pagelevel/vertraege-details-stammdaten.js"></script>
<script src="../js/pagelevel/vertraege-details-laufzeiten.js"></script>
<script src="../js/pagelevel/vertraege-details-kosten.js"></script>
<script src="../js/pagelevel/vertraege-details-klauseln.js"></script>
<script src="js/pagelevel/vertraege-details-positionen.js"></script>
<script src="../js/pagelevel/vertraege-laufzeiten-validierung.js"></script>

<script>
    v_d = Object.assign(v_adressen, v_d);
    v_d = Object.assign(v_abrechnung, v_d);
    v_d = Object.assign(kontakte_neu, v_d);
    v_d = Object.assign(v_stammdaten, v_d);
    v_d = Object.assign(v_laufzeiten, v_d);
    v_d = Object.assign(v_kosten, v_d);
    v_d = Object.assign(v_klausel, v_d);
    v_d = Object.assign(v_Pos, v_d);
    v_d = Object.assign(adressen_neu, v_d);
    v_d = Object.assign(l_validierung, v_d);

    // v_d = Object.assign(vPos, v_d);
    v_d = Object.assign(detailHelper, v_d);

    $(document).on('app:ready', function() {


        v_d.init();

    });
</script>

</html>