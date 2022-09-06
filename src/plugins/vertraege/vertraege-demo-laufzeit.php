<?php include('01_init.php');

$_page = [
    'title' => "Laufzeit"
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-clock"></i> Laufzeit</h4>



                            <!-- Vertragsbeginn -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group form-floating">
                                        <input type="date" name="vertragsbeginn" class="form-control editable" placeholder="Vertragsbeginn" value="2022-08-01" autocomplete="off" required>
                                        <label>Vertragsbeginn</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 laufzeit-body" id="vertragsende-input">
                                    <div class="form-group form-floating">
                                        <input type="date" name="vertragsende" class="form-control" value="2027-07-31" placeholder="Vertragsende" disabled>
                                        <label>Vertragsende</label>
                                    </div>
                                </div>
                            </div>


                            <!-- Laufzeit Befristet oder Unbefristet -->
                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="form-group form-floating-check">
                                        <label class="form-label">Befristet</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input editable" id="laufzeit" name="laufzeit-trigger" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group form-floating">
                                        <input type="number" name="laufzeit" class="form-control editable" placeholder="Laufzeit in Monaten" value="60" autocomplete="off">
                                        <label>Laufzeit</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group form-floating">
                                        <select class="form-select editable" name="laufzeit_interval" placeholder="Interval">
                                            <option value="d">Tag/e</option>
                                            <option value="M" selected>Monat/e</option>
                                            <option value="Y">Jahr/e</option>
                                        </select>
                                        <label>Interval</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">

                                </div>
                            </div>

                            <!-- Automatische Verlängerung -->
                            <div class="row" id="automatische-verlaengerung">
                                <div class="col-lg-3">
                                    <div class="form-group form-floating-check">
                                        <label class="form-label">Verlängerung</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input editable" id="verlaengerung" name="laufzeit-trigger" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group form-floating">
                                        <input type="number" name="laufzeit" class="form-control editable" value="12" placeholder="Laufzeit in Monaten" autocomplete="off">
                                        <label>Laufzeit</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group form-floating">
                                        <select class="form-select editable" name="laufzeit_interval" placeholder="Interval">
                                            <option value="d">Tag/e</option>
                                            <option value="M" selected>Monat/e</option>
                                            <option value="Y">Jahr/e</option>
                                        </select>
                                        <label>Interval</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group form-floating">
                                        <input type="text" name="vertragsende" class="form-control" value="31.07.2028" placeholder="Vertragsende" disabled>
                                        <label>Ende</label>
                                    </div>
                                </div>
                            </div>


                            <div class="row" id="kuendigung_frist">

                                <div class="col-lg-3">
                                    <div class="form-group form-floating-check">
                                        <label class="form-label">Kündigungsfrist</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input editable" id="kuendigungsfrist" name="laufzeit-trigger" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group form-floating">
                                        <input type="number" name="laufzeit" class="form-control editable" value="6" placeholder="Laufzeit in Monaten" autocomplete="off">
                                        <label>Laufzeit</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group form-floating">
                                        <select class="form-select editable" name="laufzeit_interval" placeholder="Interval">
                                            <option value="d">Tag/e</option>
                                            <option value="M" selected>Monat/e</option>
                                            <option value="Y">Jahr/e</option>
                                        </select>
                                        <label>Interval</label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group form-floating">
                                        <input type="text" name="vertragsende" class="form-control" value="31.01.2027" placeholder="Vertragsende" disabled>
                                        <label>Ende</label>
                                    </div>
                                </div>
                            </div>


                            <div id="vertraege-progress-bar" class="progress mt-3">
                                <div class="progress-bar bg-success" data-id="laufzeit" role="progressbar" style="width: 60%;">01.10.2022</div>
                                <div class="progress-bar bg-warning" data-id="verlaengerung" role="progressbar" style="width: 20%;">01.10.2032</div>
                                <div class="progress-bar progress-bar-striped bg-danger" data-id="kuendigungsfrist" role="progressbar" style="width: 20%;">08.02.2023</div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-md-4">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-dollar"></i> Abrechnung</h4>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-floating-check">
                                        <label class="form-label">Pauschale</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input editable" id="pauschale" name="pauschale" value="1" />
                                            <label class="form-check-label" for="pauschale"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-floating">
                                        <select class="form-select init-select2 editable" name="name" placeholder="Abrechnung">
                                            <option value="">Quartal</option>
                                            <option value="">Monatlich</option>
                                            <option value="">Jährlich</option>
                                            <option value="">Nach Kalendarium</option>
                                        </select>
                                        <label>Abrechnung</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-floating">
                                        <select class="form-select init-select2 editable" name="kalendarium" placeholder="Kalendarium">
                                            <option value="">Bitte wählen</option>
                                            <option value="">Kalendarium 1</option>
                                            <option value="">Kalendarium 2</option>
                                            <option value="">...</option>
                                        </select>
                                        <label>Kalendarium</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group form-floating-check">
                                        <label class="form-label">Gesamtpauschale</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input editable" id="id" name="id" value="1" />
                                            <label class="form-check-label label-info" for="id" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Die Preise aus den Positionen werden damit überschrieben">Aktiviert</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-floating">
                                        <input type="text" name="preis" class="form-control editable" placeholder="Preis" autocomplete="nope">
                                        <label>Preis</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-floating">
                                        <select class="form-select editable" name="laufzeit_interval" placeholder="Interval">
                                            <option value="d">Tag/e</option>
                                            <option value="M" selected>Monat/e</option>
                                            <option value="Y">Jahr/e</option>
                                        </select>
                                        <label>Interval</label>
                                    </div>
                                </div>
                            </div>



                            <hr>




                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-floating-check">
                                        <label class="form-label">Zähler</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input editable" id="zaehler" name="zaehler" value="1" />
                                            <label class="form-check-label" for="zaehler"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-floating">
                                        <select class="form-select init-select2 editable" name="name" placeholder="Abrechnung">
                                            <option value="">Quartal</option>
                                            <option value="">Monatlich</option>
                                            <option value="">Jährlich</option>
                                            <option value="">Nach Kalendarium</option>
                                        </select>
                                        <label>Abrechnung</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-floating">
                                        <select class="form-select init-select2 editable" name="kalendarium" placeholder="Kalendarium">
                                            <option value="">Bitte wählen</option>
                                            <option value="">Kalendarium 1</option>
                                            <option value="">Kalendarium 2</option>
                                            <option value="">...</option>
                                        </select>
                                        <label>Kalendarium</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-floating-check">
                                        <label class="form-label">Einheitliche Preise</label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input editable" id="id" name="id" value="1" />
                                            <label class="form-check-label label-info" for="id" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Die Preise werden pro Position eingestellt, dürfen aber nicht abweichen!">Aktiviert</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                     <div class="form-group form-floating-check">
                                        <label class="form-label">Freimenge </label>
                                        <div class="form-check form-switch">
                                            <input type="checkbox" class="form-check-input editable" id="id" name="id" value="1" />
                                            <label class="form-check-label" for="id">Aktiviert <a href="javascript:void(0);"><i class="fa-solid fa-link"></i></a></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-dollar"></i> Abrechnung</h4>
                            <h6 class="subtext">Beispiel zum Generieren einer Abrechnung</h6>

                            <?php

                            $array = generateAbrechnung();


                            echo "<table class='table table-sm table-striped'>";
                            foreach($array AS $sub) {
                                echO "<tr><td>".implode("</td><td>", $sub)."</td></tr>";
                            }   
                            echo "</table>";


                            /**
                             * Abrechnung generieren
                             */
                            function generateAbrechnung() {

                            }









                            ?>





                    
                        </div>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>




        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        // Beim Initalisieren laufen lassen
        updateStatusBar();

        // On Change Event (nicht nur CB sondern auch der Datumsfelder, )
        $('#laufzeit, #verlaengerung, #kuendigungsfrist').on('change', function() {
            updateStatusBar();
        });



        // Dates
        function updateStatusBar() {

            // Eigentlich sollte es hier aus der Form ausgelesen werden
            // var data =  me.form.getData();

            // Daten auslesen
            var laufzeit = $('#laufzeit').prop('checked');
            var verlaengerung = $('#verlaengerung').prop('checked');
            var kuendigungsfrist = $('#kuendigungsfrist').prop('checked');

            // Die Wert müssten hier natürlich noch dynamisch ausgelesen werden
            var cases = [
                [100, '01.08.2022', 0, '', 0, ''],
                [100, '01.08.2022 - 31.08.2027', 0, '', 0, ''],
                [80, '01.08.2022 - 31.08.2027', 0, '', 20, '31.08.2028'],
                [60, '01.08.2022 - 31.08.2027', 20, '31.01.2027', 20, '31.08.2028'],
            ];

            // Aktueller Wert
            var current = (laufzeit && verlaengerung && kuendigungsfrist) ? 3 : ((laufzeit && verlaengerung) ? 2 : (laufzeit) ? 1 : 0);

            // Setzen der Progress bar
            $('#vertraege-progress-bar').find('[data-id=laufzeit]').width(cases[current][0] + "%").html(cases[current][1]);
            $('#vertraege-progress-bar').find('[data-id=verlaengerung]').width(cases[current][2] + "%").html(cases[current][3]);
            $('#vertraege-progress-bar').find('[data-id=kuendigungsfrist]').width(cases[current][4] + "%").html(cases[current][5]);
        }

    });
</script>

</html>