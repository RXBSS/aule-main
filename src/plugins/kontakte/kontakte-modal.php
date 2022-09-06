<div class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-user"></i> Kontakt</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times btn-schliessen"></i></button>
            </div>
            <div class="modal-body">
                <form id="modal-kontakte-form">

                    <input type="hidden" name="id">

                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group form-floating">
                                <select class="form-select init-select2 editable" name="geschlecht" placeholder="Anrede" required>
                                    <option value="">bitte wählen</option>
                                    <option value="H">Herr</option>
                                    <option value="F">Frau</option>
                                    <option value="D">Divers</option>
                                </select>
                                <label>Anrede</label>
                            </div>
                        </div>
                        <div class="col col-lg-5">
                            <div class="form-group form-floating">
                                <input type="text" name="vorname" class="form-control editable" placeholder="Vorname" autocomplete="off" required>
                                <label>Vorname</label>
                            </div>
                        </div>
                        <div class="col col-lg-5">
                            <div class="form-group form-floating">
                                <input type="text" name="nachname" class="form-control editable" placeholder="Nachname" autocomplete="off" required>
                                <label>Nachname</label>
                            </div>
                        </div>
                    </div>

                    <div id="adressen-id"></div>

                    <!-- <div class="row">
                        
                        <div class="col col-lg-11">
                            <div class="form-group form-floating">
                                <input type="text" name="unternehmen" class="form-control editable" placeholder="unternehmen" autocomplete="off" required>
                                <label>Unternehmen</label>
                            </div>

                            <input type="hidden" name="adressen_id">
                        </div>
                        <div class="col col-lg-1">
                            <a href="javascript:void(0);" id="pickliste-adressen-open">
                                <i class="fa-solid fa-search"></i>
                            </a>
                        </div>
                    </div>
                            
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="form-group form-floating">
                                <input type="text" name="abteilung" class="form-control editable" placeholder="Abteilung" autocomplete="off" >
                                <label>Abteilung</label>
                            </div>
                        </div>
                        <div class="col col-lg-6">
                            <div class="form-group form-floating">
                                <input type="text" name="funktion" class="form-control editable" placeholder="Funktion" autocomplete="off" >
                                <label>Funktion</label>
                            </div>
                        </div>
                    </div> -->

                    <div class="row">
                        
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="email" name="email" data-format="Lowercase" class="form-control editable" placeholder="Email" autocomplete="nope" required>
                                <label>Email</label>
                            </div>

                        </div>
                    </div>

                    <div id="kontakt-adresse">

                        <div class="row">
                            <div class="col">
                                <div class="form-group form-floating adressen-select">
                                    <select class="form-select editable init-quickselect" data-qs-name="adressen" name="adressen_id" placeholder="Adresse">
                                        <option value="">bitte wählen</option>
                                    </select>
                                    <label>Adresse</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">

                                <div class="form-group form-floating">
                                    <input type="text" name="abteilung" class="form-control editable" placeholder="Abteilung" autocomplete="nope">
                                    <label>Abteilung</label>
                                </div>
                            </div>
                            <div class="col">

                                <div class="form-group form-floating">
                                    <input type="text" name="funktion" class="form-control editable" placeholder="Funktion" autocomplete="nope">
                                    <label>Funktion</label>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div class="row">
                        
                        <div class="col">
                            <div class="row">
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="telefon" data-format="Telefon" class="form-control editable" placeholder="Telefon" autocomplete="nope">
                                        <label>Telefon</label>
                                    </div>
                                </div>
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="mobil" data-format="Telefon" class="form-control editable" placeholder="Mobil" autocomplete="nope" >
                                        <label>Mobil</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-lg-2">
                        <div class="col">
                            <a href="javascript:void(0);" id="kontakte-mehr-anzeigen-toggler" class="">Mehr anzeigen</a>
                            <!-- <a href="javascript:void(0);" id="adressen-weniger-anzeigen-toggler" class="">Weniger anzeigen</a> -->
                        </div>
                    </div>


                    <div id="kontakte-mehr-anzeigen">
                        <div class="row ">
                            
                            <div class="col">
                                <div class="row">
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
                                            <input type="text" name="telefax" class="form-control editable" placeholder="Telefax" autocomplete="off" >
                                            <label>Telefax</label>
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


