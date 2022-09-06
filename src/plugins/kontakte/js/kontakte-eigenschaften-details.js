

// Alle Funktionen die nur auf der Details Seite der Kontakte Sichtbar sind
// Dies sind nur Funktionen für die Eigenschaften Tabs
var kde = {

    // 
    init() {

        var me = this;

        // ID des Kontaktes
        me.id = app.getUrlId();

        // Adressen Neu für neue Adresse anlegen
        adressen_neu.initAdressen();

        // Init der Pickliste auf diesem Tab
        me.initPicklist();

        // Init Modal 
        me.initModal(); 

        // add Event Listner
        me.addEventListener();

    },

    // Picklist 
    initPicklist() {

        var me = this;

        // Pickliste
        me.list = new Picklist("#adressen-pickliste", "adressen_kontakte", {
            type: 'multi-picklist',
            card: true,
            data: [
                'kontakte-eigenschaften',
                me.id,
            ],
            addHandleButtons: true
        });

        // Pickliste Adressen
        // me.listAdressen = new PicklistModal('adressen', {
        //     type: "multi-picklist",
        //     autoDeselect: false,
        //     disabled: {
        //         query: {
        //             table: 'adressen_kontakte',
        //             field: 'adressen_id',
        //             filter: {
        //                 kontakte_id: me.id
        //             }
        //         },
        //         icon: '<i class="fa-solid fa-check-double text-primary"></i>'
        //     }
        // });
    },

    // Modal 
    initModal() {

        var me = this;

        me.modal = new ModalForm('#adressen-kontakte-form');
        me.modal.initValidation();
    },

    // Eventlistener
    addEventListener() {

        var me = this;

        // ************************************************************
        // Standard Event
        // ************************************************************

        // Neue Adresse Erstellen
        $('#btn-neue-adresse').on('click', function() {

            // Get Daten die schon geschrieben worden sind
            me.getData = me.modal.getData();

            // Modal zum Kontakte hinzufügen schließen
            me.modal.close();

            // Modal neue Adressen Anlegen Öffnen
            me.modalNeueAdresse.open();

        });

        // Wenn das Modal geschlossen wird soll sich wieder das Modal öffnen das als option mitgegeben wurde
        $('#adressen-neu .btn-schliessen, #adressen-neu .close').on('click', function () {
            
            me.modal.open();

            // Setzt die Daten die vor dem Schließen da waren
            me.modal.setData(me.getData);

            // Standardmäßig immer ausgeblendet
            $('.duplettenpruefung').hide();
        });

        // ************************************************************
        // Form Handler Event
        // ************************************************************

        // Wenn das Modal geöffnet werden soll
        me.list.container.on('click', '.dt-action[data-action="add"]', function() {

            // Reset
            me.modal.reset(1);

            // Modal Öffnen
            me.modal.open();
            
            

        });

        // Wenn das Formular abgeschickt werden soll
        me.modal.on('submit', function() {

            me.submit();
        });

        // Wenn ein Eintrag gelöscht werden soll
        me.list.container.on('click', '.dt-action[data-action="delete"]', function() {
            new simpleDeleteTask(me.list, 'deleteKontakteAdresse', 'kontakte-details-handle.php');
        })

        me.list.container.on('click', '.dt-action[data-action="edit"]', function() {


            // Load And Open Modal
            var tet = new simpleEditTask(me.list, me.modal, 'loadAndOpen', 'kontakte-details-handle.php')

        });

        // Wenn neue Adresse Abgeschickt werden soll
        me.modalNeueAdresse.on('submit', function () {
            me.submitNeueAdresse();
        });


    },


    // abschicken des Formulares um einen Kontakt zu einer neuen Adressen hinzuzufügen
    submit() {

        var me = this;

        
        // Save
        me.modal.save('adressen-kontakt-submit', 'kontakte-details-handle.php', 

            // Success
            function(response) {

                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                me.list.refresh();

                me.modal.reset(1);

                // me.modal.close();
            },

            // Error
            function(a,b,c) {

                var errorText = ((b.error !== true) ? b.error : 'Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!');

                app.notify.error.fire("Fehler", errorText);
            }, 

            // Additonal
            {
                'kontakte_id': me.id
            }

        );

    },

    // Wenn eine neue Adresse erstellt werden soll über die Akquise
    submitNeueAdresse() {

        var me = this;

        // Optionen
        var options = {
            'modal': me.modal,
        }

        // Open Dialog -- Abschicken der Ajax
        me.openDialog(options, function (response) {

            // Modal Wieder öffnen
            me.modal.open();

            // Neue Abfrage um die Daten wieder zu bekommen
            app.simpleRequest("get", "adressen-handle.php", response.data,

                // Success
                function (responseAdresse) {

                    // Option erstellen mit den neuen Daten
                    var option = '<option value="' + responseAdresse.data.id + '">' + responseAdresse.data.name + '</option>'

                    // Anhängen an den DOM des selects Der neuen Daten
                    $('select[name=adressen_id]').html(option);

                }
            );


        });

    },

    // Es wird nur eine Adresse hinzugefügt
    submitAdresse(el, data) {

        var me = this;

        // Ajax
        app.simpleRequest("onlyAdresse", "kontakte-details-handle", 

            // Additional
            {
                data: data,
                id: me.id
            },
          
            // Success
            function(response) {

                // Pickliste neuladen
                me.list.refresh(true);

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");


            },

            // Error
            function(xhr) {
                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }
            
        );

    }
}