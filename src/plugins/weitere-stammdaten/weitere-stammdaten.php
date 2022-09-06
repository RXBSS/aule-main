<?php include('01_init.php');

$_page = [
    'title' => "<i class='fa-solid fa-cogs'></i> Weitere Stammdaten",
    'breadcrumbs' => ['Stammdaten']
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

            <!-- Button für die Pickliste Modal -->
            <div class="row">
                <div class="col-md-6">


                    <!-- --------------------------- -->
                    <!-- Card für ARTIKEL            -->
                    <!-- --------------------------- -->
                    <div class="card">
                        <div class="card-body">

                            <h4><i class="fa-solid fa-box"></i> Artikel</h4>
                            <h6 class="subtext">Weitere Stammdaten für den Artikelbereich.</h6>



                            <div class="accordion" id="acc-artikel" style="border:0;">

                                <!-- Artikel Gruppen -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-artikel-1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-artikel-collapse-1">
                                            <i class="fa-solid fa-boxes"></i> <strong>Artikelgruppen</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-artikel-collapse-1" class="accordion-collapse collapse" data-bs-parent="#acc-artikel">
                                        <div class="accordion-body">
                                            Jedem Artikel kann eine Artikelgruppe zugewiesen werden. MIt Hilfe der Artikelgruppen können statistische Auswertungen erhoben
                                            und Kalkulationsschlüssel verteilt werden. Zudem können dem Artikel über die Artikelgruppe Standard-Attribute zugewiesen werden.
                                            <div class="mt-3">
                                                <button class="btn btn-primary" id="artikelgruppen-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Artikelgruppe</button>
                                                <button class="btn btn-secondary" id="artikelgruppen-modal-open"><i class="fa-solid fa-plus"></i> Neue Artikelgruppe</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Artikel Attribute -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-artikel-2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-artikel-collapse-2">
                                            <i class="fab fa-medapps"></i> <strong>Artikel Attribute</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-artikel-collapse-2" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#acc-artikel">
                                        <div class="accordion-body">
                                            Bei Artikel-Attributen handelt es sich um Felder anlegen und den Artikelgruppen zuordnen kann.
                                            So kann jede Artikelgruppe bestimmte Attribute haben.
                                            <div class="mt-3">
                                                <button class="btn btn-primary" id="artikelgruppen-attribute-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Attribute</button>
                                                <button class="btn btn-secondary" id="artikelgruppen-attribute-modal-open"><i class="fa-solid fa-plus"></i> Neues Attribute</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Garantie -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-artikel-6">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-artikel-collapse-6">
                                            <i class="fa-solid fa-scale-balanced"></i> <strong>Garantie</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-artikel-collapse-6" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#acc-artikel">
                                        <div class="accordion-body">
                                            <div class="alert alert-danger">Ist noch nicht programmiert</div>
                                            Man kann verschiedene Garantien anlegen. Diese können dann als Vorauswahl genommen werden.
                                            <div class="mt-3">
                                                <button class="btn btn-primary" id="garantie-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Garantien</button>
                                                <button class="btn btn-secondary" id="garantie-modal-open"><i class="fa-solid fa-plus"></i> Neue Garantie</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Lager -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-artikel-3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-artikel-collapse-3">
                                            <i class="fa-solid fa-warehouse"></i> <strong>Lager</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-artikel-collapse-3" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#acc-artikel">
                                        <div class="accordion-body">
                                            Hier werden die Lagerstätten eines Unternehmens verwaltet. Für jedes Lager kann man verschiedene Einstellungen getätigt werden.
                                            <div class="mt-3">
                                                <button class="btn btn-primary" id="lagerverwaltung-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Lagerverwaltung</button>
                                                <button class="btn btn-secondary" id="lagerverwaltung-modal-open"><i class="fa-solid fa-plus"></i> Neues Lager</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Software / Firmware -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-artikel-4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-artikel-collapse-4">
                                            <i class="fa-solid fa-code-branch"></i> <strong>Software/Firmware Versionen</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-artikel-collapse-4" class="accordion-collapse collapse" data-bs-parent="#acc-artikel">
                                        <div class="accordion-body">
                                            Hier werden einzelne Soft- und Firmwarestände gepflegt. Diese können dann bestimmten Maschinen und Softwarelösungen zugeordnet werden.
                                            <div class="mt-3">
                                                <a href="software" class="btn btn-primary" id="software-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Software / Firmware</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Software / Firmware -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-artikel-5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-artikel-collapse-5">
                                            <i class="fa-solid fa-stopwatch-20"></i> <strong>Zähler</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-artikel-collapse-5" class="accordion-collapse collapse" data-bs-parent="#acc-artikel">
                                        <div class="accordion-body">
                                            Hier können neue Bestände erfassst werden für die ein Zähler existieren kann.
                                            <div class="mt-3">
                                                <button class="btn btn-primary" id="zaehler-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Zähler</button>
                                                <button class="btn btn-secondary" id="zaahler-modal-open"><i class="fa-solid fa-plus"></i> Neuer Zähler</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-money-check-alt"></i> Kosten</h4>
                            <h6 class="subtext">Weitere Stammdaten für den Kostenbereich</h6>



                            <div class="accordion" id="acc-kosten">


                                <!-- Artikel Gruppen -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-kosten-1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-kosten-collapse-1">
                                            <i class="fa-solid fa-euro-sign"></i> <strong>Kostenstellen</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-kosten-collapse-1" class="accordion-collapse collapse" data-bs-parent="#acc-kosten">
                                        <div class="accordion-body">
                                            Jedem Artikel kann eine Kostenstelle zugewiesen werden.
                                            <div class="mt-3">
                                                <button class="btn btn-primary" id="kostenstellen-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Kostenstelle</button>
                                                <button class="btn btn-secondary" id="kostenstellen-modal-open"><i class="fa-solid fa-plus"></i> Neue Kostenstelle</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Artikel Attribute -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-kosten-2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-kosten-collapse-2">
                                            <i class="fa-solid fa-cash-register"></i> <strong>Zahlungsbedingungen</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-kosten-collapse-2" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#acc-kosten">
                                        <div class="accordion-body">
                                            Hier werden alle noch fällige Zahlungsbedingungen aufgelistet. Außerdem können neue Zahlungsbedingungen mit Skonto angelegt werden
                                            <div class="mt-3">
                                                <button class="btn btn-primary" id="zahlungsbedingungen-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Zahlungsbedingungen</button>
                                                <button class="btn btn-secondary" id="zahlungsbedingungen-modal-open"><i class="fa-solid fa-plus"></i> Neue Zahlungsbedingung</button>
                                            </div>
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
                            <h4 class="card-title"><i class="fas fa-flag"></i> Prozesse</h4>

                            <h6 class="subtext">Weitere Stammdaten für den Prozess bereich</h6>


                            <!-- Prozesse -->
                            <div class="accordion" id="acc-prozesse">

                                <!-- Meilensteine -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-prozesse-1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-prozesse-collapse-1">
                                            <i class="fa-solid fa-flag"></i> <strong>Meilensteine - Akquise</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-prozesse-collapse-1" class="accordion-collapse collapse" data-bs-parent="#acc-meilensteine">
                                        <div class="accordion-body">
                                            Hier kann man weitere Meilensteine anlegen die zu keiner Akquise Aktion zugeordnet sind.
                                            <div class="mt-3">
                                                <button class="btn btn-primary" id="meilensteine-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Meilensteine</button>
                                                <button class="btn btn-secondary" id="meilensteine-modal-open"><i class="fa-solid fa-plus"></i> Neue Meilensteine</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Zählerbeschreibung -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-prozesse-2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-prozesse-collapse-2">
                                            <i class="fa-solid fa-book"></i> <strong>Zählerstände Anleitungen</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-prozesse-collapse-2" class="accordion-collapse collapse" data-bs-parent="#acc-prozesse">
                                        <div class="accordion-body">
                                            Hier können Anleitungen hinterlegt werden, die dem Benutzer im Kundenportal vorgeschlagen werden
                                            <div class="mt-3">
                                                <a class="btn btn-primary" href="zaehlerstaende-anleitungen"><i class="fa-solid fa-external-link-alt"></i> Zählerstände Anleitungen</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Verträgegruppen -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="acc-prozesse-3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-prozesse-collapse-3">
                                            <i class="fa-solid fa-file-contract"></i> <strong>Verträgegruppen</strong>
                                        </button>
                                    </h2>
                                    <div id="acc-prozesse-collapse-3" class="accordion-collapse collapse" data-bs-parent="#acc-prozesse">
                                        <div class="accordion-body">
                                            Hier können alle Vertragsgruppen eingesehen, editiert oder gelöscht werden.
                                            <div class="mt-3">
                                                <button class="btn btn-primary" id="vertraegegruppen-pickliste-open"><i class="fa-solid fa-external-link-alt"></i> Verträgegruppen</button>
                                                <button class="btn btn-secondary" id="vertraegegruppen-modal-open"><i class="fa-solid fa-plus"></i> Neue Verträgegruppen</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- --------------------------- -->
        <!-- PickListe Artikelgruppen -->
        <!-- --------------------------- -->
        <div id="artikelgruppen-pickliste"></div>




    </div>
    </div>

    <!-- Die Modals -->
    <?php include('./weitere-stammdaten-modal.php'); ?>
    <?php include('./akquise-meilenstein-modal.php') ?>

</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        ag.init();




    });
</script>

</html>