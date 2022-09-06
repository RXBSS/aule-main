<div class="card">
    <div class="card-body">
        <div id="form-position" class="sub-form" autocomplete="off">

            <!-- Hidden ID -->
            <input type="hidden" name="id" value="">

            <nav>
                <div class="nav nav-tabs" id="tab-nav-name">
                    <button class="nav-link active" id="tab-nav-name-1" data-bs-toggle="tab" data-bs-target="#tab-content-name-1" type="button">Preise</button>
                    <button class="nav-link" id="tab-nav-name-2" data-bs-toggle="tab" data-bs-target="#tab-content-name-2" type="button">Langtext</button>
                    <button class="nav-link" id="tab-nav-name-3" data-bs-toggle="tab" data-bs-target="#tab-content-name-3" type="button">Layout</button>
                </div>
            </nav>
            <div class="tab-content" id="tab-content-name">
                <div class="tab-pane fade show active" id="tab-content-name-1">

                    <div id="positionen-kalkulationsverbund">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="menge" data-role="menge" class="form-control editable" placeholder="Menge" required>
                                    <label>Menge</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating label-info">
                                    <input type="text" name="vk" data-role="vk" class="form-control editable" data-unit="€" placeholder="Netto">
                                    <label>VK Netto</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="steuer" data-role="steuer_satz" value="19" class="form-control editable" data-unit="%" placeholder="Steuer">
                                    <label>Steuer</label>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <span class="badge bg-secondary" data-role="richtung">EK <i class="fa-solid fa-angle-right"></i> VK</span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check form-floating-check form-switch">
                                    <label class="form-label">Rabatt</label><br>
                                    <input class="form-check-input editable color-warning" id="test-checkbox" name="rabatt_aktiv" data-role="rabatt_aktiv" type="checkbox">
                                    <label class="form-check-label" for="position-rabatt-aktiv">Aktiv</label>
                                </div>
                            </div>
                            <div class="col-md-3 rabatt-is-checked">
                                <div class="form-group form-floating label-warning">
                                    <input type="text" name="rabatt_prozent" data-role="rabatt_prozent" data-unit="%" class="form-control editable" placeholder="Prozent">
                                    <label>Prozent</label>
                                </div>
                            </div>
                            <div class="col-md-3 rabatt-is-checked">
                                <div class="form-group form-floating label-warning">
                                    <input type="text" name="rabatt_wert" data-role="rabatt_wert" data-unit="€" class="form-control editable" placeholder="rabatt_wert">
                                    <label>Wert</label>
                                </div>
                            </div>
                            <div class="col-md-3 rabatt-is-checked">
                                <div class="form-group form-floating label-warning">
                                    <input type="text" name="vk_inkl_rabatt" data-role="vk_inkl_rabatt" data-unit="€" class="form-control editable" placeholder="VK Rabatt">
                                    <label>VK (Rabatt)</label>
                                </div>
                            </div>
                        </div>


                        <div class="row rabatt-is-checked">

                            <div class="col-md-3 "></div>
                            <div class="col-md-3 ">
                                <div class="form-group form-floating label-warning">
                                    <input type="text" name="marge_prozent_inkl_rabatt" data-role="marge_prozent_inkl_rabatt" data-unit="%" class="form-control editable" placeholder="Netto">
                                    <label>Marge Rabatt %</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating label-warning">
                                    <input type="text" name="marge_wert_inkl_rabatt" data-role="marge_wert_inkl_rabatt" data-unit="€" class="form-control editable" placeholder="Netto">
                                    <label>Marge Rabatt</label>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                        </div>



                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="ek" data-role="ek" class="form-control editable" data-unit="€" placeholder="Netto">
                                    <label>EK Netto</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="marge_prozent" data-role="marge_prozent" data-unit="%" class="form-control editable" placeholder="Marge %">
                                    <label>Marge %</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="marge" data-role="marge" data-unit="€" class="form-control editable" placeholder="Marge">
                                    <label>Marge</label>
                                </div>
                            </div>

                        </div>

                        <br>

                        <strong>Gesamt</strong>
                        <div class="row rabatt-is-not-checked">
                            <div class="col-md-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="netto_gesamt" data-role="netto_gesamt" class="form-control editable" data-unit="€" placeholder="Netto" value="" disabled>
                                    <label>Netto</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="marge_gesamt" data-role="marge_gesamt" class="form-control editable" data-unit="%" placeholder="Marge" value="" disabled>
                                    <label>Marge</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="steuer_wert_gesamt" data-role="steuer_wert_gesamt" data-unit="€" class="form-control editable" placeholder="MwSt." value="" disabled>
                                    <label>MwSt.</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating">
                                    <input type="text" name="brutto_gesamt" data-role="brutto_gesamt" data-unit="€" class="form-control editable" placeholder="Brutto" value="" disabled>
                                    <label>Brutto</label>
                                </div>
                            </div>
                        </div>
                        <div class="row rabatt-is-checked">
                            <div class="col-md-3">
                                <div class="form-group form-floating label-warning">
                                    <input type="text" name="netto_inkl_rabatt_gesamt" data-role="netto_inkl_rabatt_gesamt" class="form-control editable" placeholder="Netto" value="" disabled>
                                    <label>Netto</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating label-warning">
                                    <input type="text" name="marge_inkl_rabatt_gesamt" data-role="marge_inkl_rabatt_gesamt" class="form-control editable" data-unit="%" placeholder="Marge" value="" disabled>
                                    <label>Marge</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating label-warning">
                                    <input type="text" name="steuer_wert_inkl_rabatt_gesamt" data-role="steuer_wert_inkl_rabatt_gesamt" data-unit="€" class="form-control editable" placeholder="MwSt." value="" disabled>
                                    <label>MwSt.</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-floating label-warning">
                                    <input type="text" name="brutto_inkl_rabatt_gesamt" data-role="brutto_inkl_rabatt_gesamt" data-unit="€" class="form-control editable" placeholder="Brutto" value="" disabled>
                                    <label>Brutto</label>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <div class="tab-pane fade" id="tab-content-name-2">


                     <div class="form-group form-floating-check">
                        <label class="form-label">Automatischer Langtext</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input editable" id="langtext_auto" name="langtext_auto" value="1" />
                            <label class="form-check-label" for="langtext_auto">Aktivieren</label>
                        </div>
                    </div>

                    <!-- Langtext -->
                    <div class="form-group form-floating">
                        <textarea class="form-control editable" name="langtext" placeholder="Langtext"></textarea>
                        <label>Langtext</label>
                    </div>

                    <!-- Notizen -->
                    <div class="form-group form-floating">
                        <textarea class="form-control editable" name="notiz" placeholder="Notizen"></textarea>
                        <label>Notizen (Nur Intern sichtbar)</label>
                    </div>


                </div>
                <div class="tab-pane fade" id="tab-content-name-3">

                    <div class="my-3">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pos-davor-neue-seite" name="pos_vorher_seite" value="1" />
                            <label class="form-check-label" for="pos-davor-neue-seite">Davor neue Seite</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pos-davor-nachher-seite" name="pos_nacher_seite" value="1" />
                            <label class="form-check-label" for="pos-davor-nachher-seite">Danach neue Seite</label>
                        </div>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="pos-hervorheben" name="pos_hervorheben" value="1" />
                            <label class="form-check-label" for="pos-hervorheben">Hervorheben</label>
                        </div>
                    </div>

                </div>


                <button type="button" name="i bims" class="btn btn-primary btn-positionen-speichern mt-3"><i class="fa-solid fa-save"></i> Speichern</button>


                <!-- Mehrere Artikel Warnmeldung -->
                <div class="mt-3" id="form-multi-artikel-warning">
                    <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on top" style="cursor:pointer;">
                        <i class="fa-solid fa-info-circle"></i> <em>Mehrere Artikel gewählt</em>
                    </span>
                </div>

            </div>
        </div>
    </div>
</div>