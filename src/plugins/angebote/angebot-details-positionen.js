/**
 * ANGEBOT - POSITIONEN
 */
var agPos = {

    initPos() {

        var me = this;

        // Positionsliste
        me.initPositionsListe("angebote_positionen");

        // Artikelliste hinzufügen
        me.initArtikelListe();

        // Position Form
        me.initPositionForm();

        // Event Listner hinzufügen
        me.addPosListner();

    },

    /**
     * 
     */
    handlePositionSelection() {

        var me = this;

        // Aktuelle ausgewählte
        var result = me.handlePositionSelectionDefault();

        // Entscheiden nach Status
        switch (me.status) {

            // Entwurf
            case 1:

                if (result) {

                    $('.btn-pos-shift, .btn-pos-delete').show();

                    // Wenn etwas gewählt ist
                    me.positionList.container.closest('.col-selector').removeClass().addClass('col-selector col-md-8');
                    me.positionForm.container.closest('.col-selector').removeClass().addClass('col-selector col-md-4').show();

                    // Laden
                    me.loadPositionFormStart(result, function(posIds, response) {
                        
                        console.log(response);

                        // Single 
                        
        
                        
                    });
                }


                break;

            // Offenes Angebot
            case 2:

                break;

            // Angebot ist Auftrag
            case 3:

                break;

            // Angebot ist Abgelaufen / Abgelehnt
            case 4:

                break;
        }
    },

}