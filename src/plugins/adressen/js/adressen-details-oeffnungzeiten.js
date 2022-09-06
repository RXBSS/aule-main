var ao = {



    init() {

        var me = this;

        // Details Tab im Modal immer hide
        $('#details-tab').hide();
        $('.duplettenpruefung').hide();

        // Url Id
        me.id = app.getUrlId();

        me.initList();
        me.initForm();
        me.setTime();
        me.addListners();


        /**
         * Bekommt seinen Parameter von der adressen.js Datei
         */
        me.openingHoursAdditional();


    },


    initList() {

        var me = this;


        // Adressen Eigenschaften - Pickliste Öffnungszeiten
        me.list = new Picklist('#oeffnungszeiten-pickliste', 'adressen_oeffnungszeiten', {
            type: 'single-list',
            card: false,
            description: false,
            lengthMenu: false,
            pagination: false,
            // addHandleButtons: true,
            search: false,
            buttons: false,

            data: me.id
        });
    },

    initForm() {

        var me = this; 

        // Adressen Eigenschaften - Modal Öffnungszeiten
        me.modal = new ModalForm('#adressen-oeffnungszeiten-form');

        var fields = {
            von1: {
                validators: {
                    callback: {
                        message: 'Offen darf nicht größer sein als Schließen!',
                        callback: function (input) {

                            var von = me.modal.container.find('input[name=von1]').val();
                            var bis = me.modal.container.find('input[name=bis1]').val();

                            return (von < bis);
                        },
                    },
                },
            },
            bis2: {
                validators: {
                    callback: {
                        message: 'Beide Zeiten müssen richtig und vollständig eingetragen werden!',
                        callback: function (input) {

                            var von2 = me.modal.container.find('input[name="von2"]').val();
                            var bis2 = me.modal.container.find('input[name="bis2"]').val();

                            var res;
                            var defaultEmptyRes;

                            if(von2 != '' && bis2 != '') {
                                res = true;
                            } else if (von2 == '' && bis2 == '') {
                                defaultEmptyRes = true;
                            } else {
                                res = false;
                            }

                            return (defaultEmptyRes || (res && (von2 < bis2)) );

                        },
                    },
                },
            },
        }

        // Validieren der Fields
        me.modal.initValidation(fields);

        me.modalGoogle = new ModalForm('#modal-google');
        // me.modalGoogle.initValidation();

        me.modalGoogleVerbinden = new ModalForm('#modal-adressen-form');
    },


    addListners() {

        var me = this;

        // BUTTONS OBEN RECHTS KARTE
        // *************************

        $('.btn-oeffnungszeit-edit').on('click', function() {
            me.edit();
        });

        $('.btn-oeffnungszeit-delete').on('click', function() {
            me.delete();
        });

        $('#adressen-oeffnungszeiten-card').on('click', '.btn-oeffnungszeit-google', function() {
            me.google();

        });

        

        $('#powered-google').on('click', '#google-verbinden' , function(e) {
            me.getDataFromGoogle();
        });

        $('#google-search').on('change', function() {

            // console.log(adressen.initAutocomplete())

        });

        // FORM
        // ****************

        me.modal.container.find('select[name=tag]').on('change', function() {
            me.modalDayChange();
        });   

        me.modal.container.find('input[name=offen]').on('click', function() {
            me.checkOffenOrGeschlossen();
        });   

        me.modal.on('submit', function() {
            me.submit();
        });   

        me.modalGoogle.on('submit', function() {
            me.submitGoogle();
        });

        

        me.modalGoogleVerbinden.container.on('click', '.btn-schliessen', function() {
            
            ad_d.discardForm();

            // MARK: Weiß nicht ob reset an der Stelle sinnvoll ist. Geht eh um die eigene Firma. Es wird jedes mal die Abfrage gemacht und alle felder wieder reingeschrieben
            me.modalGoogleVerbinden.reset();
        });
        
    },

    openingHoursAdditional(openingHour) {

        var me = this;

        me.modalGoogleVerbinden.on('submit', function() {
            me.submitGoogleModal(openingHour);
        });
    },

    edit() {
        
        var me = this;

        // 
        me.modal.open();
        
        // 
        me.modalDayChange();

        // 
        me.checkOffenOrGeschlossen();

    }, 

    delete() {
        var me = this; 

        // Es wird geprüft ob überhaupt Daten vorhanden sind die man löschen kann
        app.simpleRequest("oeffnungszeiten-vorhanden", "adressen-handle", me.id, function(response) {

            // Alle Öffnungszeiten werden gelöscht
            app.alert.question.fire("Alles löschen","Wollen Sie wirklich alle Öffnungszeiten löschen?").
                then(result => {

                    // Wenn Gelöscht werden soll
                    if (result.isConfirmed) {

                        // Daten Löschen Anfrage 
                        app.simpleRequest("oeffnungszeiten-delete", "adressen-handle", me.id, function(response) {

                            // Erfolgsmeldung
                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
                            
                            // Neu Laden der Liste
                            me.list.refresh();

                            // Geöffnet oder geschlossen neu Laden
                            ad_d.getCurrentTime();

                        }, false);
                    // Abbruch der Aktion
                    } else {
                        app.notify.error.fire("Abbruch","Die Aktion wurde auf Wunsch abgebrochen");
                    }
                }
            );
        
        // Fehlermeldung
        }, function(xhr) {

            // Keine Daten vorhanden zum Löschen
            app.notify.error.fire("Keine Daten vorhanden","Es liegen keine Daten vor die man löschen könnte");

        })
        

        
    },

    google() {

        var me = this;

        // Name aus dem Input Feld holen
        var firmenName = $('input[name="name"]').val();

        // Firmanename wird passend für die URl gemacht
        var encoded = encodeURI(firmenName);

        var place_id = $('input[name="place_id"').val();

        // URL für die erste abfrage um die Place_id herauszubekommen
        var dataUrl = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input="+ encoded + "&inputtype=textquery&fields=formatted_address%2Cname%2Cplace_id%2Crating%2Copening_hours%2Cgeometry&key=AIzaSyBcz5vCR6GMcbQtHfK_ImcU3yQwgmAVfa8&language=de";

        // Zuerst muss geprüft werden ob überhaupt Daten vorhanden sind
        app.simpleRequest("oeffnungszeiten-vorhanden", "adressen-handle", me.id, 
            
            // Success
            function(response) {
            
                // Soll nicht nochmal angelegt werden können
                app.notify.error.fire("Nicht Erfolgreich","Es sind bereits Daten vorhanden");

            // Error
            }, function(response) {

            if(response.error == true) {

                // Erste Abfrage um die Place id herauszubekommen
                me.googleHelper(place_id, 'vorhanden');
                
            }
        })

    },

    getDataFromGoogle() {

        var me = this;

        // Name aus dem Input Feld holen
        var firmenName = $('input[name="name"]').val();

        // Firmanename wird passend für die URl gemacht
        var encoded = encodeURI(firmenName);

        // URL die angesprochen wird
        var dataUrl = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input="+ encoded + "&inputtype=textquery&fields=formatted_address%2Cname%2Cplace_id%2Crating%2Copening_hours%2Cgeometry&key=AIzaSyBcz5vCR6GMcbQtHfK_ImcU3yQwgmAVfa8&language=de";

        // Daten werden von Google Geholt
        app.simpleRequest("getGoogleData", "adressen-handle", dataUrl,
            function(response) {

                // Wenn es ein Ergebnis gibt
                if(response.data.status == 'OK') {

                    // Place ID
                    var place_id = response.data.candidates[0].place_id;

                    // Die geholte Place ID wird als Value abgespeichert für DB
                    $('input[name="place_id"]').val(place_id);

                    // Google Helper Funktion (damit nicht doppelt noch stringVorhanden eingefügt)
                    me.googleHelper(place_id, "nicht vorhanden");
                } else {
                    app.notify.error.fire("Nicht Erfolgreich","Es wurde keinen Ergebnisse zu diesem Namen gefunden!");
                }

        }, false);

    },

    googleHelper(id, stringVorhanden) {

        var me = this;

        // Zweite URL mit der Abfrage palce id
        var dataUrlPlaceId = "https://maps.googleapis.com/maps/api/place/details/json?fields=name%2Crating%2Copening_hours,formatted_address,address_component,geometry,international_phone_number,website&place_id="+ id +"&key=AIzaSyBcz5vCR6GMcbQtHfK_ImcU3yQwgmAVfa8&language=de";

        // Abfrage mit der Place Id um die detailierten Öffnungszeiten zurück zu bekomemn
        app.simpleRequest("getGoogleData", "adressen-handle", dataUrlPlaceId, function(response) {


            if(response.data.status == 'OK') { 

                // Nur Wenn Öffnungszeiten vorhanden sind
                if(typeof(response.data.result.opening_hours) !== 'undefined') {

                    // Für ADDITIONAL Data
                    me.oeffnungszeitenPeriods = response.data.result.opening_hours.periods;
                }
                
                // Wenn Schon eine Place ID vorher vorhanden war
                if(stringVorhanden == 'vorhanden') {
                    // Modal soll sich öffnen
                    me.modalGoogle.open();
                    
                    // Tabelle Wird erstellt
                    var oeffnungszeiten = "<table style='width: 100%;'><thead><tr><th>Wochentag</th><th>Zeiten</th></tr></thead><tbody>";+

                    // Schleife durch alle Öffnungszeiten
                    $.each(response.data.result.opening_hours.weekday_text, function(index, value) {
                        var subvalues = value.split(':');
                        var weekday = subvalues.shift();
                        oeffnungszeiten += "<tr><td>" + weekday + "</td><td>" + subvalues.join(":") + "</td></tr>";
                    });

                    // Container wird angezeigt und Element angefügt
                    $('.oeffnungszeiten-container').show().find('.oeffnungszeiten-table').html(oeffnungszeiten);
                

                // Wenn die Place ID selber geholt wurde via Abfrage
                } else if(stringVorhanden == "nicht vorhanden") {

                    // Öffnet Modal
                    me.modalGoogleVerbinden.open();

                    // Damit das Alert nur einmal erscheint werden alle gelöscht und eins wieder neu hinzugefügt
                    $('#modal-adressen-form').find('.alert').remove();   

                    // Fügt Alert mit an das Element
                    $('#modal-adressen-form').prepend(
                        '<div class="alert alert-warning" role="alert">'
                        + 'Bitte Daten vor dem Absenden überprüfen! Dieser Vorgangn kann nach dem Absenden nicht mehr Rückgängig gemacht werden!'
                        + '</div>'
                    );                

                    me.fillData(response)

                }

            } else {
                app.notify.error.fire("Nicht Erfolgreich","Es wurden keine Daten gefunden");
            }

        }, false);

    },

    submit() {
        
        var me = this;

        // 
        me.modal.save('oeffnungszeiten-submit', 'adressen-handle', function(response) {

            // 
            me.list.refresh();

            // Geöffnet oder geschlossen neu Laden
            ad_d.getCurrentTime();

        }, null, {
            id: me.id,
        });

    },

    submitGoogle() {
        var me = this;

        // Modal Abgeschickt
        me.modalGoogle.save('oeffnungszeiten-google', 'adressen-handle', function() {
            
            // Modal Schließt
            me.modalGoogle.close()

            // Liste wird neu geladen
            me.list.refresh();
            
            // Erfolgsmeldung
            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

            // Geöffnet oder geschlossen neu Laden
            ad_d.getCurrentTime();
        
        }, false, {
            id: me.id,
            oeffnungszeiten: me.oeffnungszeitenPeriods
        });
    },

    // 
    modalDayChange() {

        var me = this;

        var c = me.modal.container;

        // Alle Tage auf unchecked und disabled false
        c.find('#zusaetzlich-tage input[type="checkbox"]').prop('disabled', false).prop('checked', false);

        var currentDay = c.find('select[name=tag]').val();

        c.find('#zusaetzlich-tage input[type=checkbox][value=' + currentDay + ']').prop('disabled', true).prop('checked', true);
    },


    checkOffenOrGeschlossen() {

        var me = this;

        // Element
        var el = me.modal.container.find('input[name=offen]');

        // validierung je nach dem ob offen oder geschlossen
        if(!el.prop('checked')) {

            $('#adressen-oeffnungszeiten-form #uhrzeiten').hide();
            me.modal.fvInstanz.disableValidator('von1');
            me.modal.fvInstanz.disableValidator('bis1');

        } else {    
            $('#adressen-oeffnungszeiten-form #uhrzeiten').show();
            me.modal.fvInstanz.enableValidator('von1');
            me.modal.fvInstanz.enableValidator('bis1');
        }
    },

    // Öffnungszeiten - Aktuelle Uhrzeit
    setTime() {
        setInterval( function() {
            $('#aktuelle-uhrzeit').html(moment().format("HH:mm:ss"));
        }, 1000);
    },

    fillData(response) {


        // if(response.data.result.name) 
            // $('input[name="google-search"]').val(response.data.result.name);

        if(response.data.result.name) 
            $('input[name="name"]').val(response.data.result.name);
        
        // TODO: GGF funktioniert es nicht weil das format was zurück kommt komisch ist. Habe es selber Formatiert nicht automatisch von Googl
        if(response.data.result.formatted_address.split(',')[0]) 
            $('input[name="strasse"]').val(response.data.result.formatted_address.split(',')[0]);


        // Fragt den Kürzel des Landes
        app.simpleRequest("getLand", "adressen-handle", response.data.result.formatted_address.split(',')[2], function(resultCode) {
            if(response.data.result.formatted_address.split(',')[2]) {
                var option = '<option value="' + resultCode.data[0]['code'] + '">'+ response.data.result.formatted_address.split(',')[2] +'</option>'
                $('select[name=laender]').html(option);
            }
        });

        

        if(response.data.result.formatted_address.split(',')[1].split(" ")[1]) 
            $('input[name="plz"]').val(response.data.result.formatted_address.split(',')[1].split(" ")[1]);

        if(response.data.result.formatted_address.split(',')[1].split(" ")[2]) 
            $('input[name="ort"]').val(response.data.result.formatted_address.split(',')[1].split(" ")[2]);

        if(response.data.result.international_phone_number) 
            $('input[name="telefon"]').val(response.data.result.international_phone_number);

        if(response.data.result.website) 
            $('input[name="website"]').val(response.data.result.website);

        if(response.data.result.geometry.location.lat) 
            $('input[name="latitude"]').val(response.data.result.geometry.location.lat);

        if(response.data.result.geometry.location.lng) 
            $('input[name="longitude"]').val(response.data.result.geometry.location.lng);


            
        // $('input[name="telefax"]').val($('input[name="telefax"]'));
        $('input[name="email"]').val();


        $('input[name="steuernummer"]').val($('input[name="steuernummer"]').val());
        $('input[name="umsatzsetuer_id"]').val($('input[name="umsatzsetuer_id"]').val());

        // TODO: MUSS NOCH GESCHAUT WERDEN WIE MAN DAS BERECHNET
        /*
        $('input[name="fahrtzeit"]').val(response.result.name);
        $('input[name="kilometer"]').val(response.result.name);
        */
        

    },

    submitGoogleModal(openingHours) {

        var me = this;

        // Abfrage ob man wirklich speichern möchte
        app.alert.question.fire("Sind Sie sicher?","Wollen Sie diese Adresse wirklich mit Google verknüpfen?  Alle Daten werden ÜBERSCHRIEBEN!").
            then((result) => {

                // Wenn Weiter gemacht werden soll
                if (result.isConfirmed) {

                    // Daten werden gespeichert
                    me.modalGoogleVerbinden.save('adr_d-submit', 'adressen-handle', function(response) {
            

                        // Modal wird geschlossen
                        me.modalGoogleVerbinden.close();

                        // Damit die Seite sich "indirekt" neu lädt um die geänderten Daten zu sehen
                        location.reload();
            
                    }, null, {
                        id: me.id,
                        oeffnungszeiten: openingHours
                    });
                    
                // Wenn Abgebrochen werden soll
                } else if (result.isDenied) {
                    me.modalGoogleVerbinden.close();
                }
          });

    }

}