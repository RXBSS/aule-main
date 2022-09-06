<div id="adressen-details">
    <div class="actions">
        <a class="action-item" id="adressen-details-erstellen" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse hinzufügen"><i class="fa-solid fa-plus"></i></a>
        <a class="action-item" id="adressen-details-bearbeiten" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Bearbeiten"><i class="fa-solid fa-edit"></i></a>
        <a class="action-item" id="adressen-details-suchen" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Suchen"><i class="fa-solid fa-search"></i></a>
    </div>

    <!-- Navigation -->
    <nav>
        <div class="nav nav-tabs" id="tab-adressen-details">
            <button class="nav-link active" id="tab-btn-adresse-1" data-bs-toggle="tab" data-bs-target="#tab-content-adresse-1" type="button"><i class="fa-solid fa-users"></i> Rechnungsadresse</button>
            <button class="nav-link" id="tab-btn-adresse-2" data-bs-toggle="tab" data-bs-target="#tab-content-adresse-2" type="button"><i class="fa-solid fa-truck-loading"></i> Lieferadresse</button>
        </div>
    </nav>

    <!-- Rechnungsemfpänger gesperrt -->
    <div id="adressen-details-rechnungsempfaenger-gesperrt" class="alert alert-danger my-2" style="display:none;">
        <i class="fa-solid fa-exclamation-triangle"></i> <strong>Der Kunde ist gesperrt!</strong> <span class="detail-text"></span>
    </div>


    <!-- Inhalte des Tabs -->
    <div class="tab-content" id="tab-content-adresse">

        <!-- Rechnungadresse -->
        <div class="tab-pane show active" id="tab-content-adresse-1" data-type="re">

            <!-- Seperate Lieferadresse -->
            <div class="mt-3" id="adressen-details-seperate-lieferadresse"><em>Es wurde eine separate Lieferadresse gewählt!</em></div>

            <div class="form-group form-floating">
                <select class="form-select init-quickselect editable" name="re_name" data-qs-name="adressen" placeholder="Kunde" required>
                    <option value="">bitte wählen</option>
                </select>
                <label>Kunde</label>
            </div>

            <div class="form-group form-floating">
                <input type="text" name="re_strasse" class="form-control" placeholder="Straße" readonly>
                <label>Straße</label>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <div class="form-group form-floating">
                        <input type="text" name="re_land" class="form-control" placeholder="Land" readonly>
                        <label>Land</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group form-floating">
                        <input type="text" name="re_plz" class="form-control" placeholder="PLZ" readonly>
                        <label>PLZ</label>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group form-floating">
                        <input type="text" name="re_ort" class="form-control" placeholder="Ort" readonly>
                        <label>Ort</label>
                    </div>
                </div>

            </div>
        </div>


        <!-- Lieferadressen -->
        <div class="tab-pane" id="tab-content-adresse-2" data-type="lf">

            <!-- Separate Lieferadresse -->
            <div class="form-group form-floating-check">
                <label class="form-label">Lieferadresse</label>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input editable" id="adressen-details-lieferadresse" name="lf_gleich_re" value="1" checked />
                    <label class="form-check-label" for="adressen-details-lieferadresse">Identisch mit Rechnungsadresse</label>
                </div>
            </div>

            <!-- Lieferadresse -->
            <div class="form-group form-floating">
                <select class="form-select init-quickselect" name="lf_name" data-qs-name="adressen" placeholder="Adresse" required>
                    <option value="">bitte wählen</option>
                </select>
                <label>Kunde</label>
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
</div>