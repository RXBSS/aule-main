// Dieses Objekt ist nur dafür das um eine neue Adresse anzulegen
// Dieses Objekt muss so gebaut werden das es global überall in Aule genutzt werden könnte 
// Dieses Objekt wird mit einem Object.assign mit einem anderen Objekt verbunden damit die funktionien hier wie callback funktionien genutzt werden können

var adressen_neu = {

    initAdressen() {

        var me = this;

        // Globale Variable
        me.callback = false;

        // Dialog zum erstellen einer neuen Adresse
        // me.openDialog();

        // Standardmäßig immer ausgeblendet
        $('.duplettenpruefung').hide();

        // Neue Modal Adressen Init
        me.initModalNeueAdresse(); 

        // EventListener für die Adressen
        me.addEventListenerAdressenNeu();

    },

    // Modal zum Neue erstellen der Adressen
    initModalNeueAdresse() {

        var me = this;

        // Modal Init um neue Adressen hinzuzufügen
        me.modalNeueAdresse = new ModalForm('#modal-adressen-neu');
        me.modalNeueAdresse.initValidation();

        
    },

    // EventListener die nur in dieser Datei stattfinden werden
    addEventListenerAdressenNeu() {

        var me = this;

        // Wenn das Modal Sichtbar ist soll die InitAutoComplete Funktion von Google geladen werden
        me.modalNeueAdresse.on('shown.bs.modal', function() {
            me.initAutocomplete();
        });

        // Wenn das Input Feld gelöscht wird
        // $('input[name="google-search"]').on('keyup', function() {
            
        //     // Wenn der Input Leer ist soll die Form gesäubert werden
        //     $('.resetForm input').val('');
        // }); 

        // Wenn das Input Feld gelöscht wird
        $('input[name="google-search"]').on('focusout', function() {
            
            // Wenn der Input Leer ist soll die Form gesäubert werden
            if($(this).val() == '') {
                me.modalNeueAdresse.clearForm();

                $('.duplettenpruefung').hide();

            }
        }); 
        

    },

   

    // Dieser Dialog wird als Callback genutzt
    openDialog(options, callback) {

        var me = this;

        // Ajax
        me.modalNeueAdresse.save('neueAdresse', 'adressen-handle.php', 
        
            // Success
            function(response) {

                // me.modalNeueAdresse.find('input').val('')
                // me.modalNeueAdresse.find('select').remove();

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                // Modal wieder schließen
                me.modalNeueAdresse.close();

                // Modal zurücksetzen
                me.modalNeueAdresse.reset(1);

                // Modal Wieder öffnent
                // options.modal.open();

                // Callback der Zurück geht
                callback(response);


            },

            // Error
            function(xhr) {

                // Fehlermeldung
                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");


            },

            // Additional Data
            {
                options: options
            }
    
        )

    },

    // Automatische Google Suche in der Leiste
    initAutocomplete() {

        var me = this;

        // TODO: GUCKEN WEGEN ASYNC das das script wartet
        // console.log(google.maps);

        // Koordinaten von Bürosystemhaus
        var bsLatLng = new google.maps.LatLng('50.5540434','9.6559213');
            
        // 
        var options = {
            bounds: new google.maps.LatLngBounds(bsLatLng),
            types: ['establishment']
        };

        // Input Feld das auf die Google Suche hört
        var input = document.getElementById("google-search");

        // AutoComplte Funktione von der Google Api
        var autocomplete = new google.maps.places.Autocomplete(input, options);

        // Event - Wenn sich das Input fehlt verändert - wenn man was eintippt
        autocomplete.addListener('place_changed', function() {
            
            // 
            var place = autocomplete.getPlace();

            // Adresseteile holen
            var address = google.getAddressComponentByPlace(place);



            if(place.place_id) me.modalNeueAdresse.container.find(('input[name="place_id"]')).val(place.place_id);
            if(place.name) me.modalNeueAdresse.container.find(('input[name=name]')).val(place.name);
            if(address.route) me.modalNeueAdresse.container.find(('input[name=strasse]')).val(address.route + ((address.street_number) ? " " + address.street_number : ""));
            if(address.postal_code) {
                $('input[name=plz]').val(address.postal_code) ;
            }
            if(address.locality) me.modalNeueAdresse.container.find(('input[name=ort]')).val(address.locality);
            if(place.geometry.location.lat) me.modalNeueAdresse.container.find(('input[name=latitude]')).val(place.geometry.location.lat);
            if(place.international_phone_number) me.modalNeueAdresse.container.find(('input[name=telefon]')).val(place.international_phone_number);
            
            if(address.political) {
                
                // Löscht in Valid und macht Valid
                $('select[name=land]').removeClass('is-invalid');
                $('select[name=land]').removeClass('is-valid');

                // Löscht das Icon
                $('i[data-field="land"]').remove();

                // Option 
                var option = '<option value="'+ address.country +'">'+ address.political +'</option>'

                // Fügt es an den Select an
                me.modalNeueAdresse.container.find(('select[name=land]')).html(option);
            }

            // Wenn Strasse und PLZ vorhanden sind
            if(address.postal_code && address.route) {

                // Daten die an die Datenbank gegeben werden und prüfen ob es so eine Adresse schon gibt
                var data = {
                    'strasse': address.route + ((address.street_number) ? " " + address.street_number : ""),
                    'plz': address.postal_code,
                }

                // Dupletten Pruefung Klasse - prüft ob "data" schon vorhanden ist und gibt eine Fehlermeldung aus wenne so ist
                var dP = new duplettenPruefung("getAdressen", "adressen-handle", data, 'An dieser Adresse ist bereits ein Kunde hinterlegt. Bitte überprüfen Sie ob der Kunde, den Sie anlegen möchten, schon vorhanden ist!');


                // app.simpleRequest("getAdressen", "adressen-handle.php", data, 
                
                //     // Success
                //     function(response) {

                //         // Wenn ein Eintrag gefunden wurde
                //         if(response.data.length >= 1) {

                //         }
                //     });
            }


            // ISt Kunde wieder auf Checked setzen
            $('#kundee').prop('checked', true);
         

        });
    }

}

// MARK: Google
google = {



    // Teile der Adresse aus Google holen
    getAddressComponentByPlace: function(place) {
        var components;

        // console.log("Google");


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