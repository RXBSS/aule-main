var v_d = {

    init() {


        var me = this;

        // Additional
        me.id = app.getUrlId();

        // Die Datei in der alle Standard-Abfrage verarbeitet werden
        me.handler = "vertraege-handle";

        // Standard Mäßig Ausblenden des Selectes Kalendarium
        $('#zaehler-kalendarium, #pauschale-kalendarium').hide();



        // Ausbelnden der Lieferadresse
        // $('#tab-btn-adresse-2').hide();

        // Initalisieren des Status
        me.status = 0;
        me.subStatus = 0;

        // Id
        if (me.id) {

            // Initalisieren
            me.initForm();

            // Action Items Hinzufügen
            me.formAdresse.container.find('.actions').prepend('<a class="action-item" id="adressen-details-suchen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Suchen"><i class="fa-solid fa-search"></i></a>'
                + '<a class="action-item" id="adressen-details-erstellen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Neu Erstellen"><i class="fa-solid fa-plus"></i></a>'
                + '<a class="action-item" id="adressen-details-bearbeiten" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Editieren"><i class="fa-solid fa-address-card"></i></a>');

            // ------------ GET DATa HEWRE -----------

            // Adressen Neue
            // me.initAdressen();

            // Init Modal
            // me.initModal();

            // Init Quickselect
            // me.initQuickselect();

            // Init Pickliste
            // me.initPickliste();

            // Init Aktivation
            // me.initAktivation2();

            // 
            // me.getData(me.id, function (res) {
            //     me.checkKuendigung(res);

            //     // Lädt die Vorschau
            //     me.loadVertragPDF();

            //     // Schleife geht Alle Inputs Durch und Schreib das richtige an die Data Unit Stelle
            //     $('select.set-data-unit').each(function () {
            //         me.setLaufzeitInterval($(this));
            //     })

            //     // Lädt die Abrechnungstabelle
            //     me.loadAbrechnungTable();
            // });

            // init Summernote
            // me.initSummernote();

            // // Init Quickselect
            // me.initQuickselect();

            // Card Resize
            new CardSizer(['#card-adressen', '#card-stammdaten', '#status-1']);
            new CardSizer(['#card-adressen', '#card-stammdaten', '#status-2-0']);

            // // Standardmäßig immer Hide 
            // $('#benutzerdefinierte-klausel-card').hide();

            // me.initAdr();


            // Daten auslesen
            // me.getData(me.id, function (response) {

            //     me.initAdr();
            //     me.initPos();

            //     // Status ändern
            //     me.changeStatus(response.status);

            //     // Card Sizer aktivieren
            // });
        }

        // Positionen Init
        // me.initPos(); 

        // Adressen Init 
        // me.initAdr();

        // Form
        // me.initForm();

        // Vertrags Status
        // me.vertragStatus();

        // EventListener
        // me.addEventListener();

        // EventListener
        me.addEventListener2();


    },

    // Quickselect
    initQuickselect() {

        var me = this;

        // **************************************************************
        // Geschäftsführer
        // **************************************************************
        me.qGeschaeftsfuehrer = new Quickselect('mitarbeiter', {

            // Der Selector muss zwangsläufig gesetzt werden
            selector: '#authorisierer',
        });

        // Filter setzen
        me.qGeschaeftsfuehrer.setFilter('mitarbeiter', 1, 'geschaeftsfuehrer');


        // **************************************************************
        // Kunde Unterschrift
        // **************************************************************
        me.qKunde = new Quickselect('adressen_kontakte', {

            // Der Selector muss zwangsläufig gesetzt werden
            selector: '#authorisiert',
        });

        // Filter setzen
        me.qKunde.setFilter('adressen_kontakte', me.id, 'kontakte_id_vertraege');


        // **************************************************************
        // Kündigungs Auftraggeben
        // **************************************************************
        me.qKuendigung = new Quickselect('adressen_kontakte', {

            // Der Selector muss zwangsläufig gesetzt werden
            selector: '#kuendigung-auftraggeber',
        });

        // Filter setzen
        me.qKuendigung.setFilter('adressen_kontakte', me.id, 'kontakte_id_vertraege');


        // Vertrags Vorlagen
        me.quickVertragsVorlagen = new Quickselect('default', {
            selector: '#vertrags_vorlagen',
            table: 'vertraege_vorlagen',
            fields: ['bezeichnung'],
            primary: 'id'
        });

    },

    initForm() {

        var me = this;

        // Karte der Adresse -- Vertragsnehmer
        me.formAdresse = new CardForm('#form-vertraege-adressen');
        me.formAdresse.initValidation();

        // Karte der Stammdaten des Vertrags
        me.formStammdaten = new CardForm('#form-vertraege-stammdaten');
        me.formStammdaten.initValidation();

        // Karte der Laufzeiten der Vertäge
        me.formLaufzeiten = new CardForm('#card-laufzeiten');
        me.formLaufzeiten.initValidation();

        // Karte der Abrechnung
        me.formKosten = new CardForm('#card-kosten');
        me.formKosten.initValidation();



        // Neue Form
        // me.form = new Form('#vertraege-form');

        // // Form Validation initalisieren
        // me.form.initValidation();

        // // Validierung ausschalten
        // me.enableDisableValidator(false);

        // // Form
        // me.form.on('invalid', function () {
        //     app.notify.error.fire("Fehler", "Einige Felder sind noch nicht vollständig ausgefüllt.");
        // });


    },

    // init Modal
    initModal() {

        var me = this;

        me.modal = new ModalForm('#modal-adressen-form');
        me.modal.initValidation();

        // Vertrag Kündigen Modal
        me.modalKuendigen = new ModalForm('#vertrag-kuendigen-form');
        me.modalKuendigen.initValidation();


    },

    // Aktivation der Checkbox Laufzeiten
    initAktivation2() {

        var me = this;

        // Pauschale Aktivattion
        new ActivationCheckbox('#pauschale', '.pauschale-body', me.form);

        // Gesamtpauschale Aktivattion
        new ActivationCheckbox('#gesamtpauschale', '.gesamtpauschale-body', me.form);

        // Zähler Aktivattion
        new ActivationCheckbox('#zaehler', '.zaehler-body', me.form);



        // ************************************************************
        // Kündigungsfrist Aktivation
        // ************************************************************
        me.kuendigungsfrist = new ActivationCheckbox('#kuendigungsfrist',
            [
                {
                    el: '.kuendigungsfrist-body'
                },
                {
                    el: '.kuendigungsfrist-body'
                }
            ], me.form);

        // ************************************************************
        // Verlängerung Aktivation
        // ************************************************************
        me.verlaengerung = new ActivationCheckbox('#verlaengerung',
            [
                {
                    el: '.verlaengerung-body'
                },
                {
                    el: '.verlaengerung-body'
                },
                {
                    el: '#kuendigung_frist',
                    child: me.kuendigungsfrist
                }
            ], me.form);


        // // ************************************************************
        // // Laufzeit Aktivation
        // // ************************************************************
        me.laufzeit = new ActivationCheckbox('#laufzeit',
            [
                {
                    el: '.laufzeit-body'
                },
                {
                    el: '.laufzeit-body'
                },
                {
                    el: '#verlaengerung_kuendigung_ebene',
                    child: me.verlaengerung
                }
            ], me.form);

    },

    // Summernote
    initSummernote() {

        var me = this;

        // Summernote im Editieren Block
        $('textarea[name=text]').summernote({
            height: 100,
            minHeight: null,
            maxHeight: null,
            focus: true,
            lang: 'de-DE',

            // Callbacks
            callbacks: {
                onPaste: function () {
                    app.notify.success.fire("Erfolgreich", "Erfolgreich reinkopiert");
                }
            },

            // Toolbar
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['font', ['strikethrough']],
                ['para', ['ul', 'ol']],
                ['codeview'],
                ['Insert', ['picture', 'link']]
            ],
        });

    },





    initPickliste() {

        var me = this;

        // Pickliste initalisieren -- Adressen hinzufügen
        me.picklistAdr = new PicklistModal("adressen", {
            type: 'single-picklist',
            quickPick: true,
            fixFilter: new PickFilter('ist_kunde', 1)
        });

        // Pickliste der Klauseln Vertraege -- Übersicht von allen die hinzugefügt worden sind
        me.vertraegeKlauseln = new Picklist('#vertraege-klauseln-pickliste', 'vertraege_klauseln_vertraege', {
            type: "multi-picklist",
            autoDeselect: false,
            pagination: false,
            addButtons: [
                {
                    action: "add",
                    class: "add",
                    icon: "fa-solid fa-plus",
                    id: "add",
                    tooltip: "Gruppen Hinzufügen",
                    pos: 2
                },
                {
                    action: "btn-klausel-delete",
                    class: "btn-klausel-delete",
                    icon: "fa-solid fa-trash",
                    tooltip: "Löschen Klausel",
                    show: 'onSelected',
                    pos: 3
                }
            ],
            data: me.id
        });

        // Pickliste Modal mit dem man neue Klauseln hinzufügen kann
        me.paragraphenList = new PicklistModal('vertraege_klauseln', {
            type: "multi-picklist",
            config: {
                file: 'config-overwrite.json',
            },
            autoDeselect: false,
            disabled: {
                query: {
                    table: 'vertraege_klauseln_vertraege',
                    field: 'klausel_id',
                    filter: {
                        vertraege_id: me.id
                    }
                },
                icon: '<i class="fa-solid fa-check-double text-primary"></i>'
            },
            data: 'only_aktiv'
        });

        me.listPositionen = new Picklist('#pickliste-positionen', 'vertraege_positionen', {
            type: "multi-picklist",
            card: false,
            data: me.id,
            addButtons: [
                {
                    action: "btn-positionen-delete",
                    class: "btn-positionen-delete",
                    icon: "fa-solid fa-trash",
                    tooltip: "Löschen Positionen",
                    show: 'onSelected',
                    pos: 3
                }
            ],
        });

    },

    addEventListener2() {

        var me = this;

        // Form Adresse Abschicken
        // me.formAdresse.on('submit', function () {

        //     console.log("On Click");
        //     me.submitForm(me.formAdresse, 'vertraegeAdressenSubmit');
        // });

    },

    /**
     * Globale Submit Funktion die für alle Formen gilt
     */
    submitForm(form, task) {

        var me = this;

        // Wenn die Form Valide ist
        form.fvInstanz.validate().then(function (status) {

            if (status == 'Valid') {

                console.log("Form Save");


                form.save(task, 'vertraege-handle', 
                
                    // Success
                    function (response) {
                        app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
                    }, 
                    null, 

                    // Additional
                    {
                        id: me.id
                    }
                    
                );


            }

        });

    },


    addEventListener() {


        var me = this;

        // ***************************************************************************
        // Standard Events
        // ***************************************************************************

        // Suchen
        $('#adressen-details-suchen').on('click', function () {
            if (!$(this).hasClass('disabled')) {
                me.picklistAdr.open();
            }
        });

        // Erstellen
        $('#adressen-details-erstellen').on('click', function () {
            if (!$(this).hasClass('disabled')) {
                me.modalNeueAdresse.open(); // Google Adressen
            }
        });

        // Bearbeiten
        $('#adressen-details-bearbeiten').on('click', function () {
            if (!$(this).hasClass('disabled')) {
                me.adrEdit();
            }
        });

        // Wenn Datum sich ändert oder Laufzeit
        $('input[name="vertragsbeginn"], #laufzeit, #verlaengerung, #kuendigungsfrist').on('change', function () {
            me.setVertragsende();
        });

        // Wenn Laufzeit, Vertragslaufzeit, Kündigungslaufzeit sich ändert soll sich das Feld automatisch anpassen
        $('input[name="laufzeit"], input[name="kuendigungsfrist_laufzeit"], input[name="verlaengerung_laufzeit"]').on('keyup', function () {
            me.setVertragsende();
        });

        // ***************************************************************************
        // Form Handler Events
        // ***************************************************************************

        // Auftrag erstellen
        me.form.container.on('click', '.btn-vertrag-erstellen', function () {
            me.vertragErstellen();
        });

        // Entwurf löschen
        me.form.container.on('click', '.btn-entwurf-loeschen', function () {
            me.entwurfLoeschen();
        });

        // Entwurf speichern
        me.form.container.on('click', '.btn-entwurf-speichern', function () {
            me.entwurfSpeichern();
        });

        // Wenn eine Position Gespeichert werden soll
        me.form.container.on('click', '.btn-positionen-speichern', function () {
            me.submitPositionen();
        });

        // Unterschrift erstellen
        me.form.container.on('click', '.unterschrift-test', function () {
            app.alert.info.fire("Info...", "Diese Funktion wird noch programmiert <img src='https://media.giphy.com/media/QMHoU66sBXqqLqYvGO/giphy.gif' width='450' />");
        });

        // Wenn Unbefristet An und Abgehakt wird
        // me.form.container.on('change', 'input[name="cb-aktivieren"]', function() {
        //     me.unbefristetVertrag($(this).is(':checked'));
        // });


        // Wenn Interval Select eine andere Auswahl getroffen wird
        me.form.container.on('change', 'select.set-data-unit', function () {
            me.setLaufzeitInterval($(this));
        });

        // Wenn ein Anwahl getroffen wird
        me.vertraegeKlauseln.on('selection', function (key, value) {
            me.markKlausel(value);
        });

        // Wenn die Auswahl Kalendarium getroffen wird soll das jeweilige Kalendarium angezeigt werden ansonsten nicht
        me.form.container.on('change', 'select[name="pauschale_abrechnung_interval"], select[name="zaehler_abrechnung_interval"]', function () {
            if ($(this).val() == 'K') {
                $('#' + $(this).data('kalendarium')).show();
            } else {
                $('#' + $(this).data('kalendarium')).hide();
            }

        });

        // 
        // me.form.on('submit', function() {
        //     me.form.save('v-submit', "vertraege-handle");
        // });

        // Adressen on Pick
        me.picklistAdr.on('pick', function (el, data) {

            // Adressen
            me.adrSet(data[1]);
        });

        // Erstellen -- Abschicken
        // Wenn neue Adresse Abgeschickt werden soll
        me.modalNeueAdresse.on('submit', function () {
            me.submitNeueAdresse();
        });

        // Submit Modal
        me.modal.on('submit', function () {
            me.adrSubmit();
        });

        // Wenn eine neue Version erstellt werden soll
        me.form.container.on('click', '.btn-vertrag-neue-version', function () {
            me.vertragVersionNeu();
        });

        // Modal Vertrag Kündigen Öffnen
        me.form.container.on('click', '.btn-vertrag-kuendigen', function () {
            me.modalKuendigen.open();
        });

        // Wenn das Modal Kündigen Abgeschickt wird
        me.modalKuendigen.on('submit', function () {
            me.submitKuendigen();
        })

        // Wenn in der Pickliste ein Paragraph hinzugefügt werden soll 
        me.vertraegeKlauseln.container.on('click', '.add', function () {
            me.paragraphenList.open();
        });

        // Wenn in der Paragraphen List etwas hinzugefügt werden soll
        me.paragraphenList.on('pick', function (el, data) {
            me.addKlauselnVertraege(data);
        });

        // Wenn aus der Liste ein Paragraph gelöscht werden soll
        me.vertraegeKlauseln.container.on('click', '.btn-klausel-delete', function () {
            // me.deleteKlausel();

            new simpleDeleteTask(me.vertraegeKlauseln, 'deleteVertragKlausel', 'vertraege-handle');
        });

        // Wenn BenutzerDefinierte Klausel Aktiv ist
        me.form.container.on('click', '#benuzterdefinierter-vertrag', function () {
            if ($(this).is(':checked')) {
                $('#benutzerdefinierte-klausel-card').show();
            } else {
                $('#benutzerdefinierte-klausel-card').hide();
            }
        });

        // Wenn in der Positionen Liste eine Auswahl getroffen wurde
        me.listPositionen.on('selection', function (el, data) {
            me.editPositionen(data);
        });

        // Wenn eine neue Benutzerdefinierte Klausel hinzugefügt werden soll
        me.form.container.on('click', '.btn-benutzerdefinierte-klausel', function () {
            app.notify.info.fire("Info...", "Das wird noch programmiert!");
        });

        // Wenn in der Positionsliste eine Option gelöscht werden soll 
        me.listPositionen.container.on('click', '.btn-positionen-delete', function () {
            me.deletePositionen();
        });

        // Wenn die Abrechnung Card abgeschickt werden soll
        me.form.container.on('click', '.abrechnung-abschicken', function () {
            me.abrechnungSubmit();
        });


    },

    // Wenn die Abrechnung Card abgeschickt wird
    abrechnungSubmit() {

        var me = this;

        // Ajax Save funktion das Formular abschicken
        me.form.save('abrechnungSubmit', 'vertraege-handle',

            // Success
            function (response) {

                console.log(response);

                // 
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // Abrechnung Tabelle Laden
                me.loadAbrechnungTable();

            },

            // Error
            function (response) {

                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            },

            // Additional
            {
                id: me.id,
                abrechnungID: $('input[name="vertragsAbrechnungID"]').val()
            }

        )

    },

    // Kündigung wird abgeschickt
    submitKuendigen() {

        var me = this

        // Ajax mit der Save funktion
        me.modalKuendigen.save('submitKuendigen', 'vertraege-handle',

            // Success
            function (response) {

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // Seite Neu Laden
                me.getData(me.id, function (res) {
                    me.checkKuendigung(res)
                });

            },

            // Error
            function (response) {
                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            },

            // Additional
            {
                id: me.id
            }

        )

    },


    /**
     * Funktion zum Speichern der Adressen
     */
    adrSubmit() {

        var me = this;

        // Save Funktion um das Modal zu Speichern
        me.modal.save('adr_d-submit', 'adressen-handle',

            // Success
            function (response) {
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // 
                me.adrSet(me.adrID);

            },

            // Error
            function (response) {
                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            },

            // Additonal
            {
                id: me.adrID
            }

        )

    },

    /**
     * Funktion zum Editieren der Adresse die dann direkt gespeichert wird 
     * 
     */
    adrEdit() {

        var me = this;

        // Id die Ausgelesen werden soll
        me.adrID = $('select[name="vn_adresse"]').val();

        // Modal Öffnen und Laden
        me.modal.loadAndOpen('load', 'adressen-handle', me.adrID, function (response) {

            // Set Select in Ländert
            var option = '<option value="' + response.data.land + '">' + response.data.land_text + '</option>'
            $('select[name=land]').html(option);

            // $('#authorisierer').blur();
        })

    },


    // setzt Die Ausgewählt Adresse
    adrSet(id) {

        var me = this;

        // Daten per API abfragen
        app.simpleRequest("get-adresse", "vertraege-handle.php", id, function (result) {

            // Wenn der Kunde Gesperrt ist 
            if (result.data.kunde_gesperrt == 1) {
                $('#rechnungsempfaenger-ist-gesperrt').show();
            } else {
                $('#rechnungsempfaenger-ist-gesperrt').hide();
            }

            // Daten setzen
            var option = '<option value="' + result.data.id + '">' + result.data.name + '</option>'
            me.form.container.find('select[name="vn_adresse"]').html(option);
            me.form.container.find('input[name="strasse"]').val(result.data.strasse);
            me.form.container.find('input[name="plz"]').val(result.data.plz);
            me.form.container.find('input[name="ort"]').val(result.data.ort);
            me.form.container.find('input[name="land"]').val(result.data.land);

        });
    },

    // Lädt die Adressen
    loadAdresse(id, callback) {

        var me = this;

        // Lädt mit Ajax die gewünschte Adresse
        app.simpleRequest("load", "adressen-handle", id,

            // Success
            function (response) {

                callback(response);

            }

        );

    },

    // Fügt einem Vertrag neue Klauseln hinu
    addKlauselnVertraege(data) {

        var me = this;

        // Additional data
        var additional = {
            'data': data,
            'id': me.id
        }

        // mit Ajax Formular abschicken
        app.simpleRequest("addKlauselnVertraege", "vertraege-handle", additional,

            // Success
            function (response) {

                // Liste Neu Laden
                me.vertraegeKlauseln.refresh(true);
                me.paragraphenList.refresh(true);

                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // PDF Neu Laden
                me.loadVertragPDF();
            },

            // Error
            function () {
                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }

        );


    },

    // Positionen Delete
    deletePositionen() {

        var me = this;

        // Via Ajax Senden
        new simpleDeleteTask(me.listPositionen, 'deletePositionen', 'vertraege-handle');

    },

    // Wenn eine Position Editiert werden soll
    editPositionen(data) {

        var me = this;

        me.positionenID = "";

        // Nur wenn die Länge 1 ist soll Editiert werden können Ansonsten immer Submit
        if (Object.keys(data).length == 1) {

            // Positionen ID überschrieben damit man Unterscheiden kann zwischen Submit New und Submit Edit
            me.positionenID = me.listPositionen.getSelectedSingle()[1];

            // Via Ajax die Daten holen
            app.simpleRequest("editPositionen", "vertraege-handle", me.positionenID,

                // Daten werden hier geschrieben
                function (response) {

                    me.form.container.find('input[name="beschreibung"]').val(response.data.beschreibung)
                    me.form.container.find('input[name="pauschale"]').val(response.data.pauschale)


                }
            );

        } else if (Object.keys(data).length > 1 || Object.keys(data).length < 1) {

            me.form.container.find('input[name="beschreibung"]').val('')
            me.form.container.find('input[name="pauschale"]').val('')

            // Positionen ID überschrieben damit man Unterscheiden kann zwischen Submit New und Submit Edit
            me.positionenID = "";
        }


    },

    // Neue Position hinzufügen
    submitPositionen() {

        var me = this;

        // Via Ajax die Daten versenden
        me.form.save('submitPositionen', 'vertraege-handle',

            // Success
            function (response) {

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // Neu Laden der Liste
                me.listPositionen.refresh(true);

            },

            // Error
            function (response) {

                // 
                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin");

            },

            // Additional
            {
                id: me.id,
                positionenID: me.positionenID
            }

        )


    },

    // Wenn der Vertrag Erstellt und Aktiv werden soll
    vertragErstellen() {

        var me = this;

        // Validierung einschalten
        me.enableDisableValidator(true);

        var getData = me.form.getData();

        // Löscht die Stelle mit dem Key Datatable... 
        delete getData['DataTables_Table_1_length']
        delete getData['DataTables_Table_2_length']
        delete me.getDataForm['DataTables_Table_1_length']
        delete me.getDataForm['DataTables_Table_2_length']

        // Speichern
        me.form.fvInstanz.validate().then(function (status) {
            if (status == 'Valid') {

                // Wenn Nicht geändert Wurde
                if (JSON.stringify(getData) == JSON.stringify(me.getDataForm)) {

                    // Abfrage ob Gespeichert werden soll
                    app.alert.question.fire("Aktiv Stellen", "Wollen Sie den Vertrag Aktivieren? Nach diesem Vorgang können Sie den Vertrag nicht mehr bearbeiten!")

                        .then((result) => {

                            // Wenn Ja 
                            if (result.isConfirmed) {

                                // Save Funktion Ajax
                                me.form.save('vertragErstellen', 'vertraege-handle',

                                    // Success
                                    function (response) {
                                        app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                                        me.getData(me.id, function (res) { });
                                    },

                                    // Error
                                    function () {
                                        app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                                    },

                                    // Additional
                                    {
                                        id: me.id
                                    }
                                );

                            }

                        });

                    // Meldung aufzeigen das etwas geändert wurde und die Form erst gespeichert werden muss
                } else {
                    app.notify.warning.fire("Änderung", "Sie haben die Form verändert. Bitte speichern Sie zunächst den Entwurf bevor Sie fortfahren!");
                }

            } else {

                app.notify.warning.fire("Warnung", "Sie können den Vertrag nicht auf Aktiv setzen solange nicht alle nötigen Felder gefüllt sind");

            }


        });

    },



    // Wenn der Entwurf gelöscht werden soll
    entwurfLoeschen() {

        var me = this;

        // Dialog und Fragen ob wirklich gelöscht werden soll
        app.alert.success.fire("Löschen?", "Wollen Sie den Vertragsentwurf wirklich löschen? Diesen Vorgang kann man nicht mehr Rückgängig machen")
            .then((result) => {

                // Wenn Ja geklickt wird
                if (result.isConfirmed) {

                    // Ajax
                    app.simpleRequest("entwurf-loeschen", me.handler, me.id,

                        // Success
                        function (response) {

                            app.alert.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst. Sie werden weitergeleitet").then(function () {
                                app.redirect("vertraege");
                            });

                        },

                        // Error
                        function (xhr) {
                            app.notify.error.fire("Fehler", "Der Vertrag konnte nicht gelöscht werden. Bitte wenden Sie sich an den Admin!");
                        }

                    );

                }

            });

    },

    // Wenn der Entwurf gespeichert werden soll
    entwurfSpeichern() {

        var me = this;

        // Data das mitgegeben wird 
        var data = {
            data: me.form.getData()
        }

        // Save Funktion
        me.form.save('entwurf-speichern', me.handler,

            // Success
            function (response) {

                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // Daten Neu Laden
                me.getData(me.id, function (res) { })

                // Validierung zurücksetzne
                me.form.reset(2);

            },

            // Error
            function (xhr) {
                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            },

            // Additional
            {
                id: me.id
            }

        )

        // Ajax
        // app.simpleRequest("entwurf-speichern", me.handle, me.id, 

        //     // Success
        //     function(response) {

        //         console.log(response);

        //         app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

        //     },

        //     // Error
        //     function(xhr) {
        //         app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
        //     }

        // );

    },



    // Holt den Status des Vertrages
    vertragStatus() {

        var me = this;

    },

    // Vertrag Adressen Ändern
    vertragAdressen() {

        var me = this;

    },

    // 
    setVertragsende() {

        var me = this;

        // 
        var formEl = me.form.container


        // Vertragsende nur setzen wenn es eine Laufzeit gibt 
        if (formEl.find('input[name="laufzeit"]').val() != '') {


            // Intervall der Vertragslaufzeit
            var intervalVertragslaufzeit = formEl.find('select[name="laufzeit_interval"]').val();

            // Enddatum des Vertrags
            var endDatumVertrag = moment($('input[name="vertragsbeginn"]').val()).add($('input[name="laufzeit"').val(), intervalVertragslaufzeit);

            // Vertragsende in das Input feld schreiben
            formEl.find('input[name="vertragsende"]').val(endDatumVertrag.subtract(1, 'days').format('DD.MM.YYYY')).blur();


            // Objekte mit den Name der Input Felder
            var inputFelder = {
                'kuendigung': ['verlaengerung_laufzeit', 'verlaengerung_laufzeit_interval', 'verlaengerung_ende'],
                'verlaengerung': ['kuendigungsfrist_laufzeit', 'kuendigungsfrist_laufzeit_interval', 'kuendigungsfrist_ende']
            }


            // Schleife geht durch alle Werte
            $.each(inputFelder, function (key, value) {

                // Wenn es einen Wert im Inputfeld (verlaengerung || kündigung)_laufzeit gibt
                if (formEl.find('input[name="' + value[0] + '"]').val() != '') {

                    // Nimmt den Interval Wert aus dem Select (verlaengerung || kündigung)_laufzeit_interval -- (Tag, Monat oder Jahr)
                    var newInterval = formEl.find('select[name="' + value[1] + '"]').val();

                    // Nimmt das Enddatum des Vertrages und Addiert die Laufzeit die in dem Inputfeld (verlaengerung || kündigung)_laufzeit steht mit dem newInterval
                    var finalDate = moment(endDatumVertrag).add($('input[name="' + value[0] + '"]').val(), newInterval).format('DD.MM.YYYY')

                    // Schreibt das Finale Datum in das Inputefeld (verlaengerung || kündigung)_ende
                    formEl.find('input[name="' + value[2] + '"]').val(finalDate).blur();

                }
            });
        }

        // Set Status Bar
        me.setStatusBar();
    },

    // setzt den Status Balken der Laufzeiten richtig
    setStatusBar() {

        var me = this;

        // Daten auslesen
        var laufzeit = $('#laufzeit').prop('checked');
        var verlaengerung = $('#verlaengerung').prop('checked');
        var kuendigungsfrist = $('#kuendigungsfrist').prop('checked');

        // Vertragsdaten Progressbar
        var unbefristetDatum = moment(me.form.container.find('input[name="vertragsbeginn"]').val()).format('DD.MM.YYYY');
        var befristetDatum = unbefristetDatum + ' - ' + me.form.container.find('input[name="vertragsende"]').val();
        var verlaengerungDatum = me.form.container.find('input[name="verlaengerung_ende"]').val();
        var kuendigungsfristDatum = me.form.container.find('input[name="kuendigungsfrist_ende"]').val();

        // Die Wert müssten hier natürlich noch dynamisch ausgelesen werden
        var cases = [
            [100, unbefristetDatum, 0, '', 0, ''], // Nur Unbefristet
            [100, befristetDatum, 0, '', 0, ''], // Nur Befristet
            [80, befristetDatum, 0, '', 20, verlaengerungDatum], // Befristet und Verlängerung
            [60, befristetDatum, 20, kuendigungsfristDatum, 20, verlaengerungDatum], // Befristet, Verländerung und Kündigung
        ];

        // Aktueller Wert
        var current = (laufzeit && verlaengerung && kuendigungsfrist) ? 3 : ((laufzeit && verlaengerung) ? 2 : (laufzeit) ? 1 : 0);

        // Setzen der Progress bar
        $('#vertraege-progress-bar').find('[data-id=laufzeit]').width(cases[current][0] + "%").html(cases[current][1]);
        $('#vertraege-progress-bar').find('[data-id=verlaengerung]').width(cases[current][2] + "%").html(cases[current][3]);
        $('#vertraege-progress-bar').find('[data-id=kuendigungsfrist]').width(cases[current][4] + "%").html(cases[current][5]);


    },

    // Validierung Beliebig ein und ausschalten
    enableDisableValidator(trigger) {

        var me = this;

        var arr = ['vn_adresse', 'vertragsbeginn'];



        // Schleife geht durch alle Felder durch
        $.each(arr, function (key, value) {

            // Wenn der Trigger True ist dann Validierung einschalten
            if (trigger) {
                me.form.fvInstanz.enableValidator(value);
            }


            // Wenn der Trigger false ist dann Validierung ausschalten
            else if (!trigger) {
                me.form.fvInstanz.disableValidator(value);
            }

        });

        // Wenn die Checkbox unbefristet Angehakt ist dann brauch man keine Laufzeit mehr
        if ($('#cb-aktiv').is(':checked')) {

            // Validierung für die Laufzeit ausschalten wenn die Checkbox gecheckt ist
            me.form.fvInstanz.disableValidator('laufzeit');
        }

    },

    // Neue Vertrags Version erstellen
    vertragVersionNeu() {

        var me = this;

        // Dialog ob Wirklich gelöscht werden will
        app.alert.question.fire("Neue Version", "Wollen Sie eine neue Version dieses Vertrages veröffentlichen?")
            .then((result) => {

                // Wenn Bestäigt wird
                if (result.isConfirmed) {

                    // Via Ajax verschicken und neue Version aktivieren
                    app.simpleRequest("vertragVersionNeu", "vertraege-handle", me.id,

                        // Success
                        function (response) {

                            app.alert.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst. Sie werden weitergeleitet").then(function () {
                                app.redirect("vertraege-details.php?id=" + response.data);
                            });

                        },

                        // Error 
                        function (response) {

                            // Meldung
                            app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

                        }

                    );

                }

            });
    },

    // Funktion die Handel ob Befristet oder Unbefristet Vertrag
    unbefristetVertrag(el) {

        var me = this;


        // Wenn True (Angehakt) oder Laufzeit Leer ist
        if (el) {

            // me.form.container.find('input[name="cb-aktivieren"]').prop('checked', true);
            me.form.container.find('input[name="laufzeit"], select[name="laufzeit_interval"]').removeClass('editable').attr('disabled', 'disabled');
            me.form.container.find('input[name="vertragsende"], input[name="laufzeit"], select[name="laufzeit_interval"], #laufzeit_interval').hide();
            me.form.container.find('select[name="laufzeit_interval"]').val('');
            me.form.container.find('input[name="laufzeit"]').val('');


        } else {

            // me.form.container.find('input[name="cb-aktivieren"]').prop('checked', false);
            me.form.container.find('input[name="laufzeit"], select[name="laufzeit_interval"]').addClass('editable').removeAttr('disabled');
            me.form.container.find('input[name="vertragsende"], input[name="laufzeit"], select[name="laufzeit_interval"], #laufzeit_interval').show();
            me.form.container.find('select[name="laufzeit_interval"]').val('M');

            // me.setVertragsende();
        }

    },

    // Funtkion die den Format data Unit verändert und das Datum neu setzt
    setLaufzeitInterval(el) {

        var me = this;

        // Setzt Das Datum neu
        me.setVertragsende();

        $('#' + el.data('selector-unit')).html('').html(el.find(":selected").text());


        // Nur Wenn der Value Nicht Leer ist -- Also Bitte Wählen nicht reinschreiben sonst steht es auch drin
        // if($('select[name="laufzeit_interval"]').val() != '') {

        //     // Data Unit wird neu gesetzt
        //     $('#laufzeit_interval').html('').html($('select[name="laufzeit_interval"]').find(":selected").text());
        // }


    },


    // Lädt eine Vorschau der Klauseln
    loadVertragPDF() {

        var me = this;

        // Wenn das Objekt nicht leer ist
        if (me.id > 0) {

            // Daten die mitgegeben werden zum auslesen
            var additional = {
                vertraegeart_id: me.id,
                // vertraegeVorlage: me.list.getSelectedColumn(1)
            }

            // GetData aus Der Form 
            var getData = me.form.getData();

            var adressenData = me.loadAdresse(getData.vertragsnehmer.value, function (res) {

                // Setzt die Daten in den Vertragsnehmer Part ein in der Vorschau
                $('.vertragsnehmer').html(""
                    + res.data.name + "<br>"
                    + res.data.strasse + "<br>"
                    + res.data.land + "- " + res.data.plz + " " + res.data.ort
                    + "")

            });

            // TODO: Alle anderen Daten müssen wir noch gucken
            // Setzt den Vertragsbeginn in die Vorschau
            $('.vertragsbeginn').html("Vertragsbeginn " + moment(getData.vertragsbeginn).format('DD.MM.YYYY'))

            // Vertragsnehmer richtig setzen

            // Ajax Abfrage über die Vertragsart_id (me.id) und Vertragsgruppen_id (in data) in der Klauseln DB
            app.simpleRequest("getKlauselnVertraege", "vertraege-handle", me.id,

                // Success
                function (response) {

                    // Wenn eine Rückgabe zurück kommen
                    if (response.data.length) {

                        // HTML DOM erstmal Löschen
                        $('#paragraphen-klauseln').html("");

                        // // Leere Gruppen Objekt
                        var gruppen = {}

                        var count = 1;

                        // Geht Die Schleife durch alle Objekte Durch
                        $.each(response.data, function (el, value) {

                            // Wenn das Element größer als 1 ist -- weil 1 - 1 = 0 und Position 0 gibt es nicht (Fehlermeldung sonst)
                            if (el >= 1) {

                                // Wenn das Objekt an der Aktuellen Stelle die selbe Gruppe ist wie der vorgänger
                                if (value['bezeichnung'] == response.data[el - 1]['bezeichnung']) {

                                }

                                // Ansonten schreibe es in ein Neues Objekt
                                else {
                                    gruppen[el] = value['bezeichnung'].replace(/ /g, "_").replace(",", "").toLowerCase();
                                    // 
                                    $('#paragraphen-klauseln').append("<div class='" + value['bezeichnung'].replace(/ /g, "-").replace(",", "").toLowerCase() + "'> <b> § " + count + " " + value['bezeichnung'] + " </b> <ul class='unorder-list'></ul> </div>")

                                    // Counter Hochzählen
                                    count++;
                                }

                            }

                            // Für alle Werte die Kleiner als 1 sind
                            else {
                                gruppen[el] = value['bezeichnung'].replace(/ /g, "_").replace(",", "").toLowerCase();

                                // 
                                $('#paragraphen-klauseln').append("<div class='" + value['bezeichnung'].replace(/ /g, "-").replace(",", "").toLowerCase() + "'> <b> § " + count + " " + value['bezeichnung'] + " </b> <ul class='unorder-list'></ul> </div>")

                                // Counter Hochzählen
                                count++;
                            }

                        });

                        // Vertrage Klausel GRUPPEN
                        var myValues = {
                            ausnahmen_der_wartung: "Ausnahmen der Wartung",
                            gerichtsstand: "Gerichtsstand",
                            inhalte_der_mietpauschale: "Inhalte der Mietpauschale",
                            inhalte_der_wartung: "Inhalte der Wartung",
                            pflichten_des_kunden: "Pflichten des Kunden",
                            sichere_außerbetriebnahme_von_druckern_kopierern_und_multifunktionsgeräte: "Sichere Außerbetriebnahme von Druckern, Kopierern und Multifunktionsgeräte",
                            sondervereinbarungen: "Sondervereinbarungen",
                            zahlungsverzug: "Zahlungsverzug",
                        }

                        // Schleife geht durch alle Daten durch
                        $.each(response.data, function (key, value) {

                            // Sucht die Paragraphen aus den MyValues
                            if (myValues[value['bezeichnung'].replace(/ /g, "_").replace(",", "").toLowerCase()]) {

                                // Sucht das DOM Element und fügt den Text der Unordered list hinzu
                                $('#paragraphen-klauseln').find("div." + value['bezeichnung'].replace(/ /g, "-").replace(",", "").toLowerCase() + " .unorder-list").append("<li data-klausel='" + value['klausel_id'] + "'>" + value['text'] + "</li>")

                            }

                        });

                    }

                },

                // Error
                function (response) {

                    // Wenn es keine Daten gibt
                    // if(!response.data[0]) {

                    //     app.notify.info.fire("Info","Für die ausgewählte Gruppe, wurde im Vertrag, noch keine Klausel angelegt!");

                    // // Keine Auswahl
                    // } else {
                    app.notify.warning.fire("Warnung", "Es wurde keine Auswahl getroffen!");
                    // }


                }

            );

            // Keine Auswahl getroffen
        } else {

            // HTML DOM erstmal Löschen
            $('#paragraphen-klauseln').html("");

            app.notify.warning.fire("Warnung", "Es wurde keine Auswahl getroffen!");

        }


    },

    // Wenn eine Auswahl getroffen wurde soll dieser angemarkt werden
    markKlausel(data) {

        var me = this;

        // Alle li erstmal Normalisieren
        $('#paragraphen-klauseln').find('li').css('font-weight', 'normal')


        // Schleife geht durch die Values der Pickliste Selection 
        $.each(data, function (key, value) {

            // Alle ausgewählten Klauseln bekommen bold Style
            $('#paragraphen-klauseln').find('li[data-klausel="' + value[3] + '"]').css('font-weight', 'bold')

        });

    },

    // Eine Klausel rausslöschen
    deleteKlausel() {

    },


    /**
    * Daten des Angebots auslesen
    */
    getData(id, callback) {

        var me = this;

        // Daten holen!
        me.form.load("load", me.handler, id,

            // Success
            function (response) {

                // Wenn der Kunde Gesperrt ist 
                if (response.data.kunde_gesperrt == 1) {
                    $('#rechnungsempfaenger-ist-gesperrt').show();
                } else {
                    $('#rechnungsempfaenger-ist-gesperrt').hide();
                }

                // Liste Dynamisch Erstellen mit der version
                $('.status-unorder-list').html(''
                    + '<li>Vorschau <a href="javascript:void(0);" data-document="ag" class="btn-print-preview">Vertrag</a></li>'
                    + '<li> Das ist die ' + response.data.version + '. Version</li>'
                )

                // Wenn der Status Entwurf ist
                if (response.data.status_id == '1') {
                    me.form.container.find('#status-1').show();
                    me.form.container.find('#status-2-0').hide();

                }

                // Wenn der Status Aktiv ist
                else if (response.data.status_id == '2') {
                    me.form.container.find('#status-2-0').show();
                    me.form.container.find('#status-1').hide();
                    me.form.container.find('.status-header').html("<i class='fa-solid fa-hourglass'></i>  Der Status ist Aktiv")
                    me.form.setReadonly(true);
                    me.listPositionen.setReadonly(true);

                    // Kunde hat den Vertrag schon unterschrieben
                    var kundeAuthorisiertText = ((response.data.sachbearbeiterkunde_id.value) ? "Vertrag ist Authorisiert. <br> <b> Die Kundenunterschrift ist vorhanden. </b> " : "Vertrag ist nicht Authorisiert. <br> <b> Die Kundenunterschrift fehlt im Vertrag. </b>")
                    me.form.container.find('.status-unorder-list').html("<li> " + kundeAuthorisiertText + " </li>")

                    // Laufzeiten Trigger Readonly setzen
                    // $('#automatische-verlaengerung, #kuendigung_frist, .laufzeit-body').read(true);

                }

                // var unbefristet = false;

                // // Wenn es keine Laufzeit gibt
                // if(response.data.laufzeit == null || response.data.laufzeit == '') {
                //     $('input[name="cb-aktivieren"]').prop('checked', true);
                //     unbefristet = true;
                // }

                var activationValue = {
                    'laufzeit-trigger': response.data.laufzeit,
                    'verlaengerung-trigger': response.data.verlaengerung_laufzeit,
                    'kuendigungsfrist-trigger': response.data.kuendigungsfrist_laufzeit,
                    'pauschale': response.data.pauschale_abrechnung_interval,
                    'gesamtpauschale-trigger': response.data.gesamtpauschale_preis,
                    'zaehler': response.data.zaehler_abrechnung_interval
                };

                console.log(me.form.getData());

                var data = me.form.getData();

                // Schleife geht durch das Objekt durch
                $.each(activationValue, function (key, value) {

                    // Wenn das Input oder der Select einen Wert hat -> dann soll die Checkbox gesetzt sein
                    if (value) {

                        // console.log(key);

                        var text = key['checked'];

                        console.log(data[key]['checked']);

                        data[key]['checked'] = true;

                        me.form.setFieldData(key, true);
                    }
                });


                // if (response.data.verlaengerung_laufzeit) {
                me.form.setData({
                    'verlaengerung-trigger': true
                });
                // }


                // Wenn die Laufzeit leer ist
                // me.unbefristetVertrag(unbefristet);

                // 
                me.setVertragsende();

                me.getDataForm = me.form.getData();

                callback(response);

            },

            // Error
            function (a) {

                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin");

                // $('#form-auftrag').hide();

                // app.alert.error.fire("Fehler beim Aufrufen", "Der Auftrag den Sie aufrufen wollten konnte nicht gefunden werden. Sie werden weitergeleitet").then(function () {
                //     app.redirect("vertraege");
                // });
            }
        );

    },

    // Prüft ob die Kündigung in Ordnung ist
    checkKuendigung(res) {

        var me = this;

        // Nur Wenn Gekündigt Wurde
        if (res.data.gekuendigt == '1') {


            // 
            var kuendigungText = "";

            // Vertragende aus der Laufzeit
            var vertragsEndeLaufzeit = me.form.container.find('input[name="vertragsende"]').val();

            // Vertragsende Kunde
            var vertragsEndeKunde = moment(res.data.gekuendigt_am).format('DD.MM.YYYY');

            // Checked ob das Kündigungsdatum identisch mit dem ist was der Kunde angegeben hat
            if (vertragsEndeKunde != vertragsEndeLaufzeit) {

                kuendigungText = "<b> Die Kündigung war nicht erfolgreich.</b> <br> Das Datum welches der Kunde angegeben hat <b> (" + vertragsEndeKunde + ") </b>, stimmt nicht mit dem Vertragsende überein das aus der Laufzeit errechnet wird <b> (" + vertragsEndeLaufzeit + ") </b> . <br>"
                    + "Soll dem Kunden eine Nachricht übermittelt werden? <a href='javascript:void(0)'> E-Mail Mitteilung </a>";


            }

            // Kündigung war Erfolgreich
            else {
                kuendigungText = "Die Kündigung war Erfolgreich. <br> Kündigungsbestätigung per Mail <a href='javascript:void(0)'> Kündigungsbestätigung </a>"

                // Kündigungsbutton kann Ausgeblendet werden
                me.form.container.find('button.btn-vertrag-kuendigen').hide();

            }

            me.form.container.find('.status-unorder-list').append("<li> " + kuendigungText + " </li>")

        }

    },

    // TODO: MERGE MIT HANDLE??????
    buildOption(selector, id, text) {

        var me = this;

        // Option erstellen mit den neuen Daten -- Vertragsnehmer
        var option = '<option value="' + ((id) ? id : "") + '">' + ((text) ? text : 'Bitte Wählen') + '</option>';
        me.form.container.find('select[name="' + selector + '"]').html(option);



    },

    // Lädt die Abrechnungstabelle
    loadAbrechnungTable() {

        var me = this;

        var vertragsAbrechnungID = $('input[name="vertragsAbrechnungID"]').val();

        // Holt alle Abrechnungspositionen zu dem Vertrag
        app.simpleRequest("loadAbrechnungTable", "vertraege-handle", vertragsAbrechnungID,

            // Success
            function (response) {
                console.log(response);

                // Nur wenn es eine Laufzeit gibt -- Für unbefristete Verträge????
                // if(response.data.length >= 1) {

                var monate;

                var intervalMonate = {
                    'M': 1,
                    'Q': 3,
                    'Y': 12
                }

                var abrechnungInterval;
                $.each(intervalMonate, function (key, value) {

                    if (response.data.pauschale_abrechnung_interval == key) {

                        abrechnungInterval = value;

                    }
                })

                var vertragsbeginn = moment($('input[name="vertragsbeginn"]').val());

                console.log(vertragsbeginn);

                var setData = "";
                for (var i = 0; i < 5; i++) {


                    if (i == 0) {

                        setData += '<tr> <td>' + vertragsbeginn.format('DD.MM.YYYY') + '</td> <td>' + response.data.gesamtpauschale_preis + ' € </td> </tr>'
                    } else {

                        var interValDate = vertragsbeginn.add(abrechnungInterval, 'M').format('DD.MM.YYYY');

                        setData += '<tr> <td>' + interValDate + '</td> <td>' + response.data.gesamtpauschale_preis + ' € </td> </tr>'
                    }


                }

                $('#abrechnungsTable').append(setData)



                // $.each(5, function(key, value) {

                // });

                // var vertragsbeginn =  moment($('input[name="vertragsbeginn"]').val());
                // var vertragsende =  moment($('input[name="vertragsende"]').val());

                // console.log(vertragsbeginn);
                // console.log(vertragsende);

                // console.log($('input[name="laufzeit"]').val());

                // var laufzeit = $('input[name="laufzeit"]').val();

                // var abrechnungInterval;

                // $.each(intervalMonate, function(key, value) {

                //     if(response.data.pauschale_abrechnung_interval == key) {

                //         abrechnungInterval = laufzeit / value;

                //     }
                // })

                // console.log(abrechnungInterval);


                // Wenn Pauschale Abrechnung Quartal (Q) ist
                if (response.data.pauschale_abrechnung_interval == 'Q') {
                    monate = 3;
                }

                // }


            },

            // Error
            function (response) {


            }

        );


    }

}

