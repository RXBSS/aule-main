var v_d = {

    init() {

        var me = this;

        // Additional
        me.id = app.getUrlId();



        // app.wrapperLoader.stop();




        // Die Datei in der alle Standard-Abfrage verarbeitet werden
        // me.handler = "vertraege-handle";

        // Standard Mäßig Ausblenden des Selectes Kalendarium
        // $('#zaehler-kalendarium, #pauschale-kalendarium').hide();

        // Id
        if (me.id) {

            // Init Alles Über Verträge Adressen Card
            me.initVertraegeAdressen();

            // Init Alles Über Verträge Abrechnugen Card
            me.initVertraegeAbrechnung();

            // Init Alles über Verträge Stammdaten Card
            me.initVertraegeStammdaten();

            // Init Alles über Verträge Laufzeiten Card
            me.initVertraegeLaufzeiten();

            // Init Alles über Verträge Kosten Card
            me.initVertraegeKosten();

            // Init Alles über Verträge Klausel Card
            me.initDetailsKlauseln();

            // Init Alles über Verträge Positionen Card
            me.initVertraegePos();

            // Load Vertrag um Entwurf oder Aktiv zu setzen
            me.loadVertrag();

            // Initalisieren
            me.initModalForm();

            // TimeOut 2 Sekunden
            setTimeout(() => {

                app.wrapperLoader.stop();

                // Card Resize
                new CardSizer(['#card-adressen', '#card-stammdaten', '#status-1']);
                new CardSizer(['#card-adressen', '#card-stammdaten', '#status-2-0']);
                // new CardSizer(['#card-kosten', '#card-laufzeiten']);

            }, 500);

            // Activation
            new ActivationMulti(me.modalVertragAktiv.container.find('input[name=versandart]'), '.vertrag-erstellen-versandart');

            v_d.validierung = {
                print: ['kunden_gesendet'],
                email: ['mail_absender', 'mail_empfaenger']
            }

            me.enableDisableValidator(v_d.validierung['print'], false);
        }

        // EventListener
        me.addEventListener();




    },

    initModalForm() {

        var me = this;

        me.modalVertragAktiv = new ModalForm('#vertraege-erstellen-form');
        me.modalVertragAktiv.initValidation();

        // Filter setzen
        me.modalVertragAktiv.qs['authorisierer_id'].setFilter('unterschreib_berechtigt', 1);
    },


    addEventListener() {

        var me = this

        // Wenn der Entwurf gelöscht werden soll
        $('.btn-entwurf-loeschen').on('click', function () {
            me.deleteEntwurf();
        });

        // Neue Version des Vertrages erstellen
        $('#btn-vertrag-neue-version').on('click', function () {
            me.vertragVersionNeu();
        });


        // Bei Jedem Tab Card Sizer neu ausrichten sonste Fehler
        // $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        //     new CardSizer(['#card-klauseln', '#card-klauseln-pickliste']);
        // });

        // Wenn der Vertrag auf aktiv gesetzt wird
        $('.btn-vertrag-erstellen').on('click', function () {
            me.getData();
        });

        // Validierung ein und Ausschalten
        me.modalVertragAktiv.container.on('change', 'input[name="versandart"]', function () {
            if ($(this).val() == 'print') {
                me.enableDisableValidator(v_d.validierung['print'], true);
                me.enableDisableValidator(v_d.validierung['email'], false);
            } else if ($(this).val() == 'email') {
                me.enableDisableValidator(v_d.validierung['print'], false);
                me.enableDisableValidator(v_d.validierung['email'], true);
            }
        });

        // Modal Angebot Erstellen wird abgeschickt -- Submit
        me.modalVertragAktiv.container.on('click', '.btn-form-save', function () {
            me.vertragAktivieren();
        })

        // Wenn Kosten Fertig ist
        me.formKosten.on('initComplete', function () {
            console.log("SAFSDFDs");
        });




    },

    // Man Kann einen Benutzer Definierten Vertrag wählen
    benutzerdefinierteVertrag() {

        var me = this;

        // Wenn der Benutzer Definierte Vertrag nicht angehakt ist
        if (!$('input[name="benuzterdefinierter-vertrag"]').prop('checked')) {
            me.vertraegeKlauseln.setReadonly(true);

            $('#vertraege-klauseln-pickliste').find('.dataTables_buttons').css('pointer-events', 'none')
        }
    },

    // Vertrag Neue Version erstellen
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

    // Löschen des Entwurfs
    deleteEntwurf() {

        var me = this;

        // Dialog und Fragen ob wirklich gelöscht werden soll
        app.alert.question.fire("Löschen?", "Wollen Sie den Vertragsentwurf wirklich löschen? Diesen Vorgang kann man nicht mehr Rückgängig machen")
            .then((result) => {

                // Wenn Ja geklickt wird
                if (result.isConfirmed) {

                    // Ajax
                    app.simpleRequest("entwurf-loeschen", 'vertraege-handle', me.id,

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

    // Lädt die Daten des Vertrages
    loadVertrag() {

        var me = this;

        app.simpleRequest("load", "vertraege-handle", me.id,
            function (response) {
                me.manipulateGUI(response);
            }
        );

    },

    // Setzt den Status des Vertrages
    manipulateGUI(response) {

        var me = this;



        // Status ist ein Entwurf
        if (response.data.status_id == '1') {
            me.vertragEntwurf(response);

            // Status ist Aktiv
        } else if (response.data.status_id == '2') {
            me.vertragAktiv(response);
        }
    },

    // Holt alle Daten von jeder Form
    getData() {

        var me = this;

        // Holt die Daten via AJAX
        app.simpleRequest("load", "vertraege-handle", me.id,

            // Success
            function (response) {

                // Response kürzer in VAR
                var resD = response.data;

                // Erst wenn Alle Daten aus der ToDo  Liste okey sind kann der Vertrag auf Aktiv gesetzt werden
                if (resD.vertragsbeginn && (resD.pauschale_abrechnung_interval || resD.zaehler_abrechnung_interval)) {
                    me.modalVertragAktiv.open();
                }

                // Ansonsten eine Meldung ausgeben das noch nicht alle Felder gefüllt sind die wichtig sind
                else {
                    app.notify.warning.fire("Aktivieren nicht möglich!", "Um den Vertrag auf Aktiv zu setzen, müssen Sie alle nötigen Felder ausfüllen. Arbeiten Sie die \"<b> ToDo-Liste </b>\" ab und versuchen Sie es erneut.");
                }

            },

            // Error
            function (response) {
                console.log(response);

                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            }


        );

    },


    // Vertrag auf Aktiv setzen
    vertragAktivieren() {

        var me = this;

        // me.enableDisableValidator();

        // Prüfen ob alles Valide ist
        me.modalVertragAktiv.fvInstanz.validate().then(function (status) {
            if (status == 'Valid') {

                me.modalVertragAktiv.save('vertragAktivieren', 'vertraege-handle',

                    // Success
                    function (response) {

                        app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                        me.loadVertrag();

                    },

                    false,

                    // Additional
                    {
                        id: me.id
                    }

                )
            }

        });

    },

    enableDisableValidator(array, enable) {

        var me = this;

        // Läuft durch alle Elemente des Arrays
        for (var i = 0; i < array.length; i++) {

            // Wenn die Validierung eingeschaltet wurde
            if (enable) {
                me.modalVertragAktiv.fvInstanz.enableValidator(array[i]);

                // Wenn die Validierung ausgeschaltet wurde
            } else {
                me.modalVertragAktiv.fvInstanz.disableValidator(array[i]);
            }

        }

    },

    // Wenn der Vetrag ein Entwurf ist
    vertragEntwurf(response) {

        var me = this;

        // Liste Dynamisch Erstellen mit der version
        $('.status-unorder-list').html(''
            + '<li>Vorschau<a href="javascript:void(0);" data-document="vt" data-bs-toggle="tooltip" data-bs-placement="top" title="Vorschau Erstellen" class="btn-print-preview action-item btn-show-document">Vertrag</a></li>'
            + '<li> Das ist die ' + response.data.version + '. Version</li>'
        )



        // Response Data in VAR speichern
        var resD = response.data

        $('#status-2-0, #tab-nav-vertraege-4').hide();

        // Wenn es einer dieser nicht gibt
        if (!resD.vertragsbeginn || (!response.data.pauschale_abrechnung_interval && !response.data.zaehler_abrechnung_interval)) {
            $('.status-unorder-list').append("<br><b>ToDo - Liste: </b>");
        }

        // Wenn es keinen Vertragsbeginn gibt
        if (!response.data.vertragsbeginn) {
            $('.status-unorder-list').append('<li> <i class="fa-solid fa-calendar-days"></i> Vertragsbeginn fehlt</li>')
        }

        // Wenn der Abrechnungsinterval fehlt 
        if (!response.data.pauschale_abrechnung_interval && !response.data.zaehler_abrechnung_interval) {
            $('.status-unorder-list').append('<li> <i class="fa-solid fa-money-bill-1"></i> Abrechnungsinterval fehlt</li>')
        }

    },


    // Wenn der Vertrag Aktiv ist
    vertragAktiv(response) {

        var me = this;

        // Response Data in VAR speichern
        var resD = response.data

        me.setReadonlyForm();
        me.setReadonlyButtons();

        // Liste Dynamisch Erstellen mit der version
        $('.status-unorder-list').html(''
            + '<li>  <a href="javascript:void(0);" data-document="vt" data-bs-toggle="tooltip" data-bs-placement="top" title="Vorschau Erstellen" class="btn-print-preview action-item btn-show-document" style="margin-left: 0px;">Vertrag</a> </li>'
            + '<li> Das ist die ' + response.data.version + '. Version</li>'
        )

        $('#status-1').hide();
        $('#status-2-0, #tab-nav-vertraege-4').show();

        // Wenn die Autorisierte Person im Aktiv Modus gesetzt wurde
        if (response.data.authorisierer_id) {
            $('#authorisierte_person').show();
            me.formStammdaten.container.find('input[name="authorisierer_id_"]').val(response.data.authorisierer_id.text)
        }

        // Solange die Kundenunterschrift nicht gesetzt wurde
        if (response.data.kunden_unterschrift != '1') {
            // Kunden Unterschrift Vorhanden Anzeigen wenn Vertrag auf Aktiv ist
            $('#kunden_unterschrift').show();
            me.formStammdaten.container.find('input[name="kunden_unterschrift"]').addClass('editable').attr('disabled', false)
            $('.status-unorder-list').append("<li> <i class='fas fa-signature'></i> Kundenunterschrift <strong>fehlt</strong>. <br> Der Vertrag wird trotzden abgerechnet, da er rechtskräftig ist.</li>")

        } else {

            $('#kunden_unterschrift').hide();
            $('.status-unorder-list').append("<li> Kundenunterschrift ist <strong>vorhanden </strong> </li>")
        }

        // In dem Moment wenn der Vertrag Aktiv ist gibt es immer eine Abrechnung
        me.loadAbrechnung();


    },

    // SEtzt Alle Buttons auf Readonly wenn die Form Aktiv ist
    setReadonlyButtons() {

        console.log('kjvgjhffcgccgh');

        // Button Weg
        $('a.action-item.btn-form-edit, button.fab-parent.fab-rotate, .quickselect-buttons').hide();

        // console.log(variable);

        // console.log();
        
        $('#pickliste-positionen').closest('.dataTables_buttons').css('pointer-events', 'none')

        // In Picklisten die Buttons auf Readonly setzen
        $('.dataTables_buttons').css('pointer-events', 'none')

    },

    // setzt Alle Forms, Listen auf Readonly
    setReadonlyForm() {

        var me = this;

        // Forms auf Readonly
        me.formAdresse.setReadonly(true);
        me.formStammdaten.setReadonly(true);
        me.formKosten.setReadonly(true);
        me.formLaufzeiten.setReadonly(true);

        // Buttons bei Adresse verschwinden lassen
        me.formAdresse.container.find('.actions .action-item').hide();

        // me.positionList.setReadonlyButton(true);

        // Liste auf ReadOnly
        me.positionList.setReadonly(true);
        me.vertraegeKlauseln.setReadonly(true);


    },

    // Lädt die Abrechnungen
    loadAbrechnung() {

        var me = this;

        // app.simpleRequest("loadAbrechnungTable", "vertraege-handle", me.id,

        //     // Success
        //     function(response) {

        //         var intervalMonate = {
        //             'M': 1,
        //             'Q': 3,
        //             'Y': 12
        //         }

        //         var setData = "";

        //         // Schleife geht Alle Einträge durch und Fügt die zu SetData hinzu
        //         $.each(response.data, function(key, value) {
        //             var pauschaleZaehler = (value.pauschale == '1') ? "Pauschaleabrechnung" : "Zaehlerabrechnung";

        //             var faelligkeit = ""; 
        //             if(value.status_id == '1') {
        //                 faelligkeit = "<custom class='text-danger'>" + value.statusIcon + " Fällig</custom>"
        //             } else if (value.status_id == '2') {
        //                 faelligkeit = "<custom class='text-success'>" + value.statusIcon + " Abgerechnet</custom>"
        //             } 

        //             // var faelligkeit = (value.status_id == '1') ? value.statusIcon + " Fällig" : (value.status_id == '2') ? value.statusIcon + " Abgerechnet" : "";
        //             setData += '<tr> <td>' + moment(value.abrechnungszeitpunkt).format('DD.MM.YYYY') + '</td> <td>' + value.kosten + ' € </td>  <td> ' + pauschaleZaehler + '</td> <td>' + faelligkeit +  '</td> </tr>'
        //         })

        //         $('#abrechnungsTable').append(setData)

        //     },

        //     false, 
        // );

    }



}

