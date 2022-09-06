/**
 * 
 * Eine Funktion die einem das Ständige Copy Pasten entnimmt
 * 
 * Prinzipiell haben alle Picklisten die gleichen ohne ähnliche Funktionen die man immer brauch:
 *          - Add, Edit, Delete
 * SimpleDeleteTask löscht einem den ausgewählten Wert aus der Pickliste
 * 
 * !!!! WICHTIG !!!!!
 * Diese Klasse steht in Zusammenhang mit der *****simplePickListeTasks**** Klasse
 * 
 * Sie kann auch ggf. alleine genutzt werden, jedoch wurde das noch nicht getestet
 * 
 * @param {*} list_name Variablen Name der initialisierten Pickliste z.B. me.pickliste
 * @param {String} deleteTask Ein Taskname der dann in der ...-handle.php angesprochen werden kann z.B. 'ag-delete'
 * @param {String} handleFile Eine ...-handle.php muss angegegeben werden über die dann Datenbankabfragen oder Löschungen stattfinden können z.B. 'weitere-stammdaten-handle.php'
 */

var simpleDeleteTask = class {

    
    constructor(list_name, deleteTask, handleFile) {

        var me = this;

        // Wenn es eine Auswahl gibt
        if(list_name.getSelectedLength() > 0) {

            // Abfrage was alles gemacht werden soll
            app.alert.question.fire('Wollen Sie wirklich löschen?','Dieser Vorgang kann nicht Rückgängig gemacht werden!')
                .then((result) => { 	        

                    // Wenn der Nutzer zustimmt
                    if(result.value) {

                        // Alle angewählten Ids auslesen
                        var ids = list_name.getSelectedColumn(1);

                        // Simple Request
                        app.simpleRequest(deleteTask, handleFile, ids, function() {                                
                            
                            // PickListe wird automatisch neu geladen
                            list_name.refresh(true);

                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
                            //
                            // return true;
                        });
                    }
            });
        } else {
            app.notify.error.fire("Auswahl Treffen","Es wurden keine Auswahl getroffen");
        }

    }
}