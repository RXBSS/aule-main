<!--- Laufzeit Befristet oder Unbefristet -->
<div class="row">
    <div class="col-lg-4">
        <div class="form-group form-floating-check">
            <label class="form-label">Befristet</label>
            <div class="form-check form-switch">
                <input type="checkbox" class="form-check-input editable" id="laufzeit" name="laufzeit-trigger" />
                <label class="form-check-label" for="laufzeit">Befristet</label>
            </div>
        </div>
    </div>
    <div class="col-lg-8 laufzeit-body">
        <div class="row">
            <div class="col-lg-8">

                <div class="form-group form-floating">
                    <input type="number" name="laufzeit" class="form-control" placeholder="Laufzeit in Monaten" autocomplete="off" required>
                    <label>Laufzeit</label>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group form-floating">
                    <select class="form-select set-data-unit editable init-select2" data-selector-unit="unbefristet_laufzeit_interval" name="laufzeit_interval" placeholder="Interval" required>
                        <option value="">bitte wählen</option>
                        <option value="d">Tag/e</option>
                        <option value="M">Monat/e</option>
                        <option value="Y">Jahr/e</option>
                    </select>
                    <label>Interval</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="verlaengerung_kuendigung_ebene">

    <!-- Automatische Verlängerung -->
    <div id="automatische-verlaengerung">
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group form-floating-check">
                    <label class="form-label">Verlängerung</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input editable" id="verlaengerung" name="verlaengerung-trigger" />
                        <label class="form-check-label" for="verlaengerung">Verlängerung</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 verlaengerung-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group form-floating">
                            <input type="number" name="verlaengerung_laufzeit" class="form-control" placeholder="Laufzeit in Monaten" autocomplete="off" required>
                            <label>Laufzeit</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group form-floating">
                            <select class="form-select set-data-unit editable init-select2" data-selector-unit="verlaengerung_laufzeit_interval" name="verlaengerung_laufzeit_interval" placeholder="Interval" required>
                                <option value="">bitte wählen</option>
                                <option value="d">Tag/e</option>
                                <option value="M">Monat/e</option>
                                <option value="Y">Jahr/e</option>
                            </select>
                            <label>Interval</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kündigungsfrist -->
    <div id="kuendigung_frist">
        <div id="automatische-verlängerung">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group form-floating-check">
                        <label class="form-label">Kündigungsfrist</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input editable" id="kuendigungsfrist" name="kuendigungsfrist-trigger" />
                            <label class="form-check-label" for="kuendigungsfrist">Kündigungsfrist</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 kuendigungsfrist-body laufzeit-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group form-floating">
                                <input type="number" name="kuendigungsfrist_laufzeit" class="form-control" placeholder="Laufzeit in Monaten" autocomplete="off" required>
                                <label>Laufzeit</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group form-floating">
                                <select class="form-select set-data-unit editable init-select2" data-selector-unit="kuendigungsfrist_laufzeit_interval" name="kuendigungsfrist_laufzeit_interval" placeholder="Interval" required>
                                    <option value="">bitte wählen</option>
                                    <option value="d">Tag/e</option>
                                    <option value="M">Monat/e</option>
                                    <option value="Y">Jahr/e</option>
                                </select>
                                <label>Interval</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>