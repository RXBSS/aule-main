<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-cart-plus\"></i> Neuer Bestellvorschlag",
    'breadcrumbs' => ['Prozesse', '<a href="bestellungen"><i class="fa-solid fa-shopping-cart"></i> Bestellungen</a>']

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

            <div class="card">
                <div class="card-body">

                    <h4 class="card-title"><i class="fa-solid fa-search"></i> Bestellvorschlag</h4>
                    <h6 class="subtext">Hier werden die Suchparameter für einen Bestellvorschlag eingestellt</h6>

                    <!-- Form -->
                    <form id="bestellvorschlag">

                        <div class="row">
                            <div class="col-md-3">

                                <!-- Auftragsbestand -->
                                <div class="form-group form-floating-check">
                                    <label class="form-label">Auftragsbestände</label>
                                    <div class="form-check form-switch ">
                                        <input type="checkbox" class="form-check-input" id="auftragsbestand" name="auftragsbestand" value="1" checked />
                                        <label class="form-check-label" for="auftragsbestand">Aktiviert</label>
                                    </div>
                                </div>

                                <!-- Min- und Maximalbestand -->
                                <div class="form-group form-floating-check">
                                    <label class="form-label">Minimal und Maximal Bestände</label>
                                    <div class="form-check form-switch ">
                                        <input type="checkbox" class="form-check-input" id="minimal-maximal-bestaende" name="minimal-maximal-bestaende" value="1" checked />
                                        <label class="form-check-label" for="minimal-maximal-bestaende">Aktiviert</label>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3">

                                <!-- Auftragsbestand
                                <div class="form-group form-floating-check">
                                    <label class="form-label">Auftragsbestände</label>
                                    <div class="form-check form-switch ">
                                        <input type="checkbox" class="form-check-input" id="auftragsbestand" name="auftragsbestand" value="1" checked />
                                        <label class="form-check-label" for="auftragsbestand">Aktiviert</label>
                                    </div>
                                </div>
 -->

                            </div>


                            <div class="col-md-4">

                            </div>

                        </div>


                        <br>
                        <button class="btn btn-primary"><i class="fa-solid fa-cogs"></i> Bestellvorschlag generieren</button>

                    </form>
                </div>
            </div>


            <!-- Bestellvorschlag -->
            <div id="bestellvorschlag-data"><em>Noch kein Bestellvorschlag erstellt</em></div>

            <?php

            echo "<pre>";

            // Bestellung
            $b = new Bestellvorschlag();

            // Bestellvorschlag
            $b->create();

            ?>



        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        

        var form = new Form('#bestellvorschlag');


        form.on('submit', function() {
            
            // 
            form.save('create','bestellvorschlag-handle', function(data) {
                
                console.log(data);


            });


        });

    });
</script>

</html>