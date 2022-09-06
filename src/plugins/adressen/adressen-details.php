<?php include('01_init.php');

// Alle Daten von Adressen mit dieser id
$adressen = new Adressen();
$data = $adressen->get($_GET['id']);

$_page = [
    'title' => "Adressen Details <custom class='kontosperre'></custom>",
    'breadcrumbs' => ['Stammdaten', '<a href="adressen"><i class="fa-regular fa-address-card"></i> Adressen</a>']
];


// $laender = $adressen->getLaender($data['land']);



?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body>



    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">

            <!-- ****************************************************** -->
            <!-- Warnung Kunde gesperrt -->
            <!-- ****************************************************** -->
            <div class="kontosperre-warning">

            </div>
            
           

            <!-- ****************************************************** -->
            <!-- Stammdaten -->
            <!-- ****************************************************** -->
            <div class="row">
                <div class="col-md-4">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-box"></i> Adressen Stammdaten</h4>

                            <!-- Form -->
                            <form id="form-adressen">

                                <!-- HIDDEN -->
                                <input type="hidden" name="id">
                                <input type="hidden" name="place_id">

                                <div class="form-group form-floating">
                                    <input type="text" name="name" class="form-control editable name" placeholder="Firmenname">
                                    <label>Firmenname</label>
                                </div>
                                <div class="form-group form-floating">
                                    <input type="text" class="form-control editable" placeholder="Namenszusatz">
                                    <label>Namenszusatz</label>
                                </div>
                                <div class="form-group form-floating">
                                    <input type="text" name="strasse" class="form-control editable" placeholder="Straße">
                                    <label>Straße</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" name="laender" data-qs-name="laender" placeholder="Länder">
                                                
                                            </select>
                                            <label>Länder</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-floating">
                                            <input type="text" name="plz" class="form-control editable" placeholder="PLZ">
                                            <label>PLZ</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-floating">
                                            <input type="text" name="ort" class="form-control editable" placeholder="Ort">
                                            <label>Ort</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" data-format="Telefon" name="telefon"  class="form-control editable" placeholder="Telefon">
                                            <label>Telefon</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" data-format="Telefon" name="telefax"  class="form-control editable" placeholder="Telefax">
                                            <label>Telefax</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <input type="email" data-format="Lowercase" name="email" class="form-control editable" placeholder="E-Mail">
                                            <label>E-Mail</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">

                                        <div class="form-group form-floating">
                                            <select class="form-select editable" name="auslieferungsart" placeholder="Auslieferungsart">

                                                <option value="standard">Standard</option>
                                                <option value="versand">Versand</option>
                                                <option value="auslieferung">Auslieferung</option>
                                                <option value="techniker">Techniker</option>
                                            </select>
                                            <label>Auslieferungsart</label>
                                        </div>

                                    </div>
                                </div>



                                <div class="form-group form-floating">
                                    <input type="text" name="website"  data-format="Website" class="form-control editable" placeholder="Website">
                                    <label>Website</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="steuernummer" class="form-control editable" placeholder="Steuernummer">
                                            <label>Steuernummer</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="umsatzsetuer_id" class="form-control editable" placeholder="Umsatzsetuer ID">
                                            <label>Umsatzsetuer-ID</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Google Fahrzeit Informationen -->
                                <div class="row" id="google_maps_infos">
                                    
                                </div>

                                <div class='mt-lg-3' id="powered-google">

                                
                                <!-- <?php
                                
                                   

                                ?> -->
                                </div>

                            </form>
                        </div>
                    </div>

                </div>



                <div class="col-md-8">

                    <ul class="nav nav-tabs nav-fill mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <button class="nav-link  " id="pills-eigenschaften" data-bs-toggle="pill" data-bs-target="#eigenschaften" type="button" role="tab" aria-controls="eigenschaften" aria-selected="true">Eigenschaften</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-personen" data-bs-toggle="pill" data-bs-target="#personen" type="button" role="tab" aria-controls="personen" aria-selected="false">Personen</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link ist_kunde" id="pills-kunde" data-bs-toggle="pill" data-bs-target="#kunde" type="button" role="tab" aria-controls="kunde" aria-selected="false">
                                
                                Kunde
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link ist_lieferant active"  id="pills-lieferant" data-bs-toggle="pill" data-bs-target="#lieferant" type="button" role="tab" aria-controls="lieferant" aria-selected="false">

                                Lieferant
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link ist_hersteller" id="pills-hersteller" data-bs-toggle="pill" data-bs-target="#hersteller" type="button" role="tab" aria-controls="hersteller" aria-selected="false">
                                
                                Hersteller
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane " id="eigenschaften" role="tabpanel" aria-labelledby="pills-eigenschaften">

                            <div class="row">
                                <div class="col col-md-6">
                                    <div class="card" id="adressen-bankverbindung-card">
                                        <div class="card-body">

                                            <div class="actions">
                                                <a class="action-item btn-bankverbindung-add" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Hinzufügen Öffnungszeiten"><i class="fa-solid fa-plus"></i></a>
                                                <a class="action-item btn-bankverbindung-edit" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Editieren Öffnungszeiten"><i class="fa-solid fa-edit"></i></a>
                                                <a class="action-item btn-bankverbindung-delete" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Löschen Öffnungszeiten"><i class="fa-solid fa-trash"></i></a>
                                            </div>

                                            <h5 class="card-title"><i class="fa-solid fa-piggy-bank"></i> Bankverbindungen</h5>

                                            <div id="bankverbindungen-pickliste"></div>

                                        </div>
                                    </div>

                                </div>
                                <div class="col col-md-6">
                                    <div class="card" id="adressen-oeffnungszeiten-card">
                                        <div class="card-body">

                                            <div class="actions">
                                            
                                                <a class="action-item btn-oeffnungszeit-delete" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Löschen aller Öffnungszeiten"><i class="fa-solid fa-trash"></i></a>
                                                <a class="action-item btn-oeffnungszeit-edit" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Öffnungszeiten Editieren oder löschen"><i class="fa-solid fa-edit"></i></a>
                                            </div>

                                            <h5 class="card-title"><i class="fa-solid fa-clock"></i> Öffnungszeiten

                                                <small id="aktuelle-uhrzeit"></small>


                                            </h5>
                                            <div id="geoeffnet-noch"></div>

                                            <div id="oeffnungszeiten-pickliste"></div>


                                            <div id="aktuell-oeffnungszeiten"></div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="personen" role="tabpanel" aria-labelledby="pills-personen">

                            <div class="text-end" id="adressen-personen-ansichten">
                                
                                <a href="javascript:void(0);" id="button-kontakte-hinzufuegen">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <a href="javascript:void(0);" id="adressen-personen-pickliste-ausloeser">
                                    <!-- <i class="fa-solid fa-table"></i> -->
                                    <i class="fa-solid fa-list"></i>
                                </a>
                                
                            </div>

                            <div class="card" id="adressen-kontakte-pickliste">
                                <div class="card-body">

                                    <div id="adressen-personen-pickliste"></div>

                                </div>
                            </div>

                            <div class="row" id="adressen-kontakte-card">

                            </div>

                            <?php

                                // include('./adressen-visitenkarten-ansicht.php');

                                // cardView($_GET['id']);
                            ?>

                        </div>

                        <!---

                        // MARK: Kunde

                        -->



                        <div class="tab-pane " id="kunde" role="tabpanel" aria-labelledby="pills-kunde">
                            <div class="card" id="activation-card-kunde">
                                <div class="card-body">



                                    <h4>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input card-activate-switch" type="checkbox" id="ist_kunde_cb" name="ist_kunde">
                                            <label class="form-check-label" for="ist_kunde_cb">Kunde</label>
                                        </div>
                                    </h4>

                                    <br>

                                    <form id="form-kunden-stammdaten" class="card-body-checked">

                                        <div class="row">

                                            <div class="col-lg-4 ist-kunde-toggler">
                                                <div class="">
                                                    <div class="form-group form-floating">
                                                        <input type="text" name="kunden_nummer" class="form-control editable" placeholder="Kundennummer" autocomplete="off">
                                                        <label>Kundennummer</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group form-floating">
                                                    <select class="form-select init-select2 editable init-quickselect" data-qs-name="branche" name="branche" placeholder="label">

                                                    </select>
                                                    <label>Branche</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group form-floating">
                                                    <select class="form-select editable" name="auslieferungsart" placeholder="Auslieferungsart" required>
                                                        <option value="standard">Standard</option>
                                                        <option value="versand">Versand</option>
                                                        <option value="auslieferung">Auslieferung</option>
                                                        <option value="techniker">Techniker</option>
                                                    </select>
                                                    <label>Auslieferungsart</label>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <!-- <div class="card"> -->
                                            <!-- <div class="card-body"> -->
                                                <!-- <h4 class="card-title"><i class="fa-solid fa-circle-info"></i> Informationen zum Kunden</h4> -->
                                        
                                                <!-- <h6 class="subtext">Es werden Informationen über den Kunden gesammelt, um sich ein Bild über diesen zu schaffen</h6> -->

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <!-- <div class="form-group "> -->

                                                        <div class="form-group form-floating-radio">
                                                            <label class="form-label">Kundenstatus</label><br>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="interessent" name="kundenstatus" value="interessent">
                                                                <label class="form-check-label" for="interessent">Interessent</label>
                                                            </div>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="neukunde" name="kundenstatus" value="neukunde">
                                                                <label class="form-check-label" for="neukunde">Neukunde</label>
                                                            </div>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="stammkunde" name="kundenstatus" value="stammkunde">
                                                                <label class="form-check-label" for="stammkunde">Stammkunde</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group form-floating-radio">
                                                            <label class="form-label">Anzahl der Mitarbeiter</label><br>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="1-10" name="unternehmensgroeße" value="1-10">
                                                                <label class="form-check-label" for="1-10">1-10</label>
                                                            </div>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="11-20" name="unternehmensgroeße" value="11-20">
                                                                <label class="form-check-label" for="11-20">11-20</label>
                                                            </div>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="21-100" name="unternehmensgroeße" value="21-100">
                                                                <label class="form-check-label" for="21-100">21-100</label>
                                                            </div>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="100+" name="unternehmensgroeße" value="100+">
                                                                <label class="form-check-label" for="100+">100+</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group form-floating-radio">
                                                            <label class="form-label">IT-Situation</label><br>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="eigene" name="it_situation" value="eigene">
                                                                <label class="form-check-label" for="eigene">Eigene</label>
                                                            </div>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="externe" name="it_situation" value="externe">
                                                                <label class="form-check-label" for="externe">Externe</label>
                                                            </div>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="eigene_externe" name="it_situation" value="eigene_externe">
                                                                <label class="form-check-label" for="eigene_externe">Beides</label>
                                                            </div>
                                                            <div class="form-radio form-check-inline">
                                                                <input class="form-check-input editable" type="radio" id="keine" name="it_situation" value="keine">
                                                                <label class="form-check-label" for="keine">Keine IT</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                        
                                            <!-- </div> -->
                                        <!-- </div> -->

                                        


                                        <br>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group form-floating-radio">
                                                    <div class="form-radio form-check-inline">
                                                        <input type="radio" class="form-check-input editable" id="kundentyp-1" name="ist_betreiber" value="0" required />
                                                        <label class="form-check-label" for="kundentyp-1">Rechnungempfänger</label>
                                                    </div>
                                                    <div class="form-radio form-check-inline">
                                                        <input type="radio" class="form-check-input editable" id="kundentyp-2" name="ist_betreiber" value="1" required />
                                                        <label class="form-check-label" for="kundentyp-2">Betreiber</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="kunden-type kunden-type-1">
                                            <div class="form-group form-floating">
                                                <select class="form-select init-quickselect editable" name="rechnungsempfaenger_id" data-qs-name="adressen" placeholder="Rechnungsempfänger">
                                                    <option value="">bitte wählen</option>
                                                </select>
                                                <label>Rechnungsempfänger</label>
                                            </div>
                                        </div>

                                        <div class="kunden-type kunden-type-0">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card" id="activation-card-email-rechnung">
                                                        <div class="card-body">
                                                            <h5>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input card-activate-switch" type="checkbox" id="kunde_email_rechnung" name="kunde_email_rechnung">
                                                                    <label class="form-check-label" for="kunde_email_rechnung">E-Mail Rechnung</label>
                                                                </div>
                                                            </h5>

                                                            <div class="card-body-checked">


                                                                <!-- Mockup -->
                                                                <div class="activation-input-container">
                                                                    <div class="form-group form-floating-check">
                                                                        <label class="form-label">Andere</label>
                                                                        <div class="form-check">
                                                                            <input type="checkbox" class="form-check-input editable" id="kunde_email_rechnung_benutzerdefiniert" name="kunde_email_rechnung_benutzerdefiniert" value="1" />
                                                                            <label class="form-check-label" for="kunde_email_rechnung_benutzerdefiniert"></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group form-floating">
                                                                        <input type="email" name="kunde_email_rechnung_adresse" class="form-control editable card-input-checked" data-mode="0" placeholder="E-Mail" autocomplete="off" required>
                                                                        <label>E-Mail Benutzerdefiniert</label>
                                                                    </div>
                                                                </div>




                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="card" id="activation-card-konto-sperre">
                                                        <div class="card-body">
                                                            <h5>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input card-activate-switch color-danger" type="checkbox" id="kunde_gesperrt" name="kunde_gesperrt">
                                                                    <label class="form-check-label" for="kunde_gesperrt">Konto Sperre</label>
                                                                </div>
                                                            </h5>
                                                            <div class="card-body-checked">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group form-floating">
                                                                            <select class="form-select editable card-input-checked" name="kunde_gesperrt_grund" data-mode="0" placeholder="Grund" required>
                                                                                <option value="">bitte wählen</option>
                                                                                <option value="stören">Stören</option>
                                                                                <option value="sicherheit">Sicherheit</option>
                                                                                <option value="mehr">Mehr Folgt</option>
                                                                            </select>
                                                                            <label>Grund</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group form-floating">
                                                                            <select class="form-select init-quickselect card-input-checked" data-qs-name="mitarbeiter" data-mode="0" name="kunde_gesperrt_mitarbeiter" id="kunde_gesperrt_mitarbeiter" placeholder="Mitarbeiter" required>

                                                                            </select>
                                                                            <label>Mitarbeiter</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-group form-floating">
                                                                            <input type="date" name="kunde_gesperrt_datum" class="form-control editable card-input-checked" data-mode="0" placeholder="Zeitpunkt der Sperre" autocomplete="off" required>
                                                                            <label>Zeitpunkt der Sperre</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane show active" id="lieferant" role="tabpanel" aria-labelledby="pills-lieferant">

                            <div class="card" id="activation-card-lieferant">
                                <div class="card-body">


                                    <h4>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input card-activate-switch" type="checkbox" id="ist_lieferant_cb" name="ist_lieferant">
                                            <label class="form-check-label" for="ist_lieferant_cb">Lieferant</label>
                                        </div>
                                    </h4>

                                    <br>


                                    <form id="form-lieferant-stammdaten" class="card-body-checked">
                                        <div class="row">

                                            <div class="col  col-lg-3">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="lieferanten_nummer" class="form-control editable" placeholder="Lieferantennummer" autocomplete="off">
                                                    <label>Lieferantennummer</label>
                                                </div>
                                            </div>

                                            <!-- TODO: DAS IST UNSERE KUNDENNUMMER DIE ANDERE IST DIE KUNDENNUMMER DES KUNDEN -->
                                            <div class="col col-lg-3">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="lieferant_kundennummer" class="form-control editable" placeholder="Kundennummer" autocomplete="off">
                                                    <label>Unsere Kundennummer</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="lieferant_bezeichnung" class="form-control editable" placeholder="Lieferant Bezeichnung" autocomplete="off">
                                                    <label>Lieferant Bezeichnung</label>
                                                </div>
                                            </div>
                                        </div>





                                        <div class="row mt-3">
                                            <div class="col-lg-6">
                                               
                                                        
                                                <div class="activation-input-container">
                                                    <div class="form-group form-floating-check">
                                                        <label class="form-label">Andere</label>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input editable" id="lieferant_bestellung_email_benutzerdefiniert" name="lieferant_bestellung_email_benutzerdefiniert" value="1" />
                                                            <label class="form-check-label" for="lieferant_bestellung_email_benutzerdefiniert"></label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-floating">
                                                        <input type="email" name="lieferant_bestellung_email" class="form-control editable card-input-checked" data-mode="0" placeholder="E-Mail" autocomplete="off" required>
                                                        <label>E-Mail für Bestellungen</label>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-lg-6">

                                                <div class="form-group form-floating">
                                                    <select class="form-select init-select2 editable" name="lieferant_bestellung_art" placeholder="Bevorzugte Bestellart">
                                                        <option value="">Bitte wählen</option>
                                                        <option value="1">Manuelle Bestellung / Bereits erfolgt</option>
                                                        <option value="2">Bestellung drucken</option>
                                                        <option value="3">Bestellung per Mail versenden</option>
                                                        <option value="4">Übertragung per Schnittstelle</option>
                                                    </select>
                                                    <label>Bevorzugte Bestellart</label>
                                                </div>

                                            </div>
                                            
                                            <br>

                                            <div class="col mt-lg-4">

                                                <div class="row">

                                                    <div class="col-lg-6">


                                                    <!-- Zahlungsbedinungen -->
                                                        <div class="card" id="activation-card-zahlungsbedinungen">
                                                            <div class="card-body">
                                                                <h5>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input card-activate-switch" type="checkbox" id="lieferant_zahlungsbedingung" name="lieferant_zahlungsbedingung">
                                                                        <label class="form-check-label" for="lieferant_zahlungsbedingung">Zahlungsbedinungen</label>
                                                                    </div>
                                                                </h5>

                                                                <div class="card-body-checked">

                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="form-group form-floating">
                                                                                <input type="text" name="lieferant_zahlungsbedingung_tage" class="form-control editable" placeholder="Anzahl Tage" autocomplete="nope">
                                                                                <label>Anzahl Tage</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-group form-floating">
                                                                                <input type="text" name="lieferant_zahlungsbedingung_kreditwert" class="form-control editable" placeholder="Kreditwert" data-format="Waehrung" autocomplete="nope">
                                                                                <div class="form-unit">€</div>
                                                                                
                                                                                <label>Kreditwert</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">



                                                                        <div class="form-group form-floating-check">
                                                                            <label class="form-label">Skonto</label>
                                                                            <div class="form-check form-switch">
                                                                                <input type="checkbox" class="form-check-input editable" id="skonto-checkbox" name="skonto-checkbox" value="1">
                                                                                <label class="form-check-label" for="skonto-checkbox">Skonto</label>
                                                                            </div>
                                                                        </div>
                                                                        <div id="skonto-checked">
                                                                            <div class="row">
                                                                                <div class="col">
                                                                                    <div class="form-group form-floating">
                                                                                        <input type="text" name="lieferant_zahlungsbedingung_skonto_tage" class="form-control editable" placeholder="Skonto Tage" autocomplete="nope">
                                                                                        <label>Skonto Tage</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <div class="form-group form-floating">
                                                                                        <input type="text" name="lieferant_zahlungsbedingung_skonto" class="form-control editable" placeholder="Skonto in %" autocomplete="nope">
                                                                                        <div class="form-unit">%</div>
                                                                                        
                                                                                        <label>Skonto in %</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        
                                                                    </div>

                                                                    <!-- Mockup -->
                                                                    <!-- <div class="activation-input-container">
                                                                        <div class="form-group form-floating-check">
                                                                            <label class="form-label">Andere</label>
                                                                            <div class="form-check">
                                                                                <input type="checkbox" class="form-check-input editable" id="kunde_email_rechnung_benutzerdefiniert" name="kunde_email_rechnung_benutzerdefiniert" value="1" />
                                                                                <label class="form-check-label" for="kunde_email_rechnung_benutzerdefiniert"></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group form-floating">
                                                                            <input type="email" name="kunde_email_rechnung_adresse" class="form-control editable card-input-checked" data-mode="0" placeholder="E-Mail" autocomplete="off" required>
                                                                            <label>E-Mail Benutzerdefiniert</label>
                                                                        </div>
                                                                    </div> -->

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">

                                                        <!-- Mindermengenzuschlag  -->
                                                        <div class="card" id="activation-card-mindermengenzuschlag">
                                                            <div class="card-body">
                                                                <h5>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input card-activate-switch" type="checkbox" id="lieferant_mindermengenzuschlag" name="lieferant_mindermengenzuschlag">
                                                                        <label class="form-check-label" for="lieferant_mindermengenzuschlag">Mindermengenzuschlag</label>
                                                                    </div>
                                                                </h5>

                                                                <div class="card-body-checked">


                                                                    <!-- Mockup -->
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="form-group form-floating">
                                                                                <input type="text" name="lieferant_mindermengenzuschlag_schwelle" class="form-control editable" placeholder="Schwelle (bis)" autocomplete="nope">
                                                                                <div class="form-unit">€</div>
                                                                                
                                                                                <label>Schwelle (bis)</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div class="form-group form-floating">
                                                                                <input type="text" name="lieferant_mindermengenzuschlag_zuschlag" class="form-control editable" placeholder="Zuschlag" autocomplete="nope">
                                                                                <div class="form-unit">€</div>
                                                                                <label>Zuschlag</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    

                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>


                                                </div>


                                                <div class="row">

                                                    <div class="col-lg-6">

                                                        <!-- Versand/ Versicherung -->
                                                        <div class="card" id="activation-card-versand-versicherung">
                                                            <div class="card-body">
                                                                <h5>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input card-activate-switch" type="checkbox" id="lieferant_versand_versicherung" name="lieferant_versand_versicherung">
                                                                        <label class="form-check-label" for="lieferant_versand_versicherung">Versand/ Versicherung</label>
                                                                    </div>
                                                                </h5>

                                                                <div class="card-body-checked">


                                                                    <!-- Mockup -->
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group form-floating">
                                                                                <input type="text" name="lieferant_versand_versicherung_betrag" class="form-control editable" placeholder="Betrag" autocomplete="nope">
                                                                                <div class="form-unit">€</div>
                                                                                
                                                                                <label>Betrag</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group form-floating">
                                                                                <input type="text" name="lieferant_versand_versicherung_versicherung" class="form-control editable" placeholder="Versicherung" autocomplete="nope">
                                                                                <div class="form-unit">€</div>
                                                                                
                                                                                <label>Versicherung</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group form-floating-check">
                                                                        <label class="form-label">Freibeträge</label>
                                                                        <div class="form-check form-switch">
                                                                            <input type="checkbox" class="form-check-input editable" id="freibetrag-checkbox" name="freibetrag-checkbox" value="1">
                                                                            <label class="form-check-label" for="freibetrag-checkbox">Freibetrag ab: </label>
                                                                        </div>
                                                                    </div>
                                                                    <div id="freibetrag-checked">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="form-group form-floating">
                                                                                    <input type="text" name="lieferant_versand_versicherung_freibetrag" class="form-control editable" placeholder="Skonto Tage" autocomplete="nope">
                                                                                    <div class="form-unit">€</div>
                                                                                    
                                                                                    <label>Betrag</label>
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





                                    </form>
                                </div>
                            </div>

                            <!-- <div class="row ist-lieferant-toggler">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title"> Zahlungsbedingungen</h6>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" name="mindermengenzuschlag" type="checkbox" role="switch" id="mindermengenzuschlag" />
                                                    <label class="form-check-label" for="mindermengenzuschlag">Mindermengenzuschlag</label>
                                                </div>
                                            </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title"> Versand & Versicherung</h6>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" name="automatische_bestellung" type="checkbox" role="switch" id="automatische-bestellung" />
                                                    <label class="form-check-label" for="automatische-bestellung">Automatische Bestellung</label>
                                                </div>
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body">
                                             <h6 class="card-title">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" name="automatische_artikelimport" type="checkbox" role="switch" id="automatische-artikelimport" />
                                                    <label class="form-check-label" for="automatische-artikelimport">Automatische Artikelimport</label>
                                                </div>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                        <div class="tab-pane" id="hersteller" role="tabpanel" aria-labelledby="pills-hersteller">

                            <div class="card" id="activation-card-hersteller">
                                <div class="card-body">

                                    <h4>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input card-activate-switch" type="checkbox" id="ist_hersteller_cb" name="ist_hersteller">
                                            <label class="form-check-label" for="ist_hersteller_cb">Hersteller</label>
                                        </div>
                                    </h4>

                                    <br>
                                    <form id="form-hersteller-stammdaten" class="card-body-checked">
                                        <div class="row">
                                            <div class="col ist-hersteller-toggler col-lg-3">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="hersteller_nummer" class="form-control editable" placeholder="Herstellernummer" autocomplete="off">
                                                    <label>Herstellernummer</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 ist-hersteller-toggler">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="hersteller_bezeichnung" class="form-control editable" placeholder="Hersteller Bezeichnung" autocomplete="off">
                                                    <label>Hersteller Bezeichnung</label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- <div class="row ist-hersteller-toggler">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="sub-card">
                                                <strong>Logo</strong>
                                                <br>
                                                <br>
                                                <img src="https://entwicklung.buerosystemhaus.de/assets/data/images/hersteller/develop_logo.gif" style="width: 100%;">
                                                <br>
                                                <br>
                                                <button type="button" class="btn btn-link"><i class="fa-solid fa-upload"></i> Logo hochladen</button>
                                                <button type="button" class="btn btn-link"><i class="fa-solid fa-trash"></i> Logo löschen</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="sub-card">
                                                                        
                                                <strong>Garantie</strong>
                                                <br>
                                                <br>

                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group form-floating">
                                                            <input type="text" name="monate" class="form-control editable" placeholder="Monate" value="12" autocomplete="off" >
                                                            <label>Monate</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9">
                                                        <div class="form-group form-floating">
                                                            <input type="text" name="ruecksende_adresse" class="form-control editable" placeholder="Rücksende Adresse" value="Konica Minolta Garantieabteilung, Allee 1, 36041 Fulda" autocomplete="off" >
                                                            <label>Rücksende Adresse</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <!-- ****************************************************** -->
                    <!-- Progress Bar -->
                    <!-- ****************************************************** -->
                    <div class="row">
                        <div class="col">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-label="Example with label" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title=" "></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>

    <?php include('./adressen-details-modal.php') ?>

