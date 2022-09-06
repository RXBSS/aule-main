<div class="modal" id="modal-ticket" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fas fa-plus"></i> Neues Ticket</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <form id="modal-ticket-form">

                <div class="row">
                    <div class="col">
                        <div class="form-group form-floating">
                            <input type="text" name="titel" class="form-control editable" placeholder="Titel" autocomplete="nope" required>
                            <label>Titel</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group form-floating">
                            <select class="form-select init-select2 editable" name="status_id" placeholder="Status" required>
                                <option value="">Bitte wählen</option>
                                <option value="1" selected>Neues Ticket</option>
                                <option value="2">In Bearbeitung (BS)</option>
                                <option value="3">In Bearbeitung (Kunde)</option>
                                <option value="4">Erledigt</option>

                            </select>
                            <label>Status</label>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="modal-footer"></div>
        </div>
    </div>
</div>