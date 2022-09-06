<div class="modal" id="modal-verlei" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-plus"></i> Kaufobjekt Verleih</h5>
            <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
        
            <form id="inventar-verleih-form">

                <div class="row">
                    <div class="col">
                        <div class="warning-nicht-verfügbar"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group form-floating">
                            <input type="text" name="kaufobjekt" class="form-control " placeholder="Bezeichnung" autocomplete="nope" readonly>
                            <label>Kaufobjekt</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group form-floating">
                            <select class="form-select init-quickselect" id="select-nutzer" name="nutzer_id" data-qs-name="mitarbeiter" placeholder="Nutzer" required>
                                
                            </select>
                            <label>Nutzer</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group form-floating">
                            <input type="date" name="nutzungsdauer" class="form-control editable" placeholder="Nutzungsdauer" autocomplete="nope">
                            <label>Nutzungsdauer bis</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">

                        <div class="form-group form-floating">
                            <input type="text" name="nutzungsstandort" class="form-control editable" placeholder="Nutzungsstandort" autocomplete="nope">
                            <label>Nutzungsstandort</label>
                        </div>

                    </div>
                    <div class="col">

                        <div class="form-group form-floating">
                            <textarea class="form-control editable" name="nutzungsgrund" placeholder="Nutzungsgrund"></textarea>
                            <label>Nutzungsgrund</label>
                        </div>

                    </div>
                </div>

            </form>
        
        </div>
        <div class="modal-footer"> 


            <button type="button" id="verleih-beenden" class="btn btn-info">Verleih beenden</button>

        </div>
        </div>
    </div>
</div>