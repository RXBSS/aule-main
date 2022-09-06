
/**
 * ARTIKELGRUPPEN
 * 
 * 
 * 
 * 
 */
 var ag = {

    // 
    init: function() {

        var me = this;

        // Get Cookie Verträge Gruppen
        me.getCookie();

        // Modal - Artikelgruppen
        me.modalAG = new ModalForm('#artikel-gruppen-form');
        me.modalAG.initValidation();

        // Modal - Attribute
        me.modalAGA = new ModalForm('#artikel-gruppen-attribute-form');
        me.modalAGA.initValidation();

        // Modal - Kostenstelle
        me.modalKS = new ModalForm('#kostenstellen-form');
        me.modalKS.initValidation();

        // Modal - Lagerverwaltung
        me.modalLG = new ModalForm('#lagerverwaltung-form');
        me.modalLG.initValidation();

        // Modal - Zahlungsbedingungen
        me.modalZB = new ModalForm('#zahlungsbedingungen-form');
        me.modalZB.initValidation();

        // Modal - Zahlungsbedingungen
        me.modalZaehler = new ModalForm('#zaehler-form');
        me.modalZaehler.initValidation();

        // Modal - Meilensteine
        me.modalMeilensteine = new ModalForm('#form-meilenstein');
        me.modalMeilensteine.initValidation();

        // Modal - Vertragsgruppen
        me.modalVertaegegruppen = new ModalForm('#vertraegegruppen-form');
        me.modalVertaegegruppen.initValidation();


        // ---------------------------------------------------------------------
        // ---------------------------------------------------------------------
        // ---------------------------------------------------------------------
        // ---------------------------------------------------------------------
        
        // Pickliste Artikelgruppe
        me.listModalAG = new PicklistModal("artikel_gruppen", {
            type: 'multi-picklist',
            addHandleButtons: true,
            submitButton: false
        });

        // Pickliste - Artikelgruppen Attribute
        me.listModalAGA = new PicklistModal('artikel_attribute', {
            type: 'multi-picklist',
            addHandleButtons: true,
            submitButton: false
        });

        // Pickliste - Kostenstellen
        me.listModalKS = new PicklistModal('kostenstellen', {
            type: 'multi-picklist',
            addHandleButtons: true,
            submitButton: false
        });

        // Pickliste - Lagerverwaltung
        me.listModalLG = new PicklistModal('lager', {
            type: 'multi-picklist',
            addHandleButtons: true,
            submitButton: false
        });

        me.listModalZB = new PicklistModal('zahlungsbedingungen', {
            type: 'multi-picklist',
            addHandleButtons: true,
            submitButton: false
        });

        // Pickliste - Zähler
        me.listModalZaehler = new PicklistModal('zaehler', {
            type: 'multi-picklist',
            addHandleButtons: true,
            submitButton: false
        });

        // Pickliste - Veträgegruppen
        me.listVertaegegruppen = new PicklistModal('vertraege_gruppen', {
            type: 'multi-picklist',
            addHandleButtons: true,
            submitButton: false,
            addButtons: [
                {
                    action: "up",             
                    class: "btn-pos-shift",
                    icon: "fa-solid fa-chevron-up",           
                    tooltip: "Hoch",     
                    show: 'onSingleSelected',
                    pos: 4       
                },
                {
                    action: "down",             
                    class: "btn-pos-shift",
                    icon: "fa-solid fa-chevron-down",           
                    tooltip: "Runter",     
                    show: 'onSingleSelected',
                    pos: 5                        
                }
            ]
        });


        // Pickliste - Meilensteine Akquise
        me.listMeilenstein = new PicklistModal('akquise_meilenstein',  {
            type: 'multi-picklist',
            addHandleButtons: true,
            submitButton: false,
            data: {
                'aktion_id': 0,
                'setMeilenStein': '1'
            },
            addButtons: [
                {
                    action: "up",             
                    class: "btn-pos-shift",
                    icon: "fa-solid fa-chevron-up",           
                    tooltip: "Hoch",     
                    show: 'onSingleSelected',
                    pos: 4       
                },
                {
                    action: "down",             
                    class: "btn-pos-shift",
                    icon: "fa-solid fa-chevron-down",           
                    tooltip: "Runter",     
                    show: 'onSingleSelected',
                    pos: 5                        
                }
            ]

        });



        // me.quickselect = new Quickselect('artikel_attribute', {
        //     selector: '#selectAttribute',
        //     defaultText: 'Bitte auswählen',
        //     defaultValue: '0'
        // });


        // Event Listner hinzufügen
        me.addEventListener();

    },

    /**
     * Die EventListner
     * 
     * 
     */
    addEventListener() {

        var me = this;

        // Modal (oontainer, initModal, submitTask, handleFile)
        me.simpleModalTaskAG = new simpleModalTask('#artikelgruppen-modal-open', me.listModalAG, me.modalAG, 'ag-submit', 'weitere-stammdaten-handle');
        me.simpleModalTaskAGA = new simpleModalTask('#artikelgruppen-attribute-modal-open', me.listModalAGA, me.modalAGA, 'aga-submit', 'weitere-stammdaten-attribute-handle');
        me.simpleModalTaskKS = new simpleModalTask('#kostenstellen-modal-open', me.listModalKS, me.modalKS, 'ks-submit', 'weitere-stammdaten-kostenstellen-handle');
        me.simpleModalTaskLG = new simpleModalTask('#lagerverwaltung-modal-open', me.listModalLG, me.modalLG, 'lg-submit', 'weitere-stammdaten-lagerverwaltung-handle');
        me.simpleModalTaskZB = new simpleModalTask('#zahlungsbedingungen-modal-open', me.listModalZB, me.modalZB, 'zb-submit', 'weitere-stammdaten-zahlungsbedingungen-handle');
        me.simpleModalTaskZaehler = new simpleModalTask('#zaahler-modal-open', me.listModalZaehler, me.modalZaehler, 'zaehler-submit', 'weitere-stammdaten-zaehler-handle');
        me.simpleModalTaskZaehler = new simpleModalTask('#meilensteine-modal-open', me.listMeilenstein, me.modalMeilensteine, 'createMeilenstein', 'akquise-handle');
        
        me.simpleModalTaskVertraegegruppen = new simpleModalTask('#vertraegegruppen-modal-open', me.listVertaegegruppen, me.modalVertaegegruppen, 'vertraegegruppen-submit', 'vertraege-handle');


        // Pickliste (id, list_name, modal_name, deleteTask, handleFile, editTask)
        me.simplePickListeTasksAG = new simplePickListeTasks('#artikelgruppen-pickliste-open', me.listModalAG, me.modalAG, 'ag-delete', 'weitere-stammdaten-handle.php', 'ag-edit');
        me.simplePickListeTasksAGA = new simplePickListeTasks('#artikelgruppen-attribute-pickliste-open', me.listModalAGA, me.modalAGA, 'aga-delete', 'weitere-stammdaten-attribute-handle.php', 'aga-edit');
        me.simplePickListeTasksKS = new simplePickListeTasks('#kostenstellen-pickliste-open', me.listModalKS, me.modalKS, 'ks-delete', 'weitere-stammdaten-kostenstellen-handle.php', 'ks-edit');
        me.simplePickListeTasksLG = new simplePickListeTasks('#lagerverwaltung-pickliste-open', me.listModalLG, me.modalLG, 'lg-delete', 'weitere-stammdaten-lagerverwaltung-handle', 'lg-edit');
        me.simplePickListeTasksZB = new simplePickListeTasks('#zahlungsbedingungen-pickliste-open', me.listModalZB, me.modalZB, 'zb-delete', 'weitere-stammdaten-zahlungsbedingungen-handle', 'zb-edit');
        me.simplePickListeTasksZaehler = new simplePickListeTasks('#zaehler-pickliste-open', me.listModalZaehler, me.modalZaehler, 'zaehler-delete', 'weitere-stammdaten-zaehler-handle', 'zaehler-edit');
        me.simplePickListeTasksZaehler = new simplePickListeTasks('#meilensteine-pickliste-open', me.listMeilenstein, me.modalMeilensteine, 'deleteMeilensteine', 'akquise-handle', 'editMeilenstein');

        me.simplePickListeTasksZaehler = new simplePickListeTasks('#vertraegegruppen-pickliste-open', me.listVertaegegruppen, me.modalVertaegegruppen, 'deleteVertaegegruppen', 'vertraege-handle', 'editVertaegegruppen');


        // Meilenstein Submit Funktion 
        // var modaltask = new simpleModalTask(false, me.listMeilensteine, me.meilensteinModalForm, 'createMeilenstein', 'akquise-handle.php', me.id);


        // Wenn ein Meilenstein die Position verschoben werden soll
        me.listMeilenstein.container.on('click', '.btn-pos-shift', function() {
            var direction = $(this).data('action');

            me.posShift(direction, me.listMeilenstein, 'akquise-handle');

        });

        me.listVertaegegruppen.container.on('click', '.btn-pos-shift', function() {
            var direction = $(this).data('action');

            me.posShift(direction, me.listVertaegegruppen, 'vertraege-handle');
        });
    },

    // Positionen Veschieben AJAX
    posShift(direction, liste, handleFile) {

        var me = this;

        // Die ID der Spalte auslesen -- Global immer überschrieben
        me.colID = liste.getSelectedColumn(1);

        // Ajax
        app.simpleRequest("positionen-shift", handleFile, 
        
            // Additonnal
            {
                id: false, 
                colID: me.colID, 
                direction: direction
            }, 
            
            // Erfolg
            function(response) {
                liste.refresh();

                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

            },

            // Fehler
            function(a,b,c) {

                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }
        );

    },

    getCookie() {


        $.each(decodeURIComponent(document.cookie).split(' '), function(key, value) {
            
            // Wenn dia eine id hat
            if(value.split('vg=')[1] > 0) {

                // Verträgegruppen Button 
                $('#acc-prozesse-3 .accordion-button').removeClass('collapsed').attr('aria-expanded', "true");

                // Veträge Gruppen Content Show
                $('#acc-prozesse-collapse-3').addClass('show')

                // Cookie wieder löschen
                document.cookie = "vg=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            } 
        });

    }
}