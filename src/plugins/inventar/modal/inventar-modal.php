<!-- Modal -->
<div class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Hinzufügen</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
        </div>
        <div class="modal-body">

            <form id="modal-inventar">

                <!-- Hidden ID -->
                <input type="hidden" name="id" value="">

                <div class="row">
                    <div class="col">
                        <div class="form-group form-floating">
                            <input type="text" name="kaufobjekt" class="form-control editable" placeholder="Kaufobjekt" autocomplete="off" required>
                            <label>Kaufobjekt</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">

                        <div class="form-group form-floating">
                            <select class="form-select init-quickselect" id="select-kaufperson" name="kaufperson_id" data-qs-name="mitarbeiter" placeholder="Kaufperson" required>
                                
                            </select>
                            <label>Kaufperson</label>
                        </div>

                    </div>
                    <div class="col-lg-6">

                        <div class="form-group form-floating">
                            <input type="text" name="seriennummer" data-format="Uppercase" class="form-control editable more-readable" placeholder="Seriennummer" autocomplete="off" >
                            <label>Seriennummer</label>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6">
                        

                    </div> -->
                </div>


                <div class="row">
                    <div class="col-lg-6">

                        <div class="form-group form-floating">
                            <input type="date" name="kaufdatum" class="form-control editable" placeholder="Kaufdatum" autocomplete="off" required>
                            <label>Kaufdatum</label>
                        </div>

                    </div>
                    <div class="col-lg-6">

                        <div class="form-group form-floating">
                            <input type="text" name="kaufpreis" class="form-control editable" placeholder="Netto Kaufpreis" autocomplete="off" required>
                            <div class="form-unit">€</div>
                            <label>Netto Kaufpreis</label>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col">

                        <div class="form-group form-floating">
                            <textarea class="form-control editable" name="beschreibung" placeholder="Floating Textarea"></textarea>
                            <label>Beschreibung</label>
                        </div>

                    </div>
                </div>


                <div >

                    <div class="row">
                        <div class="col">
                                <div class="form-group form-floating-check">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="abschreibung" value="1" disabled />
                                    <label class="form-check-label" for="id">Abschreibung</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="abschreibung">
                        <div class="col-lg-6">

                            <div class="form-group form-floating">
                                <input type="text" name="abschreibezeitraum" class="form-control editable" placeholder="Zeitraum (in Jahren)" autocomplete="off" required>
                                <label>Zeitraum (in Jahren)</label>
                            </div>

                        </div>
                        <div class="col-lg-6">

                            <div class="form-group form-floating">
                                <input type="text" name="enddatum" class="form-control editable" placeholder="Enddatum" disabled autocomplete="off" >
                                <label>Enddatum</disabled label>
                            </div>

                        </div>
                    </div>



                </div>

            </form>


        </div>
        <div class="modal-footer"> </div>
        </div>
    </div>
</div>
