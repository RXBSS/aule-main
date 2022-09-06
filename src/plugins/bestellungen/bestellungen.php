<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-shopping-cart\"></i> Bestellungen",
    'breadcrumbs' => ['Prozesse']
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
            <div id="bestellungen-liste"></div>
        </div>
    </div>

    <div class="fab-container">
        <button class="btn btn-primary btn-sm fab-children btn-neue-bestellungen" data-label="Bestellung"><i class="fa-solid fa-plus"></i></button>
        <button class="btn btn-primary btn-sm fab-children btn-bestellvorschlag" data-label="Bestellvorschlag"><i class="fa-solid fa-plus"></i></button>
        <button class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
    </div>

    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-shopping-cart"></i> Neue Bestellung</h5>
                    <div class="actions"></div>
                </div>
                <div class="modal-body">
                    <form id="bestellungen-neu">
                        <div class="form-group form-floating">
                            <select class="form-select init-quickselect editable" data-qs-name="lieferanten" name="lieferant_id" placeholder="Lieferant" required>
                                <option value="">bitte wählen</option>
                            </select>
                            <label>Lieferant</label>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-floating">
                                    <input type="date" name="liefertermin" class="form-control editable" data-help="bestellungen-liefertermin" placeholder="Liefertermin" autocomplete="off">
                                    <label >Liefertermin</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-floating-check" data-bs-toggle="tooltip" data-bs-placement="left" title="Aktuell noch nicht programmiert">
                                    <label class="form-label" >Direktlieferung</label>
                                    <div class="form-check form-switch" >
                                        <input type="checkbox" class="form-check-input" id="direktlieferung" name="direktlieferung" value="1"  disabled />
                                        <label class="form-check-label" for="id">Ja</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>



</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        // Liste
        var list = new Picklist("#bestellungen-liste", "bestellungen");

        // list.setFilter(new PickFilter(3, ['Teillieferung','Entwurf', 'Offen'], 'in'));

        // Bestellvorschlag
        $('.btn-bestellvorschlag').on('click', function() {
            app.redirect('bestellvorschlag');
        });

        list.on('pick', function(el, data) {
            app.redirect('bestellung-details?id=' + data[1]);
        });

        // Form
        // ########################################


        var form = new ModalForm('#bestellungen-neu');

        form.initValidation();

        hotkeys('ctrl+e', function(event, handler) {
            event.preventDefault();
            form.open();
        });

        // Bestellungen
        $('.btn-neue-bestellungen').on('click', function() {
            form.open();
        });

        // On Submit Event Abfangen
        form.on('submit', function(e) {
            
            // Save
            form.save('create', 'bestellungen-handle', function(response) {
                app.redirect('bestellung-details?id=' + response.data);
            });

        });
    });
</script>

</html>