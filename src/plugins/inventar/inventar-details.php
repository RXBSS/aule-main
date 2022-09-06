<?php include('01_init.php');

$_page = [
    'title' => "Inventar Stammdaten",
    'breadcrumbs' => ['Stammdaten' , '<a href="inventar"><i class="fa-solid fa-car"></i> Inventar</a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">
        
            <div class="row">

                <!-- Das ist die Card -- Inventar Stammdaten -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-car"></i> Inventar Details</h4>
                    
                            <form id="form-inventar">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <input type="text" name="kaufobjekt" class="form-control editable" placeholder="Kaufobjekt" autocomplete="off" required>
                                            <label>Kaufobjekt</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">

                                        <!-- <input type="hidden" name="kaufperson_id"> -->
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect" id="select-kaufperson" name="kaufperson_id" data-qs-name="mitarbeiter" placeholder="Kaufperson" required>
                                                
                                            </select>
                                            <label>Kaufperson</label>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <!-- <input type="hidden" name="nutzer_id"> -->
                                        
                                        <div class="form-group form-floating">
                                            <input type="text" name="seriennummer" data-format="Uppercase" class="form-control editable  more-readable" placeholder="Seriennummer" autocomplete="off" >
                                            <label>Seriennummer</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col">
                                       
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-lg-6">

                                        <div class="form-group form-floating">
                                            <input type="date" name="kaufdatum"  class="form-control editable" placeholder="Kaufdatum" autocomplete="off" required>
                                            <label>Kaufdatum</label>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">

                                        <div class="form-group form-floating">
                                            <input type="text" name="kaufpreis" class="form-control editable" placeholder="Netto Kaufpreis" autocomplete="off" required>
                                            <div class="form-unit">€</div>
                                            
                                            <label>Netto Kaufpreis</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">

                                        <div class="form-group form-floating">
                                            <textarea class="form-control editable" name="beschreibung" placeholder="Floating Textarea"></textarea>
                                            <label>Beschreibung</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating-check">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="abschreibung" value="1" disabled />
                                                <label class="form-check-label" for="id">Abschreibung</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="abschreibung">
                                    <div class="col-lg-6">

                                        <div class="form-group form-floating">
                                            <input type="text" name="abschreibezeitraum" class="form-control editable" placeholder="Zeitraum (in Jahren)" autocomplete="off" required>
                                            <label>Zeitraum (in Jahren)</label>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">

                                        <div class="form-group form-floating">
                                            <input type="text" name="enddatum" class="form-control editable" placeholder="Enddatum" disabled autocomplete="off" >
                                            <label>Enddatum</disabled label>
                                        </div>

                                    </div>
                                </div>

                            </form>
                    
                        </div>
                    </div>
                </div>


                <!-- Das sind die Tabs -- weiter Details zu einem Inventar -->
                <div class="col-lg-8">
                    <ul class="nav nav-tabs nav-fill mb-3" id="pills-tab" role="tablist">
                       
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " role="tab" data-bs-toggle="pill" data-bs-toggle="tab" data-bs-target="#tab-inventar-verleih" type="button" aria-controls="verleih" aria-selected="true">Verleih</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" role="tab" data-bs-toggle="pill" data-bs-toggle="tab" data-bs-target="#tab-inventar-tags" type="button" aria-controls="tags" aria-selected="true">Tags</button>
                        </li>
                        
                    </ul>
                    <br>
                    <div class="tab-content" id="tab-content-name">
                        
                        <!-- <div class="tab-pane show active" id="tab-inventar-vorschau" role="tabpanel" aria-labelledby="tab-inventar-vorschau">

                            <div class="row">
                                <div class="col">
                                    
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title"><i class="fa-solid fa-book"></i> Dokumente</h4>
                                            <h6 class="subtext">Hier können Dokumente für dieses Inventar Kaufobjekt hinterlegt werden.</h6>


                                            <div id="dokumente-drag-n-drop" class="upload-area mb-3"></div>

                                            Im Hintergrund ELO ????  Aber Nötigung dem Kunde ELO zu verkaufen

                                            <div id="picklist-dokumente"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            Hier Könnten man eine PDF erzeugen oder ein Etikett zum aufkleben
                            PDF gibt eine Übersicht über Abschreibung oder Kauf. Rechnung vom Kauf kann mit hochgeladen und an die PDF angehängt werden
                        
                        </div> -->

                        <div class="tab-pane " id="tab-inventar-verleih" role="tabpanel" aria-labelledby="tab-inventar-verleih">

                            <div class="row">
                                <div class="col-lg-6">
                                
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="actions">
                                                <a class="action-item verleih-beenden" id="verleih-beenden" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Verleih beenden"><i class="fa-solid fa-circle-exclamation"></i> </a>
                                            </div>

                                            <h4 class="card-title"><i class="fas fa-truck-moving"></i> Verleih</h4>
                                    
                                            <h6 class="subtext">Das Objekt kann Verliehen werden</h6>

                                            <form id="inventar-verleih-form">

                                                <!-- <div class="row">
                                                    <div class="col">
                                                        <div class="form-group form-floating">
                                                            <input type="text" name="kaufobjekt" class="form-control " placeholder="Bezeichnung" autocomplete="nope" readonly>
                                                            <label>Kaufobjekt</label>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group form-floating">
                                                            <select class="form-select editable init-quickselect" id="select-nutzer" name="nutzer_id" data-qs-name="mitarbeiter" placeholder="Nutzer" required>
                                                                
                                                            </select>
                                                            <label>Nutzer</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group form-floating">
                                                            <input type="date" name="nutzungsdauer" class="form-control editable" placeholder="Nutzungsdauer" autocomplete="nope">
                                                            <label>Nutzungsdauer bis</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">

                                                        <div class="form-group form-floating">
                                                            <input type="text" name="nutzungsstandort" class="form-control editable" placeholder="Nutzungsstandort" autocomplete="nope" required>
                                                            <label>Nutzungsstandort</label>
                                                        </div>

                                                    </div>
                                                   
                                                </div>

                                                <div class="row">
                                                    
                                                    <div class="col">

                                                        <div class="form-group form-floating">
                                                            <textarea class="form-control editable" name="nutzungsgrund" placeholder="Nutzungsgrund" required></textarea>
                                                            <label>Nutzungsgrund</label>
                                                        </div>

                                                    </div>
                                                </div>


                                            </form>
                                    
                                    
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">

                                    <!-- <div class="row"> -->
                                        <!-- <div class="col"> -->

                                            <div id="inventar-verleih-timeline"></div>

                                        <!-- </div> -->
                                    <!-- </div> -->


                                </div>
                            </div>
                        
                        </div>

                        <div class="tab-pane show active" id="tab-inventar-tags" role="tabpanel" aria-labelledby="tab-inventar-tags">

                            <!-- <div class="row">
                                <div class="col">
                                    
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title"><i class="fa-solid fa-book"></i> Dokumente</h4>
                                            <h6 class="subtext">Hier können Dokumente für dieses Inventar Kaufobjekt hinterlegt werden.</h6>


                                            <div id="dokumente-drag-n-drop" class="upload-area mb-3"></div>

                                            Im Hintergrund ELO ????  Aber Nötigung dem Kunde ELO zu verkaufen

                                            <div id="picklist-dokumente"></div>

                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            Hier Könnten man eine PDF erzeugen oder ein Etikett zum aufkleben
                            PDF gibt eine Übersicht über Abschreibung oder Kauf. Rechnung vom Kauf kann mit hochgeladen und an die PDF angehängt werden
                        
                        </div>


                    </div>
                </div>



            </div>
        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="../js/pagelevel/inventar-a.js"></script>

<script>
    $(document).on('app:ready', function() {

        // 
        Object.assign(id, i_both);

        id.init(); 
    });
</script>
</html>