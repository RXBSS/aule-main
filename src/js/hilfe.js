

var hilfe = {


    init() {


        var me = this;
        me.addListner();
    },

    // Event Listner hinzufügen
    addListner() {

        // 
        var me = this;

        hotkeys('ctrl+i', function (event, handler) {
            
            // Element prüfen
            var el = (event.target || event.srcElement);
            
            // Nur wenn es ein Input it
            if (el.tagName == 'INPUT') {

                // Öffnen
                me.open(el);

                
            }
        });

    },

    // Hilfe öffnen
    open(el) {

        var me = this;

        el = $(el);

        var source = false;

        // Wenn es ein Hilfe Modul hat
        if(el.data('help')) {   

            // Splitten
            var array = el.data('help').split('-');          

            if(array.length == 1) {
                source = (me.data[array[0]]) ? me.data[array[0]] : false;
            } else if (array.length == 2) {
                source = (me.data[array[0]] && me.data[array[0]][array[1]]) ? me.data[array[0]][array[1]] : false;
            } else if (array.length == 3) {
                source = (me.data[array[0]] && me.data[array[0]][array[1]] && me.data[array[0]][array[1]][array[2]]) ? me.data[array[0]][array[1]][array[2]] : false;
            }        
        }

        // Wenn eine Quelle gefunden wurde
        if(source) {

            var title = "Hilfe - " + source[0];
            var text = source[1];


            if(el.attr('type') == 'date') {
                text += "<hr>" + me.data.datenfelder.datum;
            }

            app.alert.info.fire(title, text);


        // Wenn keine Quelle gefunden wurde
        } else {
            app.notify.error.fire("Keine Hilfe-Daten","Für dieses Feld stehen leider keine Hilfe-Daten zur Verfügung");
        }
    },

    // Aktuell nur x schichten
    data: {
        
        // Bestellungen
        bestellungen: {
            liefertermin: ["Liefertermin","Der Liefertermin kann angegeben werden um eine Übersicht zu erhalten, wann mit der Lieferung zu rechnen ist. Das Feld ist kein Pflichtfeld."]
        },

        // Datenfelder
        datenfelder: {
            datum: ["Datumsfeld", "Mit STRG + D kann man das aktuelle Datum eintragen. Mit + und - kann man einzelne Tage aufrechnen oder abziehen!"]
        }
    }



}

$(document).on('app:ready', function() {
    hilfe.init();
});