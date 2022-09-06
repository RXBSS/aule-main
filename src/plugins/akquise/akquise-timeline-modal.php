<!-- MODAL TIMELINE DES KUNDEN -->
<div class="modal" id="akquise-timeline-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <div class="modal-title">

                    <h5>
                        <i class="fa-solid fa-comments"></i> Akquise

                        <custom id="aktuelle-status-akquise"></custom>
                    </h5>
                    
                </div>

                <div class="actions">

                    <span class="dropdown">
                        <a class="action-item" id="aktueller-status" href="javascript:void(0);" data-bs-toggle="dropdown" title="Altueller Status"></a>
                        
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item btn-change-status" data-status="2" data-color="text-danger" data-statusres="status_2" data-statustext="Status NICHT EROLGRC" href="javascript:void(0);"><i class="fa-solid fa-thumbs-down text-danger" style="font-size:0.9em;"></i> Nicht Erfolgreich</a></li>
                            <li><a class="dropdown-item btn-change-status" data-status="1" data-color="text-success" data-statusres="status_1" data-statustext="Status EROLGRC" href="javascript:void(0);"><i class="fa-solid fa-thumbs-up text-success" style="font-size:0.9em;"></i> Erfolgreich</a></li>
                            <li><a class="dropdown-item btn-change-status" data-status="3" data-color="text-secondary" data-statusres="status_3" data-statustext="Status GELSÖCth" href="javascript:void(0);"><i class="fa-solid fa-trash text-secondary" style="font-size:0.9em;"></i> Löschen</a></li>
                            <li><a class="dropdown-item btn-change-status" data-status="0" data-color="text-info" data-statusres="status_0" data-statustext="Status Offen" href="javascript:void(0);"><i class="fa-solid fa-hourglass text-info" style="font-size:0.9em;"></i> Offen</a></li>
                        </ul>
                    </span>


                    <a href="javascript:void(0);" data-abo="abonniert" class="action-item color-red fa-solid fa-bell text-gray button-akquise-abonniert" data-bs-original-title="Abonnieren" data-bs-toggle="tooltip" data-bs-placement="bottom" value="1"></a>

                    <a href="javascript:void(0);" data-abo="deabonniert" class="action-item color-red fa-solid fa-bell-slash text-gray button-akquise-deabonniert" data-bs-original-title="Deabonnieren" data-bs-toggle="tooltip" data-bs-placement="bottom" value="0"></a>
                    
                    <!-- <a href="javascript:void(0);" class="action-item fa-solid fa-file-pdf text-gray button-akquise-create-pdf" data-bs-original-title="Erstellt eine Dokumentation des vorhandenen Verlaufs mit dem Kunden" data-bs-toggle="tooltip" data-bs-placement="bottom" value="0"></a> -->


                    <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>

            </div>

            
            <div class="modal-body">
                <form id="akquise-bearbeiten-form">

                   
                    
                    <div class="row">
                        <div class="col-lg-6">


                            <nav>
                                <div class="nav nav-tabs" id="tab-nav-something">
                                    <button class="nav-link active" id="tab-nav-eintrag" data-bs-toggle="tab" data-bs-target="#tab-content-eintrag" type="button">Eintrag</button>
                                    <button class="nav-link " id="tab-nav-kontakt" data-bs-toggle="tab" data-bs-target="#tab-content-kontakt" type="button">Kontakte</button>
                                    <button class="nav-link " id="tab-nav-meilenstein" data-bs-toggle="tab" data-bs-target="#tab-content-meilenstein" type="button"> Meilenstein</button>
                                    <button class="nav-link position-relative" id="tab-nav-offene-aqkuise" data-bs-toggle="tab" data-bs-target="#tab-content-offene-aqkuise" type="button">
                                        Akquise<span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-warning offene-akquise"> <span class="visually-hidden">unread messages</span></span>
                                    </button>
                                </div>
                            </nav>
                            <br>
                            <div class="tab-content" id="tab-content-something">
                                <div class="tab-pane show active" id="tab-content-eintrag">
                                    <!-- CONTENT 1 -->


                                    <input type="hidden" name="sessionID" value="<?php echo $_SESSION['user']['id'] ?>">


                                    <!-- Art der Kommunikation -->
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-floating-radio">
                                                <label class="form-label">Art der Kommunikation</label><br>

                                                <div class="form-radio form-check-inline padding-righ-icons">
                                                    <input class="form-check-input editable" type="radio" name="art" value="0" id="telefonat">
                                                    <label class="form-check-label label-info" for="telefonat" data-bs-title="Kunden Telefonat eingehend/ ausgehend" data-bs-toggle="tooltip" placement="bottom"><i class="fa-solid fa-phone-flip"></i></label>
                                                </div>
                                                <div class="form-radio form-check-inline padding-righ-icons">
                                                    <input class="form-check-input editable" type="radio" name="art" value="1" id="nicht-erreichbar-telefon">
                                                    <label class="form-check-label label-info" for="nicht-erreichbar-telefon" data-bs-title="Kunde Telefonisch nicht erreichbar" data-bs-toggle="tooltip" data-bs-placement="bottom"><i class="fa-solid fa-phone-slash"></i></label>
                                                </div>
                                                <div class="form-radio form-check-inline padding-righ-icons">
                                                    <input class="form-check-input editable" type="radio" name="art" value="2" id="mail">
                                                    <label class="form-check-label label-info" for="mail" data-bs-title="Kunde E-Mail empfangen/ versendet" data-bs-toggle="tooltip" data-bs-placement="bottom"><i class="fa-solid fa-envelope"></i></label>
                                                </div>
                                                <div class="form-radio form-check-inline padding-righ-icons">
                                                    <input class="form-check-input editable" type="radio" name="art" value="3" id="gespraech">
                                                    <label class="form-check-label label-info" for="gespraech" data-bs-title="Kunde persönliches Gespräch" data-bs-toggle="tooltip" data-bs-placement="bottom"><i class="fa-solid fa-people-arrows-left-right"></i></label>
                                                </div>
                                                <div class="form-radio form-check-inline padding-righ-icons">
                                                    <input class="form-check-input editable" type="radio" name="art" value="4" id="sonstiges">
                                                    <label class="form-check-label label-info" for="sonstiges" data-bs-title="Sonstiges" data-bs-toggle="tooltip" data-bs-placement="bottom"><i class="fa-solid fa-circle-info"></i></label>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <!-- SUMMERNOTE -->
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group form-summernote">
                                                <textarea name="text" data-fv-notempty="true"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div id="wiedervorlage_nicht_aenderbar"></div>

                                    <!-- Activation Checkbox WIEDERVORLAGE -->
                                    <div class="row">
                                        <div class="col">

                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <div class="form-group form-floating-check">
                                                        <label class="form-label">Wiedervorlage</label>
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input editable wiedervorlageMehrZeigen" id="wiedervorlagemehrAnzeigen" name="wiedervorlagemehrAnzeigen" value="1" />
                                                            <label class="form-check-label wiedervorlageMehrZeigen labelWiedervorlageOff" for="wiedervorlagemehrAnzeigen">Anpassen</label>

                                                            <label class="form-check-label label-info labelWiedervorlageOn" id="wiedervorlageTooltip" data-bs-title="Die Wiedervorlage kann nicht gleichzeitig mit der Zuständigkeit angepasst werden" data-bs-toggle="tooltip" data-bs-placement="top" for="wiedervorlagemehrAnzeigen">Anpassen</label>

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-6">

                                                    <div class="form-group form-floating" id="aktuelle-wiedervorlage-info">
                                                        <input type="text" name="aktuelle_wiedervorlage" class="form-control" placeholder="Bezeichnung" autocomplete="nope" readonly>
                                                        <label>Aktuelle Wiedervorlage</label>
                                                    </div>


                                                    <div class="alert alert-soft-info" id="keine-wiedervorlage">Keine Wiedervorlage vorhanden</div>
                                                </div>
                                            </div>



                                            <div id="wiedervorlage-mehr-anzeigen">

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="d-flex">

                                                            <div class="wiedervorlage-voreinstellungen">
                                                                <div class="btn-group">
                                                                    <a href="javascript:void(0)" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-calendar-check"></i>
                                                                    </a>

                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item btn-set-date" data-add-value="1" data-add-interval="days">+1 Tag</a></li>
                                                                        <li><a class="dropdown-item btn-set-date" data-add-value="3" data-add-interval="days">+3 Tage</a></li>
                                                                        <li><a class="dropdown-item btn-set-date" data-add-value="7" data-add-interval="days">+7 Tage</a></li>
                                                                        <li><a class="dropdown-item btn-set-date" data-add-value="14" data-add-interval="days">+14 Tage</a></li>
                                                                        <li><a class="dropdown-item btn-set-date" data-add-value="1" data-add-interval="months">+1 Monat</a></li>
                                                                        <li><a class="dropdown-item btn-set-date" data-add-value="6" data-add-interval="months">+6 Monate</a></li>
                                                                        <li><a class="dropdown-item btn-set-date" data-add-value="1" data-add-interval="years">+1 Jahr</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <div class="flex-grow-1">
                                                                <div class="form-group form-floating">
                                                                    <input type="date" name="wiedervorlageDatum" id="wiedervorlageDatum" class="form-control editable" placeholder="wiedervorlage" autocomplete="off">
                                                                    <label for="wiedervorlageDatum"></label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>





                                                    <div class="col-lg-6">
                                                        <div class="d-flex">

                                                            <div class="wiedervorlage-voreinstellungen">
                                                                <a href="javascript:void(0)" class="btn-set-time" data-time="09:00" aria-expanded="false" data-bs-original-title="Vormittag" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                                                    <i class="fa-solid fa-cloud-sun"></i>
                                                                </a>
                                                                <a href="javascript:void(0)" class="btn-set-time" data-time="14:00" aria-expanded="false" data-bs-original-title="Nachmittag" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                                                    <i class="fa-solid fa-cloud-moon"></i>
                                                                </a>

                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="form-group form-floating">
                                                                    <input type="time" name="wiedervorlageUhrzeit" id="wiedervorlageUhrzeit" class="form-control editable" placeholder="wiedervorlage" autocomplete="off" readonly>
                                                                    <label for="wiedervorlageUhrzeit"></label>
                                                                </div>
                                                            </div>
                                                            <div class="reset-date">
                                                                <a href="javascript:void(0);" class="tooltip-standard reset-date-button" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Wiedervorlage zurücksetzen" data-date="wiedervorlageDatum" data-time="wiedervorlageUhrzeit">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </a>
                                                            </div>
                                                            <div class="questionmark-info-date">
                                                                <a href="javascript:void(0);" class="tooltip-standard" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Wenn Sie keine Wiedervorlage auswählen wird keine eingetragen!">
                                                                    <i class="fa-solid fa-question-circle"></i>
                                                                </a>
                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>

                                                <!-- <br> -->

                                                <div id="wiedervorlage-info-text"></div>

                                            </div>

                                        </div>
                                    </div>

                                    <!-- <br> -->

                                    <!-- Activation Button Checkbox ZUSTÄNDIGKEIT -->
                                    <div class="row">
                                        <div class="col">

                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <div class="form-group form-floating-check">
                                                        <label class="form-label">Zuständigkeit</label>
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input editable" id="zustaendigkeit" name="mehrAnzeigen" value="1" />
                                                            <label class="form-check-label" for="zustaendigkeit">Anpassen</label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-6">

                                                    <div class="form-group form-floating" id="aktuelle-bearbeiter-info">
                                                        <input type="text" name="aktuelle_bearbeiter" class="form-control" placeholder="Bezeichnung" autocomplete="nope" readonly>
                                                        <label>Aktuelle Bearbeiter</label>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <!-- <br> -->

                                            <div id="div-mehr-anzeigen-zustaendigkeit">

                                                <div class="row" id="zustaendigkeit-row">
                                                    <div class="col-lg-6 offset-lg-6">

                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div class="form-group form-floating">

                                                                    <select class="form-select editable init-quickselect" data-qs-name="mitarbeiter" name="bearbeiter_id" placeholder="label">
                                                                        <option value="">bitte wählen</option>
                                                                    </select>

                                                                    <label>Zuständigkeit ändern</label>

                                                                </div>
                                                            </div>
                                                            <div class="questionmark-info">
                                                                <a href="javascript:void(0);" class="tooltip-standard" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Standardmäßig der Mitarbeiter der die Akquise angelegt hat!">
                                                                    <i class="fa-solid fa-question-circle"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="kundenterminDatum">
                                    <input type="hidden" name="kundenterminUhrzeit">

                                    <!-- **************************************************************** -->
                                    <!-- Kundentermin -->
                                    <!-- **************************************************************** -->
                                    <!-- <div class="row">
                                        <div class="col">

                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <div class="form-group form-floating-check">
                                                        <label class="form-label">Kundentermin</label>
                                                        <div class="form-check form-switch">
                                                            <input type="checkbox" class="form-check-input editable" id="kundentermin" name="mehrAnzeigenKundentermin" value="1" />
                                                            <label class="form-check-label" for="kundentermin">Kundentermin</label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-6">

                                                    <div id="aktueller-kundentermin"></div>

                                                </div>
                                            </div>
                                            

                                            <div id="div-mehr-anzeigen-kundentermin">

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group form-floating">
                                                            <input type="date" name="kundenterminDatum" class="form-control editable" placeholder="Kundentermin" autocomplete="off">
                                                            <label>Kundentermin Datum</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div class="form-group form-floating">
                                                                    <input type="time" name="kundenterminUhrzeit" class="form-control editable" placeholder="Kundentermin" autocomplete="off">
                                                                    <label>kundentermin Uhrzeit</label>
                                                                </div>
                                                            </div>
                                                            <div class="questionmark-info">
                                                                <a href="javascript:void(0);" class="tooltip-standard" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Hier kann ein Kundentermin angegeben werden">
                                                                    <i class="fa-solid fa-question-circle"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->
                                    <!-- Kundentermin -->
                                    <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ -->

                                    <!-- <br> -->

                                    
                                    
                                    <!-- Activation Button Checkbox -->
                                    <div class="row">
                                        <div class="col">

                                            <div class="form-group form-floating-check">
                                                <label class="form-label">Zeit der Eintragung</label>
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input editable" id="zeitstempel" name="mehrAnzeigenZeitstempel" value="1" />
                                                    <label class="form-check-label" for="zeitstempel">Anpassen</label>
                                                </div>
                                            </div>

                                            <!-- Benutzer Definierte Zeitstempel -->
                                            <div id="div-mehr-anzeigen-zeitstempel">

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group form-floating">
                                                            <input type="date" name="zeitstempelDatum" class="form-control editable" placeholder="Zeitstempel" autocomplete="off">
                                                            <label>Benutzer Definiertes Datum</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1">
                                                                <div class="form-group form-floating">
                                                                    <input type="time" name="zeitstempelUhrzeit" class="form-control editable" placeholder="Zeitstempel" autocomplete="off">
                                                                    <label>Benutzer Definierte Uhrzeit</label>
                                                                </div>
                                                            </div>
                                                            <div class="questionmark-info">
                                                                <a href="javascript:void(0);" class="tooltip-standard" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Standardmäßig wird die aktuelle Uhrzeit eingetragen!">
                                                                    <i class="fa-solid fa-question-circle"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col">
                                            <button type="button" class="btn btn-secondary btn-schliessen">Schließen</button>
                                            <button class="btn btn-success btn-form-save">Speichern</button>

                                        </div>
                                    </div>


                                    <br>
                                    <br>


                                </div>

                                <!-- Kontakte -->
                                <div class="tab-pane" id="tab-content-kontakt">

                                    <div class="text-end">
                                        <a href="javascript:void(0);" class="action-item button-kontakt-hinzufuegen fa-solid fa-plus text-primary hide-list"  data-bs-toggle="tooltip" data-bs-placement="top" title="Kontakte Hinzufügen"></a>
                                        <a href="javascript:void(0);" class="action-item color-red fa-solid fa-list text-primary button-list-ansicht hide-list" data-bs-original-title="List Ansicht" data-bs-toggle="tooltip" data-bs-placement="bottom" value="2"></a>
                                    </div>

                                    <br>

                                    <div class="row" id="kontakte-card">

                                    </div>

                                    <div id="kontakte-pickliste"></div>

                                </div>


                                <!-- Meilensteine -->
                                <div class="tab-pane " id="tab-content-meilenstein">

                                    <div id="meilenstein-option">

                                    </div>

                                    

                                </div>

                                <!-- Offene Akquisen -->
                                <div class="tab-pane" id="tab-content-offene-aqkuise">


                                    <!-- Meldung der Akquise -->
                                    <div id="info-status-offen"></div>

                                    <!-- Per Klick zu den Akquisen -->
                                    <div id="weitere-akquise">
                                    </div>



                                </div>



                            </div>
                        </div>
                        <div class="col-lg-6">

                            <!-- Aktueller Kunde -->
                            <div class="row mt-lg-3">
                                <div class="col">
                                    <h6 class="subtext" id="getKundenName"></h6>
                                    <input type="hidden" name="adressen_id" id="getKundenID">
                                </div>
                            </div>

                            <div id="timeline-styling">
                                <div id="akquise-timeline"></div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div id="keine-timeline-daten"></div>

                                </div>
                            </div>

                        </div>
                    </div>



                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal Akquise Nicht Erfolgreich -->
<div class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Ablehnungsgrund eintragen</h5>
                <button type="button " class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="akquise-form-nicht-erfolgreich">

                    <input type="hidden" name="status" value="2">

                    <div class="row">
                        <div class="col">
                            <p>Bitte tragen Sie hier den Grund für die Ablehnung ein. Der Grund kann später für statitische Auswertungen genutzt werden.</p>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <select class="form-select editable init-quickselect" data-qs-name="akquise_ablehnungsgrund" name="ablehnungsgrund_id" placeholder="label" required>
                                    
                                </select>
                                <label>Ablehnungsgrund</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">

                            <div class="form-group form-floating">
                                <textarea class="form-control editable" name="ablehnungsgrund_beschreibung" placeholder="Ablehnungsgrund Beschreibung" required></textarea>
                                <label>Ablehnungsgrund Beschreibung</label>
                            </div>

                        </div>
                    </div>


                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<!-- Sweet Alert Template -->
<?php include('./akquise-sweetAlert-template.php') ?>