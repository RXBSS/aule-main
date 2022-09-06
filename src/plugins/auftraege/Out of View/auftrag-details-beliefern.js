/**

 var bes = {

    initBelieferung() {
        
        var me = this;

        // Belieferunsliste
        me.belieferungListe = new PicklistModal("auftraege_positionen", {
            type: 'multi-picklist',
            data: me.id
        });

        me.addBelieferungListner();
    },

    addBelieferungListner() {

        var me = this;

        $('.btn-auftrag-bestellung').on('click', function() {
            me.belieferungListe.open();
        });

        
    }
 }

 */