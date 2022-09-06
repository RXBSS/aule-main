/**
 * - Reihenfolge in der Datei
 * 
 * - Main Init
 * - Event Listner
 * - Alle Init Funktionen
 * - Allgmeine Themen
 * - Alles zum Entwurf
 * - Alles zur Belieferung
 * - Alles zur Bestellung
 * 
 * - Alle Bearbeiten von Positionen befindet sich in der Datei 
 * - auftrag-details-positionen
 * 
 * 
 */
var au = {

    // Konstanten
    form: false,
    handler: 'auftraege-handle',

    /**
     * Muss in mehere Status initalisiert werden könne
     * Dazu wird immer zunächst der Zustand wie bei einem neuen Auftrag hergestellt
     * 
     * Im Anschluss werden die Veränderungen des Status gesetzt
     * 
     */
    // Daten laden
    // Initaler Status
    // Entscheiden, was angezeigt wird
    // Entscheiden, was möglich ist

    // Status 1 - Auftragsentwurf
    // - Adressfeld kann beliebig geändert werden
    // - Positionsdaten können eingefügt werden

    // Status 2 - Aktiv
    // - Keine Änderungen der Daten möglich 
    // - Nur noch Storno

    // Status 3 - Abgeschlossen
    // - Keine Änderungen der Daten möglich
    // - Nur noch Storno

    init: function () {

        var me = this;

        // Loading
        me.id = app.getUrlId();

        // Initalisieren des Status
        me.status = 0;
        me.subStatus = 0;

        // Id
        if (me.id) {

            // Init Form
            me.initForm();

            // Get Data
            me.getData(function (response) {

                // me.initPicklistAdressen();
                me.initPos();
                me.initLieferungenListe();
                me.initBestellungenListe();

                // Historie initalisieren
                me.initHistory();

                // Event Listner hinzufügen
                me.addListners();

                // Wenn der Kunde gesperrt ist
                if (response.data.re_gesperrt == 1) {
                    $('#rechnungsempfaenger-ist-gesperrt .detail-text').html('Grund der Sperre <strong>' + response.data.re_gesperrt_grund + '</strong> von <strong>{{MITARBEITER}}</strong> am <strong>{{DD.MM.YYYY}}</strong>');
                    $('#rechnungsempfaenger-ist-gesperrt').show();
                }

                // Prüft die Checkbox um das Thema mit LF / RE
                // me.setLfAvailible();

                // Get Status
                me.changeStatus(response.data.status_id);

                // Close Loading Wrapper
                // TODO: Temporär ausgeblenden
                app.waitForPicklists([me.picklistAdressen, me.positionList, me.lieferListe], function () {

                    // 
                    app.wrapperLoader.stop();

                    // 
                    new CardSizer(['#card-address', '#card-form', '#status-1', '#status-2-0', '#status-2-1', '#status-2-2', '#status-3', '#status-4']);
                })
            }, 'auftraege');


            // Fehlermeldung ausgeben
        } else {
            app.alert.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte kontaktieren Sie den Administrator!").then(function () {
                app.redirect('auftraege');
            })
        }

        /*
        // TODO: Das wäre nur ein Fallback, falls es zu einem Loading Error kommt
        setTimeout(function() {
            app.alert.loader.close();
        },1000);
        */
    },


    /**
     * Event Listner für alles
     */
    addListners() {

        var me = this;

        // Die Event Listner für die FORM und die PICKLIST (Adresse) sind jeweils in den Init Funktionen
        // -----

        // EventListner für die FABs in der rechten unteren Ecke
        me.addListnersFab();

        // Event Listner für Hotkeys (Tastenkombinationen)
        me.addListnersHotkey();



        // Vorschau drucken
        me.lieferListe.container.on('click', '.btn-lieferschein-anzeigen', function () {
            var id = $(this).data('id');
            me.lieferscheinAnzeigen(id);
        });



        // Ggf. noch prüfen
        // TODO: 
        window.onbeforeunload = function () {
            // return "Wollen Sie die Seite verlassen ohne zu speichern?";
        }

    },


    // HotKeys
    addListnersHotkey() {

        var me = this;

        // STRG + ENTER
        hotkeys('ctrl+enter', function (event, handler) {

            // TODO: STRG + ENTER soll unnötige Abfragen verhindern und zum Beispiel die Positionsdaten speicher
            app.notify.success.fire("Erfolgreich", "Tastenkombination STRG + ENTER gedrückt");
        });

        // STRG + S - Speichern
        hotkeys('ctrl+s', function (e, handler) {
            e.preventDefault();

            // TODO: Darf nur funktionierne, wenn es sich um einen Entwurf handelt!
            // TODO: Muss sich ebenfalls auf den aktuellen Status beziehen, damit auch anderen Themen gespeichert werden können
            me.entwurfSpeichern();
        });

        // STRG + H - Historie
        hotkeys('ctrl+h', function (e, handler) {
            e.preventDefault();
            me.history.open();
        });
    },


    /**
    * Event Listner für die FAB-Buttons
    */
    addListnersFab() {

        var me = this;

        // Auftrag erstellen
        me.form.container.on('click', '.btn-auftrag-erstellen', function () {
            me.auftragErstellen();
        });

        // Entwurf löschen
        me.form.container.on('click', '.btn-entwurf-loeschen', function () {
            me.entwurfLoeschen();
        });

        // Entwurf speichern
        me.form.container.on('click', '.btn-entwurf-speichern', function () {
            me.entwurfSpeichern();
        });

        // Lieferung Neu
        me.form.container.on('click', '.btn-lieferung-neu', function () {
            me.lieferungNeu();
        });

        // Lieferung Abbrechen
        me.form.container.on('click', '.btn-lieferung-abbrechen', function () {
            me.lieferungAbbrechen();
        });

        // Lieferung Erstellen
        me.form.container.on('click', '.btn-lieferung-erstellen', function () {
            me.lieferungErstellen();
        });

        // Bestellung Neu
        me.form.container.on('click', '.btn-bestellung-neu', function () {
            me.bestellungNeu();
        });

        // Bestellung abbrechen
        me.form.container.on('click', '.btn-bestellung-abbrechen', function () {
            me.bestellungAbbrechen();
        });

        // Bestellung erstellen
        me.form.container.on('click', '.btn-bestellung-erstellen', function () {
            me.bestellungErstellen();
        });

        // Bestellung erstellen
        me.form.container.on('click', '.btn-rechnung-erstellen', function () {
            me.rechnungErstellen();
        });
    },


    /**
     * Init Form
     * // TODO: Die Form muss später auch andere Änderungen noch mit abspeichern. Welche Möglich sind, müsste über Readonly geregelt werden und changeStatusGui
     * 
     */
    initForm() {

        var me = this;

        // Neue Form
        me.form = new Form('#form-auftrag');

        // Form Validation initalisieren
        me.form.initValidation();

        // Form
        me.form.on('invalid', function () {
            app.notify.error.fire("Fehler", "Einige Felder sind noch nicht vollständig ausgefüllt.");
        });

        // Einfaches Beispiel
        new ActivationInput('#hat_liefertermin', 'input[name=liefertermin]', me.form);

    },




    /**
     * Auftrags Historie initalisieren
     * // TODO: Historie muss noch damit umgehen können, wenn es keine Einträge gibt, wobei das eigentlich nicht vorkommen darf
     */
    initHistory() {

        var me = this;

        // Auftragshistorie
        me.history = new AuftragHistorySidebar({
            ajax: {
                task: "load-historie",
                file: "auftraege-handle",
                data: me.id
            }
        });
    },


    /**
     * Initalisieren der Lieferungsliste
     */
    initLieferungenListe() {
        var me = this;

        me.lieferListe = new Picklist("#lieferungen-liste", "auftraege_lieferungen", {
            type: 'simple',
            card: false,
            pagination: false,
            fixFilter: new PickFilter(2, me.id),
        });
    },

    /**
    * Initalisieren der Bestellungen
    */
    initBestellungenListe() {
        var me = this;

        // me.bestellListe = new Picklist("#bestellungen-liste", "auftraege_lieferungen");
    },



    /**
     * Adresse Suchen
     */
    searchAddress() {
        this.picklistAdressen.open();
    },





    /**
     * STATUS
     * --------------------------
     */


    /**
     * Diese Funktion passt die GUI an, je nachdem welcher Status aktuell ist
     * 
     * 
     * 
     * @param {Number} status Der Stauts der in der GUI gesetzt werden soll
     * @param {Number} subStatus Der SubStatus wird für die GUI genutzt
     */
    changeStatusGui() {

        var me = this;



        // Equivalent für alle Positionsbezogenen Themen
        me.changePosStatus();

        // Wenn der Status Entwurf ist
        if (me.status == 1) {
            $('#lieferungen, #bestellungen').hide();
        }

        // Wenn es nicht Entwurf ist
        if (me.status > 1) {

            $('#lieferungen, #bestellungen').show();

            // Form auf Readonly setzen
            me.form.setReadonly(true);

            // Den Lieferstatus abfragen
            me.getLieferStatus();
        }

        // Offener Auftrag
        if (me.status == 2) {

            // Substatus 0 
            if (me.subStatus == 0) {

                // Substatus 1 
            } else if (me.subStatus == 1) {

                // Substatus 2
            } else if (me.subStatus == 2) {

            } else {
                app.alert.error.fire("Fehler in der Programmierung", "Unbekannter Sub-Status des Auftrags");
            }
        }

        // Fehlermeldung beim unbekanntem Status auswerden
        if ([1, 2, 3, 4].indexOf(me.status) < 0) {
            app.alert.error.fire("Fehler in der Programmierung", "Unbekannter Status des Auftrags");
        }
    },




    /**
     * ALLES ZUM THEMA LIEFERUNG
     * --------------------------
     */




    /**
     * Wenn jemand eine neue Lieferung erstellen will
     */
    lieferungNeu() {

        var me = this;


        // Request durchführen
        app.simpleRequest("lieferung-neu", "auftraege-handle", me.id, function (response) {

            // Wenn nicht Lieferbar ist
            if (response.data.status == 0) {

                app.alert.error.fire("Keine Bestand verfügbar!", "Der Auftrag kann nicht beliefert werden, da keine Artikel im Bestand sind.");

                // Wenn Teilweise Lieferbar ist
            } else if (response.data.status == 1) {

                // Abfrage  
                app.alert.question.fire("Automatisch Füllen?", "Der Auftrag kann nur <strong>Teilweise beliefert</strong> werden.<br>Möchte Sie alle Positionen beliefern, die beliefert werden können?").then(function (data) {

                    // Teilweise beliefern - Hier muss noch geprüft werden
                    if (data.isConfirmed) {
                        me.automatischLiefern(true);
                    }
                });

                // SubStatus
                me.changeSubStatus(1);

                // Wenn Vollständig beliefert werden kann
            } else if (response.data.status == 2) {

                // Abfrage  
                app.alert.question.fire("Automatisch Füllen?", "Der Auftrag kann <strong>Vollständig beliefert</strong> werden.<br>Möchten Sie alle Positionen vollständig beliefern?").then(function (data) {

                    // Vollständig beliefern
                    if (data.isConfirmed) {
                        me.automatischLiefern(false);
                    }
                });

                // SubStatus
                me.changeSubStatus(1);

                // Wenn er bereits vollständig beliefert wurde - Darf nicht vorkommen
            } else if (response.data.status == 3) {
                app.alert.error.fire("Vollständig beliefert!", "Der Auftrag wurde bereits vollständig beliefert. Es kann keine weitere Belieferung stattfinden");

                // Wenn ein anderer Status übermittelt wird - Darf nicht vorkommen
            } else {
                app.alert.error.fire("Fehler in der Programmierung", "Dieser Status ist unbekannt!");
            }
        });
    },

    // Lieferung Abbrecehn
    lieferungAbbrechen() {
        var me = this;
        me.changeSubStatus(0);
        app.notify.error.fire("Lieferung Abbrechen", "Die Lieferung an den Kunden wurde abgebrochen!");
    },

    // Lieferung Erstellen
    lieferungErstellen() {
        var me = this;

        // Abfrage  
        app.alert.question.fire("Lieferung erstellen?", "Sie beliefern jetzt den Auftrag. Damit werden die Bestände gebucht und der Lieferschein für den Kunden erstellt").then(function (data) {


            if (data.isConfirmed) {

                app.alert.loader.fire();

                // Lieferstatus erfragen
                app.simpleRequest("lieferung-erstellen", "auftraege-handle", me.id, function (response) {

                    // Neuer Status
                    me.changeStatus(response.data.status_id, 0);

                    app.notify.success.fire("Lieferung Erstellt", "Die Lieferung für den Kunden wurde erstellt");

                });
            }
        });

    },


    /**
     * Gibt den aktuellen Lieferstatus zurück
     */
    getLieferStatus() {

        var me = this;

        // Lieferstatus erfragen
        app.simpleRequest("get-lieferstatus", "auftraege-handle", me.id, function (response) {

            var text = "";

            // Lieferstatus

            switch (response.data.status) {
                case 0:
                    text = "Der Auftrag ist aktuell nicht belieferbar";
                case 1:
                    text = "Der Auftrag ist teilweise belieferbar";
                case 2:
                    text = "Der Auftrag ist vollständig belieferbar";
                    break;

            }

            $('.lieferstatus-text').html(text);

        });

    },

    // Lieferschein anzeigen
    lieferscheinAnzeigen(id) {


        app.alert.question.fire({
            title: 'Dokument Drucken',
            html: '<br>',
            confirmButtonText: '<i class="fa-solid fa-check"></i> Mit Briefkopf',
            cancelButtonText: '<i class="fa-solid fa-times"></i> Ohne Briefkopf',
            footer: '<a href="#!" id="some-action"><i class="fa-solid fa-print"></i> Ausdrucken</a>'

        }).then((result) => {

            letterhead = (result.isConfirmed) ? true : false;

            app.alert.loader.fire();

            app.simpleRequest("show-document", "auftraege-handle", {
                docId: id,
                docType: 'lieferschein',
                docLetterhead: letterhead
            }, function (response) {

                app.alert.loader.close();

                // Öffnen
                window.open('document?file=' + response.data, '_blank');
            });

        });

    },


    /**
     * ALLES ZUM THEMA BESTELLUNG
     * --------------------------
     */

    bestellungNeu() {

        var me = this;

        // Substatus wechseln
        me.changeSubStatus(2);

        app.notify.success.fire("Erfolgreich", "Eine Bestellung erstellen");
    },

    // Lieferung Abbrecehn
    bestellungAbbrechen() {
        var me = this;
        me.changeSubStatus(0);
        app.notify.error.fire("Lieferung Abbrechen", "Die Bestellung beim Lieferanten wurde abgebrochen!");
    },

    // Lieferung Erstellen
    bestellungErstellen() {
        var me = this;
        me.changeSubStatus(0);
        app.notify.success.fire("Bestellung Erstellt", "Die Bestellung beim Lieferanten wurde erstellt");
    },




    /**
     * RECHNUNGEN
     * 
     */


    /**
     * Eine Rechnung erstellen
     */
    rechnungErstellen() {

        var me = this;

        // Abfrage  
        app.alert.question.fire("Rechnung erstellen?", "Der Auftrag wurde vollständig beliefert und kann jetzt berechnet werden.").then(function (data) {

            // Rechnung erstellen
            if (data.isConfirmed) {

                app.alert.loader.fire();

                // Rechnung erstellen
                app.simpleRequest("rechnung-erstellen", "auftraege-handle", me.id, function (response) {

                    // Status ändern
                    me.changeStatus(4);

                    // Loader schließen
                    app.alert.loader.close();
                });
            }
        });
    },


    
    /**
     * ALLES ZUM THEMA ENTWURF
     * --------------------------
     */

    // Auftrag erstellen
    auftragErstellen() {

        var me = this;

        // Zunächst speichern
        me.entwurfSpeichern(function () {

            // Speichern
            app.simpleRequest('entwurf-validieren', 'auftraege-handle', me.id, function (response) {

                // Abfrage
                app.alert.question.fire("Auftrag erstellen?", "Sobald der Auftrag erstellt wird, wird der Kunde benachrichtigt!").then(function (data) {

                    // Prüfen ob das Löschen bestätigt wurde
                    if (data.isConfirmed) {

                        // Speichern
                        app.simpleRequest('auftrag-erstellen', 'auftraege-handle', me.id, function (response) {

                            // Status des Auftrags auf 2 setzen
                            me.changeStatus(2);

                            // Ggf. kann hier noch die Abfrage im kommen ob man direkt beliefen will?
                            // --

                            // Meldung ausgeben
                            app.notify.success.fire("Auftrag erstellt", "Der Auftrag wurde erstellt!");

                            // Wenn der Auftrag nicht angelegt werden kontnte
                        }, function (response) {
                            app.alert.error.fire("Fehler beim Anlegen des Auftrags", response.error);
                        });


                        // Wenn der User abbricht
                    } else {
                        app.notify.error.fire("Auftrag nicht erstellt", "Das Erstellen des Auftrags wurde abgebrochen.");
                    }
                });

                // Wenn die Validierung fehlschlägt
            }, function (response) {
                app.alert.error.fire("Fehler beim Anlegen des Auftrags", response.error);
            });
        });
    },

    // Entwurf löschen
    entwurfLoeschen() {

        var me = this;

        app.alert.question.fire("Auftrag Entwurf Löschen?", "Wollen Sie den Auftragsentwuft wirklich löschen. Dann bestätigen Sie diese Meldung mit Ja.").then(function (data) {

            if (data.isConfirmed) {

                // Loader aktivieren
                app.alert.loader.fire();

                // Auftrag löschen
                app.simpleRequest("entwurf-loeschen", "auftraege-handle", me.id, function (data) {

                    // Löschen
                    app.alert.error.fire("Löschen", "Der Auftrag wurde gelöscht!").then(function () {
                        app.redirect('auftraege');
                    });
                });
            }
        });
    },

    // Entwurf Speichern
    entwurfSpeichern(callback) {

        var me = this;

        // Speichern
        me.form.fvInstanz.validate().then(function (status) {
            if (status == 'Valid') {
                me.form.save('entwurf-speichern', 'auftraege-handle', function (response) {

                    // Zurücksetzen der Form
                    me.form.reset(2);

                    // Wenn es einen Custom Callback gibt
                    if (typeof callback == 'function') {
                        callback();
                        // Falls nicht
                    } else {
                        app.notify.success.fire("Gespeichert", "Der Entwurf wurde erfolgreich gespeichert");
                    }

                }, function () {
                    app.notify.error.fire("Nicht gespeichert", "Der Entwurf kontte nicht gespeichert werden!");
                }, {
                    id: me.id
                });
            }
        });

    },
}