</body>



<?php include('04_scripts.php'); ?>
<script src="./js/pagelevel/adressen-details-personen.js"></script>
<script src="./js/pagelevel/adressen-details-bankverbindung.js"></script>
<script src="./js/pagelevel/adressen-details-kunde.js"></script>
<script src="./js/pagelevel/adressen-details-lieferant.js"></script>
<script src="./js/pagelevel/adressen-details-hersteller.js"></script>
<script src="./js/pagelevel/adressen-details-oeffnungzeiten.js"></script>
<script src="./js/pagelevel/adressen.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcz5vCR6GMcbQtHfK_ImcU3yQwgmAVfa8&libraries=places&v=weekly&channel=2"></script>


<script>
    $(document).on('app:ready', function() {

        // Adressen Details
        ad_d.init();

        // ad_e.init();

        // Mehr Anzeigen  Toggler Klasse
        var temp = new mehrAnzeigen('#mehr-anzeigen', '#mehr-anzeigen-toggler', '.trigger-on-off', "ZEIG MIR WENIGER AN DU DÖDDEL");

        // Adressen Details Bankverbindungen
        ab.init();

        // Adressen Details Öffnungszeiten
        ao.init();

        // Adressen Details Personen
        ad_p.init();

        // Adressem Details Kunde
        adressenKunde.init();

        // Adressen Details Lieferant
        adressenLieferant.init();

        // Adressen Details Hersteller
        adressenHersteller.init();


    });
</script>

</html>