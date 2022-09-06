<div class="modal" id="modal-adressen" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Hinzufügen</h5>
                <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form id="modal-adressen-form">

                    <input type="hidden" name="place_id">


                    <div class="p-1 row dark-row dark-mode" id="google-search-row">
                        <div class="col-sm-12 pt-lg-2">
                            
                            Automatische
                            <custom style="color:#4285F4">G</custom>
                            <custom style="color:#DB4437">o</custom>
                            <custom style="color:#F4B400">o</custom>
                            <custom style="color:#4285F4">g</custom>
                            <custom style="color:#0F9D58">l</custom>
                            <custom style="color:#DB4437">e</custom>
                            
                            Suche 
                            
                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Bitte bei Google Ergebnissen immer der Namen prüfen!"><i class="fa-solid fa-question-circle"></i></a>
                        </div>
                        <div class="col-sm-12 pt-lg-2">
                            <div class="form-group no-margin">
                                <input type="text" id="google-search" name="google-search" class="form-control pac-target-input" placeholder="Geben Sie einen Standort ein." autocomplete="off">
                                <i class="form-group__bar"></i>

                                <!-- <input id="pac-input" class="controls" type="text" placeholder="Search Box" /> -->
                                <div id="map"></div>
                            </div>
                        </div>
                        
                    </div>

                    <div>
                        <div class="alert alert-warning duplettenpruefung"></div>
                    </div>

                    <div class="row">
                        <div class="col">
                            
                            <div class="row">
                                <div class="col">

                                    <div class="form-group form-floating">
                                        <input type="text" name="name" class="form-control editable" placeholder="Bezeichnung" required autocomplete="off">
                                        <label>Firmen/ Kundenname</label>
                                    </div>

                                </div>
                                <div class="col">
                                    <div class="form-group form-floating">
                                        <input type="text" name="namenszusatz" class="form-control editable" placeholder="Namenszusatz" autocomplete="off">
                                        <label>Namenszusatz</label>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row mt-lg-2" id="adressen_information_checkbox">
                                <div class="col">
                                    <div class="form-group form-floating-checkbox">
                                        <label class="form-label">Bei dieser Adresse handelt es sich um:</label><br>
                                        <div class="form-checkbox form-check-inline">
                                            <input class="form-check-input editable" type="checkbox" id="kundee" name="ist_kunde" value="1" required checked>
                                            <label class="form-check-label" for="kundee">Kunde</label>
                                        </div>
                                        <div class="form-checkbox form-check-inline">
                                            <input class="form-check-input editable" type="checkbox" id="lieferante" name="ist_lieferant" value="1">
                                            <label class="form-check-label" for="lieferante">Lieferant</label>
                                        </div>
                                        <div class="form-checkbox form-check-inline">
                                            <input class="form-check-input editable" type="checkbox" id="herstellere" name="ist_hersteller" value="1">
                                            <label class="form-check-label" for="herstellere">Hersteller</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group form-floating">
                                        <input type="text" name="strasse" data-format="Strasse" class="form-control editable"  autocomplete="nope" placeholder="Straße" required>
                                        <label>Straße</label>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-floating">
                                        <select class="form-select init-quickselect" id="select-laender" name="laender" data-qs-name="laender" placeholder="Länder" required>
                                            
                                        </select>
                                        <label>Länder</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-floating">
                                        <input type="text" name="plz" class="form-control editable" autocomplete="nope" placeholder="PLZ" required>
                                        <label>PLZ</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-floating">
                                        <input type="text" name="ort" class="form-control editable"autocomplete="nope"  placeholder="Ort" required>
                                        <label>Ort</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="telefon" data-format="Telefon" autocomplete="nope" class="form-control editable" placeholder="Telefon">
                                        <label>Telefon</label>
                                    </div>
                                </div>
                                <div class="col col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="text" name="telefax" data-format="Telefon" autocomplete="nope" class="form-control editable" placeholder="Telefax">
                                        <label>Telefax</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group form-floating">
                                        <input type="email" name="email" data-format="Lowercase" autocomplete="nope" class="form-control editable" placeholder="E-Mail">
                                        <label>E-Mail</label>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col">
                                        <div class="form-group form-floating-check" id="oeffnungszeiten">
                                        <label class="form-label">Informationen zu:</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input editable" id="setOeffnungszeiten" name="setOeffnungszeiten" value="1" checked/>
                                            <!-- <label class="form-check-label labelOeffnugnszeitenOff" for="setOeffnungszeiten">Öffnungszeiten</label> -->
                                            <label class="form-check-label label-info labelOeffnugnszeitenOn" id="labelOeffnugnszeitenOn"  data-bs-toggle="tooltip" data-bs-placement="right" for="setOeffnungszeiten" data-html="true">Öffnungszeiten</label>

                                        </div>
                                    </div>
                                  
                                </div>

                                <div class="col">

                                    <div class="form-group form-floating-check" id="standort">
                                        <label class="form-label">Informationen zu:</label>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input editable" id="setStandort" name="setStandort" value="1" />
                                            <label class="form-check-label label-info labelStandort" for="setStandort" data-bs-toggle="tooltip" data-bs-placement="right">Standort</label>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            

                            <div class="row mt-lg-2">
                                <div class="col">
                                    <a href="javascript:void(0);" id="mehr-anzeigen-toggler" class="">Mehr anzeigen</a>
                                </div>
                            </div>

                            <div id="mehr-anzeigen">

                                <input type="hidden" name="trigger-on-off" class="trigger-on-off">

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <input type="text" name="website" data-format="Website" autocomplete="off" class="form-control editable" placeholder="Website">
                                            <label>Website</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="steuernummer" autocomplete="off" class="form-control editable" placeholder="Steuernummer">
                                            <label>Steuernummer</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="umsatzsetuer_id" autocomplete="off" class="form-control editable" placeholder="Umsatzsetuer-ID">
                                            <label>Umsatzsetuer-ID</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row" id="google-koordinaten">
                                    <div class="col col-lg-3">
                                        <div class="form-group form-floating">
                                            <input type="text" name="fahrtzeit" autocomplete="off" class="form-control editable" placeholder="Fahrtzeit">
                                            <label>Fahrtzeit</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-3">
                                        <div class="form-group form-floating">
                                            <input type="text" name="kilometer" autocomplete="off" class="form-control editable" placeholder="Kilometer">
                                            <label>Kilometer</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-3">
                                        <div class="form-group form-floating">
                                            <input type="text" name="latitude" autocomplete="off" class="form-control editable" placeholder="Latitude">
                                            <label>Latitude</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-3">
                                        <div class="form-group form-floating">
                                            <input type="text" name="longitude" autocomplete="off" class="form-control editable" placeholder="Longitude">
                                            <label>Longitude</label>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <!-- <div class="col col-lg-6">

                            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                                <input type="checkbox" name="ist_kunde" class="btn-check" id="kundee" autocomplete="off">
                                <label class="btn btn-outline-primary" for="kundee">Kunde</label>

                                <input type="checkbox" name="ist_lieferant" class="btn-check" id="lieferante" autocomplete="off">
                                <label class="btn btn-outline-primary" for="lieferante">Lieferant</label>

                                <input type="checkbox" name="ist_hersteller" class="btn-check" id="herstellere" autocomplete="off">
                                <label class="btn btn-outline-primary" for="herstellere">Hersteller</label>
                            </div>

                            <div class="form-group form-floating">
                                <select class="form-select editable" name="auslieferungsart" placeholder="Auslieferungsart" required>
                                    <option value="standard">Standard</option>
                                    <option value="versand">Versand</option>
                                    <option value="auslieferung">Auslieferung</option>
                                    <option value="techniker">Techniker</option>
                                </select>
                                <label>Auslieferungsart</label>
                            </div>

                        </div> -->
                    </div>

                </div>


            </form>

            <div class="modal-footer"></div>
        </div>
    </div>
</div>