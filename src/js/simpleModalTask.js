/**
 * Eine Funktion die einem das Ständige Copy Pasten entnimmt
 * 
 * Prinzipiell haben alle Picklisten die gleichen ohne ähnliche Funktionen die man immer brauch:
 *          - Add, Edit, Delete
 * simpleModalTask bringt verschieden helfer Funktionen mit die nicht ständig neu geschrieben werden müssen:
 *     - 1. Öffnen des Modals
 *     - 2. Submit Funktion (Abschicken)
 *     - 3. Schliesen des Modals
 * 
 * !!!! WICHTIG !!!!
 * Die Daten werden via ...-handle.php geholt und in das Feld geschrieben 
 *          -> Funktion ****loadAndOpen(editTask, handleFile, id, callback{Optional} )****
 *          -> id muss ausgelesen und mit übergeben werden (jeweilige id der Zeile die aus der PickListe ausgewählt wurde) 
 * 
 * @param {String} id Container der Modals z.B. '#artikelgruppen-modal'
 * @param {*} list_name Variablen Name der initialisierten Pickliste z.B. me.pickliste
 * @param {*} modal_name Variablen Name der initialisierten Pickliste z.B. me.modal
 * @param {String} submitTask Ein Taskname der dann in der ...-handle.php angesprochen werden kann z.B. 'ag-edit'
 * @param {String} submitFile Eine ...-handle.php muss angegegeben werden über die dann Datenbankabfragen oder Löschungen stattfinden können z.B. 'weitere-stammdaten-handle.php'
 * 
 */


    

var simpleModalTask = class {

    
   
    constructor(id, list_name, modal_name, submitTask, submitFile, additional = false) {

        var me = this;

        me.reopenPickliste = false;
    
        // Falls die Pickliste in einem Modal ist
        var listContainerClass = list_name.container.attr('class');

        // ------------------------------------------------------------
        // 1. Öffnen des Modals
        // ------------------------------------------------------------
        $(id).on('click', function() {
            me.reopenPickliste = false;

            console.log('test');

            modal_name.open();
        });

        
        // ------------------------------------------------------------
        // 2. Submit Funktion (Abschicken)
        // ------------------------------------------------------------
        modal_name.on('submit', function() {

            // id der Ausgewählten Zeile
            var id = list_name.getSelectedSingle();

            // Save Funktion
            modal_name.save(submitTask, submitFile, function(data) {

                /* Callback Success */

                // Alle Input-Felder werden gesäubert
                modal_name.clearForm(); 

                modal_name.close(); 

                // Wenn die Globale Variable auf True ist Dann Liste Wieder Öffnen ansonsten nicht
                if(me.reopenPickliste) {
                    list_name.open();
                }

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich ausgeführt");
                
                // PickListe soll automatisch neu geladen werden -> damit man das Ergebnis sieht
                list_name.refresh(true);

                me.redirect(data)

            },
            /* Callback Error ist nicht vorhanden */
            false, {

                // Additional Data - falls es Edit werden soll
                id: id,
                data: additional
            });
        });

        
        // ------------------------------------------------------------
        // 3. Schliesen des Modals
        // ------------------------------------------------------------
        modal_name.container.on('click', '.btn-schliessen', function() {

            // Alle Input-Felder werden gesäubert 
            modal_name.clearForm();

            // PickListe wird wieder geöffnet
            if(listContainerClass == 'modal dt-modal' && me.reopenPickliste == true ) {
                list_name.open();
            }
        });

        list_name.container.on('click', '.dt-action[data-action="add"]', function() {
            
            // PickListe wird geschlossen
            if(list_name.container.children().attr('class') == 'modal-dialog modal-dialog-centered modal-xl') {
                list_name.close();
            }

            // Modal wird geöffnet
            modal_name.open();

            me.reopenList(true);

        });
    }
    

    // Angepasst auf die Akquise 
    // -> TODO: entwder besser Lösung finden oder anpassen das es für alle passt
    reopenList(bool) {

        var me = this;

        me.reopenPickliste = bool;

        return me.reopenPickliste;

    }

    // Weiterleitung auf die Akquise Details Seite
    redirect(data) {

        if(data.success && window.location.pathname == '/akquise-aktionen') {
            app.redirect('akquise-aktionen-details.php?id=' + data.data);
        }


    }
}