    <!-- --------------------------- -->
    <!-- Modal für das ADD Events Artikelgruppen -->
    <!-- --------------------------- -->

    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-boxes"></i> Artikelgruppe</h5>
                    <div class="actions"></div>
                </div>
                <div class="modal-body">
                    <form id="artikel-gruppen-form" autocomplete="off">

                        <!-- Hidden ID -->
                        <input type="hidden" name="id" value="">


                        <div class="form-group form-floating">
                            <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" required>
                            <label>Bezeichnung</label>
                        </div>


                        <div class="form-group form-floating form-select2-multi-column">
                            <select class="form-select init-quickselect editable" id="selectAttribute" name="attribute" data-qs-name="artikel_attribute" placeholder="Artikel Attribute" multiple="multiple">
                                <option value="">bitte wählen</option>
                            </select>
                            <label>Artikel Attribute</label>
                        </div>

                        <div class="form-group form-floating">
                            <select class="form-select editable init-quickselect" data-qs-name="artikel_zuordnung" name="artikel_zuordnung" placeholder="Artikelzuordnung">
                                <option value="">bitte wählen</option>
                            </select>
                            <label>Artikelzuordnung</label>
                        </div>

                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- --------------------------- -->
    <!-- Modal für das ADD Events Attribute -->
    <!-- --------------------------- -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-boxes"></i> Artikelattribute</h5>
                    <div class="actions"></div>
                </div>
                <div class="modal-body">
                    <form id="artikel-gruppen-attribute-form" autocomplete="off">
                        <div class="form-group form-floating">
                            <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" required>
                            <label>Bezeichnung</label>
                        </div>
                        <div class="form-group form-floating">
                            <input type="text" name="beschreibung" class="form-control editable" placeholder="beschreibung">
                            <label>Beschreibung</label>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group form-floating">
                                    <select class="form-select editable" name="datentyp" placeholder="Datentyp">
                                        <option value="- Bitte Wähle -">- Bitte Wähle -</option>
                                        <option value="liste">liste</option>
                                        <option value="zahl">zahl</option>
                                        <option value="ja-nein">ja-nein</option>
                                        <option value="textfeld">textfeld</option>
                                    </select>
                                    <label>Datentyp</label>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group form-floating">
                                    <select class="form-select editable" name="pflichtfeld">
                                        <option value="- Bitte Wähle -">- Bitte Wähle -</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>

                                    </select>
                                    <label>Pflichtfeld</label>
                                </div>
                            </div>
                        </div>


                        <!-- TODO: Sollte type Number werden -->
                        <div class="form-group form-floating">
                            <input type="text" name="reihenfolge" class="form-control editable" placeholder="Reihenfolge">
                            <label>Reihenfolge</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- --------------------------- -->
    <!-- Modal für das ADD Events Kostenstellem -->
    <!-- --------------------------- -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-boxes"></i> Kostenstelle</h5>
                    <div class="actions"></div>
                </div>
                <div class="modal-body">
                    <form id="kostenstellen-form" autocomplete="off">
                        <div class="row">
                            <div class="col col-lg-6">
                                <div class="form-group form-floating">
                                    <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" required>
                                    <label>Bezeichnung</label>
                                </div>
                            </div>
                            <div class="col col-lg-6 mt-lg-4">
                                <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                    <input type="checkbox" class="btn-check" name="verkaeufe" id="verkauf" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="verkauf">Verkauf</label>

                                    <input type="checkbox" class="btn-check" name="einkaeufe" id="einkauf" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="einkauf">Einkauf</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- --------------------------- -->
    <!-- Modal für das ADD Events Lagerverwaltung -->
    <!-- --------------------------- -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-boxes"></i> Lagerverwaltung</h5>
                    <div class="actions"></div>
                </div>
                <div class="modal-body">
                    <form id="lagerverwaltung-form" autocomplete="off">
                        <div class="row">
                            <div class="col">
                                <div class="form-group form-floating">
                                    <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" required>
                                    <label>Bezeichnung</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group form-floating-check">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="kommission " name="kommission" />
                                        <label class="form-check-label" for="kommission">Kommission</label>
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


    <!-- --------------------------- -->
    <!-- Modal für Zahlungsbedingungen -->
    <!-- --------------------------- -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-cash-register"></i> Zahlungsbedingungen</h5>
                    <div class="actions"></div>
                </div>
                <div class="modal-body">
                    <form id="zahlungsbedingungen-form" autocomplete="off">
                        <div class="row">
                            <div class="col">
                                <div class="form-group form-floating">
                                    <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" required>
                                    <label>Bezeichnung</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group form-floating">
                                    <textarea class="form-control editable" name="text" placeholder="Beschreibung"></textarea>
                                    <label>Beschreibung</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-lg-6">
                                <div class="btn-group mt-lg-4" role="group" aria-label="Basic checkbox toggle button group">

                                    <label class="form-label" id="abbuchen-formlabel">Abbuchen:

                                        <br> Ja oder Nein

                                    </label>
                                    <div class="form-check form-switch mt-lg-3">
                                        <input class="form-check-input card-activate-switch" type="checkbox" id="abbuchung" name="abbuchung">
                                        <label class="form-check-label" for="abbuchung">Abbuchung</label>
                                    </div>

                                </div>
                                </i><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Ja, angeklickt! Nein, nicht angeklickt!"><i class="fa-solid fa-question-circle"></i></a>

                            </div>
                            <div class="col col-lg-6">
                                <div class="form-group form-floating">
                                    <input type="text" name="tage" class="form-control editable" placeholder="Tage" autocomplete="off">
                                    <label>Tage</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col col-lg-6">
                                <div class="form-group form-floating">
                                    <input type="text" name="skonto_prozent" class="form-control editable" placeholder="Skonto in Prozent" autocomplete="off">
                                    <label>Skonto in Prozent</label>
                                </div>
                            </div>
                            <div class="col col-lg-6">
                                <div class="form-group form-floating">
                                    <input type="text" name="skonto_tage" class="form-control editable" placeholder="Skonto in Tage" autocomplete="off">
                                    <label>Skonto in Tage</label>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- --------------------------- -->
    <!-- Modal für Zähler -->
    <!-- --------------------------- -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-stopwatch-20"></i> Neuer Zähler</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form id="zaehler-form">

                        <div class="row">
                            <div class="col">
                                <div class="form-group form-floating">
                                    <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" autocomplete="off">
                                    <label>Bezeichnung</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- --------------------------- -->
    <!-- Modal für Verträgegruppen -->
    <!-- --------------------------- -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-file-contract"></i> Vertragsgruppen</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form id="vertraegegruppen-form">

                        <div class="row">
                            <div class="col">
                                <div class="form-group form-floating">
                                    <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" autocomplete="off">
                                    <label>Bezeichnung</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
