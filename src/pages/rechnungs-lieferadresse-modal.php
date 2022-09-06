
<!-- ******************************************************** -->
<!-- Modal zum Editieren von Adressen -->
<!-- ******************************************************** -->
<div class="modal" id="modal-adressen" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> </h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
        
            <form id="modal-adressen-form">

                <div class="row">
                    <div class="col">
                        <div class="form-group form-floating">
                            <input type="text" name="name" class="form-control editable" placeholder="Kunde" autocomplete="nope">
                            <label>Kunde</label>
                        </div>  
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group form-floating">
                            <input type="text" name="strasse" class="form-control editable" placeholder="Straße" autocomplete="nope">
                            <label>Straße</label>
                        </div>  
                    </div>
                </div>

                <div class="row">
                    <div class="col">

                        <div class="form-group form-floating">
                            <select class="form-select editable init-quickselect" data-qs-land="_laender" name="land" placeholder="Land">
                                <option value="">bitte wählen</option>
                            </select>
                            <label>Land</label>
                        </div>
                        
                    </div>
                    <div class="col">
                        <div class="form-group form-floating">
                            <input type="text" name="plz" class="form-control editable" placeholder="PLZ" autocomplete="nope">
                            <label>PLZ</label>
                        </div>

                    </div>
                    <div class="col">

                        <div class="form-group form-floating">
                            <input type="text" name="ort" class="form-control editable" placeholder="Ort" autocomplete="nope">
                            <label>Ort</label>
                        </div>

                    </div>
                </div>

            </form>

        </div>
        <div class="modal-footer"></div>
        </div>
    </div>
</div>


