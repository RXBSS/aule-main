<!-- Modal dafür das man einen neuen Kunden zu der Akquise hinzufügen kann -->
<div class="modal"  tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fa-solid fa-add"></i> Kunde hinzufügen</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body">
        
            <form id="modal-akquise-kunde-hinzufuegen">

                <div class="row">
                    <div class="col">
                        <div class="form-group form-floating">
                            <select class="form-select init-select2 editable init-quickselect" data-qs-name="mitarbeiter" name="bearbeiter_id" placeholder="label" required>
                            </select>
                            <label>Bearbeiter</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group form-floating">
                            <select class="form-select init-select2 editable init-quickselect" data-qs-name="akquise_aktionen" name="aktion_id" placeholder="label">
                            </select>
                            <label>Aktion</label>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-10">
                        <div class="form-group form-floating">
                            <select class="form-select editable" id="adressen" name="adressen_id" placeholder="label" required>
                                <option value="">bitte wählen</option>
                            </select>
                            <label>Adresse</label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <!-- <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Neue Adressen Anlegen"><i class="fa-solid fa-plus fa-2x mt-lg-3 mr-lg-1"></i></a> -->

                        <button type="button" class="btn btn-light mt-lg-4" id="btn-neue-adresse" data-bs-toggle="tooltip" data-bs-placement="top" title="Neue Adressen Anlegen"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="hidden" name="ersteller_id">
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                         <div class="form-group form-floating-check">
                            <label class="form-label">Kontakte Filter: </label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input editable" id="nur_kunden" name="nur_kunden"  checked/>
                                <label class="form-check-label" for="nur_kunden">Nur Kontakte aus dem Kunden anzeigen:</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-10">
                        <div class="form-group form-floating form-select2-multi-column">
                            <select class="form-select editable" data-qs-close-on-select="false" multiple name="kontakt" placeholder="Kontakt" id="kontakte">
                                <option value="">bitte wählen</option>
                            </select>
                            <label>Kontakt</label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <!-- <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Neue Adressen Anlegen"><i class="fa-solid fa-plus fa-2x mt-lg-3 mr-lg-1"></i></a> -->

                        <button type="button" class="btn btn-light mt-lg-4" id="btn-neue-kontakte" data-bs-toggle="tooltip" data-bs-placement="top" title="Neuen Kontakt Anlegen"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                    
                    

            </form>
        

        </div>
        <div class="modal-footer"></div>
        </div>
    </div>
</div>
