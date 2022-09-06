var ad_d = {

    init: function() {
        
        var me = this  

        me.id = app.getUrlId();

        // Hide - Stanardmäßig geHidete Dinge
        $('#adressen-kontakte-pickliste').hide();
        $('#adressen-personen-ansichten').show();

        // Kontosperre Hide
        // $('#kontosperre').hide();
       
        // var test = new CardSizer(['#adressen-bankverbindung-card', '#adressen-oeffnungszeiten-card']);

        // Init Forms
        me.initForm();

        // Zähtl wie lange Unternehmen noch offen hat
        me.getCurrentTime();
        
        // Init der Events
        me.addEventListener();


        // TODO: wenn kunde vorausgewählt als active gilt greift das quickselect nicht
    },

    initForm() {

        var me = this;

        // Adressen Stammdaten - Init der Card
        me.form = new CardForm('#form-adressen');
        me.form.load('load', 'adressen-handle.php', me.id, 
        
            // Success
            function(response) { 

                // Wenn die Adresse Gesperrt ist
                if(response.data.kunde_gesperrt == 1) {

                    // 
                    $('.kontosperre').html(' <custom class="text-danger" style="font-size=15px;"> - Konto gesperrt</custom>')

                    // Falls der Kunde gesperrt ist soll eine Meldung kommen
                    $('.kontosperre-warning').html(" <div class='alert alert-soft-danger '> Der Kunde ist gesperrt</div>")

                }

                // Set Select in Ländert
                var option = '<option value="' + response.data.land + '">'+ response.data.land_text +'</option>'
                $('select[name=laender]').html(option);

                // Powered Google vorher Löschen
                $('#powered-google').html('');

                // Wenn es keine Place ID gibt
                if(!response.data.place_id) {

                    $('#powered-google').html("<button class='btn btn-primary' type='button' id='google-verbinden'>Google Verbinden</button>");

                }

                // Wenn es eine Place ID gibt
                else {

                    $('#powered-google').html("<p>powered by <custom style='color:red;'> Google </custom> </p>");

                    $('#adressen-oeffnungszeiten-card .card-body .actions').prepend('<a class="action-item btn-oeffnungszeit-google" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Text"><i class="fab fa-google"></i></a>');
                }


                // Daten hier reinladen
                me.loadData(response);

                // Progress bar Prozent Ausrechnen Funktion
                me.progressBar(response);

            }, 

            // Error
            function(xhr) {

            }

            

            
        )
        me.form.initValidation();

    },

    addEventListener() {

        var me = this;
     
        // Adressen Stammdaten - On Submit
        me.form.on('submit', function() {
            me.form.save('adr_d-submit','adressen-handle');
        });

        // Wenn der Tab Kunden geladen wurden
        $('#pills-kunde').on('shown.bs.tab', function() {

            // Init QuickSelect
            me.quickSelect();
        });

        // Erst wenn das Modal geladen ist soll die Init Autocomplte ausgeführt werden
        $('#modal-adressen').on('shown.bs.modal', function() {
            adressen.initAutocomplete();
        });

        $('#powered-google').on('click', '#google-verbinden' , function() {
            // console.log("DFSDFFDsgdfgdfgfdg");
        })
    },

    // Lädt die Daten in die Card die von PHP kommen
    loadData(response) {

        var me = this;

        // Wenn Fahrzeit Vorhanden ist
        if(response.data.fahrtzeit) {
            $('#google_maps_infos').append(''
                + '<div class="col-md-3">'
                    + '<div class="form-group form-floating">'
                        + '<input type="text" name="fahrtzeit" value="' + response.data.fahrtzeit + '" class="form-control editable" placeholder="Fahrtzeit">'
                        + '<label>Fahrtzeit</label>'
                    + '</div>'
                + '</div>'
            + '');
        }

        // Wenn Kilometer Vorhanden ist
        if(response.data.kilometer) {
            $('#google_maps_infos').append(''
                + '<div class="col-md-3">'
                    + '<div class="form-group form-floating">'
                        + '<input type="text" name="kilometer" value="' + response.data.kilometer + '" class="form-control editable" placeholder="Kilometer">'
                        + '<label>Kilometer</label>'
                    + '</div>'
                + '</div>'
            + '');
        }

        // Wenn Latitude vorhanden ist
        if(response.data.latitude) {
            $('#google_maps_infos').append(''
                + '<div class="col-md-3">'
                    + '<div class="form-group form-floating">'
                        + '<input type="text" name="latitude" value="' + response.data.latitude + '" class="form-control editable" placeholder="Latitude">'
                        + '<label>Latitude</label>'
                    + '</div>'
                + '</div>'
            + '');
        }

        // Wenn Longitude vorhanden ist
        if(response.data.longitude) {
            $('#google_maps_infos').append(''
                + '<div class="col-md-3">'
                    + '<div class="form-group form-floating">'
                        + '<input type="text" name="longitude" value="' + response.data.longitude + '" class="form-control editable" placeholder="Longitude">'
                        + '<label>Longitude</label>'
                    + '</div>'
                + '</div>'
            + '');
        }

        // Nav Pills on Load Anzeigen
        me.navPillsOn(response.data);

    },

    // ProgressBar - Eine Funktion die alle Felder zählt und dann das auf die Bar überträgt
    progressBar(response) {

        var me = this;

        // Counter Alle Felder Variable
        var count = 0;

        // Count Alle leeren Felder
        var countNull = 0

        // Schleife die durch alle Werte durchgeht
        $.each(response.data, function(key, value) {

            // Count alle Felder ist am Ende der Letzte Key und so viele Felder haben wir insgesamt
            count++;

            // Wenn der Value Leer ist -- Quasi Null
            if(value == "" || value == null) {

                // Zähl alle Zusammen die Null sind
                countNull++;

            }

        })

        // Count - 1 sind alle Felder die es gibt -- (Aktuell 54)
        count - 1;

        // Die Differenz Ausrechnen
        // Entweder null/alle * 100 ODER 100/ alle * null
        var diff = countNull/ count * 100

        // Alles was noch fehlt in Prozent
        diff = 100 - Math.round(diff);

        // DOm Element Verändern
        $('.progress-bar').css("width", diff + "%"); // Style
        $('.progress-bar').attr("aria-valuenow", diff); // Aktuelle Wert
        $('.progress-bar').attr("data-bs-original-title", "Diese Adresse ist zu " + diff + "% vollständig!"); // Bootstrap Tooltip
        $('.progress-bar').html(diff + " %"); // Text

        // $('.progress-bar').attr('data-bs-original-title', 'new text')

    },

    // Nav Pills Anzeigen ob Kunden Lieferant oder Hersteller ist
    navPillsOn(data) {

        var me = this;

        // Erstellt das Objekt mit den IDs aus dem Nav
        var pills = {
            'ist_kunde': '#pills-kunde',
            'ist_lieferant': '#pills-lieferant',
            'ist_hersteller': '#pills-hersteller'
        }

        // Geht die vorhandenen Daten durch
        $.each(data, function(key, value) {

            // Prüfg ob es den Pill gibt
            if(pills[key]) {

                // Wenn der Wert an der Stelle 1 ist
                if(value == 1) {

                    // Füge On Toggle hinzu
                    $(pills[key]).prepend(
                        "<i class='fa-solid fa-toggle-on'></i>"
                    ) 

                // Ansonsten ist die Stelle 0
                } else {

                    // Toggle auf off
                    $(pills[key]).prepend(
                        "<i class='fa-solid fa-toggle-off'></i>"
                    ) 
                }
            }
        });

    },

    // Setzt alle Änderungen zurück
    discardForm() {
        var me = this; 

        me.form.discard();
    },

    // Funktion die zeigt wie lange das Unternehmen noch offen hat
    getCurrentTime() {

        var me = this; 

        // Rest Zeit Leeren
        $('#geoeffnet-noch').html('');

        // Ajax
        app.simpleRequest("getCurrentTime", "adressen-handle", me.id, 
        
            // Success
            function(response) {

                // Aktueller Tag 
                var day = moment().format('d');

                // Nur wenn Daten vorhanden sind
                if(response.data.length > 0) {

                    // Geht durch alle Tage durch
                    $.each(response.data, function(key, value) {

                        // Sucht den aktuellen Tag
                        if(value['tag'] == day) {

                            var oeffnungszeit;

                            // Wenn es eine Zweiten Zeit gibt zum Schließen dann nehm die
                            if(value['bis2']) {
                                oeffnungszeit = value['bis2'].split(':');

                            // Erste Schließen Zeit nehmen
                            } else {

                                // Uhrzeit die Zurück kommt
                                oeffnungszeit = value['bis1'].split(':');

                            }

                            // New Date Akzeptiert dieses Format
                            var moments =  moment().format('MM/DD/YYYY');

                            // Uhrzeit zusammenführen ohne die Sekunden (z.B. 11:00 Uhr)
                            var joinTime = oeffnungszeit[0] + ":" + oeffnungszeit[1];

                            // Aktuelle Zeit
                            var start = new Date();

                            // Zeit die zurückkommtm
                            var end = new Date(moments + " " + joinTime);

                            // Difference
                            var diff = end - start;

                            // 
                            var diffSeconds = diff / 1000; // 100 Milisekunden sind 1 Sekunde
                            
                            // Differenz der Stunden
                            var diff_hour = Math.floor(diffSeconds / 3600); // 3600 Sekunden sin 1 Stunden
                            
                            // Differenz der Minuten
                            var diff_minute = Math.floor(diffSeconds % 3600) / 60; // 3600 Sekunden = 1 Stunden / 60 Minutn sind 1 Minute

                            // console.log(diff_minute.toString().split('.')[0]);

                            // Wenn die Minuten negativ sind (Kann sein seit 0h und -1 Minute geschlossen --- deswegen auf Minuten gehen)
                            if(diff_minute.toString().split('.')[0] <= 0) {

                                // Wenn es kleiner als 0 ist dann 1 addieren sonst ist es minus ansonsten die 0 hinschreiben
                                diff_hour = (diff_hour < 0) ? Math.abs(diff_hour + 1) : diff_hour;
                                
                                // Result
                                $('#geoeffnet-noch').html('<p class="text-danger"> Geschlossen seit ' + diff_hour  + ' Std. ' +  Math.abs(diff_minute.toString().split('.')[0]) + ' Min.' + '</p>')

                            // In allen anderen fällen ist es noch geöffnetn
                            } else {

                                // Result
                                $('#geoeffnet-noch').html
                                (""
                                    + "<p class='text-success'>Geöffnet bis " + oeffnungszeit[0] + ":" + oeffnungszeit[1]  + " Uhr"
                                    + " (<strong>" + diff_hour +" Std. " + diff_minute.toString().split('.')[0] + " Min.</strong>)"
                                    +"</p>"
                                );
                            }

                            
                        }

                    });

                // Wenn es keine Zeiten gibt
                } else {

                    // Rest Zeit Leeren
                    $('#geoeffnet-noch').html('');
                }

            },

            // Error
            function(xhr) {
                console.log("-------------------- Error ------------------");
            }
        
        );

    },
    
    // Darf erst geladen bzw. initialisiert werden wenn der jeweilig Tab oder Modal fertig geladen ist
    quickSelect() {


        /*

        var me = this;

        //  QuickSelect Kunden 
        var q = new Quickselect('kontakte', {
            selector: '#kontakte',
            defaultText: 'Bitte Benutzer auswählen',
            defaultValue: '0',
        });

        // Filter auf der adressen_id = FK der Kontake
        q.setFilter('kontakte', me.id, "adressen_id");

        */
    }


}
   

