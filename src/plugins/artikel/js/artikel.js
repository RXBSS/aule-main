

$(document).on('app:ready', function () {

    // Pickliste
    // *********
    var picklist = new Picklist("#artikel-pickliste", "artikel");

    // On Pick
    picklist.on('pick', function (el, data) {
        app.redirect('artikel-details?id=' + data[1]);
    });


    // Form mit FormValidation
    // ***********************
    var form = new ModalForm('#form-artikel', true);

    var fields = {
        ean: {
            validators: {
                regexp: {
                    regexp: /^(\d{13}|\d{8})$/i,
                    message: 'Ungültiges Format'
                }
            }
        }
    }

    // Init FormValidation
    form.initValidation(fields);

    form.on('submit', function () {
        form.save('new', 'artikel-handle', function (data) {
            if (data.success) {
                app.redirect('artikel-details.php?id=' + data.data);
            } else {
                app.notify.error.fire("Fehler beim Speichern", data.error);
                return true;
            }
        });
    });

    // On Fokus Out
    form.container.on('focusout', 'input[name=herstellernummer]', function(event) {

        var nummer = $(this).val().trim();

        // Prüfen der Hersteller Nummer
        if(nummer) {

            // Pre Duplicate Check
            app.simpleRequest("pre-duplicate-check", "artikel-handle", nummer, function(response) {
                console.log(response);
            }, function() {

                // Wenn der Artikel schon vorhanden ist
                app.alert.question.fire({
                    
                    title: 'Duplettenprüfung',
                    text: 'Dieser Artikel existiert bereits!',
                    confirmButtonText: '<i class="fa-solid fa-link"></i> Artikel öffnen',
                    cancelButtonText: '<i class="fa-solid fa-xmark"></i> Andere Nummer',
                    showCancelButton: true

                }).then(function(response) {
                    
                    // Wenn zu dem Artikel weitergeleitet werden soll
                    if(response.isConfirmed) {
                                            
                        // Abfrage und Redirect
                        app.simpleRequest("get-by-hersteller", "artikel-handle", nummer, function(response) {
                            app.redirect('artikel-details?id=' + response.data.id);
                        });
                        
                    // Wenn eine andere Artikelnummer geöffnet werdfen soll
                    } else {
                        form.container.find('input[name=herstellernummer]').val('');
                        
                        // Geht leider nicht anders, damit das eigentliche Tab Event
                        setTimeout(function() {
                            form.container.find('input[name=herstellernummer]').focus();
                        },100);
                    }
                });
            });
        }


    });


    // Open Form
    $('.btn-artikel-new').on('click', function () {
        form.open();
    });

    hotkeys('ctrl+e', function (e, handler) {
        e.preventDefault();
        form.open();
    });

    var attr = new ArtikelAttribute('#artikel-attribute', form);

    


    form.qs['zuordnung'].link(form.qs['artikelgruppe'], 'zuordnung_id', 'Zuordnung');

    // Beim Ändern der Artikelgruppe
    form.qs['artikelgruppe'].on('change', function () {
        var value = $(this).val();
        attr.load(value);
    });

});





