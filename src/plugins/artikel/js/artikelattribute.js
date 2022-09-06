// Artikel-Attribute
class ArtikelAttribute {

    // Konstruktor
    constructor(container, form) {
        var me = this;

        // 
        me.container = $(container);
        me.container.html('');
        me.form = form;
        me.priorValidationFields = [];

    }

    // Attribute
    load(artikelgruppe, callback) {
        
        var me = this;

        // Lade Icon anzeigen
        me.container.html('<br><i class="fa-solid fa-circle-notch fa-spin"></i>');

        // Simple Request
        app.simpleRequest('get-attributes','artikel-handle.php', artikelgruppe, function(response) {

            // Felder zum Validieren
            var validationFields = [];

            var html = [];
            var fields = [];

            // Sortiertes Array 
            Object.keys(response.data).sort((a, b) => response.data[a]['reihenfolge'] - response.data[b]['reihenfolge']).forEach((index) => {
                
                var value = response.data[index];

                html.push(me.getHtml(value));
                fields.push(value.id);

                // Pflichtfelder
                if(value.pflichtfeld && value.pflichtfeld == 1) {    
                    validationFields.push(value);
                }
            });

            // 
            if(html.length > 0) {

                // HTML einfügen
                me.container.html('<div class="row"><div class="col-md-6">' + html.join('</div><div class="col-md-6">') + '</div></div>');
            
            // Wenn es keine Artikelattribute gibt
            } else {
                me.container.html('');
            }     
            
            // Valdation Fields
            me.manageValidation(validationFields);

            // Callback
            if(typeof callback == 'function') {
                callback(fields);
            }


        });
    }

    getHtml(data) {

        var html = "";

        switch(data.datentyp) {
            
            // String
            case 'textfeld':
                
                html = '<div class="form-group form-floating">' + 
                    '<input type="text" name="attribute' + data.id + '" class="form-control editable" placeholder="' + data.bezeichnung + '" />' + 
                    '<label>' + data.bezeichnung + '</label>' + 
                '</div>';

                break;

            // Zahl
            case 'zahl':
                
                html = '<div class="form-group form-floating">' + 
                    '<input type="number" name="attribute' + data.id + '" class="form-control editable" placeholder="' + data.bezeichnung + '" />' + 
                    '<label>' + data.bezeichnung + '</label>' + 
                '</div>';

                break;
        
            // Zahl
            case 'ja-nein':
            	

                html = '<div class="form-group form-floating-check">' + 
                    '<label class="form-label">' + data.bezeichnung + '</label><br>' + 
                    '<div class="form-check form-check-inline">' + 
                        '<input class="form-check-input editable" type="radio" id="attribute' + data.id + '-1" name="attribute' + data.id + '" value="Ja">' + 
                        '<label class="form-check-label" for="attribute' + data.id + '-1">Ja</label>' + 
                    '</div>' + 
                    '<div class="form-check form-check-inline">' + 
                        '<input class="form-check-input editable" type="radio" id="attribute' + data.id + '-2" name="attribute' + data.id + '" value="Nein">' + 
                        '<label class="form-check-label" for="attribute' + data.id + '-2">Nein</label>' + 
                    '</div>' + 
                '</div>'

                break;

            // Integer
            case 'liste':

                html = '<div class="form-group form-floating">' + 
                    '<select class="form-select init-select2 editable" name="attribute' + data.id + '" placeholder="' + data.bezeichnung + '">' + 
                        '<option value="">bitte wählen</option>';

                    // Parse JSON
                    var json = JSON.parse(data.data);

                    // Jeden List Value
                    json.values.forEach((listValue, index) => {
                        html += "<option value='" + index + "'>" + listValue + "</option>";
                    }); 

                html += '</select>' + 
                    '<label>' + data.bezeichnung + '</label>' + 
                '</div>';

                break;
            

            // Wenn nichts gefunden wurde
            default:   
                html = '<div class="alert alert-danger">Unbekannter Datentyp: >' + data.datentyp + '<</div>';
                
                break;
        }
        return html;
    }

    manageValidation(fields) {
                
        var me = this;

        if(me.form && me.form.fvInstanz) {

            // Remove Fields
            if(me.priorValidationFields.length > 0) {

                // Add Fields
                me.priorValidationFields.forEach((value) => {
                    me.form.fvInstanz.removeField('attribute' + value.id);
                });
            } 

            // Add Fields
            fields.forEach((value) => {
                me.form.fvInstanz.addField('attribute' + value.id, {
                    validators: {
                        notEmpty: {
                            message: 'Das ist ein Pflichtfeld',
                        },
                    },
                });
            });

            // Aktuellen Felder abspeichern
            me.priorValidationFields = fields;
        }
    }   


}
