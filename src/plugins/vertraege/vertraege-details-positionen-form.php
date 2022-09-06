<div class="card" id="card-positionen-vertraege">
    <div class="card-body">

        <!-- <div id="form-position" autocomplete="off"> -->

        <form id="form-positionen-artikel">

            <input type="hidden" name="positionenID">

            <div class="row">
                <div class="col">
                    <div class="form-group form-floating">
                        <input type="text" name="bezeichnung" class="form-control " placeholder="Bezeichnung" autocomplete="nope" disabled>
                        <label>Bezeichnung</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group form-floating">
                        <input type="text" name="beschreibung" class="form-control editable" placeholder="Beschreibung" autocomplete="nope">
                        <label>Beschreibung</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col" id="pauschale-positionen">
                    <div class="form-group form-floating" >
                        <input type="text" name="pauschale" class="form-control editable" placeholder="Pauschale" autocomplete="nope">
                        <label>Pauschale</label>
                    </div>
                </div>
            </div>

            <div id="positionen-form-creator"></div>

            <!-- <div class="row">
                <div class="col">
                    <button class="btn btn-primary btn-positionen-speichern" id="btn-positionen-edit"> <i class="fas fa-save"></i>  Speichern </button>
                </div>
            </div> -->
        </form>
        <!-- </div> -->

    </div>
</div>