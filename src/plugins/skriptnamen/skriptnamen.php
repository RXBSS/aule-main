<?php include('01_init.php');

$_page = [
    'title' => "Skript-Namen"
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
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-keyboard"></i> Namen-Generator</h4>

                            <form id="namegenerator">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-floating">
                                            <input type="text" name="businesspartner" class="form-control editable" placeholder="Business Partner" value="schaefer">
                                            <label>Business Partner</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-floating-check">
                                            <label class="form-label">Schäfer Common</label>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input editable" id="cb-common" name="common" value="1" />
                                                <label class="form-check-label" for="cb-common">Aktivieren</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-floating-check is-common">
                                            <label class="form-label">Neuer/Bendef. Kunde</label>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input editable" id="cb-neukunde" name="neukunde" value="1" />
                                                <label class="form-check-label" for="cb-neukunde">Aktivieren</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row is-common">
                                    <div class="col-md-4">
                                        <div id="container-neukunde" class="form-group form-floating">
                                            <input type="text" name="neukunde_name" class="form-control editable" placeholder="Kunde">
                                            <label>Kunde</label>
                                        </div>
                                        <div id="container-kein-neukunde" class="form-group form-floating">
                                            <select class="form-select init-select2 editable" name="kunde" placeholder="Kunde">
                                                <option value="">Bitte wählen</option>
                                                <option value="accu">Accu 24</option>
                                                <option value="antonius">Antonius</option>
                                                <option value="accu">Intern (BS)</option>
                                                <option value="becker">Paul Becker</option>
                                                <option value="roessner">Rößner</option>
                                                <option value="tadiran">Tadiran</option>
                                            </select>
                                            <label>Kunde</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row is-common">
                                    <div class="col-md-4">

                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="modul" class="form-control editable" placeholder="Modul">
                                                    <label>Modul</label>
                                                </div>
                                            </div>
                                            <div style="padding-top: 32px;padding-left:5px;">
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="right" title="Das Modul ist der betreffende Bereich. Zum Beispiel invoice oder contract. Hier kann auch ein eigner Name wie, qs oder verzollung genutzt werden"><i class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                    </div>
                                </div>


                                <hr>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group form-floating-radio">
                                            <label class="form-label">Komponente</label>
                                            <div class="form-radio">
                                                <input type="radio" class="form-check-input editable" id="komponente-ar" name="komponente" value="ar" />
                                                <label class="form-check-label" for="komponente-ar">All Rhino</label>
                                            </div>
                                            <div class="form-radio">
                                                <input type="radio" class="form-check-input editable" id="komponente-ix" name="komponente" value="ix" />
                                                <label class="form-check-label" for="komponente-ix">Indexserver</label>
                                            </div>
                                            <div class="form-radio">
                                                <input type="radio" class="form-check-input editable" id="komponente-as" name="komponente" value="as" />
                                                <label class="form-check-label" for="komponente-as">Automation Service</label>
                                            </div>
                                            <div class="form-radio">
                                                <input type="radio" class="form-check-input editable" id="komponente-wf" name="komponente" value="wf" />
                                                <label class="form-check-label" for="komponente-wf">Web Forms</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="komponenten-details" data-values="ix">
                                            <div class="form-group form-floating-radio">
                                                <label class="form-label">Sub-Komponente</label>
                                                <div class="form-radio">
                                                    <input type="radio" class="form-check-input editable" id="ix_sub-1" name="ix_sub" value="keine" />
                                                    <label class="form-check-label" for="ix_sub-1">Keine</label>
                                                </div>
                                                <div class="form-radio">
                                                    <input type="radio" class="form-check-input editable" id="ix_sub-2" name="ix_sub" value="actions" />
                                                    <label class="form-check-label" for="ix_sub-2">Actions</label>
                                                </div>
                                                <div class="form-radio">
                                                    <input type="radio" class="form-check-input editable" id="ix_sub-3" name="ix_sub" value="dynkwl" />
                                                    <label class="form-check-label" for="ix_sub-3">DynKwl</label>
                                                </div>
                                                <div class="form-radio">
                                                    <input type="radio" class="form-check-input editable" id="ix_sub-4" name="ix_sub" value="functions" />
                                                    <label class="form-check-label" for="ix_sub-4">Functions</label>
                                                </div>
                                                <div class="form-radio">
                                                    <input type="radio" class="form-check-input editable" id="ix_sub-5" name="ix_sub" value="services" />
                                                    <label class="form-check-label" for="ix_sub-5">Service</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="komponenten-details" data-values="as">
                                            <div class="form-group form-floating-radio">
                                                <label class="form-label">Sub-Komponente</label>
                                                <div class="form-radio">
                                                    <input type="radio" class="form-check-input editable" id="as_sub-1" name="as_sub" value="direct" />
                                                    <label class="form-check-label" for="as_sub-1">Direct</label>
                                                </div>
                                                <div class="form-radio">
                                                    <input type="radio" class="form-check-input editable" id="as_sub-2" name="as_sub" value="optional" />
                                                    <label class="form-check-label" for="as_sub-2">OptionalJSLibs</label>
                                                </div>
                                                <div class="form-radio">
                                                    <input type="radio" class="form-check-input editable" id="as_sub-3" name="as_sub" value="rules" />
                                                    <label class="form-check-label" for="as_sub-3">Rules</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="skriptname" class="form-control editable" placeholder="Skript-Name" autocomplete="off" autocomplete="nope">
                                                    <label>Skript Name</label>
                                                </div>
                                            </div>
                                            <div style="padding-top: 32px;padding-left:5px;">
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="right" title="Der Name sollte möglichst gut beschreiben und Camel-Case sein"><i class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Ergebnis</h4>
                            <div id="ergebnis"></div>
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

        var form = new Form("#namegenerator");


        new ActivationCheckbox('#cb-common', [{
            el: '.is-common',
            reverse: true
        }], form);

        new ActivationCheckbox('#cb-neukunde', [{
            el: '#container-neukunde'
        }, {
            el: '#container-kein-neukunde',
            reverse: true
        }], form);

        new ActivationMulti('input[name=komponente]', '.komponenten-details');


        form.on('change', function() {


            var data = form.getData();

            console.log(data);

            var s = [];

            // 
            s.push(data.businesspartner);

            if (data.common.checked) {
                s.push('common');
            } else {

                // 
                if (data.neukunde.checked) {
                    s.push(data.neukunde_name);
                } else {
                    s.push(data.kunde.value);
                }

                // Modul hinzufügen
                s.push((data.modul) ? data.modul : 'noModule');
            }


            // Komponenten
            if (data.komponente) {
                if (data.komponente != 'ar') {
                    s.push(data.komponente);

                    if (data.komponente == 'ix') {
                        if (data.ix_sub != 'keine' && data.ix_sub) {
                            s.push(data.ix_sub);
                        }
                    } else if (data.komponente == 'as') {
                        if (data.ix_sub != 'keine') {
                            s.push(data.ix_sub);
                        }
                    } else if (data.komponente == 'wf') {
                        if (data.ix_sub != 'keine') {
                            s.push(data.ix_sub);
                        }
                    }
                }
            }

            s.push((data.skriptname) ? data.skriptname : 'noName');

            // Ergebnis
            $('#ergebnis').html(s.join('.'));




        });

    });
</script>

</html>