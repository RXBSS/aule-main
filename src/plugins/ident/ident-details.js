idet = {

    /**
     * Init Funktion
     */
    init() {

        var me = this;

        me.id = app.getUrlId();

        // Form initalisieren
        me.initForm();
        me.initLink();
        me.addListner();

        // Card Sizer
        new CardSizer(['#card-stammdaten','#card-kundendaten','#card-verknuepfung']);

    },

    initForm() {

        var me = this;

        // Form
        me.form = new Form('#ident-form'); 

        

        // 
        me.form.load('load','ident-handle', me.id, function(response) {

            console.log(response.data);

            // Form auf Readonly setzen
            me.form.setReadonly(true);

            // Wenn es eine Haupt-Id ist
            if(response.data.is_haupt_id) {

            // Wenn es keine Haupt Id ist
            } else {
                
                // Warnmeldung hinzufügen
                $('#haupt-id-warnung').show();
                $('#card-kundendaten').addClass('card-warning');

                // Kundendaten nicht editierbar machen
                me.form.container.find('input[name=kunden_referenz], input[name=kunden_kostenstelle], input[name=standort]').removeClass('editable').prop('disabled', true);
            }
        });
    },

    // Link initalisieren
    initLink() {

        var me = this;

        var c = $('#ident-verlinkung-container');

        // 
        c.html(app.getLoaderSvg());

        // Verlinkungen holen
        app.simpleRequest("get-link", "ident-handle", me.id, function (response) {

            var d = response.data;

            // 
            var html = [];

            // Schliefe durch die IDNR 
            $.each(d, function (key, value) {

                // Leeren
                var subHtml = "";

                // Alle Sub-Ids sind eingeschoben und haben ein anderes Symbol
                subHtml += '<div ' + ((value.main) ? '' : ' class="px-2"') + '>';
                subHtml += '<i class="fa-solid ' + ((value.main) ? 'fa-circle' : 'fa-turn-up fa-rotate-90') + '"></i> ';
                
                // Wenn es diese IDNR ist, in Strong hervorheben
                subHtml += ((value.requested) ? '<strong>' : '');
                subHtml += '<a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#ident-tree-toggle-target-' + key + '">' + value.id + '</a> | ' + value.data.artikel_bezeichnung;
                subHtml += ((value.requested) ? '</strong>' : '');
                
                // Link
                subHtml += (value.requested) ? '' : ' <a href="ident-details?id=' + value.id + '"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>';

                // Nur wennn es andere IDNR sind
                if(!value.requested) {

                    // Collapse
                    subHtml += '<div class="collapse" id="ident-tree-toggle-target-' + key + '" >';
                    subHtml += '<div class="card mt-1 mb-2"><div class="card-body">';
                    subHtml += '<strong>Artikel ID:</strong> ' + value.data.artikel_id + "<br><strong>Hersteller: </strong>" + value.data.artikel_hersteller + "<br><strong>Seriennummer:</strong> " + value.data.seriennummer ;
                    subHtml += '</div></div>';
                    subHtml += '</div>';
                } 

                // Div schließen
                subHtml += '</div>';

                // HTML zusammenführen
                html.push(subHtml);
            });

            // 
            c.html(html.join(''));
        });
    },

    addListner() {

        var me = this;

        // Form
        $('.btn-form-unlock').on('click', function() {
            
            me.form.setReadonly(false);
            $('#locked-form').hide();
            $('#unlocked-form').show();
        });

        // Form
        $('.btn-form-discard').on('click', function() {
            me.form.reset(0);
            me.form.setReadonly(true);
            $('#locked-form').show();
            $('#unlocked-form').hide();
        });

    }


}