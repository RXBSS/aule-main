<div class="card" id="card-address">
    <div class="card-body">

        <div class="actions">
            <!-- <a class="action-item" id="adressen-details-suchen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Suchen"><i class="fa-solid fa-search"></i></a>
            <a class="action-item" id="adressen-details-erstellen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Neu Erstellen"><i class="fa-solid fa-plus"></i></a>
            <a class="action-item" id="adressen-details-bearbeiten" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Editieren"><i class="fa-solid fa-edit"></i></a> -->
            <!-- <a class="action-item" id="adressen-details-schliessen" data-status="2" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Nicht Speichern"><i class="fa-solid fa-close"></i></a> -->
            <!-- <a class="action-item" id="adressen-details-speichern" data-status="2" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Speichern"><i class="fa-solid fa-save"></i></a> -->
        </div>

        <nav>
            <div class="nav nav-tabs" id="tab-name">
                <button class="nav-link active btn-adresse" id="tab-btn-adresse-1" data-adresse="re" data-bs-toggle="tab" data-bs-target="#tab-content-adresse-1" type="button"><i class="fa-solid fa-users"></i> Rechnungsadresse</button>
                <button class="nav-link btn-adresse" id="tab-btn-adresse-2" data-adresse="lf" data-bs-toggle="tab" data-bs-target="#tab-content-adresse-2" type="button"><i class="fa-solid fa-truck-loading"></i> Lieferadresse</button>
            </div>
        </nav>

        <div id="rechnungsempfaenger-ist-gesperrt" class="alert alert-danger my-2" style="display:none;">
            <i class="fa-solid fa-exclamation-triangle"></i> <strong>Der Kunde ist gesperrt!</strong> <span class="detail-text"></span>
        </div>

        <div class="tab-content" id="tab-content-adresse">
            <div class="tab-pane show active" id="tab-content-adresse-1" data-type="rechnungsanschrift">

                <!-- Info - Separate Lieferadresse -->
                <div class="mt-3 mb-0 py-2 adressen-details-seperate-lieferadresse alert alert-soft-info"><em>Es wurde eine separate Lieferadresse gewählt!</em></div>

                <!-- Info - Konto gesperrt! -->
                <div class="mt-3 mb-0 py-2 adressen-details-kontosperre-warning alert alert-soft-danger">Der Kunde ist gesperrt</div>

                <!-- Rechnungadresse -->
                <div class="qs-buttons d-flex justify-content-between">

                    <div class="form-group form-floating form-select2-multi-column flex-grow-1">
                        <select class="form-select init-quickselect editable" name="rechnungsanschrift_id" data-qs-name="adressen" placeholder="Kunde">
                            <option value="">bitte wählen</option>
                        </select>
                        <label>Kunde</label>
                    </div>

                    <div class="btn-group align-self-start pt-4 ps-2">
                        <button type="button" class="btn btn-primary" data-action="search"><i class="fa-solid fa-search"></i></button>
                        <button type="button" class="btn btn-primary" data-action="edit" data-validate="single"><i class="fa-solid fa-edit"></i></button>
                        <button type="button" class="btn btn-primary" data-action="add"><i class="fa-solid fa-add"></i></button>
                    </div>
                </div>


                <div class="form-group form-floating">
                    <input type="text" name="rechnungsanschrift_strasse" class="form-control" placeholder="Straße" readonly>
                    <label>Straße</label>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-floating">
                            <input type="text" name="rechnungsanschrift_land" class="form-control" placeholder="Land" readonly>
                            <label>Land</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-floating">
                            <input type="text" name="rechnungsanschrift_plz" class="form-control" placeholder="PLZ" readonly>
                            <label>PLZ</label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group form-floating">
                            <input type="text" name="rechnungsanschrift_ort" class="form-control" placeholder="Ort" readonly>
                            <label>Ort</label>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="tab-content-adresse-2" data-type="lieferanschrift">


                <!-- Separate Lieferadresse -->
                <div class="form-group form-floating-check">
                    <label class="form-label">Lieferadresse</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input editable" name="lf_gleich_re" value="1" checked />
                        <label class="form-check-label" for="adresse-lieferadresse">Identisch mit Rechnungsadresse</label>
                    </div>
                </div>

                 <!-- Lieferadresse -->
                <div class="qs-buttons d-flex justify-content-between">

                    <div class="form-group form-floating form-select2-multi-column flex-grow-1">
                        <select class="form-select init-quickselect" name="lieferanschrift_id" data-qs-name="adressen" placeholder="Adresse" required>
                            <option value="">bitte wählen</option>
                        </select>
                        <label>Kunde</label>
                    </div>

                    <div class="btn-group align-self-start ps-2 pt-4">
                        <button type="button" class="btn btn-primary" data-action="search"><i class="fa-solid fa-search"></i></button>
                        <button type="button" class="btn btn-primary" data-action="edit" data-validate="single"><i class="fa-solid fa-edit"></i></button>
                        <button type="button" class="btn btn-primary" data-action="add"><i class="fa-solid fa-add"></i></button>
                    </div>
                </div>             

                <div class="form-group form-floating">
                    <input type="text" name="lieferanschrift_strasse" class="form-control" placeholder="Straße" readonly>
                    <label>Straße</label>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group form-floating">
                            <input type="text" name="lieferanschrift_land" class="form-control" placeholder="Land" readonly>
                            <label>Land</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-floating">
                            <input type="text" name="lieferanschrift_plz" class="form-control" placeholder="PLZ" readonly>
                            <label>PLZ</label>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group form-floating">
                            <input type="text" name="lieferanschrift_ort" class="form-control" placeholder="Ort" readonly>
                            <label>Ort</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>