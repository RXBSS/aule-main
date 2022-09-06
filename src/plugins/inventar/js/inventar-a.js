// Dieses Objekt wird auf beiden Seiten geladen -- Hier sind funktionen die für die Details und Landing Page sind

var i_both = {


    initBoth() {

        var me = this;

        // Eventlistner die auf beiden Seiten da sein soll
        me.addEventListenerBoth();

    },

    addEventListenerBoth() {

        var me = this;

        // ********************************************************************************
        // Standard Events
        // ********************************************************************************

        // Wenn der Kaufpreis geändert wird
        $('input[name="kaufpreis"]').on('keyup', function() {

            // Wenn der Kaufpreis größer als 800 Euro ist
            me.abschreibungToggler(parseInt($(this).val()));
            
        });


        // Wenn das Kaufdatum verändert wird soll sich das Enddatum der Abschreibung anpassen
        $('input[name="kaufdatum"]').on('change', function() {
            me.kaufdatum = $(this).val();

            me.abschreibeEndDatum(me.kaufdatum);
        });

        // Wenn der Abschreibezeitraum verändert wird soll sich das Enddatum auch verändertn
        $('input[name="abschreibezeitraum"]').on('keyup', function() {
            me.abschreibeEndDatum(me.kaufdatum);
        });

    },

    // Funktion die ein Enddatum hinzufügt damit der Benutzer sieht wann die Abschreibung zu ende ist
    abschreibeEndDatum(kaufdatum) {

        var me = this;

        // Rüchgabe Wert
        var res;

        // Jahre
        var abschreibezeitraum = $('input[name="abschreibezeitraum"]').val()

        // Nur wenn es einen Wert gibt
        if(kaufdatum !== undefined) {

            // Wenn der Wert größer als 0 ist
            if(abschreibezeitraum > 0) {
                res = moment(kaufdatum).add(abschreibezeitraum, 'years').format("DD.MM.YYYY");
            } else {
                res = moment(kaufdatum).format("DD.MM.YYYY");
            }
        }

        // Rückgabe als Value gespeichert
        $('input[name="enddatum"]').val(res);


    },

    // Funktion die die Abschreibung triggert
    abschreibungToggler(val) {

        var me = this;

        // Wenn der Kaufpres größer als 800 ist
        if(val >= 800) {

            // Checkbox wird angehackt
            $('input[name="abschreibung"]').prop('checked', true);
                
            // Wert wird auf 1 gesetzt für die API PHP
            $('input[name="abschreibung"]').val(1);

            // Die Felder die ausgefüllt werden sollen werden angezeigt
            $('#abschreibung').show();
        } else {

            // Checkbox wird angehackt
            $('input[name="abschreibung"]').prop('checked', false);

            // Wert wird auf 0 gesetzt für die API PHP
            $('input[name="abschreibung"]').val(0);

            // Felder werden ausgeblendet
            $('#abschreibung').hide();

        }

    },

    // Verleih beenden
    verleihBeenden(id, callback) {

        var me = this;

        // Id
        // var id = me.list.getSelectedSingle()[1];


        // Mit Ajax Verleih beenden
        app.simpleRequest("verleihBeenden", "inventar-handle", id, 
        
            // Success
            function(response) {

                callback(response);

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
            },

            // Error
            function(response) {
                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }
            
        );

    },

    // Submit Modal Verleih
    verleihSubmit(id, el, callback) {

        var me = this;

        el.save('verleihSubmit', 'inventar-handle', 
        
            // Success
            function(response) {

                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                callback(response);

            },

            // Error 
            function(response) {
                app.alert.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            },

            // Additional
            {
                id: id
            }
        
        )

    },


}