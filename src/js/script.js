var template = {

    init: function () {
        var me = this;

        // Alert/ Dupletten Meldung soll verschwinden
        $('.duplettenpruefung').hide();


        // Add EventListener to Init
        template.addEventListener();
    },


    addEventListener() {
        var me = this;


        // Reset Funktion - An vielen Stellen wird der Code sonst doppelt geschrieben
        $('.modal .btn-schliessen').on('click', function () {
            me.reset();
        });
    },


    reset() {

        $('.duplettenpruefung').hide();

        // Mehr anzeigen - wird beim Schließen des Modals wieder versteckt
        $('#mehr-anzeigen').hide();

        // Mehr anzeigen - Text wird auf "Mehr anzeigen" zurückgesetzt
        $('#mehr-anzeigen-toggler').text(function (i, text) {
            return "Mehr anzeigen";
        });

        // TODO: Adressen Modal - Mehr Anzeigen offen oder nicht offen?

    }
}

/**
 * 
 * 
 * Dies ist eine Klasse die dabei hilft den Toggler Mehr anzeigen zu toggeln, den Text richtig anzeigen
 * und den Wert 0 oder 1 speichern für sichtbar oder nicht sichtbar um damit in PHP die Abfrage machen zu können
 * und je nachdem die Inputfelder auf Falsche setzen die innerhalb des Bereiches "mehr-anzeigen" liege
 * 
 * @param {String} id - diese ID ist das Div wo die ganzen Inputfelder drin liegen. Es muss als String die Klasse oder ID mitgegeben werden
 * @param {String} idPlainText - das ist die id des Plaintextes. Dieser wird dann dynamisch geändert und angepasst. Es muss als String die Klasse oder ID mitgeben werden
 * @param {String} hiddenInputField - das ist das inputfeld in der die id gespeichert wird um damit in PHP die Abfrage zu machen. Es muss als String die Klasse oder ID mitgeben werden
 * @param {String} wenigerMessage - Dieser Parameter ist die Schrift die angezeigt wird wenn weniger angezeigt werden soll. Wenn er gesetzt ist wird er genommen. Der Default ist "Weniger anzeigen"
 * 
 *    z.B.  var test = new mehrAnzeigen('#mehr-anzeigen', '#mehr-anzeigen-toggler', '.trigger-on-off');
 *          ODER
 *    z.B. var test = new mehrAnzeigen('#mehr-anzeigen', '#mehr-anzeigen-toggler', '.trigger-on-off', "ZEIG MIR WENIGER AN DU BIMBO");
 * 
 */
var mehrAnzeigen = class {

    constructor(id, idPlainText, hiddenInputField, wenigerMessage) {
        var me = this;

        // Standardmäßig ausgeschaltet
        $(hiddenInputField).val("0");

        // Mehr Anzeigen ist Standardmäßig HIDE
        me.mehranzeigen = $(id);
        me.mehranzeigen.hide();

        // Mehr Anzeigen - Toggler
        $(idPlainText).on('click', function () {

            // Mehr anzeigen - Toggler
            me.mehranzeigen.toggle();

            // Mehr anzeigen - Wenn das div zu sehen ist dann wird der Wert auf 1 gesetzt ansonsten auf 0
            if ($(me.mehranzeigen).is(':visible')) {
                $(hiddenInputField).val("1");
            } else {
                $(hiddenInputField).val("0");
            }

            // Mehr anzeigen - Text verändert sich an den dementsprechend richtigen Wert
            $(idPlainText).text(function (i, text) {
                return text === "Mehr anzeigen" ? ((wenigerMessage) ? wenigerMessage : "Weniger anzeigen") : "Mehr anzeigen";
            });
        });

    }
}


/**
 * 
 * Diese Klasse hilft einem eine Duplettenprüfung auszuführen und fügt eine Alert hinzu
 * 
 * !!!!!! WICHTIG !!!!!!!!
 * Vorraussetzung: 
 *  - Es muss ein div mit der class dupplettenpruefung angelegt werden und mit der warnung die man ausgebenn habn möchte
    - z.B.  <div class="alert alert-warning" class="duplettenpruefung"></div>
 * 
 * 
 * @param {String} task - Task das dann in der ...-handle Datei abgefangen werden kann 
 * @param {String} file - Die Handle Datei in der geprüft werden soll 
 * @param {*} data - Objekt das mit übergeben werden soll z.B. Straße und PLZ übergeben um auf Duplette zu prüfen 
 * @param {STring} message - String das als Alert Meldung angezeigt werden soll 
 */
var duplettenPruefung = class {
    constructor(task, file, data, message) {
        var me = this;

        // Ajax Request 
        app.simpleRequest(task, file, data, function (response) {

            var responseLength = response.data.length;

            // Container der angelegt wird
            var container = $('.duplettenpruefung')

            // Alert wird geleert
            container.empty()

            // Wenn es einen Eintrag in der Datenbank gibt
            if (responseLength > 0) {
                container.show();

                container.append(
                    "<strong>Achtung</strong>"
                    + "<br>"
                    + "<p>" + message + "</p>");
                // Wenn es keinen Eintrag in der Datenbank gibt
            } else {
                container.hide();
            }
        }, false);
    }
}



var appAppend = {

    /**
     * 
     */
    showDocument(id, doctype, preview, print) {

        var me = this;
        preview = preview || false;
        print = print || false;

        // Open
        window.open('document?doctype=' + doctype + '&id=' + id + '&action=' + ((preview) ? 'preview' : 'show') + "&print=" + ((print) ? true : false), 'targetWindow', `toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600px,height=900px`);
    },


}

// Eigene Dinge in die App von Orthor anfügen
app = Object.assign(app, appAppend);


$(document).on('app:ready', function () {

    // Vorschau drucken
    $('body').on('click', '.btn-show-document', function () {

        // Id aus der URL auslesen
        var id = app.getUrlId();

        // Print
        var isPrint = (typeof $(this).data('print') == 'undefined') ? ((app.keys.shift) ? true : false) : ($(this).data('print') === true) ? true : false;
    
        console.log(app.keys.shift);

        // is Preview
        var isPreview = ($(this).data('show') === true) ? false : true;

        // Dokument aus den Daten auslesen    
        var doc = $(this).data('document');

        // Show Document
        app.showDocument(id, doc, isPreview, isPrint);
    });




});


