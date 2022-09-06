<!-- Bankverbindungen Modal Hier -->
<div class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-money-check-dollar"></i> Kontodaten</h5>
                <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="adressen-bankverbindungen-form">

                    <!-- <div class="row"> -->
                        <!-- <div class="form-group form-floating"> -->
                            <!-- Damit nur die Bankverbindungen anzeigt werden die zu dieser id gehören -->
                            <input type="hidden" name="id" >

                            <input type="hidden" name="adressen_id" >
                        
                        <!-- </div> -->
                    <!-- </div> -->

                    <div class="row mb-lg-2">
                        <div class="col">
                            <div class="d-flex bd-highlight">
                                <div class="flex-grow-1 bd-highlight">
                                    <div class="form-group form-floating">
                                        <input type="text" name="iban_search" data-format="Trim" id="iban_search" placeholder="Automatische Suche" class="form-control editable" autocomplete="off" value="" required>
                                        <label for="iban_search">Automatische Suche</label>
                                    </div>
                                </div>
                                <div class=" bd-highlight">

                                    <div class="spinner-border" role="status" id="bankverbindung-laedt">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <!-- <button type="button" class="btn btn-link btn-iban-auto-undo mt-lg-4"><i class="fa-solid fa-xmark"></i></button> -->

                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="row iban-gueltig"></div>

                    <div class="div input-felder-bankverbindung">
                        <div class="row">
                            <div class="col col-lg-8">
                                <div class="form-group form-floating">
                                    <input type="text" name="iban" data-format="Trim" class="form-control editable" placeholder="IBAN" autocomplete="off" required>
                                    <label>IBAN</label>
                                </div>
                            </div>
                            <div class="col col-lg-4">
                                <div class="form-group form-floating">
                                    <input type="text" name="bic" data-format="Trim" class="form-control editable" placeholder="BIC" autocomplete="off" required>
                                    <label>BIC</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-lg-6">
                                <div class="form-group form-floating">
                                    <input type="text" name="bank" class="form-control editable" placeholder="Bank" autocomplete="off" required>
                                    <label>Bank</label>
                                </div>
                            </div>
                            <div class="col col-lg-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="plz" class="form-control editable" placeholder="PLZ" autocomplete="off">
                                    <label>PLZ</label>
                                </div>
                            </div>
                            <div class="col col-lg-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="ort" class="form-control editable" placeholder="Ort" autocomplete="off">
                                    <label>Ort</label>
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

<?php include('./kontakte-modal.php') ?>

<!-- Personen Anlegen Modal
<div class="modal" id="modal-personen" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Hinzufügen</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="adressen-personen-form">

                    <div class="row">

                        <div class="col col-lg-1 icon-col">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="col col-lg-11 input-col">

                            HIDDEN
                            <input type="hidden" name="kontakte-id" id="kontakt-id">

                            <div class="row">
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="vorname" class="form-control editable" placeholder="Vorname" autocomplete="off" required>
                                        <label>Vorname</label>
                                    </div>
                                </div>
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="nachname" class="form-control editable" placeholder="Nachname" autocomplete="off" required>
                                        <label>Nachname</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mt-lg-5">
                        <div class="col col-lg-1 icon-col">
                            <i class="fa-solid fa-building"></i>

                        </div>
                        <div class="col col-lg-11 input-col">
                            <div class="row">
                                <div class="col col-lg-11">
                                    <div class="form-group form-floating">
                                        <input type="text" name="unternehmen" value="<?php echo $data['name'] ?>" disabled class="form-control editable" placeholder="unternehmen" autocomplete="off" required>
                                        <label>Unternehmen</label>
                                    </div>
                                    <input type="hidden" value="<?php echo $data['id']  ?>" name="adressen_id">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="abteilung" class="form-control editable" placeholder="Abteilung" autocomplete="off">
                                        <label>Abteilung</label>
                                    </div>
                                </div>
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="funktion" class="form-control editable" placeholder="Funktion" autocomplete="off">
                                        <label>Funktion</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-lg-5">
                        <div class="col col-lg-1 icon-col">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="col col-lg-11 input-col">
                            <div class="form-group form-floating">
                                <input type="email" name="email" data-format="Lowercase" class="form-control editable" placeholder="Email" autocomplete="off" required>
                                <label>Email</label>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-lg-5">
                        <div class="col col-lg-1 icon-col">
                            <i class="fa-solid fa-phone-alt"></i>
                        </div>
                        <div class="col col-lg-11 input-col">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="telefon" data-format="Telefon" class="form-control editable" placeholder="Telefon" autocomplete="off" required>
                                        <label>Telefon</label>
                                    </div>
                                </div>
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="mobil" data-format="Telefon" class="form-control editable" placeholder="Mobil" autocomplete="off">
                                        <label>Mobil</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-lg-2">
                        <div class="col">
                            <a href="javascript:void(0);" id="kontakte-mehr-anzeigen-toggler" class="">Mehr anzeigen</a>
                            <a href="javascript:void(0);" id="adressen-weniger-anzeigen-toggler" class="">Weniger anzeigen</a>
                        </div>
                    </div>

                    <br><br>

                    <div id="kontakte-mehr-anzeigen">
                        <div class="row">
                            <div class="col col-lg-1 icon-col">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="col col-lg-11 input-col">
                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-select2 editable" name="geschlecht" placeholder="Anrede">
                                                <option value="">bitte wählen</option>
                                                <option value="H">Herr</option>
                                                <option value="F">Frau</option>
                                                <option value="D">Divers</option>
                                            </select>
                                            <label>Anrede</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-select2 editable" name="titel" placeholder="Titel">
                                                <option value="">bitte wählen</option>
                                                <option value="Dr">Doktor</option>
                                                <option value="Dipl">Diplom</option>
                                                <option value="Meg.">Magister</option>
                                                <option value="Prof">Professor</option>
                                            </select>
                                            <label>Titel</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" name="geburtstag" placeholder="Geburtstag">
                                            <label>Geburtstag</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="telefax" class="form-control editable" placeholder="Telefax" autocomplete="off">
                                            <label>Telefax</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="col col-lg-6">
                                            <div class="form-group form-floating-check">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="account_anlegen" name="account" value="1" />
                                                    <label class="form-check-label" for="account_anlegen">Account anlegen</label>
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
            <div class="modal-footer"></div>
        </div>
    </div>
