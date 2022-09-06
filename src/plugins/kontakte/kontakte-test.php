<?php include('01_init.php');

$_page = [
    'title' => "Kontakte"
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


            <h4>Adressen & Kontakte</h4>
            <p>
                In vielen Situation wird es im ERP-System notwendig sein, einen Kontakt anzulegen, zu bearbeiten, etc.<br>
                Meistens auch in Kombination mit einer Adresse. Deshalb sollte hier eine Standard-Lösung geschaffen werden!
            </p>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-users"></i> Kontakte</h4>
                            <h6 class="subtext">Kontakte müssen nicht zur Adresse gehören</h6>




                            <!-- Adressen -->
                            <div class="d-flex justify-content-between ">

                                <div class="form-group form-floating form-select2-multi-column flex-grow-1">
                                    <select class="form-select init-quickselect editable" id="adressen-1" name="adressen" placeholder="Adressen">
                                        <option value="">Bitte wählen</option>
                                    </select>
                                    <label>Adressen</label>
                                </div>

                                <div class="btn-group align-self-start pt-4 ps-2" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-edit"></i></button>
                                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-add"></i></button>
                                </div>
                            </div>

                            <!-- Kontakte -->
                            <div class="qs-buttons d-flex justify-content-between">

                                <div class="form-group form-floating form-select2-multi-column flex-grow-1">
                                    <select class="form-select init-quickselect editable" id="kontakte-1" name="kontakte" placeholder="Kontakte" multiple>
                                        <option value="">Bitte wählen</option>
                                    </select>
                                    <label>Kontakte</label>
                                </div>

                                <div class="btn-group align-self-start pt-4 ps-2" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary" data-action="link"><i class="fa-solid fa-link"></i></button>
                                    <button type="button" class="btn btn-primary" data-action="edit"><i class="fa-solid fa-edit"></i></button>
                                    <button type="button" class="btn btn-primary" data-action="add"><i class="fa-solid fa-add"></i></button>
                                </div>
                            </div>







                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-users"></i> Kontakte</h4>
                            <h6 class="subtext">Kontakte müssen zur Adresse gehören</h6>


                            <!-- Adressen -->
                            <div class="d-flex justify-content-between ">

                                <div class="form-group form-floating form-select2-multi-column flex-grow-1">
                                    <select class="form-select init-quickselect editable" id="adressen-2" name="adressen" placeholder="Adressen">
                                        <option value="">Bitte wählen</option>
                                    </select>
                                    <label>Adressen</label>
                                </div>

                                <div class="btn-group align-self-start pt-4 ps-2" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-edit"></i></button>
                                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-add"></i></button>
                                </div>
                            </div>

                            <!-- Kontakte -->
                            <div class="d-flex justify-content-between ">

                                <div class="form-group form-floating form-select2-multi-column flex-grow-1">
                                    <select class="form-select init-quickselect editable" id="kontakte-2" name="kontakte" placeholder="Kontakte" multiple>
                                        <option value="">Bitte wählen</option>
                                    </select>
                                    <label>Kontakte</label>
                                </div>

                                <div class="btn-group align-self-start pt-4 ps-2" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-edit"></i></button>
                                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-add"></i></button>
                                </div>
                            </div>







                        </div>
                    </div>
                </div>
            </div>








        </div>
    </div>
</body>

<?php include('./adressen-neu-modal.php')  ?>
<?php include('./kontakte-neu-modal.php')  ?>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        var form = new ModalForm('#kontakte-neu-modal-form');

        // Pasted
        form.getField('vorname').on('paste', function(e) {

            // Nur wenn noch nichts in dem Feld steht
            if (!$(this).val() && !form.getField('nachname').val()) {
                var text = e.originalEvent.clipboardData.getData('text');

                console.log(text);
                var array = text.trim().split(" ");

                if (array.length > 1) {
                    var nachname = array.pop();
                    form.getField('nachname').val(nachname);
                    $(this).val(array.join(' '));

                    form.getField('email').focus();

                    return false;
                }


            }
        });

        // Quickselect - Adressen
        var q1 = new Quickselect('default', {
            selector: '#adressen-1',
            table: 'adressen',
            fields: 'name',
            primary: 'id'
        });


    


        // Quickselect - Kontakte
        var q2 = new Quickselect('kontakte2', {
            selector: '#kontakte-1',
        });

        q2.on('action', function(el, action, value, buttonEl) {
            console.log('Action');

            if (action == 'link') {
                console.log(el);
                if(buttonEl.hasClass('btn-primary')) {
                    buttonEl.removeClass('btn-primary').addClass('btn-outline-success');
                } else {
                    buttonEl.removeClass('btn-outline-success').addClass('btn-primary');
                }
            } else {
                form.open();
            }


        });


        q2.setData(2);

        // Quickselect - Adressen
        var q3 = new Quickselect('adressen', {
            selector: '#adressen-2'
        });

        // Quickselect - Kontakte
        var q4 = new Quickselect('kontakte', {
            selector: '#kontakte-2'
        });




    });
</script>

</html>