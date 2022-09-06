/**
 * @class Adressen 
 * 
 * 
 * 
 */
var adressen = {

    // init
    init: function() {

        var me = this;

        // Öffnungszeiten ist Standardmäßig das Label nicht da
        $('#oeffnungszeiten').hide();
        $('#standort').hide();

        // Koordinaten werden entweder von der Google Auto Funktion eingetragen oder gar nicht
        $('#google-koordinaten').hide();
       
        // Details Tab Ausblenden - Außer Google Trägt die Öffnungszeiten mit ein
        $('#details-tab').hide();

        // Modal - Adressen
        me.modal = new ModalForm('#modal-adressen-form');
        me.modal.initValidation();

        // Pickliste - Adressen
        me.list = new Picklist('#adressen-pickliste', 'adressen', {
            type: 'single',
            card: false
        });

        // addEventListener
        me.addEventListener();

    },

    // EventListener
    addEventListener() {

        var me = this;
        
        // Weiterleitung - wenn eine Auswahl in der Pickliste getroffen wurde
        me.list.on('pick', function (el, data) {
            app.redirect('adressen-details.php?id=' + data[1]);
        });

        // Google Suchfeld - Wenn das Input der Google Suche geleert wird dann soll sich alle reseten
        $('#google-search').on('change', function() {
            if($('input[name=google-search').val() == '') {
                me.reset(); 
            }
        });

        // Adressen Modal - Open
        $('#modal-adressen-open').on('click', function() {
            me.modal.open();
        });

        // Adressen Modal - Submit 
        me.modal.on('submit', function() {
            me.submit();
        });

        // Adressen Modal - Formular wird geleert beim Schließen
        $('.btn-schliessen').on('click', function() {
            me.reset();
            $('#details-tab').hide();
        });

        // Duplettenprüfung - Ist die Adresse bereits vorhanden Abfrage
        $('input[name="plz"]').on('blur', function() {
            me.adressenDuplettenpruefung();
        });

        // Todo: InitAutoComplete ????
        $('#modal-adressen').on('shown.bs.modal', function() {
            me.initAutocomplete();
        });
    },

    adressenDuplettenpruefung() {

        // Holt die Daten aus den Input Feldern um Sie weiterzugeben
        var strasse = $('input[name="strasse"]').val();
        var plz = $('input[name="plz"]').val();
        var data = {
            strasse: strasse,
            plz: plz
        }

        // Dupletten Pruefung Klasse - prüft ob "data" schon vorhanden ist und gibt eine Fehlermeldung aus wenne so ist
        var dP = new duplettenPruefung("getAdressen", "adressen-handle", data, 'An dieser Adresse ist bereits ein Kunde hinterlegt. Bitte überprüfen Sie ob der Kunde, den Sie anlegen möchten, schon vorhanden ist!');

    },

    // Submit
    submit() {
        var me = this;
        
        // ID das ausgewählt wurde für additional Data
        var id = me.list.getSelectedSingle();

        // 
        var listContainerClass = me.list.container.attr('class');

        // Modal soll gepspeichert werden
        me.modal.save('adr-submit', 'adressen-handle', function(response) {

            //  Modall schließt
            me.modal.close(); 


            // Es wird geprüft ob die Pickliste ein Modal ist damit es danach wieder geöffnet werden soll
            if(listContainerClass == 'modal dt-modal') {
                me.list.open();
            }

            // Input Felder werden gesäubert
            me.modal.clearForm(); 

            // Rückmeldung
            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich ausgeführt");
            
            me.list.refresh(true);

            // Custom Reset Funktion
            me.reset();

            // Alert der Duplettenprüfung soll verschwinden
            $('.duplettenpruefung').hide();

            // Details Tab soll verschwinde
            $('#details-tab').hide();

            // Wenn es ein ID gibt 
            if(response.data.data) {

                // Weiterleitung auf die Adresse die gerade erstellt wurde
                app.redirect('adressen-details.php?id=' + response.data.data);


            }

          
        }, false,
            {
            id: id,
            oeffnungszeiten: me.oeffnungszeiten
        });
    },

    reset() {
        // TODO: clearForm cleart die Unteren Felder nicht - Wieso?
        $('input').val('');

        // Google - Optionsfeld Länder zurücksetzen
        var option = '<option value="">Bitte Wählen</option>'
        $('#select-laender').html(option);

        // Google - Öffnungszeiten verstecken
        $('.oeffnungszeiten-container').hide();

        // Keine Details Einblenden
        $('#keine-details').show();

        // Google - Bilder des Unternehmen verstecken
        $('#photos').hide();

        // Google Koordinaten - sollen verschwinden
        $('#google-koordinaten').hide();
        
    },

    initAutocomplete() {

        var me = this;


        // Koordinaten von Bürosystemhaus
        var bsLatLng = new google.maps.LatLng('50.5540434','9.6559213');
			
        // 
        var options = {
            bounds: new google.maps.LatLngBounds(bsLatLng),
            types: ['establishment']
        };

        // Input Feld
        var input = document.getElementById("google-search");

        // AutoComplte Funktione von der Google Api
        var autocomplete = new google.maps.places.Autocomplete(input, options);

        // Event
        autocomplete.addListener('place_changed', function() {
            
            var place = autocomplete.getPlace();

            // Adresseteile holen
            var address = google.getAddressComponentByPlace(place);

            // console.log(address);
            // console.log(place);

            if(place.place_id) $('input[name="place_id"]').val(place.place_id);
            if(place.name) $('input[name=name]').val(place.name);
            if(address.route) $('input[name=strasse]').val(address.route + ((address.street_number) ? " " + address.street_number : ""));
            if(address.postal_code) {
                $('input[name=plz]').val(address.postal_code) ;
                // me.adressenDuplettenpruefung();
            }
            if(address.locality) $('input[name=ort]').val(address.locality);
            // if(place.geometry.location.lat) $('input[name=latitude]').val(place.geometry.location.lat);
            // if(place.geometry.location.lng) $('input[name=longitude]').val(place.geometry.location.lng);
            if(place.international_phone_number) $('input[name=telefon]').val(place.international_phone_number);
            if(place.website) {

                // 
                $('input[name=website]').val(place.website);

                // Mehr anzeigen soll eingeblendet werden
                $('#mehr-anzeigen').show();

                // 
                $('#mehr-anzeigen-offen').val('ma-open');

                // Text wird auf Weniger anzeigen gewechselt
                $('#mehr-anzeigen-toggler').text(function(i, text){
                    return "Weniger anzeigen";
                });   
            }
            if(address.political) {
                
                // Option 
                var option = '<option value="'+ address.country +'">'+ address.political +'</option>'

                // Fügt es an den Select an
                $('select[name=laender]').html(option);
            }

            if(place.opening_hours) {

                // Label für Offnunggszeiten zeigen mit gestrichelter Kenntlicher Linie
                $('#oeffnungszeiten').show();

                var oeffnungszeiten = "";

                // Tabelle erstellen
                $.each(place.opening_hours.weekday_text, function(index, value) {
                    var subvalues = value.split(':');
                    var weekday = subvalues.shift();


                    // Fügt die Öffnungszeiten zu in die Variable
                    oeffnungszeiten += weekday + subvalues.join(":") + "\n";
                });


                // Öffnungszeiten in das BS-Toolip geschrieben
                var tooltip = new bootstrap.Tooltip('.labelOeffnugnszeitenOn', {
                    title: oeffnungszeiten
                });

                // $('.labelOeffnugnszeitenOn').attr('data-bs-title', oeffnungszeiten);

                // Stanard wieder weg
                $('.labelOeffnugnszeitenOff').hide();

              
            } else {

                // Öffnungszeiten ausblenden
                $('.oeffnungszeiten-container').hide().find('.oeffnungszeiten-table').html('');
            }

            var photos = "<div class='row'>";

            // Check for Photos
            if(place.photos) {

                $('#photos').show();

                // Loop Photos
                $.each(place.photos, function(index, value) {
                    
                    // Add Photo URL
                    photos += "<div class='col'><img src='" + value.getUrl() + "' class='img-fluid'></div>";
                    
                    // Break to Show only 3 Images
                    if(index > 1) {
                        return false;
                    }

                });
            } 

            photos += "</div>";

				// Set Photos
            $('#photos').html(photos);

            // Get Directory Service
            var directionsService = new google.maps.DirectionsService();

            // Create Request				  
            var request = {
                origin: bsLatLng,
                destination: place.geometry.location,
                travelMode: 'DRIVING'
            };
					
            // Get Route				
            directionsService.route(request, function(result, status) {

                $('.trigger-on-off').val("1");
                
                // Wenn der Status Ok ist
                if (status == 'OK') {

                    // Standort wieder anzeigen
                    $('#standort').show();

                    // Bootstrap BS-Tooltip Hinzufügen
                    var tooltip = new bootstrap.Tooltip('.labelStandort', {
                        title: "Kilometer: " + parseFloat(result.routes[0].legs[0].distance.value / 1000).toFixed(1) + "\n" + "Fahrzeit: " + moment().startOf('day').seconds(result.routes[0].legs[0].duration.value).format('HH:mm')
                    });

                    // Kilometer und Fahrzeit setzen
                    // $('input[name=kilometer]').val(parseFloat(result.routes[0].legs[0].distance.value / 1000).toFixed(1));
                    // $('input[name=fahrtzeit]').val(moment().startOf('day').seconds(result.routes[0].legs[0].duration.value).format('HH:mm'));
            
                // Wenn es keine Info's gibt				
                } else {

                    $('#google-koordinaten').hide();
                    $('input[name=kilometer], input[name=fahrtzeit]').val("");
                }

                // Blur
                $('input').trigger('blur');
            });	

        });
    }
}

// MARK: Google
google = {


    // Teile der Adresse aus Google holen
    getAddressComponentByPlace: function(place) {
        var components;

        components = {};

        $.each(place.address_components, function(index1, value1) {
            
            $.each(value1.types, function(index2, value2) {
                
                if(value2 == 'country') {
                    components[value2] = value1.short_name;
                } else {
                    components[value2] = value1.long_name;
                }				
            });
        });
        
        return components;
    }

}