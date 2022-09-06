<?php include('01_init.php');

$_page = [
    'title' => "Admin Einstellungen"
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
                <div class="col-xl-4">
                    <div class="card card-form">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fas fa-envelope"></i> E-Mail-Einstellungen</h4>
                            <h6 class="subtext">Hier werden alle E-Mail Einstellungen festgelegt</h6>

                            <form id="email-form">

                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group form-floating">
                                            <input type="text" name="smtp-server" class="form-control editable" placeholder="SMTP-Server" autocomplete="nope" value="mail.buerosystemhaus.de">
                                            <label>SMTP-Server</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-floating">
                                            <input type="text" name="smtp-port" class="form-control editable" placeholder="Port" autocomplete="nope" value="25">
                                            <label>Port</label>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating-radio">
                                            <label class="form-label">Verschlüsselung</label><br>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="verschluesselung-1" name="name" value="false" checked>
                                                <label class="form-check-label" for="verschluesselung-1">Keine</label>
                                            </div>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="verschluesselung-2" name="name" value="ssl">
                                                <label class="form-check-label" for="verschluesselung-2">SSL</label>
                                            </div>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="verschluesselung-3" name="name" value="tls">
                                                <label class="form-check-label" for="verschluesselung-3">TLS</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating-check">
                                            <label class="form-label">Authentifizierung</label>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input editable" id="email-authentification-cb" name="authentification" value="1" />
                                                <label class="form-check-label" for="authentification">Eingeschaltet</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="email-authentification-active">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="user" class="form-control editable" placeholder="Benutzer" autocomplete="nope" >
                                            <label>Benutzer</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="password" name="password" class="form-control editable" placeholder="Passwort" autocomplete="nope" >
                                            <label>Passwort</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-floating">
                                    <input type="text" name="absender" class="form-control editable" placeholder="Absender (From)" autocomplete="nope" value="erp@buerosystemhaus.de" >
                                    <label>Absender (From)</label>
                                </div>

                                <div class="form-group form-floating">
                                    <input type="text" name="antwort" class="form-control editable" placeholder="Rücksende Adresse (Reply To)" autocomplete="nope" value="erp@buerosystemhaus.de">
                                    <label>Rücksende Adresse (Reply To)</label>
                                </div>
                            </form>
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

        var form = new CardForm('#email-form');

        form.initValidation();

        new ActivationCheckbox('#email-authentification-cb', [{
            el: '#email-authentification-active'
        }], form);

    });
</script>

</html>