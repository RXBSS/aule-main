/**
 * Alle Funktion die für die Rechnungs und Lieferadresse von Verträge sind 
 * werden hier geladen -- dient der Übersichtlichkeit
 */

var vAdr = {

    // Init der Adressen
    initAdr() {

        var me = this;

        //  Globale Variable
        me.aktiveAdresseId = false;

        // Form Adresse
        me.initFormAdr();

        // Add EventListner
        me.addEventListenerAdr();

    },

    // Alle Forms für die Adressen
    initFormAdr() {

        var me = this;

        // Verträge Adressen
        me.form = new Form('#vertraege-form');

    },

    // EventListner der Adressen
    addEventListenerAdr() {

        var me = this;

        // ***************************************************************************
        // Standard Events
        // ***************************************************************************

        // Wenn der Kunde gewählt oder gewechselt wird
        // $('select[name="rechnungsanschrift_id"]').on('change', function() {

        //     // if()
        //     me.aktiveAdresseId = $(this).val();
            
        //     // Nur Rechnungsadresse als zweiter Parameter kann Händeln das Rechnungs und Lieferadresse gesetzt werden soll
        //     me.getAdresseData($(this).val(), 'nur_rechnungsadresse');
        // });

        // Wenn der Kunde gewählt oder gewechselt wird
        // $('select[name="lieferanschrift_id"]').on('change', function() {

        //     // me.aktiveAdresseId = $(this).val();

        //     console.log("Liefreant HIER");
            
        //     me.getAdresseData($(this).val(), true);
        // });

        // Wenn Identisch mit Rechnungs Adresse abgehackt wird
        // $('input[name="ident_re_adr"]').on('change', function() {
        //     me.lieferadresseHandler($(this).prop('checked'));
        // });

        // ***************************************************************************
        // Form Handler Events
        // ***************************************************************************

    },

    // Eine Helper Funktion für die Lieferadresse je nachdem ob es an oder abgehackt wird
    lieferadresseHandler(checked) {

        var me = this;

        // Wenn Die Checkbox angehakt ist --- also True ist
        if(checked) {

            me.getAdresseData(me.aktiveAdresseId, 'nur_rechnungsadresse');

            // Dann Immer Disbaled und Editable 
            me.vertrageAdressenForm.container.find('#lieferAdresse .handler-disabled, #lieferAdresse .handler-disabled').removeClass('editable');
            me.vertrageAdressenForm.container.find('#lieferAdresse .handler-disabled, #lieferAdresse .handler-disabled').attr('disabled', true);

        }

        // Wenn die Checkbox abgehakt --- also False ist
        else {

            // Dann Editable hinzufügen und Disbaled löschen
            me.vertrageAdressenForm.container.find('#lieferAdresse .handler-disabled, #lieferAdresse .handler-disabled').addClass('editable');
            me.vertrageAdressenForm.container.find('#lieferAdresse .handler-disabled, #lieferAdresse .handler-disabled').removeAttr('disabled');



            // Restet
            me.vertrageAdressenForm.container.find('#lieferAdresse input').val('');
            me.vertrageAdressenForm.container.find('#lieferAdresse select').find('option')
            // .remove()
            .append('<option value="">bitte wählen</option>');

        }
    },

    // Holt alle Informationen wie Straße, PLZ usw. zu der gewählen Adresse
    getAdresseData(id, bool) {

        var me = this;

        // Wenn es eine ID gibt -- Andernfall soll nicht passen
        if(id > 0) {

            // Ajax
            app.simpleRequest("getAdresseData", "vertraege-handle", id, 
            
                function(response) {

                    // me.vertrageAdressenForm.setData(response.data);


                    // TODO: MINIMIEREN - DOPPPELT NICHT GUT UND BULLSHIT !!!!!c
                    // Wenn die Checkbox gesetzt ist soll auch Lieferadresse gesetzt werden
                    if($('input[name="ident_re_adr"]').prop('checked') && bool == 'nur_rechnungsadresse') {

                        me.vertrageAdressenForm.container.find('#rechnungsadresse input[name="strasse"], #lieferAdresse input[name="strasse"]').val(response.data.strasse);
                        me.vertrageAdressenForm.container.find('#rechnungsadresse input[name="plz"], #lieferAdresse input[name="plz"]').val(response.data.plz);
                        me.vertrageAdressenForm.container.find('#rechnungsadresse input[name="ort"], #lieferAdresse input[name="ort"]').val(response.data.ort);
                        me.vertrageAdressenForm.container.find('#rechnungsadresse select[name="land"], #lieferAdresse select[name="land"]').val(response.data.land);
                

                        // Option erstellen mit den neuen Daten
                        var lieferanschrift_id = '<option value="' + response.data.kunde.value + '">' + response.data.kunde.text + '</option>'

                        // Anhängen an den DOM des selects Der neuen Daten
                        $('select[name=lieferanschrift_id]').html(lieferanschrift_id);


                        // Option Land Treffen
                        var land = '<option value="' + response.data.land.value + '">' + response.data.land.text + '</option>'

                        // Anhängen an den DOM des selects Der neuen Daten
                        $('select[name=land]').html(land);
                    } 

                    // Ansonsten nur Rechnungsadresse setzen 
                    else if($('input[name="ident_re_adr"]').prop('checked') && !bool) {
                    
                        me.vertrageAdressenForm.container.find('#rechnungsadresse input[name="strasse"]').val(response.data.strasse);
                        me.vertrageAdressenForm.container.find('#rechnungsadresse input[name="plz"]').val(response.data.plz);
                        me.vertrageAdressenForm.container.find('#rechnungsadresse input[name="ort"]').val(response.data.ort);
                        me.vertrageAdressenForm.container.find('#rechnungsadresse select[name="land"]').val(response.data.land);
                

                        // Option erstellen mit den neuen Daten
                        var lieferanschrift_id = '<option value="' + response.data.kunde.value + '">' + response.data.kunde.text + '</option>'

                        // Anhängen an den DOM des selects Der neuen Daten
                        $('select[name=lieferanschrift_id]').html(lieferanschrift_id);


                        // Option Land Treffen
                        var land = '<option value="' + response.data.land.value + '">' + response.data.land.text + '</option>'

                        // Anhängen an den DOM des selects Der neuen Daten
                        $('select[name=land]').html(land);
                    }

                    // Wenn Nur Lieferanschrift
                    else if(!$('input[name="ident_re_adr"]').prop('checked') && bool){

                        me.vertrageAdressenForm.container.find('#lieferAdresse input[name="strasse"]').val(response.data.strasse);
                        me.vertrageAdressenForm.container.find('#lieferAdresse input[name="plz"]').val(response.data.plz);
                        me.vertrageAdressenForm.container.find('#lieferAdresse input[name="ort"]').val(response.data.ort);
                        me.vertrageAdressenForm.container.find('#lieferAdresse select[name="land"]').val(response.data.land);
                

                        // Option erstellen mit den neuen Daten
                        var lieferanschrift_id = '<option value="' + response.data.kunde.value + '">' + response.data.kunde.text + '</option>'

                        // Anhängen an den DOM des selects Der neuen Daten
                        $('select[name=lieferanschrift_id]').html(lieferanschrift_id);


                        // Option Land Treffen
                        var land = '<option value="' + response.data.land.value + '">' + response.data.land.text + '</option>'

                        // Anhängen an den DOM des selects Der neuen Daten
                        $('select[name=land]').html(land);
                    }

                    


                },

                // Error
                function(xhr) {

                    app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                }
                
            );

        }

    },


}