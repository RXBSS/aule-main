/**
 * Dieses Objekt beinhaltet Funktionen die nur auf der Landingpage Seite sichtbar sein sollen
 */

var akquise = {

    // Init Funktion
    init() {

        var me = this;

        // Init die auf beiden Seiten gelten soll
        akquise_both.initBoth();

        // Cookie Setzen damit das bei Notification.Js abgefangen wird --- Wenn auf der Akquise Seite draufgeklickt wird soll die seite nicht neu geladen werden
        document.cookie = 'akq=true'

        // Adressen JS HIER INIT
        me.initAdressen();

        // KONTAKTE JS HIER INIT
        me.initKontakteNeu();

        // Init Pickliste der LandingPage
        me.initPickliste();

        // Init Forms
        me.initForm();

        // Init Modal Kunde
        me.initModalKunde();

        // Init Quickselect
        me.initQuickselcet();

        // Aktionen Count
        me.aktionenCount();

        // History letzen Einträge anzeigen
        me.historyAkquise();

        // EventListener der LandingPage
        me.addEventListener();

    },

    // Init Pickliste der LandingPage
    initPickliste() {

        var me = this;

        // Liste der Landingpage
        me.list = new Picklist('#akquise-pickliste', 'akquise', {


        });


    },

    // Alle Forms können hier geladen werden
    initForm() {

        var me = this;

        // Filter Form 
        me.filterForm = new Form('#filter');


    },

    // Wenn ein Neuer Kunde zu einer Akquise oder zu einem Aktion hinzugefügt werden soll
    initModalKunde() {

        var me = this;

        // Modal
        me.modalAddKunde = new ModalForm('#modal-akquise-kunde-hinzufuegen');
        me.modalAddKunde.initValidation();

    },

    // Quickselect
    initQuickselcet() {

        var me = this;

        // Kontakt Quickselect
        me.kontakteQuickselect = new Quickselect('kontakte', {
            selector: '#kontakte',
            defaultText: 'Bitte Benutzer auswählen',
            closeOnSelect: false
        });

        // Adressen Quickselect
        me.adressenQuickselect = new Quickselect('adressen', {
            selector: '#adressen',
            defaultText: 'Bitte Benutzer auswählen',
            // closeOnSelect: false
        });

        // me.kontakteQuickselect.container.html("<option>ttte</option>");

    },

    // EventListener der LandingPage
    addEventListener() {

        var me = this;

        // *************************************************************
        // Standard EventListener
        // *************************************************************

        // Filter (Meine oder Alle) und (Fällig oder Alle)
        $('input[name="meineOderAlle"], input[name="alleOderFaellige"]').on('change', function () {
            me.applyFilter();
        });

        // Wenn Status geändert wurde
        $('input.status-filter').on('change', function () {
            me.onChangeStatus($(this));
        });

        // Kunden Hinzufügen zu einer Akquise oder zu eine Aktion
        $('.btn-kunde-akquise-add').on('click', function () {
            me.modalAddKunde.open();
        });

        // Wenn der eine Neue adresse angelegt werden soll -----> Callback auf Adressen
        $('#btn-neue-adresse').on('click', function () {

            // Holt die Daten die Aktuell schon eingetragen worden sind
            me.getData = me.modalAddKunde.getData();

            // Modall Add Kunde wird geschlossen
            me.modalAddKunde.close();

            // neue Adresse anlegen Open
            me.modalNeueAdresse.open();

        });

        // Wenn ein neuer Kontakt angelegt werden soll ----- Callback
        $('#btn-neue-kontakte').on('click', function () {
            me.helperNeuerKontakt();
        });

        // Wenn das Modal geschlossen wird soll sich wieder das Modal öffnen das als option mitgegeben wurde
        $('#adressen-neu .btn-schliessen, #adressen-neu .close').on('click', function () {
            
            me.modalAddKunde.open();

            // Setzt die Daten die vor dem Schließen da waren
            me.modalAddKunde.setData(me.getData);
        });

        // Wenn das Modal geschlossen wird soll sich wieder das Modal öffnen das als option mitgegeben wurde
        $('#kontakte-neu .btn-schliessen').on('click', function () {

            me.modalAddKunde.open();

            // Setzt die Daten die vor dem Schließen da waren
            me.modalAddKunde.setData(me.getData);
        });


        // On Change bei den Checkbox der "Nur Kunden.." soll der Filter Kontakte neu gesetzt werden
        $('#nur_kunden').on('change', function() {
            me.setQuickselectFilter();
        });

        // Wenn der Button auf dieser Seite geklickt wird
        // $('.url-redirect-trigger').on('click', function(e) {
        //     e.preventDefault();

        // });


        // Wenn übe die Sidebar eine abonnierte Akquise geöffnet werden soll
        me.sidebar.container.on('click', '.url-redirect-trigger', function() {

            // Holt die aktive ID aus dem Input
            me.aktiveID = $(this).find($('input[name="aktiveID"]')).val();

            // Öffnet das Modal
            me.openModal(me.aktiveID)

            // Sidebar wieder ausblenden
            me.sidebar.close();

        });

        // *************************************************************
        // Form Handler
        // *************************************************************

        // Wenn eine Auswahl in der Pickliste getroffen wurde
        me.list.on('pick', function (el, data) {

            // OpenModal mit Aktive ID
            me.openModal(data[1]);
        });

        // Wenn die Liste fertig Geladen ist soll folgendes ausgeführt werden
        me.list.on('initComplete', function () {
            me.applyFilter();
        });

        // Wenn das Modal zum Hinzufügen von neuen Kunden abgeschickt wird 
        me.modalAddKunde.on('submit', function () {
            me.submitNeuerKunde();
        });

        // Wenn das Modal Sichtbar ist dann Bearbeiter Vorausfüllen
        me.modalAddKunde.on('shown.bs.modal', function () {
            me.getCurrentUser();
            me.modalAddKunde.container.find('#nur_kunden').prop('checked', true);
        });

        // Wenn neue Adresse Abgeschickt werden soll
        me.modalNeueAdresse.on('submit', function () {
            me.submitNeueAdresse();
        });

        // Wenn neuer Kontakt abgeschickt werden soll
        me.modalneuerKontakt.on('submit', function () {
            me.submitNeuerKontakt();
        });

        me.getSidebarHistory();

        // Wenn das Icon geklickt wird zur History wird die Sidebar geöffnet
        me.historyAkquiseIcon.on('click', function () {
            // document.cookie = 'history=1';

            // Klassen so hinzufügen das es Blinkt wenn etwas vorhanden ist 
            // TODO: Sollte noch als COOKIE oder in der SESSION gespeichert werden damit es sich merkt ob schon mal geklick wurde oder nicht
            // me.historyAkquiseIcon.container.removeClass('action-signal action-info');
            me.sidebarHistory.open();
        });

        // TODO: Wenn es geschlossen wird soll es nicht laden
        // Wenn die Sidebar offen ist sollen die letzen drei geänderten Akquise erscheinen
        me.sidebarHistory.on('open', function () {
            me.getSidebarHistory();
        });

        // Wenn eine Akquise aus der History in der Sidebar angeklickt wird
        me.sidebarHistory.container.on('click', '.url-redirect-akquise', function () {
            me.sidebarHistory.close();

            me.openModal($(this).find('input[name="aktiveID"]').val())
        });

        // On Change bei den Adressen Quickselect soll der Filter Kontakte neu gesetzt werden
        me.adressenQuickselect.on('change', function() {

            // Sobald eine andere Adresse ausgewählt wird sollen alle ausgewählten Kontakt zurückgesetzt werden
            me.kontakteQuickselect.reset(false);

            me.setQuickselectFilter();
        });

        // Wenn das Add Modal Kunde schließt dann Reset daten
        me.modalAddKunde.container.on('click', '.btn-schliessen', function() {
            me.modalAddKunde.clearForm();
        });

    },
    
    // Wenn ein neuer Kontakt erstell wird über die Akquise
    submitNeuerKontakt() {

        var me = this;

        var options = false;

        // var modalGetData = me.modalAddKunde.getData();

        // console.log(modalGetData);

        // OpenDialog --- Abschicken von Ajax mit einem Callback
        me.openDialogKontakteNeu(options, function (response) {

            me.modalAddKunde.open();

            app.simpleRequest("getAdressenKontakt", "kontakte-handle", response.data,

                // Success
                function (responseNeuerKontakt) {
                    // TODO: HIER MUSS DER KONTAKT EINGEPFLEGT WERDEN

                    me.modalAddKunde.setData(me.getData);

                    // TODO: Wenn es mehr als einen Kontakt gibt
                    // Wenn es vorher schon einen Kontakt gab und der gesetzt wurde -- Auch bei neu erstellen
                    // if(me.getData['kontakt'] != false) {

                    //     // Geht Alle Kontakte nochmal durch
                    //     $.each(me.getData['kontakt'], function(key, value) {
                    //         // Fügt die Kontakte die vorher gesetzt worden sind wieder hinzu

                    //         console.log(value);

                    //         // Hinzufügen
                    //         me.kontakteQuickselect.setData(value.value, value.text)


                    //     });

                    // } else {



                    // Hinzufügen
                    me.kontakteQuickselect.setData(responseNeuerKontakt.data.id, responseNeuerKontakt.data.vorname + " " + responseNeuerKontakt.data.nachname)


                    
                    // Option erstellen mit den neuen Daten
                    // var option = '<option value="' + responseNeuerKontakt.data.id + '">' + responseNeuerKontakt.data.vorname + " " + responseNeuerKontakt.data.nachname + '</option>'


                    // me.kontakteQuickselect.html(option);

                    // // Anhängen an den DOM des selects Der neuen Daten
                    // $('select[name=kontakt]')

                    // $('select').find('option[value="' + responseNeuerKontakt.data.id + '"]').attr('selected', 'selected');

                },

                // Error
                function (xhr) {


                }

            );

        });

    },

    // Wenn eine neue Adresse erstellt werden soll über die Akquise
    submitNeueAdresse() {

        var me = this;

        // Optionen
        var options = {
            'modal': me.modalAddKunde,
        }

        // Open Dialog -- Abschicken der Ajax
        me.openDialog(options, function (response) {

            // Modal Wieder öffnen
            me.modalAddKunde.open();

            // Neue Abfrage um die Daten wieder zu bekommen
            app.simpleRequest("get", "adressen-handle.php", response.data,

                // Success
                function (responseAdresse) {

                    // Setz die daten die vorher ausgewählt wurden
                    me.modalAddKunde.setData(me.getData);

                    // Option erstellen mit den neuen Daten
                    var option = '<option value="' + responseAdresse.data.id + '">' + responseAdresse.data.name + '</option>'

                    // Anhängen an den DOM des selects Der neuen Daten
                    $('select[name=adressen_id]').html(option);


                }
            );


        });

    },

    // Wenn ein neuer Kunde zur Akquise oder zu einer Aktion hinzufügt werden soll
    submitNeuerKunde() {

        var me = this;

        // Save Funktion
        me.modalAddKunde.save('newKundeAkquise', 'akquise-handle',

            // Success
            function (response) {

                // Alle Input-Felder werden gesäubert
                me.modalAddKunde.clearForm();

                // Modal Schließt sich
                me.modalAddKunde.close();

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich ausgeführt");

                // PickListe soll automatisch neu geladen werden -> damit man das Ergebnis sieht
                me.list.refresh(true);

                // Filter neu setzen
                me.applyFilter();

                // OpenModal Funktion
                me.openModal(response.data);

                // Status
                me.hideStatus('0')

            },
            /* Callback Error ist nicht vorhanden */
            false
        );


    },

    // Funktionen die die Anzahl alle Aktionen zählt und in die Box reinschreibt auf der Landingpage
    aktionenCount() {

        // Ajax
        app.simpleRequest("getCount", "akquise-handle", null, function (res) {

            // Fügt die Zahl die zurück gekommen ist in die Card oben rechts ein
            $('#countEntries').append(res.data.data['COUNT(name)']);

        }, false)

    },

    // Wenn der Status on Change getriggert wird
    onChangeStatus(selector) {

        var me = this;

        // Holt sich die Angewählten Values
        var status = me.getStatusFilterValues();

        // Mit STRG gedrückt - verhält sich wie checkbox
        if (app.keys.ctrl) {

            // Wenn eine Auswahl getroffen wurde
            if (status.length > 0) {

                // Übernehmen den Filter
                me.applyFilter();
            } else {

                // 
                selector.prop('checked', true);
            }

            // Verhält sich wie Radio
        } else {

            // Alle werden auf False gesetzt
            $('.status-filter').prop('checked', false);

            // Der Aktuelle gewählte wird auf true gesetzt
            selector.prop('checked', true);

            // Übernehmend den Filter
            me.applyFilter();
        }

    },

    // Holt die letzen 3 Einträge aus der Datenbank
    getSidebarHistory() {

        var me = this;

        //  Value des Cookies 
        // var cookieVal = ('; '+ document.cookie).split(`; history=`).pop().split(';')[0];

        // // Wenn der Cookie gesetzt ist wurde die History schon mal angeguckt und es muss nicht mehr blinken
        // if(cookieVal == '1') {

        //     // Klassen so hinzufügen das es Blinkt wenn etwas vorhanden ist
        //     me.historyAkquiseIcon.container.removeClass('action-signal action-info');

        // } else {

        //     // Klassen so hinzufügen das es Blinkt wenn etwas vorhanden ist
        //     me.historyAkquiseIcon.container.addClass('action-signal action-info');

        // }

        // Ajax
        app.simpleRequest("getHistoryAkquise", "akquise-handle", false,

            // Success
            function (response) {

                var setData = "";

                // Wenn es überhaupt Daten gibt
                if (response.data.length > 0) {

                    // document.cookie = "history=0";

                    setData += "<p class='mb-lg-1'> Folgende Akquisen haben Sie in der letzten Zeit bearbeitet: </p> <hr>";

                    // Array Erstellen
                    var adressen = {};

                    // Geht Alle Adressen durch
                    // $.each(response.data, function(keyAdresse, valueAdresse) {

                    //     // Checkt ob das der Wert in dem Objekt vorhanden ist --- Wenn nicht wird einen 1 als Key hinzugefügt
                    //     if (!adressen.hasOwnProperty(valueAdresse.adressen_id)) {
                    //         adressen[valueAdresse.adressen_id] = 1;
                        
                    //     // Ansonsten wird an der Stelle die ID hochgezählt --- Das heißt mehr als einmal vorhanden
                    //     } else {
                    //         adressen[valueAdresse.adressen_id]++;
                    //     }

                    // })

                    // Schleife geht durch alle Daten die zurück kommen
                    $.each(response.data, function (key, value) {

                        setData += '<a class="action-item url-redirect-akquise"  href="javascript:void(0);" style="margin-left: 0rem;"> '

                            + '<div class="row" id="sidebar-container-akquise" style="color: black">'
                                + '<input type="hidden" name="aktiveID" value="' + value.akquise_id + '">'
                                // + '<input type="hidden" name="aktion" value="' + response.result.data[key]['aktion'] +  '">'
                                // + '<input type="hidden" name="gelesen" value="' + response.result.data[key]['gelesen'] +  '">'

                                + '<div class="col col-lg-10">'

                                    + '<p class="date-container" style="margin-bottom: 5px;">'
                                        + '<i class="fa-solid fa-calendar-days" style="font-size: 18px; color: #7ab929"></i> <custom class="date">' + moment(value['zeitstempel']).format('DD.MM.YYYY HH:mm') + ' </custom> '
                                        // + '| <i class="fa-solid fa-user" style="font-size: 18px; color: #7ab929"></i> <custom class="date"> ' + value.mitarbeiterVorname + " " + value.mitarbeiterNachname + ' </custom>'

                                    + '</p>'

                                + '</div>'

                                // + '<h6 class="title"> Es wurde der Kunde: <strong>"' + value.adressenName + '"</strong></h6>';
                                + '<h6 class="title"> <strong>' + value.adressenName + '</strong>' + ((value.aktionName) ?  " - " + value.aktionName : "") +  '</h6>';
                                // + '<h6 class="title"> <strong>' + value.adressenName + '</strong></h6>';


                            // Wenn es eine Aktion Gibt
                            if (value.aktionName) {

                                // setData += '<h6 style class="subtitle"> Aktion: <strong>' + value.aktionName + '</strong> </h6> ';
                            }


                            // Wenn es keine Aktion gibt
                            if (!value.aktionName) {
                                // setData += '<p>bearbeitet. </p>';

                                // setData += '<p>Die Akquise ist keiner Aktion zu geordnet.</p>';
                            }

                        setData += '</div> <hr>';


                    });

                    // Wenn es keine Daten gibt
                } else {

                    // Klassen so hinzufügen das es Blinkt wenn etwas vorhanden ist
                    // me.historyAkquiseIcon.container.removeClass('action-signal action-info');

                    setData += "<div class='alert alert-soft-warning mt-lg-4'> Es sind noch keine Daten vorhanden </div>"

                    
                }

                // Set sidebarHistory Data
                me.sidebarHistory.setHtml(setData);
            },

            // Error 
            function (xhr) {

                // Klassen so hinzufügen das es Blinkt wenn etwas vorhanden ist
                // me.historyAkquiseIcon.container.removeClass('action-signal action-info');

                app.notify.error.fire("Fehler ", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            }

        );
    },

    // Holt den Aktuellen User der angemeldet ist
    getCurrentUser() {

        var me = this;

        // Ajax
        me.modalAddKunde.load("getCurrentUser", "akquise-handle", null,

            // Success
            function (response) {

            },

            // Error
            function (xhr) {
                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }

        );
    },

    // Nach Status Filter
    getStatusFilterValues() {

        var me = this;

        // Holt die daten
        var data = me.filterForm.getData();

        // Leeere Array
        var statusArray = [];

        // Schleife geht durch alle Statuse 
        $.each(['offen', 'erfolgreich', 'geloescht', 'nicht_erfolgreich'], function (index, value) {

            // Guckt wer checked ist
            if (data[value].checked) {

                // Setzt seine Value in das Array
                statusArray.push(data[value].value);
            }
        });

        // Rückgabe
        return statusArray;


    },
    
    // Wenn ein Neuer Kontakt angelegt werden soll
    helperNeuerKontakt() {

        var me = this;

        // Input Feld wird erstmal geleert
        // me.modalneuerKontakt.clearForm(); ----> das setzt die Validierung auch zurück will ich aber an der Stell nicht
        $('input').val("");

        // Wenn keine Adresse Ausgewählt wurde dann soll es nicht möglich sein einen Kontak anzulegen
        // Eine Adresse ist ausgewählt
        if(me.adressenQuickselect.val()) {

            // Adressen ID ist die Aktuell ausgewählte Adresse
            $('input[name="adressen_id"]').val(me.adressenQuickselect.val());

            // Holt die Daten die Aktuell schon eingetragen worden sind
            me.getData = me.modalAddKunde.getData();

            // Modal Add Kunde Schließen
            me.modalAddKunde.close();

            // Neuen Kontakt Anlegen Öffnen
            me.modalneuerKontakt.open();

        // Keine Adresse ist ausgewählt
        } else {

            app.notify.info.fire("Adresse auswählen","Bitte wählen Sie zunächst eine Adresse an oder fügen Sie eine neue Adresse hinzu!");

        }
       
    },

    // Setzt bei den Kontakten einen Filter
    setQuickselectFilter() {

        var me = this;

        // Alle Filter löschen um dann einen neuen zu setzen
        me.kontakteQuickselect.clearFilter();

        // Wenn die Checkbox Filter angehakt ist
        if($('#nur_kunden').prop('checked')) {

            // Wenn eine Adresse schon gesetzt wurde
            if(me.adressenQuickselect.val()) {

                // Setzt den Filter auf die ID die ausgewählt worden ist
                me.kontakteQuickselect.setFilter('kontakte', me.adressenQuickselect.val(), 'adressen_id', false);

            } 
        
        }
        
        // Wenn die Checkbox nicht angehakt ist
        else {

            // Setzt den Filter darauf das die Checkbox nicht angehakt ist und Alle Kontakte angezeigte werden soll
            me.kontakteQuickselect.setFilter('kontakte', $('#nur_kunden').prop('checked'), 'checkbox', false);

        }
       
    },


    // Filter auf der Landingpage (Alle, Fällige, Offen, Gelöscht, ....)
    applyFilter() {

        var me = this;

        // Holt die Daten aus dem Formular
        var data = me.filterForm.getData();

        // Init Filter
        var filter1;
        var filter2;

        // Aktuelles Datum holen
        var date = moment().format("YYYY-MM-DD HH:mm:ss");

        // Init CompleteFilter
        var completeFilter = [];

        // FILTER 1 - EIGENE
        // *****************

        // Wenn es keinen Bearbeiter gibt
        if (data['meineOderAlle']) {

            // Setzt Filter 
            filter1 = new PickFilter(2, data['meineOderAlle'], "=");

            // Pusht in den CompleteFilter den Filter 1
            completeFilter.push(filter1);
        }

        // FILTER 2 - FÄLLIG
        // *****************

        // Nur Fällig Anzeigen
        if (data['alleOderFaellige'] == 1) {

            // Wiedervorlage wird nach aktuellem Tag gefilter
            filter2 = new PickFilter(10, date, "<=");

            // Pusht Filter 1 in den CompleteFilter
            completeFilter.push(filter2);
        }

        // FILTER 3 - STATUS
        // *****************

        // 
        var statusArray = me.getStatusFilterValues();

        var filter3 = new PickFilter(8, (statusArray.length > 0) ? statusArray : [0, 1, 2, 3], 'IN');

        completeFilter.push(filter3);


        // ZUSAMMENBAUEN
        // *****************

        // Wenn der CompletFilter nicht leer ist
        if (completeFilter.length > 0) {

            // Erstellt Filter
            completeFilter = new PickFilter(completeFilter);

            // Übernimmt es für die Pickliste
            me.list.setFilter(completeFilter);


            // Wenn der CompleteFilter leer ist - Filter ZURÜCKSETZEN
        } else {
            me.list.resetFilter();
        }

    },

    // Die letzen 3 geänderten Akquisen soll hier angezeigt werden
    historyAkquise() {

        var me = this;

        // Icon in der oberen Leisten
        me.historyAkquiseIcon = new Notification({
            icon: "fa-solid fa-clock-rotate-left",
        });

        // Sidebar die geöffnet wird
        me.sidebarHistory = new Sidebar({
            name: 'history-akquise',
            width: 400,
            clickToClose: true
        });

    }

}

