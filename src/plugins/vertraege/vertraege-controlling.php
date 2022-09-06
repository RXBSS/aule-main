<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-chart-area\"></i> Controlling",
    'breadcrumbs' => ['Prozesse', '<a href="vertraege"><i class="fa-solid fa-file-contract"></i> Verträge</a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
    <style>
        body {
            overflow-x: hidden;
        }

        .spehere {
            background: #7ab929;
            min-height: 10vh;
            min-width: 15vh;
            border-radius: 50%;

            padding-top: 0.7cm;
        }

        .spehere p {
            text-align: center;
            color: white;
        }
    </style>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">


            <!-- Notizen -->
            <ul style="background: rgba(255,0,0,0.2);">
                <li>Hier sollten nur Dinge angezeigt werden, die eine Zusammenfassung von mehreren Verträgen sind. Die Auswertung von einem einzelnen Vertrag findet immer in den Details statt.</li>
                <li>Viele Dinge des Controllings können ggf. schon über Standard Filter realisiert werden. Zum Beispiel: Zeige mir alle Verträge an, die gekündigt sind, zeige mir alle Verträge an, die zum X auslaufen...</li>
            </ul>


            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="actions">
                                <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Text"><i class="fa-solid fa-arrow-left"></i></a>
                                <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Text">2022</a>
                                <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Text"><i class="fa-solid fa-arrow-right"></i></a>
                                <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Text"><i class="fa-solid fa-filter"></i></a>
                            </div>
                            <h4 class="card-title"><i class="fa-solid fa-chart-area"></i> Cash-Flow</h4>
                            <h6 class="subtext">Eine Auflistung der zur erwartenden Einnahmen über das Jahr hinweg</h6>
                            <canvas id="chart-cashflow"></canvas>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-secondary">
                                <div class="d-flex justify-content-between">
                                    <div><strong>Verträge</strong></div>
                                    <div><strong>1.565</strong></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div><i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>&nbsp;&nbsp;<a href="vertraege">Aktiv</a></div>
                                    <div><strong>1.056</strong></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div><i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>&nbsp;&nbsp;<a href="vertraege">Entwürfe</a></div>
                                    <div><strong>265</strong></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div><i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>&nbsp;&nbsp;<a href="vertraege">Gekündigt</a></div>
                                    <div><strong>202</strong></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div><i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>&nbsp;&nbsp;<a href="vertraege">In Verlängerung</a></div>
                                    <div><strong>80</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-secondary">
                                <div class="d-flex justify-content-between">
                                    <div><strong>Wert</strong></div>
                                    <div><strong>1.659.959,00 €</strong></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div><i class="fa-solid fa-arrow-turn-up fa-rotate-90"></i>&nbsp;&nbsp;Ø Monat</div>
                                    <div><strong>138.329,02 €</strong></div>
                                </div>
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-danger">
                                <div class="d-flex justify-content-between">
                                    <div><strong>Zu Berechnen</strong></div>
                                    <div><strong>105.232,03 €</strong></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div><strong>Unbezahlt</strong></div>
                                    <div><strong>20.454,03 €</strong></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-primary">
                                <div class="d-flex justify-content-between">
                                    <div><strong>Abgerechnet</strong></div>
                                    <div><strong>469.232,03 €</strong></div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div><strong>Bezahlt</strong></div>
                                    <div><strong>400.454,03 €</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <div class="col-md-4"></div>
            </div>

















            <?php
            /*


            <!-- Abrechnung und Controlling -->
            <div class="row">
                <div class="col-lg-8">

                    <div class="card border-left-primary" id="vertraege-abrechnung">
                        <div class="card-body">
                            <a href="vertraege-abrechnung">
                                <h4 class="card-title"><i class="fas fa-dollar-sign text-gray-300"></i> Verträge Abrechnung</h4>
                            </a>

                            <h6 class="subtext">Das ist der Subtext</h6>

                            <div id="chart">
                                <canvas id="vertraege-chart" style="min-height: 300px; display: block; box-sizing: border-box; height: 133px; width: 267px;" width="267" height="133">

                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-lg-4">


                    <!-- <div class="card border-left-dark" id="vertraege-controlling">
                        <div class="card-body">
                            <a href="vertraege-controlling">
                                <h4 class="card-title"><i class="fa-solid fa-calculator"></i> Verträge Controlling</h4>
                            </a>

                            <div class="position-relative">

                                <div class="position-absolute top-0 start-50 translate-middle">
                                    <div class="spehere" style="margin-top: 3cm">
                                        <p>
                                            Planung 
                                        </p>
                                    </div>

                                </div>

                                <div class="position-absolute top-50 start-100 translate-middle">
                                    <div class="spehere" style="margin-top: 9cm; margin-right: 3cm;">
                                        <p >
                                            Durchührung
                                        </p>
                                    </div>
                                    <i class="fa-solid fa-arrow-down" style="rotate: 50deg; font-size: 25px;"></i>

                                </div>

                                <div class="position-absolute top-50 start-0 translate-middle">
                                    <div class="spehere" style="margin-top: 9cm; margin-left: 3cm;">
                                        <p >
                                            Steuerung
                                        </p>
                                    </div>
                                    
                                </div>

                                <div class="position-absolute top-100 start-50 translate-middle">
                                    
                                    <div class="spehere" style="margin-top: 14cm;">

                                        <p >
                                            Erfolgskontrolle
                                        </p>
                                    </div>
                                    
                                </div>
                            </div>
                    
                        </div>
                    </div> -->

                </div>
            </div>


  


          
            */
            ?>

        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        // Do Something
        var v = {

            init() {


                var me = this;

                // Init Vertrage Chart
                me.initCashFlowChart();

                // Card Sizer
                //  me.initCardSizer();

                // Events
                me.addEventListener();

            },


            // Vertraege Chart
            initCashFlowChart() {

                var me = this;

                // Chart initalisieren
                var ctx = document.getElementById('chart-cashflow').getContext('2d');

                me.cashFlowChart = new Chart(ctx, {
                    type: 'line',

                    data: {
                        labels: ['Januar', 'Februar', 'Märt', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                        datasets: [{
                                label: 'Zu Erwarten',
                                data: [450656, 65211, 38565, 246561, 56562, 97654, 103155, 123544, 40545, 54896, 54584, 143665],
                                borderColor: '#3498db'
                            },
                            {
                                label: 'in Rechnung',
                                data: [400541, 55511, 37565, 266561, 54562, 65954, 89155, 0, 0, 0, 0, 0],
                                borderColor: '#e67e22'
                            },
                            {
                                label: 'Bezahlt',
                                data: [325094, 32965, 34599, 210595, 34989, 55954, 48652, 0, 0, 0, 0, 0],
                                borderColor: '#e74c3c'
                            }
                        ],
                    }


                    // data: {
                    //     datasets: [{
                    //         data: [
                    //             6, 1, 3, 5, 9, 6, 8, 10
                    //         ],
                    //         backgroundColor: [
                    //             '#7ab929',
                    //             '#0d6efd',
                    //             '#fd7e14',
                    //             '#6f42c1',
                    //             '#343a40',
                    //             '#dc3545',
                    //             '#6c757d',
                    //             '#0dcaf0',

                    //         ],
                    //         label: 'Ergebnisse'
                    //     }],
                    //     labels: [
                    //         'Miet- und Zählervertrag',
                    //         'Mietvertrag',
                    //         'Möbelvertrag',
                    //         'Nebenkostenabrechnung',
                    //         'Softwarepflegevertrag',
                    //         'Zählervertrag',
                    //         'Zählervertrag 0-Miete',
                    //         'Wartungsvertrag',
                    //     ]
                    // },
                    // options: {
                    //     legend: {
                    //         position: 'left',
                    //         align: 'center'
                    //     },
                    //     responsive: true,
                    //     maintainAspectRatio: false
                    // }
                });



            },

            // Events
            addEventListener() {

                var me = this;

                // *****************************************************************************
                // Standard Events
                // *****************************************************************************


                // *****************************************************************************
                // Form Handler Events
                // *****************************************************************************


            }

        }


        v.init();

    });
</script>

</html>