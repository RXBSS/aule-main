
var kontakte = {
    
    // init
    init: function() {

        var me = this; 

        // Abteilung etc. sollte nur auf der Detailsseite Eintragbar sein 
        // $('#kontakt-adresse').hide();

        // Kontakte Modal - zum neu anlegen von einem Kontakt
        me.modal = new ModalForm('#modal-kontakte-form');
        me.modal.initValidation();

        // Kontakte Pickliste - Kontakte Landing Page
        me.list = new Picklist('#kontakte-pickliste', 'kontakte', {
            type: 'single',
            card: false,
            config: {
                file: 'config-overwrite.json' 
            }
        });

        // Kontake Mehr anzeigen
        me.kontakte_ma = $('#kontakte-mehr-anzeigen');
        me.kontakte_ma.hide();

        // Adresen Pickliste Modal - für die Auswahl von einem Unternehmen in dem man arbeitet
        me.adressen = new PicklistModal("adressen", {
            type: 'single-picklist'
        });
        
        // Eventlistener
        me.addEventListener();

    },

    // EventListener
    addEventListener() {
        
        var me = this; 

        // Kontakte Mehr Anzeigen - Toggler
        $('#kontakte-mehr-anzeigen-toggler').on('click', function() {
            me.mehrAnzeigen();
        });

        // Kontakte Modal - Wenn das Model geschlossen wird soll alles vollständig zurückgesetzt werden
        me.modal.container.on('click', '.btn-schliessen', function() {
            me.reset();
        });

        // Kontakte - Weiterleitung auf die Detailsseite
        me.list.on('pick', function(el, data) {
            app.redirect('kontakte-details.php?id=' + data[1]);
        });

        // Adressen Modal - Wenn ein Datensatz aus Adressen ausgeweählt wurde
        me.adressen.on('pick', function(el, data) {
            me.modal.container.show();
            me.modal.open();
            me.modal.container.find('input[name=unternehmen]').val(data[2]);
            me.modal.container.find('input[name=adressen_id]').val(data[1]);
        });

        // Adressen Modal - Modalform soll verschwinden wenn die Pickliste geöffnet wird
        $('#pickliste-adressen-open').on('click', function() {
            me.adressen.open();
            me.modal.container.hide();
        });

        // Modal Öffnen
        $('#modal-kontakte-open').on('click', function() {
            me.modal.open();
        });

        // Adressen Auswahl - Modalform soll wieder kommen wenn die Pickliste geschlossen wird
        me.adressen.container.on('click', '.btn-dt-close', function() {
            me.adressen.close();
            me.modal.container.show();
            me.modal.open();
        });

        me.modal.on('submit', function() {
            me.submit();
        });

        // Modal Klasse übernimmt alle Aufgaben
        // me.simpleModalTask = new simpleModalTask('#modal-kontakte-open', me.list, me.modal, 'k-submit', 'kontakte-handle');
        me.simplePickListeTask= new simpleModalTask('#pickliste-adressen-open', me.modal, me.adressen, null, null, null);

        
    },

    // Wenn ein neuer Kontakt erstellt wird
    submit() {

        var me = this;

        // id der Ausgewählten Zeile
        var id = me.list.getSelectedSingle();

        // Save Funktion
        me.modal.save('k-submit', 'kontakte-handle', function(response) {

            /* Callback Success */

            // Alle Input-Felder werden gesäubert
            me.modal.clearForm(); 

            me.modal.close(); 
            
            // Erfolgsmeldung
            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich ausgeführt");
            
            // PickListe soll automatisch neu geladen werden -> damit man das Ergebnis sieht
            me.list.refresh(true);

            app.redirect('kontakte-details.php?id=' + response.data.data);


        },
        /* Callback Error ist nicht vorhanden */
        false);

    },

    mehrAnzeigen() {
        var me = this; 

        // Toggler
        me.kontakte_ma.toggle();

        // Text ändert sich
        $('#kontakte-mehr-anzeigen-toggler').text(function(i, text){
            return text === "Mehr anzeigen" ? "Weniger anzeigen" : "Mehr anzeigen";
        });

    },

    // Reset Funktion
    reset() {

        // Kontake Mehr anzeigen - Details sollen verschwinden
        $('#kontakte-mehr-anzeigen').hide();

        // Kontakte Mehr anzeigen - Text wird wieder auf das Standard "Mehr anzeigen" zurückgesetzt
        $('#kontakte-mehr-anzeigen-toggler').text(function(i, text){
            return"Mehr anzeigen";
        });
    }

}