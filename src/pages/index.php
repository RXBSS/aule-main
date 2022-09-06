<?php include('01_init.php');


// Temporär!!!!
if(isset($_GET['set-login-user']) && $_GET['set-login-user']) {
    $app->user->doLogin($_GET['set-login-user'],  true);
    header('Location: /');
}


$_page = [
    'title' => "<i class='fa-solid fa-puzzle-piece'></i> Dashboard"
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

            <!-- Temporäre Platzhalter -->
            <div class="row">
                <div class="col-md-6">
                    <div class='card'>
                        <div class='card-body'>
                            <h4><i class="fa-regular fa-smile-wink"></i> Willkommen</h4>
                            <h6 class='subtext'>Hier entsteht das neue Dashboard</h6>
                            <p>
                                Das neue ERP-System ist grade in der Entwicklung. Solange sich noch niemand um das
                                Dashboard gekümmert hat, wird hier vorne diese Karte angezeigt.
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-database"></i> Stammdaten</h4>
                            <h6 class="subtext">Alle Stammdaten</h6>
                    
                            <button class="btn btn-secondary" data-redirect="adressen">Adressen</button>
                            <button class="btn btn-secondary" data-redirect="kontakte">Kontakte</button>
                            <button class="btn btn-secondary" data-redirect="artikel">Artikel</button>
                            <button class="btn btn-secondary" data-redirect="geraete">Geräte</button>
                            <button class="btn btn-secondary" data-redirect="modelle">Modelle</button>
                            <button class="btn btn-secondary" data-redirect="hersteller">Hersteller</button>
                            <button class="btn btn-secondary" data-redirect="mitarbeiter">Mitarbeiter</button>
                            <button class="btn btn-secondary" data-redirect="weitere-stammdaten">Weitere</button>
                    
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-bolt"></i> Anmeldung Welchseln</h4>
                            <h6 class="subtext">Diese Funktion ist nur für die Entwicklung gedacht</h6>

                           
                            <strong>Angemeldeter Benutzer: </strong> <i class="fa-solid fa-user-lock"></i> <?php echo $_SESSION['user']['vorname']." ".$_SESSION['user']['nachname']; ?><br>
                            <br>
                            <strong>Anmeldung wechseln</strong><br>

                            <a class="btn btn-secondary" href="/?set-login-user=11"><i class="fa-solid fa-rotate"></i> Tobias Pitzer</a>
                            <a class="btn btn-secondary" href="/?set-login-user=1003"><i class="fa-solid fa-rotate"></i> Yusuf Gördük</a>
                            <a class="btn btn-secondary" href="/?set-login-user=31"><i class="fa-solid fa-rotate"></i> Leandro Schäfer</a>
                            <a class="btn btn-secondary" href="/?set-login-user=33"><i class="fa-solid fa-rotate"></i> Fabian Hamacher</a>

                    
                    
                        </div>
                    </div>



                </div>
                <div class="col-md-6">
                    <div class='card'>
                        <div class='card-body'>
                            <h4><i class="fa-solid fa-sync-alt"></i> Prozesse</h4>
                            <h6 class='subtext'>Alle Abläufe im Unternehmen</h6>

                            <!-- Erste Reihe -->
                            <div class="row">
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="btn btn-warning" data-redirect="akquise"><i class="fa-solid fa-users"></i> Akquise</button>
                                    </div>
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                </div>
                            </div>


                            <!-- Zeiter Reihe -->
                            <div class="row">
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="btn btn-warning" data-redirect="angebote"><i class="fa-solid fa-comments-dollar"></i> Angebote</button>

                                    </div>
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="btn btn-danger" data-redirect="bedarfsmeldungen"><i class="fa-solid fa-inbox"></i> Bedarfsmeldungen</button>
                                    </div>
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="btn btn-info" data-redirect="tickets"><i class="fa-solid fa-ticket-alt"></i> Tickets</button>
                                    </div>
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                </div>
                            </div>

                            <!-- Dritte Reihe -->
                            <div class="row">
                                <div class="col-8">
                                    <div class="d-grid">
                                        <button class=" btn btn-success" data-redirect="auftraege"><i class="fa-solid fa-layer-group"></i> Aufträge</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="btn btn-info"><i class="fa-solid fa-tools"></i> Service</button>
                                    </div>

                                </div>
                            </div>



                            <!-- Vierte Reihe -->
                            <div class="row">
                                <div class="col-3">
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                    <div class="d-grid">
                                        <button class="btn btn-success" data-redirect="bestellungen"><i class="fa-solid fa-shopping-cart"></i> Bestellungen</button>
                                    </div>
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                </div>
                                <div class="col-1">
                                    <br>
                                    <div class="mt-3">
                                        <center><i class="fa-solid fa-arrow-left"></i></center>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i> <i class="fa-solid fa-arrow-up mb-2 mt-2"></i></center>
                                    <div class="d-grid">
                                        <button class="btn btn-success"><i class="fa-solid fa-database"></i> Lager</button>
                                    </div>
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i> <i class="fa-solid fa-arrow-up mb-2 mt-2"></i></center>
                                </div>
                                <div class="col-1">
                                    <br>
                                    <div class="mt-3">
                                        <center><i class="fa-solid fa-arrow-left"></i> <i class="fa-solid fa-arrow-right"></i></center>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                    <div class="d-grid">
                                        <button class="btn btn-info"><i class="fa-solid fa-map-signs"></i> Dispatch</button>
                                    </div>
                                </div>
                            </div>


                            <!-- Fünfte Reihe -->
                            <div class="row">
                                <div class="col-7">
                                    <div class="d-grid">
                                        <button class="btn btn-success" data-redirect="wareneingang"><i class="fa-solid fa-truck-loading"></i> Wareneingang</button>
                                    </div>
                                </div>
                            </div>


                            <!-- Arrows -->
                            <div class="row">
                                <div class="col-3">
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                </div>
                                <div class="col-5">
                                </div>
                                <div class="col-4">
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                </div>
                            </div>

                            <!-- Sechste Reihe -->
                            <div class="row">
                                <div class="col-3">
                                    <div class="d-grid">
                                        <button class="btn btn-success" data-redirect="kommissionen"><i class="fa-solid fa-box-open"></i> Kommissionieren</button>
                                    </div>
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                </div>
                                <div class="col-1">
                                    <center><i class="fa-solid fa-arrow-right mb-2 mt-2"></i></center>
                                </div>
                                <div class="col-3">
                                    <div class="d-grid">
                                        <button class="btn btn-success"><i class="fa-solid fa-shipping-fast"></i> Versand</button>
                                    </div>
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                </div>

                            </div>

                            <!-- Siebte Reihe -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button class="btn btn-secondary" data-redirect="rechnungen"><i class="fa-solid fa-dollar-sign"></i> Rechnungen</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Achte Reihe -->
                            <div class="row">
                                <div class="col-4">
                                    <center><i class="fa-solid fa-arrow-up mb-2 mt-2"></i></center>
                                    <div class="d-grid">
                                        <button class="btn btn-secondary" data-redirect="vertraege"><i class="fa-solid fa-file-signature"></i> Vertragsabrechnung</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                    <div class="d-grid">
                                        <button class="btn btn-secondary"><i class="fa-solid fa-file-invoice-dollar"></i> Mahnungen</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <center><i class="fa-solid fa-arrow-down mb-2 mt-2"></i></center>
                                    <div class="d-grid">
                                        <button class="btn btn-secondary"><i class="fa-solid fa-book"></i> Finanzbuchhaltung</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Neunte Reihe -->
                            <div class="row">
                                <div class="col-8"></div>
                                <div class="col-4">
                                    <center><i class="fa-solid fa-arrow-up mb-2 mt-2"></i></center>
                                    <div class="d-grid">
                                        <button class="btn btn-secondary" data-redirect="kassenbuch"><i class="fa-solid fa-cash-register"></i> Kasse</button>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

            </div>

        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        hotkeys('ctrl+f7', function(event, handler) {
            app.redirect("auftraege");
        });
    });
</script>

</html>