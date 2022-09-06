<?php include('01_init.php');

$_page = [
    'title' => "Zählerstand Mockup"
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>

    <style>
        #test td {
            vertical-align: middle;
            border-bottom: 1px solid #ddd;
        }


        #test td:first-child {
            text-align: center;
            font-size: 18pt;
        }
    </style>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">


            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fa-solid fa-gauge"></i> Zählerstand-Abfrage am <?php echo date('d.m.Y'); ?></h4>
                    <h6 class="subtext">Bitte tragen Sie unter Aktuell die Zählerstände zu dem Gerät ein. Alternativ können Sie auch die Zählerinformationen als PDF anhängen.</h6>


                    <br>

                    <form id="test">
                        <table id="test" class="table table-borderd">
                            <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Gerät</th>
                                    <th>Zählerstand</th>
                                    <th style="text-align:center;">Hochladen</th>
                                    <th>Anleitung</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-1"><i class="fa-solid fa-hourglass-empty text-warning"></i></td>
                                    <td class="col-2">
                                        <strong>Develop Ineo +251</strong><br>
                                        1234 #A0ED1234355<br>
                                        1.OG Buchhaltung<br>

                                    </td>
                                    <td class="col-4">

                                        <i class="fa-solid fa-circle"></i> Schwarz / Weiß<br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="value1" class="form-control editable more-readable test1" placeholder="Bezeichnung" autocomplete="nope" value="106.506" disabled>
                                                    <label>Letzer</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-floating label-info">
                                                    <input type="text" name="value2" class="form-control editable more-readable test2" placeholder="Bezeichnung" autocomplete="nope" value="" required>
                                                    <label>Aktuell</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="value3" class="form-control editable more-readable test3" placeholder="Bezeichnung" autocomplete="nope" value="" disabled>
                                                    <label>Differenz</label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <i class="fa-solid fa-circle" style="color: #00FFFF; padding-right: 2px;"></i><i class="fa-solid fa-circle" style="color: #FF00FF;padding-right: 2px;"></i><i class="fa-solid fa-circle" style="color: #FFFF00;"></i> Farbe<br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="value4" class="form-control editable more-readable test1" placeholder="Bezeichnung" autocomplete="nope" value="56.158" disabled>
                                                    <label>Letzer</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-floating label-info">
                                                    <input type="text" name="value5" class="form-control editable more-readable test2" placeholder="Bezeichnung" autocomplete="nope" value="" required>
                                                    <label>Aktuell</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="value6" class="form-control editable more-readable test3" placeholder="Bezeichnung" autocomplete="nope" value="" disabled>
                                                    <label>Differenz</label>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-3" style="text-align: center;"><em style="color: #aaa;">kein Dokument</ems><br><br>
                                            <button class="btn btn-primary"><i class="fa-solid fa-cloud-arrow-up"></i> Hochladen</button></td>
                                    <td>
                                        <button class="btn btn-primary"><i class="fa-brands fa-youtube"></i> Video</button><br><br>
                                        <button class="btn btn-primary"><i class="fa-solid fa-book"></i> Anleitung</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-1"><i class="fa-solid fa-hourglass-empty text-warning"></i></td>
                                    <td class="col-2">
                                        <strong>Lexmark M5155</strong><br>
                                        5678 #27989595<br>
                                        Versandbüro<br>

                                    </td>
                                    <td class="col-4">

                                        <i class="fa-solid fa-circle"></i> Schwarz / Weiß<br>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="value7" class="form-control editable more-readable test1" placeholder="Bezeichnung" autocomplete="nope" value="985.945" disabled>
                                                    <label>Letzer</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-floating label-info">
                                                    <input type="text" name="value8" class="form-control editable more-readable test2" placeholder="Bezeichnung" autocomplete="nope" value="" required>
                                                    <label>Aktuell</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="value9" class="form-control editable more-readable test3" placeholder="Bezeichnung" autocomplete="nope" value="" disabled>
                                                    <label>Differenz</label>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="col-3" style="text-align: center;"><em style="color: #aaa;">kein Dokument</ems><br><br>
                                            <button class="btn btn-primary"><i class="fa-solid fa-cloud-arrow-up"></i> Hochladen</button></td>
                                    <td>
                                        <button class="btn btn-primary"><i class="fa-brands fa-youtube"></i> Video</button><br><br>
                                        <button class="btn btn-primary"><i class="fa-solid fa-book"></i> Anleitung</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>




                        <br><br>
                        <div class="form-group form-floating-check">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input editable" id="id" name="name" value="option1">
                                <label class="form-check-label" for="id">Hiermit bestätige ich, dass ...</label>
                            </div>
                        </div>

                        <button class="btn btn-primary">Absenden</button>
                    </form>


                </div>
            </div>







        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {




        var form = new Form('#test');


        var fields = {
            value2: {
                validators: {
                    notEmpty: {
                        message: 'Wert Eingeben',
                    },
                    greaterThan: {
                        min: 106506,
                        message: 'Wert zu niedrig',
                    },
                },
            },
            value5: {
                validators: {
                    notEmpty: {
                        message: 'Wert Eingeben',
                    },
                    greaterThan: {
                        min: 56158,
                        message: 'Wert zu niedrig',
                    },
                },
            },
            value8: {
                validators: {
                    notEmpty: {
                        message: 'Wert Eingeben',
                    },
                    greaterThan: {
                        min: 985945,
                        message: 'Wert zu niedrig',
                    },
                },
            }
        }

        form.initValidation(fields);


        $('.test2').on('keyup', function() {
            var el = $(this);
            var input = parseInt(el.closest('.row').find('.test1').val().split('.').join(''));

            var thisValue = (el.val()) ? parseInt(el.val()) : 0;

            el.closest('.row').find('.test3').val(thisValue - input);

        });

    });
</script>

</html>