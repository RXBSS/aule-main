<div class="card">
    <div class="card-body">
        <h4 class="card-title"><i class="fa-solid fa-lightbulb"></i> ID-Artikel</h4>

        <form id="artikel-ident">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-floating-radio">
                        <label class="form-label">Installation</label><br>
                        <div class="form-radio form-check-inline">
                            <input class="form-check-input editable" type="radio" id="installation-1" name="ident_typ_id" value="1">
                            <label class="form-check-label label-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kann alleine Betrieben werden, aber verknüpft werden." for="installation-1">Stand Alone</label>
                        </div>
                        <div class="form-radio form-check-inline">
                            <input class="form-check-input editable" type="radio" id="installation-2" name="ident_typ_id" value="2">
                            <label class="form-check-label label-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kann nur verknüpft werden." for="installation-2">Option</a></label>
                        </div>
                        <div class="form-radio form-check-inline">
                            <input class="form-check-input editable" type="radio" id="installation-3" name="ident_typ_id" value="3">
                            <label class="form-check-label" for="installation-3">Beides</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ident-typ-id-elements" data-values="2,3">
                        <div class="form-group form-floating-check">
                            <label class="form-label">Irreversibilität</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input editable" id="ident_irreversibel" name="ident_irreversibel" value="1" />
                                <label class="form-check-label label-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Wenn der Punkt aktiviert ist, kann eine Option nach der zusammenführen mit einer ID nicht mehr getrennt werden" for="ident_irreversibel">Aktivieren</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-md-6">

                    <!-- Zähler Karte -->
                    <div class="card" id="zaehler-card">
                        <div class="card-body">
                            <div class="actions card-body-checked">
                                <a class="action-item action-delete-zaehler" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Zähler löschen"><i class="fa-solid fa-trash"></i></a>
                                <a class="action-item action-add-zaehler" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Zähler hinzufügen"><i class="fa-solid fa-plus"></i></a>
                            </div>
                            <div class="form-group form-hide-success-icon mb-0">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input card-activate-switch editable" id="zaehler-cb" name="zaehler" value="1" />
                                    <label class="form-check-label" for="zaehler-cb">Zähler aktivieren</label>
                                </div>
                            </div>
                            <div class="card-body-checked">
                                <div id="pickliste-zaehler"></div>
                                <div class="mt-4 mb-2 action-add-zaehler-large">
                                    <a class="action-add-zaehler " href="javascript:void(0);"><i class="fa-solid fa-plus"></i> Neuen Zähler hinzufügen</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Garantie Karte -->
                    <div class="card" id="garantie-card">
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input card-activate-switch editable" id="garantie-cb" name="garantie" value="1" />
                                <label class="form-check-label" for="garantie-cb">Garantie aktivieren</label>
                            </div>
                            <div class="card-body-checked">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-floating">
                                            <input type="text" name="basisgarantie_laenge" class="form-control editable" data-unit="Monate" placeholder="Basisgarantie Länge" autocomplete="off">
                                            <label>Basis Länge</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" name="basisgarantie_art" data-qs-name="garantie" placeholder="Garantie Art">
                                                <option value="">Standard Garantie</option>
                                            </select>
                                            <label>Basis Art</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-floating">
                                            <input type="text" name="basisgarantie_laenge" class="form-control editable" data-unit="Monate" placeholder="Basisgarantie Länge" autocomplete="off">
                                            <label>Erweiter Länge</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" name="basisgarantie_art" data-qs-name="garantie" placeholder="Garantie Art">
                                                <option value="">Standard Garantie</option>
                                            </select>
                                            <label>Erweiter Art</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <!-- Software Karte -->
                    <div class="card" id="software-firmware-card">
                        <div class="card-body">
                            <div class="actions card-body-checked">
                                <a class="action-item" href="software" target="_blank" data-bs-toggle="tooltip" data-bs-placement="left" title="Software / Versionen verwalten"><i class="fa-solid fa-code-branch"></i></a>
                            </div>

                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input card-activate-switch editable" id="software-cb" name="software" value="1" />
                                <label class="form-check-label" for="software-cb">Software / Firmware aktivieren</label>
                            </div>
                            <div class="card-body-checked">
                                <div class="form-group form-floating">
                                    <div class="form-group form-floating">
                                        <select class="form-select init-quickselect editable" name="software_name" data-qs-name="software" placeholder="label">
                                            <option value="">Bitte wählen</option>
                                        </select>
                                        <label>Version wählen</label>
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