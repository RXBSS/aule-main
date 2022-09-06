<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-cogs\"></i> Jobs"
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

            <div class="accordion accordion-flush" id="accordionFlushExample">
                <?php

                $jobs = [
                    'vertrag1' => [
                        'title' => 'Vertrag Rechnungen',
                        'beschreibung' => 'Prüft den aktuellen Vertrag auf Fälligkeiten und erstellt Rechnungen falls notwendig',
                        'class' => 'JobVertraegeRechnungen'
                    ],

                    'vertrag2' => [
                        'title' => 'Vertrag Abbrechnungen',
                        'beschreibung' => 'Prüft die Laufzeiten aller Verträge und erstellt neue Abrechnungsdaten',
                        'class' => 'JobVertraegeAbrechnungen'
                    ],

                ];

                
                echo '<div id="job-accordion" class="accordion-item">';

                // Schleife
                $i = 1;

                foreach ($jobs as $key => $value) {
                ?>
                    <h2 class="accordion-header" id="job-accordion-header-<?php echo $i; ?>">
                        <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#job-accordion-body-<?php echo $i; ?>">
                            <div class="d-flex justify-content-between" style="width: 98%;">
                                <div><i class="fa-solid fa-gear"></i> <?php echo $value['title']; ?></div>
                                <div><i class="fa-solid fa-clock-rotate-left ps-3" style="min-width:0px;"></i> <?php echo date('d.m.Y H:i:s'); ?> <i class="fa-regular fa-clock ps-3" style="min-width:0px;"></i> <?php echo date('d.m.Y H:i:s'); ?></div>
                            </div>
                        </button>
                    </h2>
                    <div id="job-accordion-body-<?php echo $i; ?>" class="job-acc accordion-collapse collapse" data-bs-parent="#job-accordion">
                        <div class="accordion-body">



                            <div class="row">
                                <div class="col-md-6">

                                     <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Letzte Ausführung</td>
                                                <th><i class="fa-solid fa-clock-rotate-left"></i> <?php echo date('d.m.Y H:i:s'); ?></th>
                                            </tr>
                                            <tr>
                                                <td>Nächste Ausführung</td>
                                                <th><i class="fa-solid fa-clock"></i> <?php echo date('d.m.Y H:i:s'); ?></th>
                                            </tr>
                                            <tr>
                                                <td>Dauer letzte Ausführung</td>
                                                <th><i class="fa-solid fa-stopwatch"></i> 8 Sekunden</th>
                                            </tr>
                                            <tr>
                                                <td>Ø Dauer</td>
                                                <th><i class="fa-solid fa-stopwatch"></i> 6 Sekunden</th>
                                            </tr>
                                            <tr>
                                                <td>Intervall</td>
                                                <th><i class="fa-solid fa-calendar-check"></i> Jeden Tag 12:00</th>
                                            </tr>
                                        </tbody>
                    
                                    </table>


                                    <button class="btn btn-primary btn-run-job" data-job="<?php echo $value['class'];?>">Jetzt Ausführen</button>
 
                                </div>
                                <div class="col-md-6">
                                    <strong>Log</strong>
                                    <pre style="background: #333; color: #FFF;padding: 5px;font-size: 10px;min-height: 200px; max-height: 200px;"><code class="job-log">// HIER DAS LOG


                                        </code></pre>

                                </div>
                            </div>






                            


                        </div>
                    </div>
                <?php
                    $i++;
                }

                echo '</div>';


                ?>




            </div>
        </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        
        // Job ausführen
        $('.btn-run-job').on('click', function() {

            var el = $(this);


            console.log(el.data('job'));

            // Simple Request
            app.simpleRequest("run", "jobs-handle", el.data('job'), function(response) {
                el.closest('.job-acc').find('.job-log').html('Success');
            });


        });



    });
</script>

</html>