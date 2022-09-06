
<div class="modal" id="adressen-neu">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">

            <!-- Für Google Input -->
            <style>
                .pac-container.pac-logo.hdpi {
                    z-index: 9999;
                }

                /* Google Search andere Farbe */
                #google-search-row input {
                    color: white;
                    background-color: #495057 !important;

                }

                #google-search::placeholder {
                    color: white;
                }

                .dark-row.dark-mode {
                    background-color: #495057;
                    color: white;
                    margin-right: 0px;
                    margin-left: 0px;
                }

            </style>

            <h5 class="modal-title"><i class="fas fa-plus"></i> Neue Adresse</h5>
            <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            
            <form id="modal-adressen-neu">


                <input type="hidden" name="place_id">

                <div class="row dark-row dark-mode" id="google-search-row">
                    <div class="col" style="padding-top: 7px;">

                        <div class="d-flex mt-lg-2 mb-lg-1">

                            <div  class="flex-grow-1">
                                <div class="form-group no-margin">
                                    <input type="text" id="google-search" name="google-search" class="form-control pac-target-input" placeholder="Geben Sie einen Standort ein." autocomplete="off">
                                    <i class="form-group__bar"></i>

                                    <!-- <input id="pac-input" class="controls" type="text" placeholder="Search Box" /> -->
                                    <div id="map"></div>
                                </div>
                            </div>

                            <div>
                                <i class="fab fa-google"></i> <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Bitte bei Google Ergebnissen immer der Namen prüfen!"><i class="fa-solid fa-question-circle"></i></a>
                            </div>
                        </div>

                        
                    </div>
                    <!-- <div class="col-sm-10">
                        
                        <i class="fab fa-google"></i> <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Bitte bei Google Ergebnissen immer der Namen prüfen!"><i class="fa-solid fa-question-circle"></i></a>

                    </div> -->
                        
                </div>

                <br>

                <div>
                    <div class="alert alert-warning duplettenpruefung"></div>
                </div>




                <div class="resetForm">

                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="name" class="form-control editable" placeholder="Firmen/ Kundename" autocomplete="nope" required>
                                <label>Firmen/ Kundename</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="strasse" class="form-control editable" placeholder="Straße" autocomplete="nope" required>
                                <label>Straße</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <select class="form-select editable init-quickselect" data-qs-name="laender" name="land" placeholder="Länder" required>
                                </select>
                                <label>Länder</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="plz" class="form-control editable" placeholder="PLZ" autocomplete="nope" required>
                                <label>PLZ</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="ort" class="form-control editable" placeholder="Ort" autocomplete="nope" required>
                                <label>Ort</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="telefon" class="form-control editable" placeholder="Telefo" autocomplete="nope">
                                <label>Telefon</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="email" class="form-control editable" placeholder="E-Mail" autocomplete="nope">
                                <label>E-Mail</label>
                            </div>
                        </div>
                    </div>

                </div>


            </form>
    
        </div>
        <div class="modal-footer"></div>
        </div>
    </div>
</div>