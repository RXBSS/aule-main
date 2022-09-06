<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <form id="form-artikel-lager">

                    <h4 class="card-title"><i class="fa-solid fa-layer-group"></i> Bestandsführung / Lager</h4>

                    <!-- Artikel ID -->
                    <input type="hidden" name="id" value="100000">

                    <div class="row">
                        <div class="col-md-6">

                            <!-- Bestandsführung -->
                            <div class="form-group form-check form-floating-check form-switch">
                                <label class="form-label">Bestandsführung aktivieren</label><br>
                                <input class="form-check-input editable" name="bestandsfuehrung" type="checkbox" id="bestandsfuehrung">
                                <label class="form-check-label" for="bestandsfuehrung">Aktivieren</label>
                            </div>

                        </div>
                        <div class="col-md-6 bestandsfuehrung">
                            <div class="form-group form-check form-floating-check form-switch">
                                <label class="form-label">Ident Artikel</label><br>
                                <input class="form-check-input editable" name="ident" type="checkbox" id="identartikel">
                                <label class="form-check-label" for="identartikel">Aktivieren</label>
                            </div>
                        </div>
                    </div>




                    <!-- Automatisches Nachbestellen -->
                    <div class="row bestandsfuehrung">
                        <div class="col-md-6">
                            <div class="form-group form-check form-floating-check form-switch">
                                <label class="form-label">Automatisches Nachbestellen</label><br>
                                <input class="form-check-input editable" name="auto_bestand_aktiv" type="checkbox" id="automatische-bestellung">
                                <label class="form-check-label" for="automatische-bestellung">Aktivieren</label>
                            </div>
                        </div>

                        <div class="col-md-3 auto-order-additional">
                            <div class="form-group form-floating">
                                <input type="number" name="auto_bestand_min" class="form-control editable " min="1" placeholder="Mininmal" required>
                                <label>Limit</label>
                            </div>
                        </div>
                        <div class="col-md-3 auto-order-additional">
                            <div class="form-group form-floating">
                                <input type="number" name="auto_bestand_max" class="form-control editable " min="1" placeholder="Mininmal" required>
                                <label>Auffüllen auf</label>
                            </div>
                        </div>
                    </div>

                    <!-- Bestände anzeigen -->
                    <div class="bestandsfuehrung mt-3">
                        <canvas id="lager-chart" style="min-height: 130px;"></canvas>
                    </div>


                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">

                <div class="actions">
                    <a class="action-item btn-artikel-preise-kundenindividual" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="left" title="Kunden-Individualpreise"><i class="fa-solid fa-users"></i></a>
                </div>

                <h4 class="card-title"><i class="fa-regular fa-money-bill-alt"></i> Preise</h4>



                <form id="form-artikel-preis">

                    <!-- Artikel ID -->
                    <input type="hidden" name="id" value="100000">

                    <!--  -->
                    <div class="row">
                        <div class="col-md-6">

                            <!-- Feste Preise -->
                            <div class="form-group form-check form-floating-check form-switch">
                                <label class="form-label">Feste Preise</label><br>
                                <input class="form-check-input editable" name="feste_preise" type="checkbox" id="feste_preise">
                                <label class="form-check-label" for="feste_preise">Aktivieren</label>
                            </div>

                        </div>
                        <div class="col-md-3 feste-preise-aktiv">

                            <!-- EK -->
                            <div class="form-group form-floating">
                                <input type="text" name="ek" data-unit="€" data-format="Waehrung" class="form-control editable" placeholder="Einkaufspreis">
                                <label>Einkaufspreis</label>
                            </div>

                        </div>
                        <div class="col-md-3 feste-preise-aktiv">

                            <!-- VK -->
                            <div class="form-group form-floating">
                                <input type="text" name="vk" data-unit="€" data-format="Waehrung" class="form-control editable" placeholder="Verkaufspreis">
                                <label>Verkaufspreis</label>
                            </div>

                        </div>
                    </div>


                    <!-- Weitere Preise -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-floating">
                                <input type="text" name="uhg" data-unit="€" data-format="Waehrung" class="form-control editable" placeholder="Bezeichnung">
                                <label>UHG</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-floating">
                                <input type="text" name="kalkulation" data-unit="€" data-format="Waehrung" class="form-control" placeholder="Kalkulation" disabled>
                                <label>Kalkulation</label>
                            </div>
                        </div>
                    </div>

                    <!-- Canvas -->
                    <canvas class="mt-3" id="preis-chart" style="min-height: 200px;"></canvas>

                </form>
            </div>
        </div>
    </div>
</div>