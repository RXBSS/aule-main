var v_stammdaten = {

    initVertraegeStammdaten() {

        var me = this;

        // Standardmäßig Hide
        $('#authorisierte_person, #kunden_unterschrift').hide();

        // Init der Form
        me.initFormStammdaten();

        // Kontakte Init 
        me.initKontakteNeu();

        // Quickselect
        me.initQuickselectStammdaten();

        // Load Form
        me.loadFormStammdaten(function (res) {
            // me.vorlagenOnChangeEvent();

            // AddEvents Listner
            me.addEventListenerStammdaten();
        });



    },

    // Init der Form
    initFormStammdaten() {

        var me = this;

        // Karte der Stammdaten des Vertrags
        me.formStammdaten = new CardForm('#form-vertraege-stammdaten');
        me.formStammdaten.initValidation();

    },

    initQuickselectStammdaten() {

        var me = this;

        // Vertrags Vorlagen
        me.quickVertragsVorlagen = new Quickselect('default', {
            selector: '#vertrags_vorlagen',
            table: 'vertraege_vorlagen',
            fields: ['bezeichnung'],
            primary: 'id'
        });


        // **************************************************************
        // Kunde Unterschrift
        // **************************************************************
        me.qKunde = new Quickselect('adressen_kontakte', {

            // Der Selector muss zwangsläufig gesetzt werden
            selector: '#authorisiert',
        });

        // Filter setzen
        me.qKunde.setFilter('adressen_kontakte', me.id, 'kontakte_id_vertraege');


    },

    // Laden der Daten
    loadFormStammdaten(callback) {

        var me = this;

        // Form Adresse Load
        me.formStammdaten.load('loadStammdaten', 'vertraege-handle', me.id,
            function (response) {
                // me.setAdressenData(response);

                callback(response)
            }
        );
    },

    // Events
    addEventListenerStammdaten() {

        var me = this;

        // Wenn die Stammdaten Formular abgeschickt wird
        me.formStammdaten.on('submit', function () {
            me.submitStammdaten();
        });

        // 
        me.formStammdaten.container.on('click', '.btn-form-discard', function () {
            me.formStammdaten.discard();
        });


        // Wenn ein neuer Vertrag ausgewählt wird
        me.formStammdaten.container.on('input', 'select[name="vorlagen_id"]', function () {
            if (parseInt($(this).val()) > 0) {
                me.changeVorlage($(this).val());
            }
        });

        // Wenn ein neuer Kontakt hinzugefügt werden soll
        me.formStammdaten.container.on('click', '.button-kontakt-hinzufuegen', function () {
            if (me.formAdresse.getData().vn_adresse.value > 0) {
                me.modalneuerKontakt.open();
                me.modalneuerKontakt.container.find('input[name="adressen_id"]').val(me.formAdresse.getData().vn_adresse.value)
            } else {
                app.notify.info.fire("Vertragsnehmer", "Sie müssen zunächst einen Vertragsnehmer auswählen!");
            }
        });

        // Wenn neuer Kontakt abgeschickt werden soll
        me.modalneuerKontakt.on('submit', function () {
            me.submitNeuerKontakt();
        });

        // Wenn die Form Editiert wird
        me.formStammdaten.container.on('click', '.btn-form-edit', function () {
            me.formStammdaten.container.find('.button-kontakt-hinzufuegen').removeClass('pointer-none');
        });

        // Wenn die Form Beenden wird -- Auch mit Event End möglich
        me.formStammdaten.container.on('click', '.btn-form-discard', function () {
            me.formStammdaten.container.find('.button-kontakt-hinzufuegen').addClass('pointer-none');
        });

        // Wenn Kunden Unterschrift gesetzt wird
        me.formStammdaten.container.on('click', 'input[name="kunden_unterschrift"]', function() {
            me.dialogKundenUnterschrift($(this));
        });

    },


    // Wenn ein neuer Kontakt erstell wird über die Akquise
    submitNeuerKontakt() {

        var me = this;

        var options = false;
        
        // OpenDialog --- Abschicken von Ajax mit einem Callback
        me.openDialogKontakteNeu(options, function (response) {

            // me.loadFormStammdaten();

            // Die Adresse Auch den Adressen Kontakten hinzufügen
            app.simpleRequest("getAdressenKontakt", "kontakte-handle", response.data,

                // Success
                function (responseNeuerKontakt) {
                    // console.log(responseNeuerKontakt);

                    me.formStammdaten.enable();

                    // Hinzufügen
                    me.qKunde.setData(responseNeuerKontakt.data.id, responseNeuerKontakt.data.vorname + " " + responseNeuerKontakt.data.nachname)


                },

                // Error
                function (xhr) {

                }

            );



        });

    },

    // Ändert die Kunden Unterschrift -- Stzt auf Ja da oder Nicht da
    dialogKundenUnterschrift(element) {

        var me = this;

        // Dialog
        app.alert.question.fire("Kunden Unterschrift?","Wenn die Kundenunterschrift vorhanden ist, kann dieser Haken angehakt werden, andernfalls sollte dies nicht getan werden. <br> Diesen Vorgang kann man nicht Rückgängig machen!")
            .then((result) => {

                // Wenn Ja 
                if(result.isConfirmed) {
                    me.submitKundenUnterschrift();
                } else {

                    // Reset was es beim Neuladen der Seite hatte
                    me.formStammdaten.container.find('input[name="kunden_unterschrift"]').prop('checked', false);

                }
            });
        
        ;


    },

    submitKundenUnterschrift() {

        var me = this;

        // ajax
        app.simpleRequest("kundenUnterschrift", "vertraege-handle", me.id, 
        
            // Success
            function(response) {
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
            
                // Lädt diverse Daten neu
                me.loadVertrag();
            }
            
        );

    },

    // Submit der Stammdaten
    submitStammdaten() {

        var me = this;

        // Save Funktion
        me.formStammdaten.save('submitStammdaten', 'vertraege-handle',

            // Success
            function (response) {

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // Form Laden
                me.loadVertrag();

                // Modal wieder schließen
                // me.modalNeueAdresse.close();

                // Modal zurücksetzen
                // me.modalNeueAdresse.reset(1);

                // me.getAdressen(me.adressenId)

            }, null, { id: me.id }

        )

    },

    // Vorlage Wechseln
    changeVorlage(vorlageId) {

        var me = this;

        // Dialog Abfragen ob man wirklich ändern will, weil dann alle Klauseln geändert werden müssen
        app.alert.question.fire("Vorlage wechseln?", "Sind Sie sich das Sie die Vorlage ändern wollen? Somit werden alle Klausel in dem Vertrag abgeändert.")

            .then((result) => {

                // Wenn Ja
                if (result.isConfirmed) {

                    var additional = {
                        'id': me.id,
                        'vorlagenId': vorlageId
                    }

                    // Löschen der Klauseln der Aktuellen Vorlage im Vertrag und neue Klauseln hinzufügen
                    app.simpleRequest("changeVorlage", "vertraege-handle", additional,

                        function (response) {
                            app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                            // Klauseln Preview Neu Laden
                            me.loadKlauselnWithGroups();

                            // Pickliste auch neu Laden
                            me.vertraegeKlauseln.refresh(true);

                        }, null);

                } else {
                    me.formStammdaten.reset(0);

                }


            });

    }


}