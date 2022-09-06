var v_adressen = {

    initVertraegeAdressen() {

        var me = this;

        // Standardmäßig Hide
        $('#separate-lf-info').hide();

        // Initalisieren
        me.initFormAdressen();

        // Init Pickliste
        me.initPicklisteAdressen();

        // Adressen Neue
        me.initAdressen();

        // EventListener
        me.addEventListenerAdressen();

        // Load Nur Zu Beginn Der Seite
        me.loadFormAdressenStart();

        // Quickselect 
        me.initQuickselectAdressen();

        // Load Form
        // me.loadFormAdressen('start');

        // Id
        if (me.id) {

            // Action Items Hinzufügen -- Damit es oben bei den anderen Icons dabei ist
            // me.formAdresse.container.find('.actions').prepend('<a class="action-item" id="adressen-details-suchen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Suchen"><i class="fa-solid fa-search"></i></a>'
                // + '<a class="action-item" id="adressen-details-erstellen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Neu Erstellen"><i class="fa-solid fa-plus"></i></a>'
                // + '<a class="action-item" id="adressen-details-bearbeiten" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Editieren"><i class="fa-solid fa-address-card"></i></a>');

            // Tooltip Initliasieren
            me.formAdresse.container.find('[data-bs-toggle="tooltip"]').tooltip();

        }

    },




    initFormAdressen() {

        var me = this;

        // Karte der Adresse -- Vertragsnehmer
        me.formAdresse = new CardForm('#form-vertraege-adressen');
        me.formAdresse.initValidation();

    },


    initPicklisteAdressen() {

        var me = this;

        // Pickliste initalisieren -- Adressen hinzufügen
        me.picklistAdr = new PicklistModal("adressen", {
            type: 'single-picklist',
            quickPick: true,
            fixFilter: new PickFilter('ist_kunde', 1)
        });

    },

    initQuickselectAdressen() {

        var me = this;

        // me.qGeschaeftsfuehrer = new Quickselect('adressen', {

        //     // Der Selector muss zwangsläufig gesetzt werden
        //     selector: '#vertragsnehmer',
        // });

        // me.qGeschaeftsfuehrer.setFilter('mitarbeiter', 1, 'geschaeftsfuehrer');


    },

    addEventListenerAdressen() {

        var me = this

        // Wenn eine Änderungen im Select Vertragsnehmer genommen wird
        $('select[name="vn_adresse"]').on('change', function () {
            if (parseInt($(this).val()) > 0) {
                me.getAdressenData($(this).val());
            }
        });

        // Wenn eine Änderungen im Select Vertragsnehmer genommen wird
        $('select[name="lf_adresse"]').on('change', function () {
            if (parseInt($(this).val()) > 0) {
                me.getAdressenData($(this).val());
            }
        });

        // Wenn Die identische Lieferadresse Checkbox abgehakt wird
        me.formAdresse.container.find('input[name="lf_gleich_re"]').on('click', function () {

            // Wenn die Checkbox angehakt ist
            if($(this).prop('checked')) {
                me.getAdressenData($('select[name="vn_adresse"]').val())
                $('select[name="lf_adresse"]').removeClass('editable').attr('disabled', 'disabled');
            } else {
                me.resetLieferAdresse();
                $('select[name="lf_adresse"]').addClass('editable').removeAttr('disabled');
            }

        });


        // Wenn die Form Beendet wird dann Zurücksetzen auf den Standard
        me.formAdresse.container.on('end', function () {
            me.formAdresse.reset(2);
        });

        // Form Adresse Abschicken
        me.formAdresse.on('submit', function () {
            me.submitForm(me.formAdresse, 'vertraegeAdressenSubmit');

        });

        // Wenn über Pickliste eine Auswahl der Adresse getroffen wird
        me.formAdresse.container.on('click', '#adressen-details-suchen', function () {
            me.picklistAdr.open();
        });

        // Wenn eine Neue Adresse ersellt wird
        me.formAdresse.container.on('click', '#adressen-details-erstellen', function () {
            me.modalNeueAdresse.reset(1);
            me.modalNeueAdresse.open();
        });

        // Wenn ein Adresse Bearbeitet wird
        me.formAdresse.container.on('click', '#adressen-details-bearbeiten', function () {
            me.formAdresseEdit();
        });

        // Adressen on Pick -- Dann werden alle Daten in die card wieder eigesetzt
        me.picklistAdr.on('pick', function (el, data) {
            me.getAdressenData(data[1], false,);
        });

        // Wenn neue Adresse Abgeschickt werden soll
        me.modalNeueAdresse.on('submit', function () {
            me.submitNeueAdresse();
        });

    },

    getAdressenData(id) {

        var me = this;

        // Daten per API abfragen
        app.simpleRequest("get-adresse", "vertraege-handle.php", id, function (response) {
            me.setAdressenDataNew(response);
        });

    },

    setAdressenDataNew(res) {

        var me = this;

        var arr = [];

        // Checkbox
        if ($('input[name="lf_gleich_re"]').prop('checked')) {
            arr = ['vn', 'lf'];
        } else {
            arr = ['vn'];
        }

        // Schleife geht durch das Array durch und Fügt in die jeweiligen Felder den richtigen Wert
        $.each(arr, function (key, value) {

            var option = '<option value="' + res.data.id + '">' + res.data.name + '</option>'
            me.formAdresse.container.find('select[name=' + value + '_adresse]').html(option);
            me.formAdresse.container.find('input[name="' + value + '_strasse"]').val(res.data.strasse);
            me.formAdresse.container.find('input[name="' + value + '_land"]').val(res.data.de);
            me.formAdresse.container.find('input[name="' + value + '_plz"]').val(res.data.plz);
            me.formAdresse.container.find('input[name="' + value + '_ort"]').val(res.data.ort);

        });

    },

  
    // Neue Adresse Anlegen mit Callback
    submitNeueAdresse() {

        var me = this;

        // Optionen
        var options = {
            'modal': me.modalNeueAdresse,
        }

        // Wenn Editiert werden soll
        if (parseInt(me.adressenId) > 0) {

            me.modalNeueAdresse.save('adr-submit', 'adressen-handle.php',

                // Success
                function (response) {

                    // Erfolgsmeldung
                    app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                    // Modal wieder schließen
                    me.modalNeueAdresse.close();

                    // Modal zurücksetzen
                    me.modalNeueAdresse.reset(1);

                    me.getAdressenData(me.adressenId, false)

                }, null, { id: me.adressenId }

            )

            // Neue Adresse erstellen
        } else {

            // Open Dialog -- Abschicken der Ajax
            me.openDialog(options, function (response) {
                me.getAdressenData(response.data, false)
            });

        }

    },

    /**
     * Globale Submit Funktion die für alle Formen gilt
     */
    submitForm(form, task) {

        var me = this;

        form.save(task, 'vertraege-handle',

            // Success
            function (response) {
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");
            },

            null,

            // Additional
            {
                id: me.id
            }

        );

    },

    // Die Adresse Bearbeiten 
    formAdresseEdit() {

        var me = this;

        // Id die Ausgelesen werden soll
        me.adressenId = $('select[name="vn_adresse"]').val();

        // Modal Öffnen und Laden
        me.modalNeueAdresse.loadAndOpen('load', 'adressen-handle', me.adressenId, function (response) {

            // Set Select in Ländert
            var option = '<option value="' + response.data.land + '">' + response.data.land_text + '</option>'
            $('select[name=land]').html(option);

            // $('#authorisierer').blur();
        })
    },

    // Reset der Lieferadressen Felder
    resetLieferAdresse() {

        var me = this;

        // Create a DOM Option and pre-select by default
        var newOption = new Option('Bitte Wählen', '', true, true);

        // Reset
        me.formAdresse.container.find('#lieferadresse input').val('');
        me.formAdresse.container.find('#lieferadresse select').append(newOption).trigger('change');


    },




    // ***********************************************************************************
    // ***********************************************************************************
    // ***********************************************************************************
    // ***********************************************************************************
    // ***********************************************************************************


    // Dieser Load Funktion wird nur einmal zu beginn ausgführt beim Laden der Seiten
    loadFormAdressenStart() {

        var me = this;

        // Form Adresse Load
        me.formAdresse.load('loadAdressen', 'vertraege-handle', me.id,
            function (response) {
                // Wenn die Adressen Unterschiedlich sind dann soll die Checkbox nicht angehakt werden
                if (response.data.vertragsnehmerID != response.data.lieferadresseID) {
                    me.formAdresse.container.find('input[name="lf_gleich_re"]').prop('checked', false);
                
                    $('#separate-lf-info').show();

                }

            }
        );


    }



}