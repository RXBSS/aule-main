<div class="modal" id="kontakte-neu" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-user"></i> Kontakt</h5>
                <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times btn-schliessen"></i></button>
            </div>
            <div class="modal-body py-0">
                <form id="kontakte-neu-modal-form">

                    <input type="hidden" name="adressen_id">

                    <div class="row">
                        <div class="col">

                             <div class="form-group form-floating-radio">
                                <label class="form-label">Geschlecht</label><br>
                                <div class="form-radio form-check-inline">
                                    <input class="form-check-input editable" type="radio" id="geschlecht-1" name="geschlecht" value="D">
                                    <label class="form-check-label" for="geschlecht-1">Divers</label>
                                </div>
                                <div class="form-radio form-check-inline">
                                    <input class="form-check-input editable" type="radio" id="geschlecht-2" name="geschlecht" value="M">
                                    <label class="form-check-label" for="geschlecht-2">Herr</label>
                                </div>
                                <div class="form-radio form-check-inline">
                                    <input class="form-check-input editable" type="radio" id="geschlecht-3" name="geschlecht" value="F">
                                    <label class="form-check-label" for="geschlecht-3">Frau</label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-floating">
                                <select class="form-select init-select2 editable" name="titel" placeholder="Titel">
                                    <option value="">ohne</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Prof.">Prof.</option>
                                </select>
                                <label>Titel</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="vorname" class="form-control editable" placeholder="Vorname" autocomplete="off">
                                <label>Vorname</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="nachname" class="form-control editable" placeholder="Nachname" autocomplete="off" required>
                                <label>Nachname</label>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="email" name="email" class="form-control editable" data-format="Lowercase" data-unit="<i class='fa-solid fa-envelope'></i>" data-unitaction="mail" placeholder="Email" autocomplete="nope">
                                <label>Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="telefon" class="form-control editable" data-format="Telefon" data-unit="<i class='fa-solid fa-phone'></i>" data-unitaction="call" placeholder="Telefon" autocomplete="nope">
                                <label>Telefon (Direkt)</label>
                            </div>
                        </div>
                        <div class="col">

                            <div class="form-group form-floating">
                                <input type="text" name="mobile" class="form-control editable" data-format="Telefon" data-unit="<i class='fa-solid fa-mobile'></i>" data-unitaction="call" placeholder="Telefon" autocomplete="nope">
                                <label>Mobiltelefon</label>
                            </div>

                        </div>
                    </div>

                    <br>
                    <!-- <div class="alert alert-soft-warning duplettenpruefung">
                        Dublettenprüfung
                    </div> -->
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>