<?php include('01_init.php');

$_page = [
    'title' => "Template"
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
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-key"></i> Eintrag</h4>
                            <h6 class="subtext">Dies ist ein neuer Eintrag</h6>

                            <form id="test">

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group form-floating">
                                            <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope">
                                            <label>Bezeichnung</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-select2 editable" name="art" placeholder="label">
                                                <option value="">Bitte wählen</option>
                                                <option value="">Login</option>
                                                <option value="">Datenbank</option>
                                                <option value="">Bitte wählen</option>
                                            </select>
                                            <label>Art</label>
                                        </div>
                                    </div>
                                </div>                            
                                <div class="form-group form-floating">
                                    <input type="text" name="name" class="form-control editable" placeholder="Benutzername / E-Mail" autocomplete="nope">
                                    <label>Benutzername / E-Mail</label>
                                </div>

                                <div class="form-group form-floating">
                                    <input type="password" name="name" class="form-control editable" placeholder="Benutzername / E-Mail" autocomplete="nope">
                                    <label>Passwort</label>
                                </div>

                                <div class="form-group form-floating">
                                    <input type="text" name="url" class="form-control editable" placeholder="URL" autocomplete="nope">
                                    <label>URL / Zugang</label>
                                </div>

                                <div class="form-group form-floating-check">
                                    <label class="form-label">2 Faktor Authentifizierung</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input editable" id="id" name="id" value="1" />
                                        <label class="form-check-label" for="id">Aktiviert</label>
                                    </div>
                                </div>

                                <div class="form-group form-floating">
                                    <textarea class="form-control editable" name="name" placeholder="Bezeichnung"></textarea>
                                    <label>Beschreibung</label>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-user"></i> Berechtigung</h4>
                            <p>
                                Hier steht die Berechtigung 
                            </p>                 
                    
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-users"></i> Zuordnung</h4>
                            <p>
                                Hier steht drin, welchem Kunden / Lieferanten / IDNR etc. dies zugeordnet ist
                            </p>                 

                            <div class="form-group form-floating">
                                <select class="form-select init-select2 editable" name="name" placeholder="label">
                                    <option value="">Bitte wählen</option>
                                </select>
                                <label>Kunde</label>
                            </div>

                            <div class="form-group form-floating">
                                <select class="form-select init-select2 editable" name="name" placeholder="label">
                                    <option value="">Bitte wählen</option>
                                </select>
                                <label>Lieferant</label>
                            </div>

                            <div class="form-group form-floating">
                                <select class="form-select init-select2 editable" name="name" placeholder="label">
                                    <option value="">Bitte wählen</option>
                                </select>
                                <label>Liste</label>
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

        var form = new CardForm('#test');
    });
</script>

</html>