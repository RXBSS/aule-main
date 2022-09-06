/**
 * Eine Funktion die einem das Ständige Copy Pasten entnimmt
 * 
 * Prinzipiell haben alle Picklisten die gleichen ohne ähnliche Funktionen die man immer brauch:
 *          - Add, Edit, Delete
 * simpleEditTask schreibt die jeweiligen Daten, von einer Auswahl der Pickliste, in die dazugehörigen Inputfelder
 * 
 * !!!! WICHTIG !!!!
 * Die Daten werden via ...-handle.php geholt und in das jweilige Feld geschrieben 
*      - 1. loadAndOpen() : Funktion ****loadAndOpen(editTask, handleFile, id, callback{Optional} )****
 *     
 * Diese Klasse steht in Zusammenhang mit der *****simplePickListeTasks**** Klasse
 * 
 * Sie kann auch ggf. alleine genutzt werden, jedoch wurde das noch nicht getestet
 * 
 * 
 * @param {*} list_name Variablen Name der initialisierten Pickliste z.B. me.pickliste
 * @param {*} modal_name Variablen Name der initialisierten Pickliste z.B. me.modal
 * @param {*} editTask Ein Taskname der dann in der ...-handle.php angesprochen werden kann z.B. 'ag-edit'
 * @param {*} handleFile Eine ...-handle.php muss angegegeben werden über die dann Datenbankabfragen oder Löschungen stattfinden können z.B. 'weitere-stammdaten-handle.php'
 */


var simpleEditTask = class {

    
    constructor(list_name, modal_name, editTask, handleFile) {

        var me = this;

        // Selected auslesen
        if(list_name.getSelectedLength() === 1) {

            // id wird in der Variable Gespeichert
            var id = list_name.getSelectedSingle();

            // Wenn es eine id gibt
            if(id) {
               

                // PickListe wird geschlossen
                if(list_name.container.children().attr('class') == 'modal-dialog modal-dialog-centered modal-xl') {
                    list_name.close();
                }

                // ------------------------------------------
                // 1. loadAndOpen()
                // ------------------------------------------
                modal_name.loadAndOpen(editTask, handleFile, id, function() {

                    
                });

            // Darf nicht vorkommen
            } else {
                app.notify.error.fire("Fehler","Es wurde keine ID angegeben!");
            }

        // Darf nicht vorkommen
        } else {
            app.notify.error.fire("Fehler","Es wurde keine Artikelgruppe ausgewählt!");
        }

    }
}