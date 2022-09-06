var artikelDokumente = {
    initDokumente() {
        
        var me = this;

        var list = new Picklist("#picklist-dokumente", "artikel_dokumente", {
            card: false
        });

        // Drag N Drop Klasse initalisieren
        var dragger = new DragAndDrop('#dokumente-drag-n-drop', {
            handle: 'artikel-handle',
            task: 'upload-dokument'
        });

        // Bei erfolgreichem Upload die Liste neu laden
        dragger.on('upload-success', function() {
            list.refresh();
        });

    }
};