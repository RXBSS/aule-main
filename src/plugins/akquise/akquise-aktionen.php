<?php include('01_init.php');

$_page = [
    'title' => '<i class="fa-solid fa-handshake"></i> Akquise Aktionen',
    'breadcrumbs' => ['<i class="fa-solid fa-gears"></i> Prozesse', '<a href="akquise"> <i class="fa-solid fa-handshake"></i> Akquise</a>']
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
          
            <!-- Pickliste -->
            <div id="akquise-aktionen-pickliste"></div>
        </div>
    </div>


    <!-- FAB Button zum neu erstellen -->
    <div class="fab-container">
         <button class="btn btn-primary " id="btn-akquise-aktion-add"><i class="fa-solid fa-plus"></i></button>
    </div>

    <!-- Modal der Aktion -->
    <div class="modal" id="modal-akquise-aktion" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-add"></i> Neue Akquise hinzufügen</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
            </div>
            <div class="modal-body">



                <form id="form-akquise-aktionen">

                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="name" class="form-control editable" placeholder="Name der Aktion" autocomplete="off" required>
                                <div class="form-unit">Aktion</div>
                                <label>Name der Aktion</label>
                            </div>
                        </div>
                        <div class="col">

                             <div class="form-group form-floating-radio">
                                <label class="form-label">Status der Aktion</label><br>
                                <div class="form-radio form-check-inline">
                                    <input class="form-check-input editable" type="radio" id="entwurf" name="entwurf" value="0" required>
                                    <label class="form-check-label" for="entwurf">Entwurf</label>
                                </div>
                                <div class="form-radio form-check-inline">
                                    <input class="form-check-input editable" type="radio" id="aktiv" name="entwurf" value="1" required>
                                    <label class="form-check-label" for="aktiv">Aktiv</label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex">

                                <div class="form-group form-floating-check">
                                    <label class="form-label">Standard Meilensteine</label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input editable" id="standard_meilensteine" name="standard_meilensteine" value="1" />
                                        <label class="form-check-label" for="standard_meilensteine">Ja</label>
                                    </div>
                                </div>

                                <div class="flex-grow-1 standard-meilensteine">

                                    <div class="questionmark-info-date">
                                        <a href="javascript:void(0);" class="tooltip-standard" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Wird diese Checkbox angewählt werden zusätzlich die Standard-Meilensteine mitgenommen!">
                                            <i class="fa-solid fa-question-circle"></i>
                                        </a>
                                    </div>
                                </div>

                                
                            </div>
                             
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">

                            <input type="hidden" name="ersteller_id" value="<?php echo $_SESSION['user']['id'] ?>">

                            <div class="row">
                                <div class="col">
                                    <div class="form-group form-floating">
                                        <input type="date" name="zeitstempel" class="form-control editable" placeholder="Erstellt am" autocomplete="off" required>
                                        <label>Erstellt am</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col">

                            <div class="activation-input-container">
                                <div class="form-group form-floating-check">
                                    <label class="form-label"></label>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="cb-aktivieren" name="cb-aktivieren" >
                                        <label class="form-check-label" for="cb-aktivieren">Benutzerdef.</label>
                                    </div>
                                </div>
                                <div class="form-group form-floating">
                                    <input type="text" name="wiedervorlage_nach" class="form-control editable" placeholder="Wiedervorlage nach" value=" ">
                                    <div class="form-unit">Tage</div>
                                    <label>Wiedervorlage nach</label>
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

</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        // Do Something

        ak_aktion.init();
    });
</script>
</html>