</div> -->

<!-- Oeffnungszeiten Pflegen Modal -->
<div class="modal" id="modal-oeffnungszeiten" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Hinzufügen</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="adressen-oeffnungszeiten-form">
                    <div class="form-group form-floating">

                        <div class="row">
                            <div class="col">

                                <div class="form-group form-floating">
                                    <select class="form-select editable" name="tag" placeholder="Tag" id="oeffnungszeiten-tag" required>
                                        <option value="1">Montag</option>
                                        <option value="2">Dienstag</option>
                                        <option value="3">Mittwoch</option>
                                        <option value="4">Donnerstag</option>
                                        <option value="5">Freitag</option>
                                        <option value="6">Samstag</option>
                                        <option value="7">Sonntag</option>
                                    </select>
                                    <label>Tag</label>
                                </div>
                            </div>
                            <div class="col">

                                <div class="form-group form-floating-check mt-lg-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="offen" name="offen" checked />
                                        <label class="form-check-label" for="offen">Offen</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="uhrzeiten">
                            <div class="row">
                                <div class="col">

                                    <div class="form-group form-floating">
                                        <input type="time" name="von1" class="form-control editable" placeholder="Von1" autocomplete="off" value="08:00:00" required>
                                        <label>Von1</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group form-floating">
                                        <input type="time" name="bis1" class="form-control editable" placeholder="Bis1" value="17:00:00" autocomplete="off" required>
                                        <label>Bis1</label>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">

                                    <div class="form-group form-floating">
                                        <input type="time" name="von2" class="form-control editable" placeholder="Von2" autocomplete="off">
                                        <label>Von2</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group form-floating">
                                        <input type="time" name="bis2" class="form-control editable" placeholder="Bis2" autocomplete="off">
                                        <label>Bis2</label>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-lg-3" id="zusaetzlich-tage">
                            <h6>Für andere Tage übernehmen: </h6>
                            <div class="col">
                                <div class="form-group form-floating-check">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="taguebernehmen_mo" value="1" name="mo" />
                                        <label class="form-check-label" for="taguebernehmen_mo">Mo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group form-floating-check">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="taguebernehmen_di" value="2" name="di" />
                                        <label class="form-check-label" for="taguebernehmen_di">Di</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group form-floating-check">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="taguebernehmen_mi" value="3" name="mi" />
                                        <label class="form-check-label" for="taguebernehmen_mi">Mi</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group form-floating-check">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="taguebernehmen_do" value="4" name="do" />
                                        <label class="form-check-label" for="taguebernehmen_do">Do</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group form-floating-check">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="taguebernehmen_fr" value="5" name="fr" />
                                        <label class="form-check-label" for="taguebernehmen_fr">Fr</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group form-floating-check">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="taguebernehmen_sa" value="6" name="sa" />
                                        <label class="form-check-label" for="taguebernehmen_sa">Sa</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group form-floating-check">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="taguebernehmen_so" value="7" name="so" />
                                        <label class="form-check-label" for="taguebernehmen_so">So</label>
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

<!-- Google Modal -->
<div class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fa-solid fa-clock"></i> Google Öffnungszeiten</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body">
            <form id="modal-google">

            <div class="alert alert-warning" role="alert">
                Bitte Daten vor dem Absenden überprüfen!
            </div>

                <input type="hidden" name="oeffnungszeitenGoogle" value="set">
                <div class="sub-card oeffnungszeiten-container ">

                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Öffnungszeiten</div>

                            <!-- Öffnungszeiten aus Google -->
                            <div class="oeffnungszeiten-table"></div>

                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        <div class="modal-footer"> </div>
        </div>
    </div>
</div>

<!-- Google Modal -->
<?php include("./adressen-google-modal.php") ?> 