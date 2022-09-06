/**
 * Funktionen die genutzt
 * 
 */
var detailHelper = {

    /**
     * Details Listners
     */
    addDetailListners() {

        var me = this;

        $('.btn-speichern').on('click', function () {
            me.save();
        });

        // Hotkeys
        hotkeys('ctrl+h', function (event, handler) {
            event.preventDefault();
            if (typeof me.openHistory == 'function') {
                me.openHistory();
            }
        });

        // Hotkeys
        hotkeys('ctrl+s', function (event, handler) {
            event.preventDefault();
            if (typeof me.save == 'function') {
                me.save();
            }
        });
    },

    /**
     * Status ändern
     * @param {*} status 
     * @param {*} subStatus 
     */
    changeStatus(status, subStatus) {

        var me = this;

        // Initalisieren
        status = parseInt(status) || false;
        subStatus = (typeof subStatus != 'undefined') ? parseInt(subStatus) : false;

        // Status und Substatus setzen
        if (status) { me.status = status; }
        if (subStatus !== false) { me.subStatus = subStatus; }

        // Status GUI anpassen
        me.setStatusGui();
    },

    /**
     * Substatus ändern
     * @param {*} subStatus 
     */
    changeSubStatus(subStatus) {

        var me = this;

        // Sub Status setzen
        subStatus = (typeof subStatus != 'undefined') ? subStatus : false;

        // Substatus
        if (subStatus !== false) { me.subStatus = subStatus; }

        // Status GUI anpassen
        me.setStatusGui();
    },

    // Status anpassen
    setStatusGuiDefault() {

        var me = this;

        // Status anzeigen
        $('[data-status]').hide();
        $('[data-status="' + me.status + '"]').show();

        $('[data-status="' + me.status + '"][data-substatus]').hide();
        $('[data-status="' + me.status + '"][data-substatus="' + me.subStatus + '"]').show();

    },

    setStatusGui() {
        var me = this;
        me.setStatusGuiDefault();
    },


    /**
    * Daten der Detail-Seite auslesen
    * @param {Function} callback 
    */
    getData(callback, redirect) {

        var me = this;

        redirect = redirect || false;

        // Daten holen!
        me.form.load("get", me.handler, me.id, function (response) {

            // Callback
            callback(response);

            // Wenn die Daten nicht geladen werden konnten
        }, function () {

            me.loadingError("Fehler beim Laden des Datensatzes", redirect);
        });
    },


    /**
     * Standard Funktion zum Speichern des Entwurfs
     */
    entwurfSpeichern() {
        var me = this;

        // Entwurf speichern
        me.form.save("entwurf-speichern", me.handler, function () {
            console.log('-- Entwurf wurde gespeichert!');
        }, null, me.id);
    },

    /**
     * Standard Funktion zum Speichern des Entwurfs
     */
    entwurfSpeichern(callback) {

        var me = this;

        // Speichern
        me.form.fvInstanz.validate().then(function (status) {
            
            // Wenn die Form Valide ist
            if (status == 'Valid') {

                // Speichern
                me.form.save('entwurf-speichern', me.handler, function (response) {

                    // Zurücksetzen der Form
                    me.form.reset(2);

                    // Wenn es einen Custom Callback gibt
                    if (typeof callback == 'function') {
                        callback();
                        
                    // Falls nicht
                    } else {
                        app.notify.success.fire("Gespeichert", "Der Entwurf wurde erfolgreich gespeichert");
                    }

                }, null, {
                    id: me.id
                });
            }
        });

    },



    /**
     * Wird aufgerufen, wenn beim Laden ein Fehler entsteht
     */
    loadingError(error, redirect) {

        var me = this;

        redirect = redirect || false;

        // Alert
        app.alert.error.fire("Es ist ein Fehler aufgetreten", error).then(function () {
            if (redirect) {

                if (redirect === true) {
                    app.redirect("/");
                } else {
                    app.redirect(redirect);
                }
            }
        });
    }
}


// Zusammenfügen
detailHelper = Object.assign(detailHelper, detailHelperPos);
detailHelper = Object.assign(detailHelper, detailHelperAdressen);
detailHelper = Object.assign(detailHelper, detailHelperPosHandle);
detailHelper = Object.assign(detailHelper, detailHelperPosCalculate);

