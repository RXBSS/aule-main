/**
 * 
 * 
 * 
 * 
 */
var detailHelperPos = {



    /**
    * Event Listner für die Positionen
    */
    addPosListner: function () {

        var me = this;

        // Hinzufügen
        $('.btn-pos-add').on('click', function () {
            me.posAddStart();
        });

        // Löschen
        $('.btn-pos-delete').on('click', function () {
            me.posDeleteByList();
        });

        // Verschieben
        $('.btn-pos-shift').on('click', function () {
            var direction = $(this).data('shift');
            me.posShiftByList(direction);
        });

        // Der Bearbeiten Button
        $('.btn-pos-edit').on('click', function () {
            var id = me.positionList.getSelectedSingleColumn(1);
            me.openPosition(id);
        });

        // Entfernen drücken
        hotkeys('del', function (event, handler) {
            var ids = me.positionList.getSelectedSingleColumn(1);
            if (ids) {
                me.posDeleteStart(ids);

            }
        });


        // TODO: Sobald hotkeys in Version 4.0 erscheinen, muss mit "Split Key" angepasst werden
        // Siehe https://github.com/JohannesKlauss/react-hotkeys-hook/issues/544
        hotkeys('*', function (event, handler) {
            if (event.key === "+") {
                console.log('-- Pressed Plus');
            }

            if (event.key === "-") {
                console.log('-- Pressed Minus');
            }
        });


        // Wenn man STRG drückt
        $(window).on('keydown', function (evt) {
            if (evt.which == 17) {
                $('.btn-pos-shift i').each(function () {
                    if ($(this).hasClass('fa-chevron-up')) {
                        $(this).removeClass().addClass('fa-solid fa-arrow-up');
                    } else if ($(this).hasClass('fa-chevron-down')) {
                        $(this).removeClass().addClass('fa-solid fa-arrow-down');
                    }
                });

            }
        }).on('keyup', function (evt) {
            if (evt.which == 17) {
                $('.btn-pos-shift i').each(function () {
                    if ($(this).hasClass('fa-arrow-up')) {
                        $(this).removeClass().addClass('fa-solid fa-chevron-up');
                    } else if ($(this).hasClass('fa-arrow-down')) {
                        $(this).removeClass().addClass('fa-solid fa-chevron-down');
                    }
                });
            }
        });

        // Form 
        me.positionForm.container.on('click', '.btn-positionen-speichern', function () {

            // Noch Mal validieren
            me.positionForm.fvInstanz.validate().then(function (status) {
                
                // Wenn die Form Valide ist, dann speichern
                if(status == 'Valid') {
                    me.posSave();
                }
            });
        });
    },


    /**
     * Initalisieren der Positionen Liste
     */
    initPositionsListe(name) {

        var me = this;

        // Postitionen anpassen
        me.positionList = new Picklist("#pickliste-positionen", name, {
            type: 'multi-picklist',
            card: false,
            search: false,
            pagination: false,
            lengthMenu: false,
            buttons: false,
            data: me.id
        });

        // Wenn vollständig initalisiert ist
        me.positionList.on('initComplete', function () {

            // Kalkulation durchführen
            me.calculateTotal();

            // Artikel-Liste
            me.handlePositionSelection();
        });

        // Selection
        me.positionList.on('selection', function () {
            me.handlePositionSelection();
        });
    },


    /**
     * Liste zum Auswählen der Artikel
     */
    initArtikelListe() {

        var me = this;

        // 
        me.artikelSearchList = new PicklistModal("artikel", {
            type: 'multi-picklist'
        });
    },


    initPositionForm() {

        var me = this;

        // Form initalisieren
        me.positionForm = new Form('#form-position');

        // Form Validation aktivieren
        me.positionForm.initValidation();

        // Aktiviert die Kalkulation
        me.initCalculation();
    },




    /**
     * Laden einer Position
     * @param {*} posId 
     * 
     */
    loadPositionFormStart(posId, callback) {

        // multiple
        var me = this;

        // Positions ID als Array
        posId = (Array.isArray(posId)) ? posId : [posId];

        // Positions Id eintragen
        me.positionForm.container.find('input[name=id]').val(posId);

        // Wenn es nur eine Positoin ist
        if (posId.length == 1) {

            // Position laden
            me.loadSinglePosition(posId, function (posId, response) {

                // Eine Position setzen
                me.setSinglePosition(posId, response, function (posId, response) {
                    callback(posId, response);
                });

            });

            // Wenn es mehrere Postionen sind
        } else {

            // Position laden
            me.loadMultiPosition(posId, function (posIds, response) {

                // Eine Position setzen
                me.setMultiPosition(posIds, response, function (posIds, response) {
                    callback(posIds, response);
                });

            });
        }
    },

    /**
     * Eine Position laden
     */
    loadSinglePosition(posId, callback) {

        var me = this;

        // Position laden
        me.positionForm.load('positionen-load', me.handler, posId[0], function (response) {
            console.log('-- Loaded');
            callback(posId[0], response);
        });

    },

    /**
     * Alles machen, was mit einer Position gemacht werden soll
     */
    setSinglePosition(posId, response, callback) {

        var me = this;

        me.setMultiWarning(false);

        // Form Daten erneuern
        me.positionForm.renewInitFormData();

        callback(posId, response);
    },

    /**
     * Mehrere Positionen laden
     */
    loadMultiPosition(posIds, callback) {

        var me = this;

        // Form zurücksetzen
        me.positionForm.reset(1);

        // 
        callback(posIds, {});
    },

    /**
     * Mehrere Positionen setzen
     */
    setMultiPosition(posIds, response, callback) {

        var me = this;

        me.setMultiWarning(true);

        // Form Daten erneuern
        me.positionForm.renewInitFormData();

        callback(posIds, response);

    },

    setMultiWarning(set) {

        var me = this;

        if (set) {

            // Rahmen setzen
            me.positionForm.container.closest('.col-selector').find('.card').css({ 'border': '1px solid #c0392b' });
            me.positionForm.container.find('#form-multi-artikel-warning').show();

        } else {
            // Rahmen setzen
            me.positionForm.container.closest('.col-selector').find('.card').css({ 'border': '0px' });
            me.positionForm.container.find('#form-multi-artikel-warning').hide();
        }
    },















}