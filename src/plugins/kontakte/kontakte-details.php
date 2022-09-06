<?php include('01_init.php');

$_page = [
    'title' => "Kontakte Details",
    'breadcrumbs' => ['Stammdaten', '<a href="kontakte"><i class="fa-regular fa-address-book"></i> Kontakte</a>']
];

// Alle Daten von Adressen mit dieser id
$kontakte = new Kontakte();
$data = $kontakte->get($_GET['id']);

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
    <link rel="stylesheet" href="../css/pagelevel/adressen-google.css">

</head>

<body>
    <?php include('03_navigation.php'); ?>

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-lg-4">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-user"></i> Kontakte Stammdaten</h4>

                            <!-- Form -->
                            <form id="form-kontakte">

                                <!-- HIDDEN -->
                                <!-- <input type="hidden" name="kontakte-id" id="kontakt-id" value="<?php echo $data['id'] ? $data['id'] : false ?>"> -->

                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="vorname" class="form-control editable" placeholder="Vorname">
                                            <label>Vorname</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="nachname" class="form-control editable" placeholder="Nachname">
                                            <label>Nachname</label>
                                        </div>
                                    </div>
                                </div>


                                <!-- TODO: im Feld muss Name stehen aber abgeschickt wird wieder die Idee -->
                                <!-- <div class="row">
                                    <div class="col">
                                        
                                        <div class="form-group form-floating">
                                            <input type="text" name="unternehmen" class="form-control editable" placeholder="Unternehmen">
                                            <label>Unternehmen</label>
                                        </div>
                                       
                                        <input type="hidden" name="adressen_id">
                                    </div>
                                    <div class="col col-lg-1 mt-lg-4">
                                        <a href="javascript:void(0);" id="pickliste-adressen-open">
                                            <i class="fa-solid fa-search"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="abteilung" class="form-control editable" placeholder="Abteilung">
                                            <label>Abteilung</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="funktion" class="form-control editable" placeholder="Funktion">
                                            <label>Funktion</label>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <input type="email" name="email" class="form-control editable" placeholder="Email">
                                            <label>Email</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="telefon" class="form-control editable" placeholder="Telefon">
                                            <label>Telefon</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="mobil" class="form-control editable" placeholder="Mobil">
                                            <label>Mobil</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-select2 editable" name="geschlecht" placeholder="Anrede">
                                                <option value="">bitte Wählen</option>
                                                <option value="H">Herr</option>
                                                <option value="F">Frau</option>
                                                <option value="D">Divers</option>
                                            </select>
                                            <label>Anrede</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-select2 editable" name="titel" placeholder="Titel">
                                                <option value="">bitte Wählen</option>
                                                <option value="Dr">Doktor</option>
                                                <option value="Dipl">Diplom</option>
                                                <option value="Meg.">Magister</option>
                                                <option value="Prof">Professor</option>
                                            </select>
                                            <label>Titel</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col col-lg-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" name="geburtstag" placeholder="Geburtstag">
                                            <label>Geburtstag</label>
                                        </div>
                                    </div>
                                    <div class="col col-lg-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="telefax" class="form-control editable" placeholder="Telefax" autocomplete="off">
                                            <label>Telefax</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <select class="form-select editable" name="kontosperre_grund" placeholder="Grund">
                                                <option value="">bitte wählen</option>
                                                <option value="stören">Stören</option>
                                                <option value="sicherheit">Sicherheit</option>
                                                <option value="mehr">Mehr Folgt</option>
                                            </select>
                                            <label>Grund</label>
                                        </div>
                                    </div>
                                </div>
                                

                            </form>
                        </div>
                    </div>

                </div>
                <div class="col col-lg-8">
                    <ul class="nav nav-tabs nav-fill mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-eigenschaften" data-bs-toggle="pill" data-bs-target="#eigenschaften" type="button" role="tab" aria-controls="eigenschaften" aria-selected="true">Eigenschaften</button>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-personen" data-bs-toggle="pill" data-bs-target="#personen" type="button" role="tab" aria-controls="personen" aria-selected="false">Personen</button>
                        </li> -->
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="eigenschaften" role="tabpanel" aria-labelledby="pills-eigenschaften">
                            
                            <!-- <p>Coming Soon Eigenschaften</p> -->

                            <div id="adressen-pickliste"></div>
                        
                        </div>
                        <!-- <div class="tab-pane fade" id="personen" role="tabpanel" aria-labelledby="pills-personen">
                            <p>Coming Soon Personen</p>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php include('./kontakte-details-modal.php') ?>
    <?php include('./adressen-neu-modal.php')  ?>
    
</body>



<?php include('04_scripts.php'); ?>

<script src="../js/pagelevel/kontakte-eigenschaften-details.js"></script>
<script src="../js/pagelevel/adressen-neu.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcz5vCR6GMcbQtHfK_ImcU3yQwgmAVfa8&libraries=places&v=weekly&channel=2&"></script>

<script>
    $(document).on('app:ready', function() {

        k_d.init()

        // 
        kde = Object.assign(adressen_neu, kde);
       
        // 
        kde.init();

    });
</script>

</html>