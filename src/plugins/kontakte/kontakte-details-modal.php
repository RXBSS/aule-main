
<!-- Modal mit dem Man einen neue Adresse zu einem Kontak hinzufügen kann -->
<div class="modal" id="modal-adressen-kontakte" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-plus"></i> Hinzufügen</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <form id="adressen-kontakte-form">


                <div class="row">
                    <div class="col-lg-10">
                        <div class="d-flex bd-highlight">
                            <div class="flex-grow-1 bd-highlight">
                                <div class="form-group form-floating">
                                    <select class="form-select editable init-quickselect" data-qs-name="adressen" name="adressen_id" placeholder="Adresse" required>
                                        <option value="">bitte wählen</option>
                                    </select>
                                    <label>Adresse</label>
                                </div>
                            </div>

                            <input type="hidden" name="id">
                            <!-- <div class="p-2 bd-highlight">Third flex item</div> -->
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <button type="button" class="btn btn-light mt-lg-4" id="btn-neue-adresse" data-bs-toggle="tooltip" data-bs-placement="top" title="Neue Adressen Anlegen"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>

                <div class="row">
                    <div class="col">

                        <div class="form-group form-floating">
                            <input type="text" name="abteilung" class="form-control editable" placeholder="Abteilung" autocomplete="nope" required>
                            <label>Abteilung</label>
                        </div>

                    </div>
                    <div class="col">

                        <div class="form-group form-floating">
                            <input type="text" name="funktion" class="form-control editable" placeholder="Funktion" autocomplete="nope" required>
                            <label>Funktion</label>
                        </div>

                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer"> </div>
        </div>
    </div>
</div>
