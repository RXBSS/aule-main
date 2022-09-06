<?php include('01_init.php');

$_page = [
    'title' => "Mitarbeiter Details",
    'breadcrumbs' => ['Stammdaten', '<a href="mitarbeiter"><i class="fa-solid fa-home"></i> Mitarbeiter</a>']
];


$mitarbeiter = new Mitarbeiter();

$data = $mitarbeiter->get($_GET['id']);

// echo '<pre>';
// print_r($laender['de']);
// echO '</pre>';

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
                <div class="col col-xl-4">

                    <div class="card" id="mitarbeiter-stammdaten">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-box"></i> Mitarbeiter Stammdaten</h4>

                            <!-- Form -->
                            <form id="form-mitarbeiter-details">

                                <!-- HIDDEN -->
                                <input type="hidden" name="mitarbeiter-id">

                                <div class="row mt-lg-5">
                                    <div class="col col-lg-1 icon-col">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="col col-lg-11 input-col ml-lg-5"> 
                                
                                        <div class="row">
                                            <div class="col col-lg-2">
                                                <div class="form-group form-floating">
                                                    <input type="number" name="nummer" class="form-control editable" placeholder="Nummer">
                                                    <label>Nr</label>
                                                </div>
                                            </div>
                                            <div class="col col-lg-5">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="vorname" class="form-control editable" placeholder="Vorname" required value="Yusuf">
                                                    <label>Vorname</label>
                                                </div>
                                            </div>
                                            <div class="col col-lg-5">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="nachname" class="form-control editable" placeholder="Nachname" required value="Gördük">
                                                    <label>Nachname</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <br>

                                <div class="row">
                                    <div class="col col-lg-1 icon-col">
                                        <i class="fa-solid fa-map-marker-alt"></i>
                                    </div>
                                    <div class="col col-lg-11 input-col">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="strasse" class="form-control editable" placeholder="Straße" required value="Walahfridstr. 42">
                                                    <label>Straße</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-lg-4">
                                                <div class="form-group form-floating">
                                                    <select class="form-select init-quickselect" id="select-laender" name="laender" data-qs-name="laender" placeholder="Länder" required>
                                                        
                                                    </select>
                                                    <label>Länder</label>
                                                </div>

                                            </div>

                                            <div class="col col-lg-4">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="plz" class="form-control editable" placeholder="PLZ" required value="36043">
                                                    <label>PLZ</label>
                                                </div>

                                            </div>
                                            <div class="col col-lg-4">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="ort" class="form-control editable" placeholder="Ort" required value="Fulda">
                                                    <label>Ort</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                                <br>
                                <br>

                                <div class="row">
                                    <div class="col col-lg-1 icon-col">
                                        <i class="fa-solid fa-phone-alt"></i>
                                    </div>
                                    <div class="col col-lg-11 input-col">
                                        <div class="row">
                                            <div class="col col-lg 6">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="telefon" class="form-control editable" placeholder="Telefon" autocomplete="off" >
                                                    <label>Telefon</label>
                                                </div>
                                            </div>
                                            <div class="col col-lg 6">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="mobiltelefon" class="form-control editable" placeholder="Mobiltelefon" autocomplete="off" >
                                                    <label>Mobiltelefon</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <br>
                            
                                <div class="row">
                                    <div class="col col-lg-1 icon-col">
                                        <i class="fa-solid fa-mail-bulk"></i>
                                    </div>
                                    <div class="col col-lg-11 input-col">
                                        <div class="row">
                                            <div class="col col-lg-6">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="email" class="form-control editable" placeholder="E-Mail" autocomplete="off" >
                                                    <label>E-Mail</label>
                                                </div>
                                            </div>
                                            <div class="col col-lg-6">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="email_geschaeftlich" class="form-control editable" placeholder="E-Mail Geschäftlich" autocomplete="off" >
                                                    <label>E-Mail Geschäftlich</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <br>
                                <br>

                                <div id="mehr-anzeigen">
                                
                                    <div class="row">
                                        <div class="col col-lg-1 icon-col">
                                            <i class="fa-solid fa-calendar-alt"></i>
                                        </div>
                                        <div class="col col-lg-11 input-col">
                                            <div class="row">
                                                <div class="col col-lg-4">
                                                    <div class="form-group form-floating">
                                                        <input type="date" name="geburtstag" class="form-control editable" placeholder="Geburtstag" autocomplete="off" >
                                                        <label>Geburtstag</label>
                                                    </div>
                                                </div>
                                                <div class="col col-lg-4">
                                                    <div class="form-group form-floating">
                                                        <input type="date" name="eintrittsdatum" class="form-control editable" placeholder="Eintrittsdatum" autocomplete="off" >
                                                        <label>Eintrittsdatum</label>
                                                    </div>

                                                </div>
                                                <div class="col col-lg-4">
                                                    <div class="form-group form-floating">
                                                        <input type="date" name="austrittsdatum" class="form-control editable" placeholder="Austrittsdatum" autocomplete="off" >
                                                        <label>Austrittsdatum</label>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <br>

                                     

                                    <div class="row">
                                        <div class="col col-lg-1 icon-col">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                        <div class="col col-lg-11 input-col">
                                            <div class="row">
                                                <div class="col col-lg-4 mt-lg-4">
                                                    <div class="form-group form-floating-check">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input editable" id="aktiv" name="aktiv" value="1" />
                                                            <label class="form-check-label" for="aktiv">Aktiv</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col col-lg-4 mt-lg-4">
                                                    <div class="form-group form-floating-check">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input editable" id="auszubildender" name="auszubildender" value="1" />
                                                            <label class="form-check-label" for="auszubildender">Auszubildender</label>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col col-lg-4">
                                                    <div class="form-group form-floating">
                                                        <select class="form-select editable" name="geschlecht" placeholder="Anrede">
                                                            <option value="">bitte wählen</option>
                                                            <option value="H">Herr</option>
                                                            <option value="F">Frau</option>
                                                            <option value="D">Divers</option>
                                                        </select>
                                                        <label>Anrede</label>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>


                <div class="col-md-8">

                    <ul class="nav nav-tabs nav-fill mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active " id="pills-zugang" data-bs-toggle="pill" data-bs-target="#zugang" type="button" role="tab" aria-controls="zugang" aria-selected="true">Zugang</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-berechtigung" data-bs-toggle="pill" data-bs-target="#berechtigung" type="button" role="tab" aria-controls="berechtigung" aria-selected="false">Berechtigung</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link " id="pills-zeiten_urlaub" data-bs-toggle="pill" data-bs-target="#zeiten_urlaub" type="button" role="tab" aria-controls="zeiten_urlaub" aria-selected="false"> Zeiten / Urlaub</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="zugang" role="tabpanel" aria-labelledby="pills-zugang">

                            <div class="alert alert-warning" role="alert">
                                Weitere Funktion werden noch programmiert!
                            </div>
                            
                            

                        </div>
                        <div class="tab-pane fade " id="berechtigung" role="tabpanel" aria-labelledby="pills-berechtigung">
                            
                            <div class="alert alert-warning" role="alert">
                                Diese Funktion wird noch Programmiert!
                            </div>

                           

                            

                        </div>
                        <div class="tab-pane fade " id="zeiten_urlaub" role="tabpanel" aria-labelledby="pills-zeiten_urlaub">
                            <div class="alert alert-warning" role="alert">
                                Weitere Funktionen werden noch Programmiert!
                            </div>

                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>



<?php include('04_scripts.php'); ?>

<script>

    $(document).on('app:ready', function() {

        mtr_d.init();

    });



</script>

</html>