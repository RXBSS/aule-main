/**
 * Eine Funktion die einem das Ständige Copy Pasten entnimmt
 * 
 * Prinzipiell haben alle Picklisten die gleichen ohne ähnliche Funktionen die man immer brauch:
 *          - Add, Edit, Delete
 * simplePickListeTasks bringt verschieden helfer Funktionen mit die nicht ständig neu geschrieben werden müssen:
 *     - 1. Öffnen des Modals
 *     - 2. Add Funktion (Hinzufügen von neuen Daten)
 *     - 3. Edit Funktion (Editieren von vorhanden Daten)
 *     - 4. Delete Funktion (Löschen von einer oder mehreren einträgen )
 *     - 5. Schliesen des Modals
 * 
 * !!!! WICHTIG !!!!
 *  
 * Diese Klasse steht in Zusammenhang mit der *****simpleModalTask**** Klasse
 * 
 * Sie kann auch ggf. alleine genutzt werden, jedoch wurde das noch nicht getestet
 * 
 * 
 * @param {*} list_name Variablen Name der initialisierten Pickliste z.B. me.pickliste
 * @param {*} modal_name Variablen Name der initialisierten Pickliste z.B. me.modal
 * @param {*} editTask Ein Taskname der dann in der ...-handle.php angesprochen werden kann z.B. 'ag-edit'
 * @param {*} handleFile Eine ...-handle.php muss angegegeben werden über die dann Datenbankabfragen oder Löschungen stattfinden können z.B. 'weitere-stammdaten-handle.php'
 */



var simplePickListeTasks = class {

    
    constructor(id, list_name, modal_name, deleteTask, handleFile, editTask) {

        var me = this;

        // ------------------------------------------------------------
        // 1. Öffnen des Modals
        // ------------------------------------------------------------
        $(id).on('click', function() {

            list_name.open();
        });

        // ------------------------------------------------------------
        // 2. Add Funktion (Hinzufügen von neuen Daten)
        // ------------------------------------------------------------
        list_name.container.on('click', '.dt-action[data-action="add"]', function() {
            
            // PickListe wird geschlossen
            if(list_name.container.children().attr('class') == 'modal-dialog modal-dialog-centered modal-xl') {
                list_name.close();
            }

           
            // Modal wird geöffnet
            modal_name.open();

        });

        // ------------------------------------------------------------
        // 3. Edit Funktion (Editieren von vorhanden Daten)
        // ------------------------------------------------------------
        list_name.container.on('click','.dt-action[data-action="edit"]', function() {
           
            // Klasse ****simpleEditTask**** wird aufgerufen -> Doku steht in der Datei
            me.simpleEdit = new simpleEditTask(list_name, modal_name, editTask, handleFile);
        });

        // ------------------------------------------------------------
        // 4. Delete Funktion (Löschen von einer oder mehreren einträgen )
        // ------------------------------------------------------------
        list_name.container.on('click','.dt-action[data-action="delete"]', function() {
            
            // Die Klasse ****simpleDeleteTask**** wird aufgerufen -> Doku steht in der Datei
            me.simpleDelete = new simpleDeleteTask(list_name, deleteTask, handleFile);
        });

        // ------------------------------------------------------------
        // 5. Schliesen des Modals
        // ------------------------------------------------------------
        list_name.container.on('click', '.btn-dt-close', function() {

            // PickListe wird automatisch neu geladen
            list_name.refresh(true);
        });
    }
}