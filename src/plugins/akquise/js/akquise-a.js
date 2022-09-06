/**
 * Dieses Objekt beinhaltet Funktionen die in beiden Seiten vefügbar sein sollen
 * sowohl akquise Landingpage und auf der Details Seite
 */

var akquise_both = {

    // Init Funktion
    initBoth() {

        var me = this; 

        // Session ID des angemeldeten
        me.sessionID = $('input[name="sessionID"]').val();

        // Globale Variable der Zuständigkeit
        me.zustaendigkeit = false;

        // Aktive ID die das Modal öffnen soll (Global und wird dann überschrieben)
        
        // Wenn es die ID als Cookie geschrieben wurde

        // Init Modal Both Seite
        me.initModal();

        // Init der Modal Form
        me.initModalForm();

        // Init Summernote auf beiden Seiten 
        me.initSummernote();

        // Init Notification Sidebar
        me.initSidebar();

        // init Tooltip Wiedervorlage
        me.initTooltip();

        // Hotkey
        me.notificationHotkey();

        // EventLsitener die auf beiden Seite gelten
        // me.addEventListenerBoth();

       me.openModalWithCookie();


    },

    // Wenn das Redirect auf die Seite via Sidebar kommt wird es hier abgefangen
    openModalWithCookie() {

        var me = this;

        // Aktive ID
        me.aktiveID;

        // Standardmäßig Modal nicht öffnen
        var openModal = false;

        // Geht die Schleife durch alle Cookie und sucht dia
        $.each(decodeURIComponent(document.cookie).split(' '), function(key, value) {
            
            // Wenn dia eine id hat
            if(value.split('dia=')[1] > 0) {

                // OpenModal kann geöffnet werden
                openModal = true;
            } 
        });


        // Wenn Cookie vorhanden
        if(openModal) {

            // Cookie auslesen
            me.aktiveID = document.cookie.split(`; dia=`)[1];

            // Setzt das Cookie auf False - Man kann es auch löschen
            document.cookie = "dia= false;"

            // Modal Öffnen
            me.openModal(me.aktiveID);
        } else {

            me.aktiveID;

        }
    },

    // Init Modal das auf beiden Seite geöffnet werden soll
    initModal() {

        var me = this;

        // Modal das geöffnet wird sobald man eine Auswahl getroffen hat
        me.modal = new bootstrap.Modal($('#akquise-timeline-modal').get(0), {
            keyboard: false
        });

    },

    /** Alle Formulare die auf beiden Seiten geladen werden sollen */
    initModalForm() {

        var me = this;
        
        // Timeline 
        me.timelineForm = new Form('#akquise-bearbeiten-form');
        
        // TimeLine Validierung
        me.timelineForm.initValidation();
        me.validierungEingeblendet();

        // Akquise Modal Nicht Erfolgreich
        me.modalNichtErfolgreich = new ModalForm('#akquise-form-nicht-erfolgreich');
        me.modalNichtErfolgreich.initValidation();

    },

    // Tooltip Wiedervorlage
    initTooltip () {

        var me = this;

        // ------------------------------------------------------------------------------
        // --------
        // ZU VIEL TRAFFIC???!!!!

        // Holt Element des Tooltips
        // var wiedervorlageTooltip = $('#wiedervorlageTooltip');

        // const myTooltipEl = document.getElementById('myTooltip')
        
        // // Erstellt eine Neue Instanz des Tooltips
        // me.tooltip = bootstrap.Tooltip.getOrCreateInstance(wiedervorlageTooltip)
        
        // // Löscht Tooltip sodass man nicht mehr Drauf PopOver machen kann
        // me.tooltip.disable()



        // ------------------------------------------------------------------------------
        // --------
        //

        $('.labelWiedervorlageOff').show();
        $('.labelWiedervorlageOn').hide();
 
    },

    // Modal das geöffnet werden soll um Bearbeitungsvorgänge abschließen zu können
    /** Diese ModalFunktion wird so gebaut das sie auf beiden Seiten genutzt werden kann */
    openModal(id) {

        var me = this; 

        // Aktive ID überschreiben
        me.aktiveID = id;

        // Open Modal
        me.modal.show();

        // loadTimeline mit Aktive ID
        me.loadTimeline();

        // Init Activation Checkbox
        me.activationCheckbox();

        // Aktuelle Kundentermin der Akquise
        // me.kundenterminInfoText();

        // Holt den aktuellen Status ob Abonniert oder Deabonniert
        me.getAbo();

        // Init Pickliste für die Kontakte / Ansprechpartner
        me.initPicklisteKontakte();

        // Die Standard Card Ansicht ist immer ausgewählt beim öffnen
        me.visitenKarte();

        // Meilensteine Laden
        me.meilensteinOption();

        // Lädt den Namen des Kunden
        me.loadKunde(me.aktiveID);

        // alle Akquise zeigen die der Kunde aktuell Offen hat
        me.offenAnzeige();

        me.addEventListenerModal();

    },

    // Init Pickliste für die Kontakte / Ansprechpartner
    initPicklisteKontakte() {

        var me = this;

        // Init HauptListe
        me.kontakteList = new Picklist('#kontakte-pickliste', 'kontakte', {
            type: 'multi-picklist',
            autoDeselect: false,
            card: false,
            config: {
                file: 'config.json' // Weil die Andere Config hat Spezielle Eigenschaften für N:N
            },
            data: [
                me.aktiveID,
                'akquise'
            ],
            pagination: false,
            description: false, 
            buttons: {
                filter: false
            },
            addButtons: [
                {
                    action: "card-ansicht",       
                    class: "card-ansicht",                
                    icon: "fa-solid fa-id-card",      
                    id: "adressen-personen-card-ausloeser",
                    tooltip: "Ansicht - Card",         
                    pos: 30                           
                },
                {
                    action: "add-kontakt",       
                    class: "kontakt-hinzufuegen",                
                    icon: "fa-solid fa-plus",      
                    id: "kontakt-hinzufuegen",
                    tooltip: "Kontakt Hinzufügen",         
                    pos: 0                           
                },
                {
                    action: "delete-kontakt",       
                    class: "kontakt-loeschen",                
                    icon: "fa-solid fa-trash",      
                    id: "kontakt-loeschen",
                    tooltip: "Kontakt Löschen",
                    show: "onSelected",         
                    pos: 0                           
                }
            ]
        });

        // Add Liste --- Die andere Pickliste ist abgestimmt auf Adressen und Kontakte -- Kontakte2 ist Akquise
        me.addListKontakte = new PicklistModal('kontakte2', {
            type: 'multi-picklist',
            autoDeselect: false,
            disabled: {
                query: {
                    table: 'kontakte',
                    field: 'id', 
                    filter: {
                        akquise_id: me.aktiveID
                    }
                }
            }
        });

        // // Add Liste
        // me.adressenKontakteList = new PicklistModal('adressen_kontakte', {
        //     type: 'multi-picklist',
        //     autoDeselect: false,
        //     disabled: {
        //         query: {
        //             table: 'kontakte',
        //             field: 'id', 
        //             filter: {
        //                 akquise_id: me.aktiveID
        //             }
        //         }
        //     }
        // });
        


    },

    // Init Summernote auf beiden Seiten
    initSummernote() {

        // Init Summernote
        $('textarea[name=text]').summernote({
            height: 150,
            lang: 'de-DE',
            callbacks: {
                onPaste: function (e) {
                    e.preventDefault();

                    // Holt den Text der Eingefügt werdeb soll
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

                    // execCommand(aCommandName, aShowDefaultUI, aValueArgument)
                    document.execCommand('insertText', false, bufferText);
                    
                }
            }
           
        });

    },

    // Notification Sidebard
    initSidebar() {

        var me = this;
        
        // Init Sidebar Notification
        me.sidebar = new Sidebar({
            name: 'some-name',
            width: 400,
            clickToClose: true // Wenn man Weg klickt
        });


    },

    // EventListener die Auf beiden Seiten sichtbar sein sollen
    addEventListenerModal() {

        var me = this;

        // ******************************************************************
        // Standard EventListener
        // ******************************************************************

        // $("#meilenstein-option").find('.alert.alert-soft-grey').disableSelection();
        
        // Sortable Machen
        $("#meilenstein-option").sortable({
            update: function(event, ui) {

                // ID des Meilensteins die Ausgelesen und Mitgegeben wird
                var meilensteinID = ui.item.find('input[name="meilensteine"]').val();

                // Richtung wo der Meilenstein hingezogen wird
                var movement = ui.position.top - ui.originalPosition.top > 0 ? "down" : "up";

                // Positionen Shift im Modal
                me.posShiftByListModal(movement, meilensteinID);

            },
            cancel: ".ui-state-disabled"
        });
       
        // Wenn der Status gewechselt wird
        $('.btn-change-status').on('click', function () {
            me.setStatus($(this));
        });

        // Wenn Abonniert oder Deabonniert wird
        $('.button-akquise-deabonniert, .button-akquise-abonniert').on('click', function() {
            
            // SubmitAbo(ABO oder DeABO, id)
            me.submitAbo($(this).data('abo'));
        });

        // Wenn der Button gedrückt wurde das die Liste wieder Sichtbar sein soll
        $('.button-list-ansicht').on('click', function() {

            // List Anzeigen Show
            $('#kontakte-pickliste').show();

            // Liste Button Entfernen
            $('.hide-list').hide();

            // Card Ansicht Hide
            $('#kontakte-card').hide();
        });

        // Wenn Wiedervorlage per SchnellKlick geändert wird über die Button
        $('.btn-set-date').on('click', function () {
            me.setWiedervorlage($(this));
        });

        // Wenn  Wiedervorlage Uhrzeit per Schnellklick mit den Buttons geändert wird
        $('.btn-set-time').on('click', function () {
            var value = $(this).data('time');
            $('input[name="wiedervorlageUhrzeit"]').val(value);
        });

        // Wenn ein Kontakt Ansprechpartner über die Card Ansicht hinzugefügt werden soll
        $('.button-kontakt-hinzufuegen').on('click', function() {
            me.modal.hide();

            me.addListKontakte.open();
           

            // Open Dialog 
            // me.adressenKontakte();
        }); 

        // Wenn die Timeline geschlossen wird
        $('.btn-schliessen').on('click', function() {

            // Standard Einstellung zurück
            me.standardSettings();
        }); 

        // Wenn der Meilenstein Tab Angezeigt ist
        $('#tab-nav-meilenstein').on('shown.bs.tab', function() {
            // me.meilensteinOption();
        });

        // Meilenstein Option
        $('#meilenstein-option').on('click', '.meilenstein-option-hinzufuegen', function() {
            me.submitMeilenstein($(this).data('value'));
        });


        $('#kontakte-card').on('click', '.button-kontakt-delete' ,function() { 
            var kontakte_id = $(this).data('kontakte')
            me.deleteVisitenKarte(kontakte_id);

        });


        // Wenn eine Andere Akquise über "Weiter Akquisen" geöffnet werden soll
        $('#weitere-akquise').on('click', '.weitere-akquise-hinzufuegen', function() {

            // Dialog zur Abfrage ob das neue Modal wirklich geöffnet werden soll oder nicht
            me.openWeiterAkquiseDialog($(this).data('value'));

        });
     
        // Activation Checkbox Wiedervorlage
        $('input[name="wiedervorlagemehrAnzeigen"]').on('change', function() {
            me.helperValidation($(this), 'wiedervorlage');
        });

        // Activation Checkbox Bearbeiter
        $('input[name="mehrAnzeigen"]').on('change', function() {
            me.helperValidation($(this), 'zustaendigkeit');
        });

        // Activation Checkbox Kundentermin 
        // $('input[name="mehrAnzeigenKundentermin"]').on('change', function() {
        //     me.helperValidation($(this), 'kundentermin');
        // });

        // *******************************************************************
        // Form Handler
        // *******************************************************************

        // Wenn nicht Erfolgreich Modal Geschlossen wird
        me.modalNichtErfolgreich.container.on('click', '.btn-schliessen', function() {

            // Modal wieder öffnen
            me.modal.show();
        });
        
        // Wenn das Model abgeschickt werden soll
        me.timelineForm.on('submit', function() {

            // SubmitTimeline mit Aktive ID
            me.submitTimeline(me.aktiveID);
        });


        // Load EventListner -- in der Funktion liegt ein Event LOAD
        me.loadTimelineFormular();
       
        
        // Wenn Modal Nicht Erfolgreich abgeschickt werden soll
        me.modalNichtErfolgreich.on('submit', function() {
            me.submitNichtErfolgreich();
        });

        // Wenn in der Kontakte / Ansprechpartner Pickliste hinzufügen gedrückt wird
        me.kontakteList.container.on('click', '.kontakt-hinzufuegen', function() {
            me.modal.hide();

            me.addListKontakte.open();

            // Open Dialog 
            // me.adressenKontakte();

        });

        // Wenn eine Auswahl in der Kontakte Liste Hinzufuegen getroffen wurde
        me.addListKontakte.on('pick', function(el, data) {
            me.submitKontakt(el, data);
        });

         // Wenn die Pickliste zum Hinzufügen von Kontakten wieder geschlossen wird
        me.addListKontakte.container.on('click', '.btn-dt-close', function() {
            me.modal.show();
        });

        // Löschen Kontakt
        me.kontakteList.container.on('click','.dt-action.kontakt-loeschen', function() {
            new simpleDeleteTask(me.kontakteList, 'deleteKontakte', 'akquise-handle.php');
        });

        // Wenn auf die Card Ansicht gewechselt werden sollen
        me.kontakteList.container.on('click', '.card-ansicht', function() {
            me.visitenKarte();
        }); 

        $('select[name="bearbeiter_id"]').on('change', function() {
        
        });

        // Zuständigkeit Callback
        me.zustaendigkeitActivation.on('callback', function(el, isChecked, isInit) {

            // Wenn es gechecked ist und die Zuständigkeit mir gehört
            if(isChecked && me.zustaendigkeit == false) {

                me.wiedervorlageCallback(true);

            // Wenn die Zuständkeit aktuell mir gehört
            } else if(me.zustaendigkeit == false) {

                me.wiedervorlageCallback(false);

            } 

        });

        // Activation Checkbox Callback Wiedervorlage
        me.wiedervorlageActivation.on('callback', function (el, isChecked, isInit) {


            // Wenn es gechecked wurde Zeiten eintragen
            if (isChecked) {

                // Fügt Die Wiedervorlage Tage Anzahlg der Aktion hinzu --- Oftmal 10 Tage
                $('input[name="wiedervorlageDatum"]').val(moment().add(me.resTimelineFormData.result.data[0]['wiedervorlage_nach'], 'd').format('YYYY-MM-DD'));
                $('input[name="wiedervorlageUhrzeit"]').val(moment().format('HH:mm'));

            // Wenn es unchecked ist Zeiten wieder rauslöschen
            } else {
                $('input[name="wiedervorlageDatum"]').val('');
                $('input[name="wiedervorlageUhrzeit"]').val('');
            }
        });

        // Standardmäßig sollen nur die Mitarbeiter der Firma angezeigt werden
        me.addListKontakte.on('shown.bs.modal', function() {

            // Checkbox Hinzufügen mit dem man die Nur Mitarbeiter setzen kann
            // me.checkboxKontakteMitarbeiter();

            // Setzt den Filter neu
            // me.setKontakteFilter()

        });

        // Wenn die Checkbox in der Pickliste Kontakte angehackt wird dann soll der Filter immer neue gesetzt werden
        // me.addListKontakte.container.on('change', '#nur_mitarbeiter' ,function() {

        //     // Setzt den Filter neu
                // me.setKontakteFilter();

        // })

        // Activation Checkbox Callback Wiedervorlage
        // me.kundeterminActivation.on('callback', function (el, isChecked, isInit) {


        //     // Wenn es gechecked wurde Zeiten eintragen
        //     if (isChecked) {
        //         $('input[name="kundenterminDatum"]').val(moment().format('YYYY-MM-DD'));
        //         $('input[name="kundenterminUhrzeit"]').val(moment().format('HH:mm'));

        //     // Wenn es unchecked ist Zeiten wieder rauslöschen
        //     } else {
        //         $('input[name="kundenterminDatum"]').val('');
        //         $('input[name="kundenterminUhrzeit"]').val('');
        //     }
        // });

    },

    // submit funktion die den Meilenstein abschickt
    submitMeilenstein(meilenstein) {

        var me = this;

        // Akquise Modal ausblenden
        me.modal.hide();

        // Data das gesendet werden soll
        var data = {
            'akquise_id': me.aktiveID,
            'meilenstein': meilenstein 
        };

        // Dialog 
        app.alert.question.fire("Wollen Sie den Meilenstein setzen?","Dieser Vorgangen kann nicht mehr Rückgängig gemacht werden?")
            
            .then((result) => {
                
                // Wenn Abgeschickt werden soll 
                if (result.isConfirmed) {
                    
                    // Ajax
                    app.simpleRequest("submitMeilenstein", "akquise-handle", data, 
                    
                        // Error
                        function(response) {
                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                            // Modal wieder öffnen mit der Aktiven ID
                            me.modal.show();

                            // Timeline neu Laden
                            me.loadTimeline();

                            // Meilensteine Neu laden
                            me.meilensteinOption();
                        },

                        // Error
                        function(xhr) {

                            app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                        }
                        
                    );

                // Wenn Nicht gespeichert werden soll
                } else if (result.isDenied) {

                    // Modal wieder öffnen mit der Aktiven ID
                    me.modal.show();

                } else {
                    // Modal wieder öffnen mit der Aktiven ID
                    me.modal.show();
                }
        });

    },

    // Dialog das Abfragt ob alles Kontakte angezeigt werden sollen oder nur die zu der Adresssen passen
    // zwei verscheiden tabelen Adressen_Kontakt oder Kontakte
    adressenKontakte() {

        var me = this;

        app.notify.info.fire("Kommt","Kommt noch");

        // app.alert.info.fire({
        //     title: 'Welche Kontakte wollen Sie öffnen?',
        //     text: "Wollen Sie die Kontakte die zu der Adressen gehören öffnen oder wollen Sie alle Kontakte sehen?",
        //     icon: 'question',
        //     confirmButtonText: 'Adressen Kontakte',
        //     cancelButtonText: 'Alle Kontake',
        // }).then(function(result) {

        //     if(result.isConfirmed) {
                
        //         me.adressenKontakteList.open();
        //     } else {

        //         me.addListKontakte.open();
        //     }

        // }); 


    },


    // Verschiebt die Reihenfolge des Meilenstein
    posShiftByListModal(direction, id) {

        var me = this;

        me.posShiftModal(direction, id, function(response) {

            // console.log(response);


        });

    },

    // Positionen Veschieben AJAX
    posShiftModal(direction, id, callback) {

        var me = this;

        // Ajax
        app.simpleRequest("positionen-shift", "akquise-handle", 
        
            // Additonnal
            {

                id: false, 
                colID: id, 
                direction: direction,
                akquise_id: me.aktiveID

            }, 
            
            // Erfolg
            function(response) {
                
                // 
                me.meilensteinOption();

                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                callback(response)
            },

            // Fehler
            function(a,b,c) {

                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }

            
            
        );

    },

    // Funktion der alle Optionen der Meilensteine erstellt
    meilensteinOption() {

        var me = this; 


        var html = "";

        // Erst Überprüfen ob Meilenstein schon angelegt wurde -- Ein Meilenstein nicht zweimal anlegbar
        app.simpleRequest("getMeilenstein", "akquise-handle", me.aktiveID, 
        
            // Success
            function(response) {

                // Wenn es überhaupt Meilensteine gibt
                if(response.result.data.length > 0) {

                    var date = ""; 
                    var name = "";

                    $.each(response.result.data, function(key, value) {

                        $.each(response.resultTest.data, function(keyM, valueM) {
                            name = valueM.bearbeiterVorname + " " + valueM.bearbeiterNachname
                            date = moment(valueM.zeitstempel).format("DD.MM.YYYY HH:mm");
                        });

                        // Wenn der Meilensteine schon gesetzt worden ist
                        if(value['isInAqkuise'] == '1') {

                            html += ''
                                + ' <a class="list-group-item list-group-item-action flex-column align-items-start">'
                                    +'<div class="d-flex w-100 justify-content-between">'
                                        +'<p class="mb-0"><i class="fa-solid fa-flag text-success"></i> ' + value['text'] +  '</p>'
                                        +'<small><i class="fa-solid fa-check text-success"></i></small>'
                                    +'</div>'

                                    + '<input type="hidden" name="meilensteine" class="meilensteine" value="' + value.akquiseMeilensteinID + '" >'

                                    +'<small style="color: #999;"><i class="fa-solid fa-user"></i> ' + name + ' / ' + date +  ' '
                                    
                                        + '<custom><i class="fa-solid fa-arrow-right-arrow-left" style="float:right; transform: rotate(90deg); font-size: 10px; padding-top: 5px;"></i></custom>'
                                    
                                    + '</small>'
                                +'</a>';

                        // Wenn der Meilenstein noch nicht gesetzt worden ist
                        } else {

                            html += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start meilenstein-option-hinzufuegen" data-value="' +  value.akquiseMeilensteinID  +'">'
                                    +'<div class="d-flex w-100 justify-content-between">'
                                        + '<input type="hidden" name="meilensteine" class="meilensteine" value="' + value.akquiseMeilensteinID + '" >'
                                        +'<p class="mb-0"><i class="fa-regular fa-flag" style="color: #999;"></i> ' + value.text +'</p>'
                                        + '<custom><i class="fa-solid fa-arrow-right-arrow-left" style="float:right; transform: rotate(90deg); color: #999; font-size: 10px; padding-top: 5px;"></i></custom>'
                                    +'</div>'
                                    
                                +'</a>';
                        }

                    })

                    
                }

                // Wenn es keine Meilensteine gibt
                else {

                    html += '<div class="mt-lg-2 alert alert-soft-grey ui-state-disabled">Noch keine Meilensteine hinterlegt</div>';

                }


                // Option Leeren
                $('#meilenstein-option').html("<div class='list-group'>" + html + "</div>");  

            },

            // Error
            function(xhr) {

                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            }
            
        );

       

       

    },

    // Wenn ein Button gedrückt wird zum löschen 
    deleteVisitenKarte(id) {

        var me = this;

        // Modal Schließen
        me.modal.hide();

        // Frage JA oder NEIN
        app.alert.question.fire("Löschen?","Wollen Sie den Kontakt wirklich als Ansprechpartner Löschen? <br> Diesen Vorgang kann man nicht mehr Rückgängig machen!")
            .then((result) => {

                // Wenn Ja
                if(result.isConfirmed) {

                    // Ajax
                    app.simpleRequest("deleteKontakte", "akquise-handle", [id], 
                    
                        // Success
                        function(response) {

                            // Modal wieder öffnen
                            me.modal.show();

                            // Visitenkarten neuladen
                            me.visitenKarte();

                            // Erfolgsmeldung
                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
                        },

                        // Error
                        function(xhr) {
                            app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                        }
                        
                    );
                    

                // Wenn Nein
                } else {

                    // Modal wieder öffnen
                    me.modal.show();

                }
        });

    },

    /** SubmitTimeline Funktion */
    submitTimeline() {

        var me = this; 

        // SQL Akzeptiert nur doppelte ''
        var escapeTextarea = $('textarea[name=text]').val().split("'").join("''");
        escapeTextarea = $("<p>" + escapeTextarea + "</p>").text(); // löscht die <p>-Tag Formatierung aus dem Summernote

        var getData = me.timelineForm.getData();

        // Save
        me.timelineForm.save('submitTimeline', 'akquise-handle',

            // Success
            function (response) {

                // Liste Neuladen
                me.list.refresh(true);

                // Form wird zurückgesetzt
                me.resetForm();

                me.timelineForm.reset(1);

                me.loadTimeline();

                me.loadTimelineFormular();

                // me.timelineForm.setData(getData);

                // $('input[name="art"]').prop('checked', false);
                // $('textarea').val('')


                // MARK OpenMod aktive ID war hier  vorher

                // Reset Form

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

            },

            // Error
            function (xhr) {


                app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            },

            // Additional Data
            {
                id: me.aktiveID,
                sessionID: me.sessionID,
                // bearbeiter_id: dataAkquise[2],
                text: escapeTextarea
            }

        );
 

    },

    // Wenn das Modal Nicht Erfolgreich abgeschickt werden soll
    submitNichtErfolgreich() {

        var me = this;

        // Save Funktion
        me.modalNichtErfolgreich.save('notErfolgreich', 'akquise-handle', 
        
            // Success
            function(response) {

                // Modal Reseten
                me.modalNichtErfolgreich.reset(1);

                // PickListe soll automatisch neu geladen werden -> damit man das Ergebnis sieht
                me.list.refresh(true);

                // Modal wieder öffnen
                me.modal.show();

                // Timeline Neu Laden
                me.loadTimeline();

                // Aktuellen Status anzeigen
                me.currentState(2)

                // Aktuellen Status Hide
                me.hideStatus('2');

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich ausgeführt");

            },

            /* Callback Error ist nicht vorhanden */
            function(a,b,c) {

                app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            },
            {
                id: me.aktiveID
            }
            
        );
    },

    

    // Wenn die Funktion Abonniert oder Deabonniert ausgeführt wird
    submitAbo(selectorData) {

        var me = this;

        // Modal Hide
        me.modal.hide();

        var title = "";
        var text = "";

        // Wenn Data Deabonniert ist
        if(selectorData == 'deabonniert') {
            title = "Debonnieren?";
            text = "Wollen Sie die Akquise wirklich deabonnieren?";
        
        // Abonnieren
        } else {
            title = "Abonnieren?";
            text = "Wollen Sie die Akquise wirklich abonnieren?";
        }

        // Queston
        app.alert.question.fire(title,text)
        .then((result) => {

            // Bestätigung
            if(result.isConfirmed) {

                // Ajax
                app.simpleRequest("akquiseAbo", "akquise-handle", me.aktiveID, 
                    
                    // Success - Abonnieren
                    function(response) {

                        if(selectorData == 'abonniert') {
                            // Abonnieren hide
                            $('.button-akquise-abonniert').hide();

                            // Deabonnieren show
                            $('.button-akquise-deabonniert').show();
                        } else {
                            // Abonnieren Show
                            $('.button-akquise-abonniert').show();

                            // Deabonnieren Hide
                            $('.button-akquise-deabonniert').hide();
                        }

                        // Success
                        app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                        // Modal wieder anzeigen
                        me.modal.show();

                        // Aktuellen Abo wieder bekommen
                        me.getAbo();

                    }, 

                    // Error
                    function(xhr) {
                        app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte melden Sie sich beim Admin!");
                    }
                    
                );

            } 
            
            // Ablehnung
            else {

                // Modal wieder anzeigen
                me.modal.show();
            }

        });
    },

    // Wenn in der Pickliste zum Hinzufügen von Ansprechpartnern eine Auswahl getroffen wurd
    submitKontakt(el, data) {

        var me = this;

        // Data
        var newData = [
            id = me.aktiveID,
            data = data
        ];

        // Ajax
        app.simpleRequest("neuerKontakt", "akquise-handle", newData, 
        
            // Success
            function(response) {

                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                // Modal wieder anzeigen
                me.modal.show();

                // Kontakte neu laden
                me.visitenKarte();

            },

            // Error
            function(xhr) {
                
                app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte melden Sie sich beim Admin!");
            }
            
        );


    },

    // Holt den Aktuellen Status ob Abonniert oder Deabonniert beim Neu laden der Seite
    getAbo() {

        var me = this;

        // Ajax
        app.simpleRequest("getAkquiseAbo", "akquise-handle", me.aktiveID,
        
            // Success 
            function(response) {

                if(response.data.abonniert == '1') {

                    // Deabo Zeigen
                    $('.button-akquise-deabonniert').show();
            
                    // Abo Glocke Verschwinden
                    $('.button-akquise-abonniert').hide();
                } else {

                     // Deabo Verschwidnen
                    $('.button-akquise-deabonniert').hide();
        
                    // Abo Glocke anzeigen
                    $('.button-akquise-abonniert').show();
                }

            },

            // Fehler bzw. keine Daten gefunden
            function(res,xhr) {

                // Wenn Keine Daten vorhanden sind
                if(res.error) {

                    // Deabo zeigen
                    $('.button-akquise-deabonniert').hide();
                
                    // Abo Glocke verschwinden
                    $('.button-akquise-abonniert').show();


                // Wenn wirklich ein Fehler aufgetreten ist
                } else {
                    app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte melden Sie sich beim Admin!");

                }
            }
        
        );

    },

    // Einstellungen die getroffen werden bei der Wiedervorlage
    wiedervorlageCallback(bool) {

        var me = this;

        // Wenn Wiedervorlage nicht in deiner Zuständigkeit ist
        if(bool) {

           
            // Wiedervorlage das Editable entfernen
            $('input[name="wiedervorlagemehrAnzeigen"]').removeClass('editable');

            // Disabled zu der Wiedervorlage hinzufügen
            $('input[name="wiedervorlagemehrAnzeigen"]').prop('disabled', true);

            // Checkbox Auf Standard nicht angehakt
            $('input[name="wiedervorlagemehrAnzeigen"]').prop('checked', false); 
        
            // Ausblenden des Inhaltes
            $('#wiedervorlage-mehr-anzeigen').hide();


            // VIEL TRAFFFIICC?? 

            // Add Class Label Info
            // $('.labelWiedervorlage').addClass('label-info')

            // Enable Tooltip damit man es wieder ansehen kann
            // me.tooltip.enable()

            $('.labelWiedervorlageOn').show();
            $('.labelWiedervorlageOff').hide();


        }

        // Wenn die Wiedervorlage in deiner Zuständigkeit ist
        else {

            // Warnung wieder löschen
            $('#wiedervorlage_nicht_aenderbar').html("")

            // Wiedervorlage das Editable hinzufügen
            $('input[name="wiedervorlagemehrAnzeigen"]').addClass('editable');
            
            // Disabled von der Wiedervorlage Entfernen
            $('input[name="wiedervorlagemehrAnzeigen"]').removeAttr('disabled');

            // Remove Unterstrichene Linie
            // $('.labelWiedervorlage').removeClass('label-info')

            // Disable Tooltip damit man es nicht sehen kann
            // me.tooltip.disable()

            $('.labelWiedervorlageOn').hide();
            $('.labelWiedervorlageOff').show();

        }
      
    },

    // Checkbox der Kontakte Modal Pickliste hinzufügen damit man Mitarbeiter setzen und entfernen kann
    checkboxKontakteMitarbeiter() {

        var me = this;

        // Fügt der Pickliste Checkbox Hinzu um nur nach Mitarbeiter zu filtern
        // me.addListKontakte.container.find('.modal-body').prepend(''
        //     + '<div class="form-group form-floating-check">'
        //         + '<label class="form-label">Kontakte Filter: </label>'
        //         + '<div class="form-check">'
        //             + '<input type="checkbox" class="form-check-input editable" id="nur_mitarbeiter" name="nur_mitarbeiter" checked="true" value="">'
        //             + '<label class="form-check-label" for="nur_mitarbeiter">Nur Personen aus dem Kunden anzeige:</label>'
        //         + '</div>'
        //     + '</div>'
        //  + '')

    },

    // setz den Filter der Mitarbeiter in der Kontakte Liste
    setKontakteFilter() {

        var me = this;

        // Wenn die Checkbox nur Mitarbeiter anzeigen checked ist
        // if(me.addListKontakte.container.find('input[name="nur_mitarbeiter"]').is(":checked")) {

        //     // Create Filter
        //     var filter = new PickFilter(10, $('input[name="adressen_id"]').val(), '=');

        //     // Set Filter
        //     var test = me.addListKontakte.setFilter(filter);

        // // Löscht den Filter wieder raus so dass alle Mitarbeiter angezeigt werden
        // } else {

        //     // Setzt den Filter zurück das Alle Mitarbeiter angezeigt werden
        //     me.addListKontakte.resetFilter();

        // }
        
    },

    // Funktion die zeigt wie viele weiter Akquisen der Kunde aktuell hat
    // Anzeigen unterhalb der Pickliste wie viele Status offen sind für einen Kunden
    offenAnzeige() {

        var me = this; 

        // Wenn Keine Weitere Akquise Offen ist soll das Hide sein
        $('.offene-akquise').hide();

        // Reset
        $('#info-status-offen, #weitere-akquise').html("");

        // Wenn eine Auswahl getroffen wurde
        if(me.aktiveID > 0) {

            app.simpleRequest("getStatusOffen", "akquise-handle", me.aktiveID, 

                // Success
                function(response) {

                    var offeneAkquisen = response.data.length;

                    // Nur wenn es noch andere weitere Offene Akquise für den Kunden gibt - Eine Akquise Offen zu haben ist Standard
                    if(offeneAkquisen > 1) {
                    
                        var text = "Kunde hat ";

                        // Offene Akquise soll show Sein wenn eine weitere Akquise Offen ist
                        $('.offene-akquise').show();

                        // Wenn mehr als eine Akquise offen ist - Akquise - 1 weil man damit sich selbst automatisch ausschließt
                        if(offeneAkquisen > 1) {
                            text += "<strong>" + (offeneAkquisen - 1) + "</strong> " + " weitere verschiedene Akquisen offen";
                        
                        // Wenn es nur einen offene Akquise gibt
                        } else {
                            text += "<strong>" + (offeneAkquisen - 1) + "</strong> " + " weitere offene Akquise";
                        }

                        // Wenn eine weiter Akquise vorhanden ist
                        $('.offene-akquise').html(offeneAkquisen - 1);
                        
                        // Meldung wird angezeigt wie viele Status offen sind
                        $('#info-status-offen').html("<div class='alert alert-soft-warning'>" + text + "</div>");

                        // Akquisen Hinzufügen zur Ansicht

                        // Leeres HTML
                        var html = ""


                        // Geht alle Offene Akquise durch
                        $.each(response.data, function(key, value) {

                            var aktion = "";

                            // Wenn eine Aktion vorhanden ist 
                            if(value.aktionname) {

                                aktion = value.aktionname;
                            }

                            // Wenn keien Aktion vorhanden
                            else {

                                aktion = "<i>Keine Aktion</i>"
                            }

                            // Soll alle durchgehen außer die aktiveID
                            if(value['id'] != me.aktiveID) {

                                html += '<a href="javascript:void(0)" class="list-group-item list-group-item-action flex-column align-items-start weitere-akquise-hinzufuegen" data-value="' +   value['id']  +'">'
                                        +'<div class="d-flex w-100 justify-content-between">'
                                            + '<input type="hidden" name="weitere-akquise" class="weitere-akquise" value="' + value['id'] + '" >'
                                            +'<p class="mb-0"><i class="fa-regular fa-comments" style="color: #999;"></i>  ' + value.firmenname + " - <strong>" + aktion +'</strong></p>'
                                        +'</div>'
                                    +'</a>';

                            }
                        })

                        // DOM Element hinzufügen
                        $('#weitere-akquise').html("<div class='list-group'> " + html +  " </div>")

                    // Wenn Keine weitere Akquise offen ist
                    } else {

                        // Warning
                        $('#info-status-offen').html("<div class='alert alert-soft-grey'>Es ist keine weitere Akquise dieses Kunden offen!</div>")

                    }
                },

                // Error
                function(a,b,c) {
                    app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte melden Sie sich beim Admin!");
                }
            );

        // Wenn keine Auswahl vorhanden ist
        } else {
            $('#info-status-offen').html("");
        }

    },

    // Ein Dialog das Abfrage soll ob das neue Akquise Modal geöffnet werden soll
    openWeiterAkquiseDialog(el) {

        var me = this;

        // Modal ausblenden für die Abfrage
        me.modal.hide();


        // Abfrage Dialog
        app.alert.question.fire("Wollen Sie wirkllich zur anderen Akquise wechseln?","Nachdem Sie den Vorgang Bestätigen öffnet sich die von ihnen gewählte Akquise automatisch, ansonsten werden Sie zurück geleitet")
            .then((result) => {

                // Wenn Ja --- Wechseln
                if(result.isConfirmed) {
                    
                    // Aktive ID wir gewechselt
                    me.aktiveID = el;

                    // Modal wird mit der neuen Aktiven ID geöffnet
                    me.openModal(me.aktiveID);

                } 

                // Wenn Nein --- Nicht Wechseln
                else {

                    // Ansonsten bleibt die Aktive ID die Alte und wird über diese wieder geöffnet
                    me.modal.show();

                }

        });

    },


    // Kontaktpersonen in der Visitenkarten Ansicht anzeigen
    visitenKarte() {

        var me = this;

        // Liste weg
        $('#kontakte-pickliste').hide();

        // Button Zeigen
        $('.hide-list').show();

        // Ansicht Zeigen
        $('#kontakte-card').show();

        // Reseten
        $('#kontakte-card').html("");

        app.simpleRequest("getKontakte", "akquise-handle", me.aktiveID, 
        
            // Success
            function(response) {

                if(response.data.length > 0) {

                    var res = "";
                    var loop = 0;

                    $.each(response.data, function(key, value) {

                        // Result
                        res += "<div class='col-lg-6'>"
                                + "<div class='visitenkarte'>"
                                    + "<div class='p-3'>"
                                        + "<input type='hidden' name='kontakt-id' val='" + response.data[key].id +  "'>"
                                        + "<div class='d-flex pb-2'>"
                                            + "<div class='pr-2'>"
                                                + "<i class='fa-solid fa-circle-user fa-3x user-icon'></i>"
                                            + "</div>"
                                            + "<div>"
                                                + "<strong class='kontakt-info'> " + value.vorname +  " " + value.nachname + " </strong><br>";
                                                if(value.funktion) {
                                                    res += "<strong class='kontakt-info text-overflow'> " +  value.funktion + " </strong><br>";
                                                }
                                            res += "</div>"
                                        + "</div>";

                                            if(value.telefon) {
                                                res += "  <i class='fa-solid fa-phone'></i> <a href='tel:" + value.telefon + "'>" + value.telefon +  "</a>";
                                            }
                                        


                                            if(value.email) {
                                                res += "<div class='row'><div class='col-lg-1'><i class='fa-solid fa-envelope'></i> </div> <div class='col-lg-10'><a class='text-overflow' href='mailto:" + value.email + "'> " + value.email +  " </a></div></div>";
                                            }

                                            res += "<div class='position-relative' style='bottom: 20px;'><div class='position-absolute top-0 end-0'><a data-kontakte='" + response.data[key].id + "' class='action-item fa-solid fa-trash text-danger button-kontakt-delete text-end' href='javascript:void(0);'></a> </div></div>";


                                    res += "</div>"
                                + "</div>"
                            + "</div>";

                            // Wenn die Schleife fertig geladen ist dann soll der Eventlistner für die Visitenkarten geladen werden - LOOP ENDS
                            if(response.data.length - 1 == key) {
                                loop = 1;
                            }

                    });

                    $('#kontakte-card').html(res);

                } else {

                    $('#kontakte-card').html("<div class='mt-lg-2 alert alert-soft-grey'>Noch keine Kontaktperson hinterlegt</div>");

                }


            },

            // Error
            function(xhr) {

                app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte melden Sie sich beim Admin!");

            }
            
        );

    },

    // Lädt die Form neben der Timeline
    loadTimelineForm(res) {

        var me = this;
        

        // Lädt den Aktuellen Status der Akquise und Lädt die Dropdown Liste neu
        me.currentState(res.result['data'][0]['status']);

        // Wenn der Aktuelle Bearbeiter ein anderer ist als der User der Angemeldet ist
        if(res.result['data'][0]['bearbeiter_id'] != me.sessionID) {

            // Globale Variable wird auf True gesetzt
            me.zustaendigkeit = true;

            // Einstellungen die Getroffen werden müssen
            me.wiedervorlageCallback(me.zustaendigkeit);

        
        // Wenn der Bearbeiter gleich dem Angemeldetem User ist
        } else {

            me.zustaendigkeit  = false;

            me.wiedervorlageCallback(me.zustaendigkeit);

        }

        // Wenn die Wiedervorlage vorhanden ist und nicht Null ist
        if (res.result['data'][0]['wiedervorlage']) {

            // Aktuelle Wiedervorlage wird Sichtbar
            $('#aktuelle-wiedervorlage-info').show();

            // Info Keine Wiedervorlage vorhandenn HIDE
            $('#keine-wiedervorlage').hide();

            // Wert der Wiedervorlage
            $('#aktuelle-wiedervorlage-info input[name="aktuelle_wiedervorlage"]').val(moment(res.result['data'][0]['wiedervorlage']).format('DD.MM.YYYY HH:mm'));

        } else {

            // Value Input hide
            $('#aktuelle-wiedervorlage-info').hide();

            // Info soll Sichrbar sein
            $('#keine-wiedervorlage').show();
        }

    },

    // lädt Timeline Form
    loadTimelineFormular() {

        var me = this;

         // Timeline Load Funktion
        me.timelineForm.load('loadTimelineForm', 'akquise-handle.php', me.aktiveID, 
        
            // Callback
            function(res) {

                // Result Timeline Form Data
                me.resTimelineFormData = res;

                me.loadTimelineForm(me.resTimelineFormData)

            }
        )

    },

    // Timeline laden
    loadTimeline() {

        var me = this;

        // Bevor die Timeline geladen wird wird sie erst gesäubert
        $('#akquise-timeline').html("");

        // Timeline Keine Daten da Löschen
        $('#keine-timeline-daten').html("");

        // Init Timeline
        var timeline = new Timeline('#akquise-timeline');

        // Holt die Daten aus der Timeline die für die Aktive ID erstellt wurden
        app.simpleRequest("loadTimeline", "akquise-handle.php", me.aktiveID, 
        
            // Success
            function(response) {

                // Wenn Daten vorhanden sind
                if(response.data.length > 0) {

                    var dataSet = [];

                    $.each(response.data, function(el, data) {

                        var wiedervorlage = "";
                        var kundentermin = ""
                        var precontent = "";
                        var classTimeline = "";

                        // Wenn eine Wiedervorlage vorhanden ist
                        if(data.wiedervorlagAP) {

                            // Wiedervorlage Formatiert
                            var wiedervorlageFormat = moment(data.wiedervorlagAP).format('DD.MM.YYYY HH:mm').split(" ");
                        
                            // Bereit gemacht um das an die Timeline zu übergeben - ANSONSTEN einfacher leerer Text übergeben
                            precontent = '<i class="fa-solid fa-bell"></i> ' + wiedervorlageFormat[0] + " um " + wiedervorlageFormat[1];
                         
                        }

                        // Wenn es einen Meilenstein gibt
                        if(data.meilenstein_id) {

                            data.text = data.meilensteinText ;
                        }

                        // Wenn es einen Bearbeiter Wechsel Gab
                        if(data.bearbeiter_wechsel) {

                            // TEXT, WIEDERVORLAGE UND ZUSTÄNDIGKEIT
                            if(precontent && data.text != 'change_bearbeiter') {
                                precontent += ' | <i class="fa-solid fa-retweet"></i> ' + data.wechselVorname + " " + data.wechselNachname;
                            
                            // TEXT und ZUSTÄNDIGKEIT
                            } else if(data.text != 'change_bearbeiter') {
                                precontent += '<i class="fa-solid fa-retweet"></i> ' + data.wechselVorname + " " + data.wechselNachname;
                            } 
                            
                            // NUR ZUSTÄNDIGKEIT
                            else {
                                data.text = data.wechselVorname + " " + data.wechselNachname + " ist nun Bearbeiter der Akquise";
                            }
                        }

                        // Wenn ein Kundentermin vorhanden ist
                        if(data.kundentermin) {

                            // Kundentermin Formatiert
                            var kundenterminFormat = moment(data.kundentermin).format('DD.MM.YYYY HH:mm').split(" ");
                        
                            // Bereit gemacht um das an die Timeline zu übergeben - ANSONSTEN einfacher leerer Text übergeben
                            kundentermin = '<i class="fa-solid fa-calendar-days"></i> ' + kundenterminFormat[0] + " um " + kundenterminFormat[1];
                        
                        }

                        // Wenn es Einen Ablehnungsgrund gibt dann schreib ihn ansonsten nicht
                        var ablehnungsgrund = data.ablehnungsGrundBezeichnung || "";

                        // Status Array - KEY VALUE Pairs ---> TODO: aus der Datenbank holen wäre es besser
                        var myValues = {
                            status_0: "Der Status wurde auf offen gesetzt",
                            status_1: "Der Status wurde auf erfolgreich gesetzt",
                            status_2: "Der Status wurde auf nicht erfolgreich gesetzt. <br> <strong> Grund </strong>: " + ablehnungsgrund + " ",
                            status_3: "Der Status wurde auf gelöscht gesetzt",
                            akquise_abonniert: "Die Akquise wurde abonniert",
                            aqkuise_deabonniert: "Die Akquise wurde deabonniert",
                            change_wiedervorlage: "Es wurde die Wiedervorlage geändert",
                            change_bearbeiter: "Es wurde die Zuständigkeit geändert",
                            akquise_kunde_erstkontakt: "Erstkontakt mit dem Kunden",
                            akquise_kunde_vor_ort_termin: "Es wurde vor Ort ein Termin vereinbart",
                            akquise_kunde_angebot: "Dem Kunden wurde ein Angebot erstellt"
                        
                        }   

                        // Wenn der Status auf offen gesetzt wurde -- Automatisch gesetze Texte
                        if(myValues[data['positionenText']]) {
                            data.text = myValues[data['positionenText']];

                            // classTimeline = "bubble-silent bubble-tight dot-secondary"
                            classTimeline = me.setStatusBubble(data['positionenText']);
                            
                        } else {
                            data.text = data['positionenText']
                        }

                        // data.text = (myValues[data['positionenText']]) ? myValues[data['positionenText']] : data['positionenText'];

                        // Wenn es Meilensteine gibt den Text den man bekommen hat setzen und es überhaupt DATEN gibt
                        if(data.meilensteinText) {
                            data.text = data.meilensteinText + " - <strong> Meilenstein erreicht </strong>";
                            // precontent = "<i class='fa-solid fa-gauge-high'></i> Meilenstein erreicht";
                            classTimeline = "bubble-silent bubble-tight dot-secondary";
                        }

                        dataSet.push({
                            "timestamp": data.zeitstempelAP,
                            "icon": data.icon,
                            "class": classTimeline + " bubble-scroll-lg",
                            "content": '<b style="font-weight:bold">' + data.bearbeiterVorname  + " " + data.bearbeiterNachnem + ' : </b>' + data.text,
                            "precontent": precontent,
                            "subcontent": kundentermin
                        });

                    });

                    // Setzt die Daten in die Timeline
                    timeline.setData(dataSet.reverse());

                    // Rendert
                    timeline.render();

                // Wenn keine Daten vorhanden sind
                } else {

                    // Timeline Meldung wenn keine Daten vorhanden sind
                    $('#keine-timeline-daten').html('<div class="alert alert-soft-grey" role="alert">Noch keine Kommunikation mit dem Kunden</div>');

                }

            },
            
            // Error
            function(xhr) {

                // Fehlermeldung
                app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten bitte wenden Sie sich an den Admin!");

            }
            
            
        );

    },

    // Funktion die die Farbe des Bubble bei dem Status setzt
    setStatusBubble(el) {

        var me = this;
        
        // 
        var classTimeline = "";

        // Wenn Status Erfolgreich
        if(el == 'status_1') {
            classTimeline = 'bubble-primary';
        }

        // Wenn Status Offen
        else if(el == 'status_0') {
            classTimeline = 'bubble-info';
        }

        // Wenn Status Nicht erfolgreich
        else if(el == 'status_2') {
            classTimeline = 'bubble-danger';
        }

        // Wenn Status Gelöscht
        else if(el == 'status_3') {
            classTimeline = 'bubble-secondary';
        }

        return classTimeline;

    },


    // eine Funktion mit der man den Status der Akquise ändern kann
    setStatus(selector) {

        var me = this;

        // Data Status
        var dataStatus = selector.data('status');
        
        /** Es muss geprüft werden welcher Status getriggert wurde damit man das richtige Modal öffnet bzw. Sweet Alert */
        
        // Wenn Erfolgreich oder Offen getriggert wurde
        if(dataStatus == '0' || dataStatus ==  '1') {

            me.erfolgreichOrOffen(dataStatus);

        // Wenn nicht Erfolgreich getriggert wurde
        } else if(dataStatus == '2') {

            me.nichtErfolgreich();

        // Wenn Gelöscht getriggert wurde
        } else if(dataStatus == '3') {

            me.deletebutton();
        }

    },

    /**
     * 
     * Alle Activation Checkbox werden hier Inititalisiert (auf beiden Seiten)
    */
    activationCheckbox() {

        var me = this;

        // Zuständigkeit Activation
        me.zustaendigkeitActivation = new ActivationCheckbox('#zustaendigkeit', '#div-mehr-anzeigen-zustaendigkeit', me.timelineForm);
        
        // Custom TimeStamp Activation
        new ActivationCheckbox('#zeitstempel', '#div-mehr-anzeigen-zeitstempel', me.timelineForm);

        // Custom Kundentermin Activation
        // me.kundeterminActivation = new ActivationCheckbox('#kundentermin', '#div-mehr-anzeigen-kundentermin', me.timelineForm);

        // Wiedervorlage Activation
        me.wiedervorlageActivation = new ActivationCheckbox('#wiedervorlagemehrAnzeigen', '#wiedervorlage-mehr-anzeigen', me.timelineForm);

       
        
    },

    // TODO ------ Wir aktuell nicht mehr benutzt
    // Der Aktuelle Kundentermin wird geladen und dann angezeigt
    kundenterminInfoText() {

        var me = this;

        //Ajax
        app.simpleRequest("getKundentermin", "akquise-handle", me.aktiveID, 
            
            // Success
            function(response) {

                // Wenn es einen Kundentermin gibt
                if(response.data[0].kundentermin) {

                    // Anzeigen als Input Disable - Umwandlung in das richtige Zeitformat
                    $('#aktueller-kundentermin').html('' 
                        + '<div class="form-group form-floating" id="aktuelle-kundentermin-info">'
                            + '<input type="text" name="kundentermin" class="form-control" placeholder="Kundentermin" autocomplete="nope" readonly value="' + moment(response.data[0].kundentermin).format('DD.MM.YYYY HH:mm') + '">'
                            + '<label>Aktueller Kundentermin</label>'
                        + '</div>'
                    + '');

                } 

                // Wenn es keinen Kundentermin gibt
                else {

                    // Warnung
                    $('#aktueller-kundentermin').html("<div class='alert alert-soft-warning' style='padding-top: 10px; padding-bottom: 10px;'>Es ist noch kein Kundentermin vorhanden!</div>")

                }

            },

            // Error
            function(xhr) {

                app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            }
        );

    },

    /** Eigene Reset Form  */
    resetForm() {

        var me = this;

        // Input activationCheckbox 
        // $('input[name="mehrAnzeigen"]').prop('checked', false);
        // $('input[name="wiedervorlagemehrAnzeigen"]').prop('checked', false);
        // $('input[name="mehrAnzeigenKundentermin"]').prop('checked', false);

        // ActivationCheckbox Details hide
        $('#div-mehr-anzeigen').hide();
        $('#wiedervorlage-mehr-anzeigen').hide();
        $('#div-mehr-anzeigen-kundentermin').hide();



    },

    // Diese Funktion setzt den Status auf Erfolgreich oder Offen
    erfolgreichOrOffen(dataStatus) {

        var me = this; 

        var title;
        var text;
        var currentStateNum;

        // Custom Date je nachdem ob es Erfolgreich ist oder Offen
        var resData = [
            me.aktiveID
        ];

        if(dataStatus == 1) {

            title = "Akquise abschließen";
            text = "Wenn der Kunde ein Angebot angenommen hat, dann wird die Akquise als Positiv abgeschlossen.";
            resData.push("erfolgreich");

            currentStateNum = 1;

        } else {

            title = "Akquise Status Offen";
            text = "Wenn der Kunde sich vorerst umentschieden hat, dann kann die Akquise vorübergehend wieder auf offen gesetzt werden, bevor man sie auf nicht erfolgreich setzt oder schließt.";
            resData.push("offen");

            currentStateNum = 0;

        }

        // Akquise Modal Schließen
        me.modal.hide();

        // Abfrage
        app.alert.question.fire(
            
            {
                title: title,
                text: text,
                confirmButtonText: 'Speichern',
                cancelButtonText: 'Abbrechen',
            })
            .then((result) => {

                // Wenn Ja gewählt wurde
                if(result.isConfirmed) {
                    // 
                    app.simpleRequest("akquiseErfolgreichOrOffen", "akquise-handle", resData, 

                        // Erfolg
                        function(response) {

                            // Akquise Modal wieder öffnen
                            // me.modal.show();

                            // me.akquiseTimeline();

                            // Modal wieder öffnen
                            me.modal.show();

                            // Timeline neu Laden
                            me.loadTimeline();

                            // Aktuellen Status laden
                            me.currentState(currentStateNum);

                            // Liste Neu Laden
                            me.list.refresh();

                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                            // hideStatus Funktion
                            me.hideStatus(dataStatus);
                        },

                        // Error
                        function(a,b,c) {
                            app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetrete. Bitte wenden Sie sich an den Admin!");
                        }
                        
                    );


                // Wenn Nein gewählt wurde
                } else {

                    // Modal wieder öffnen
                    me.modal.show();

                }
            }
        );

    },

    // Wenn Status der Akquise auf gelöscht werden soll
    deletebutton() {

        var me = this; 

        // Akquise Modal Ausblenden
        me.modal.hide();

        // Abfrage Ja oder Nein
        app.alert.question.fire("Status Gelöscht setzten","Möchten Sie den Status wirklich auf gelöscht setzen")
            .then((result) => {
                
                // Wenn Ja 
                if(result.isConfirmed) {
                    
                    // Ajax
                    app.simpleRequest("statusDelete", "akquise-handle", [me.aktiveID], 
                        
                        // Success
                        function(response) {

                            // Hide Status Aktuelle Status - Gelöscht
                            me.hideStatus('3')

                            // Liste neu laden
                            me.list.refresh(true);

                            // Erfolgsmeldung
                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
                        },

                        // Error
                        function(a,b,c) {
                            app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte melden Sie sich beim Admin!");
                        }
                    );
                
                // Wenn Nein
                } else {

                    // Modal wieder öffnen
                    me.modal.show();

                }
        });

    },

    // Wenn Nicht Erfolgreich getriggert wurde soll folgendes Ausgeführt werden
    nichtErfolgreich(id, dataStatus) {

        var me = this;

        // Modal Soll ausgeblendet werden
        me.modal.hide();

        // Spezielle Modal soll eingeschaltet werden
        me.modalNichtErfolgreich.open();

    },

    // Lädt den aktuellen Name des Kunden und welche Aktion er zugeordnet ist
    loadKunde(id) {

        var me = this;

        app.simpleRequest("getKundenName", "akquise-handle", id, 
        
            // Success
            function(response) {

                var setData = ""

                // Hidden Input Adressen ID setzen des Kunden
                $('#getKundenID').val(response.data[0]['adressen_id'])

                // Kundennamen
                setData += response.data[0]['kundenName'] ;

                // Wenn der Kunde eine Aktion zugeordnet wurde
                if(response.data[0]['aktionName']) {
                    setData += " - " + "<strong>" + response.data[0]['aktionName'] + "</strong>"
                }

                $('#getKundenName').html(setData);
            }
            
        );


    },


    // Lädt beim neu Laden immer den aktuellen Status
    currentState(status) {

        // Objekt zu welchem Zeitpnkt welcher Text und welche Farbe kommen soll
        // Index des Objektes ist das data-status
        var obj = {

            0: ['Offen', '#3498db'],
            1: ['Erfolgreich', '#7ab929'],
            2: ['Nicht Erfolgreich', '#c0392b'],
            3: ['Gelöscht', '#222222']
        };

        // Fügt die Farben und den Text zum HTML hinzu
        $('#aktueller-status').html('<span style="color: ' + obj[status][1] + '">' + obj[status][0] + '</span>');

        // Alle Status Buttons Anzeigen
        $('.btn-change-status').show();

        // Den Status Button Hiden der Aktuelle ausgewählt ist
        $('.btn-change-status[data-status='+ status +']').hide();
    },

    // Funktion der Dynamisch immer den richtigen Status ausblendet
    hideStatus(status) {

        // Alle Status Button einschalten
        $('.btn-change-status').show();

        // Der Status der Geändert wurde wir ausgeblendet 
        $('.btn-change-status[data-status='+ status +']').hide();

    },

   

    // Hotkeys was den Internen Notifcation Workflow Öffnet
    notificationHotkey() {

        var me = this;

        // Wenn N + O gedrückt wird
        hotkeys('shift + n + o', function (event, handler) {

            event.preventDefault();

            // Sidebar soll sich öffnen
            me.sidebar.open();

        });

        // Wenn N + O gedrückt wird
        hotkeys('escape', function (event, handler) {

            event.preventDefault();

            // Sidebar soll schließen
            me.sidebar.close();

        });

    },

    // Hier soll der internet Notification Workflow geladen werden
    notificationLoad() {


    },

    // Eine Custom Reset Funktion
    standardSettings() {

        var me = this;

        // Modal Hide
        me.modal.hide();

        // Formular Zurücksetzen
        me.timelineForm.reset();

        // Funktion damit man wieder auf dem Eintrag Tab Landet
        $('#akquise-timeline-modal .nav-tabs .nav-link').removeClass('active')
        $('#akquise-timeline-modal .nav-tabs #tab-nav-eintrag').addClass('active')
        $('#akquise-timeline-modal .tab-pane').removeClass('show active')
        $('#akquise-timeline-modal #tab-content-eintrag').addClass('show active')

        // Option Leeren
        $('#meilenstein-option').html("");
    },

    // Wenn die Wiedervorlage per Schnellklick über die Buttons geändert werden soll
    setWiedervorlage(selector) {

        var me = this;

        // Anzahl Data
        var value = selector.data('add-value');

        // Interval Data
        var interval = selector.data('add-interval');

        // Wenn das Interval TAG, MONAT, JAHR ist
        if (interval == 'days' || interval == 'months' || interval == 'years') {
            var newDate = moment().add(value, interval).format('YYYY-MM-DD');
            $('input[name="wiedervorlageDatum"]').val(newDate);

            // Wenn das Intervall STUNDEN sind
        } else if (interval == 'hours') {
            var time = moment().add(value, interval).format('HH:ss');
            $('input[name="wiedervorlageUhrzeit"]').val(time);
        }

    },

    // Validierung die Eingeblendet werden sollen
    validierungEingeblendet() {

        var me = this;

        // Die Felder die Validierung haben sollen
        akquise_both.obj = {
            standard: ['art', 'text'],
            // kundentermin: ['kundenterminDatum', 'kundenterminUhrzeit'],
            wiedervorlage: ['wiedervorlageDatum', 'wiedervorlageUhrzeit'],
            zustaendigkeit: ['bearbeiter_id']
        }

        // Loop durch das Objekt
        for(var item in akquise_both.obj){

            // Jedes Position des Arrays durchgehen
            for(var i = 0; i < akquise_both.obj[item].length; i++) {
                var validator = {
                    validators: {
                        notEmpty: {
                            message: 'Bitte ausfüllen!'
                        }
                    }
                }

                //addField gibt mit welches Feld und welche Options soll ausgeführt werden
                me.timelineForm.fvInstanz.addField(akquise_both.obj[item][i], validator)
            }

            // Alle Validierungen ausschalten
            me.enableValidator(akquise_both.obj[item], false);
        }

        // Standardmäßig sollen die Standard Validiert werden
        me.enableValidator(akquise_both.obj['standard'], true);

       
    },

    // Eine Funktion die die Validierung ein und anschaltet je nachdem welche Felder gewählt worden sind
    enableValidator(array, enable) {

       var me = this;

        // Läuft durch alle Elemente des Arrays
        for(var i = 0; i < array.length; i++) {

            // Wenn die Validierung eingeschaltet wurde
            if(enable) {
                me.timelineForm.fvInstanz.enableValidator(array[i]);
            
            // Wenn die Validierung ausgeschaltet wurde
            } else {
                me.timelineForm.fvInstanz.disableValidator(array[i]);
            }

        }

    },

    // damit nicht zweimal das gleich in der EventListener Steht ein HELPER
    helperValidation(selector, validator) {

        var me = this;

        // TODO: PRÜFEN OB ART UND TEXT LEER IST ODER NICHT????
        // Value ART
        var art = me.timelineForm.container.find('input[name="art"]').val();
        
        // Value TEXT Summernote
        var text = me.timelineForm.container.find('textarea[name="text"]').val();

        // Prio 1 (Zu erst checken) - Wenn Kundentermin Angehackt ist soll Standard Automatisch validiert sein 
        // if(selector[0].checked && validator == 'kundentermin') {

            
        //     me.enableValidator(akquise_both.obj['standard'], true);
        //     me.enableValidator(akquise_both.obj['kundentermin'], true);
        //     me.enableValidator(akquise_both.obj['wiedervorlage'], false);
        //     me.enableValidator(akquise_both.obj['zustaendigkeit'], false);
        // }

        // Prio 2 - Wenn die Zustaendigkeit gecheckt ist und (ART, TEXT und KUNDENTERMIN) leer sind
        if(selector[0].checked && validator == 'zustaendigkeit' && !$('input[name="mehrAnzeigenKundentermin"]').is(":checked")) {

            me.enableValidator(akquise_both.obj['standard'], false);
            // me.enableValidator(akquise_both.obj['kundentermin'], false);
            me.enableValidator(akquise_both.obj['wiedervorlage'], false);
            me.enableValidator(akquise_both.obj['zustaendigkeit'], true);

        
        // Prio 3 - Wenn die Wiedervorlage gechekct ist und (ART, TEXT und KUNDENTERMIN) leer sind
        } else if(selector[0].checked && validator == 'wiedervorlage' && !$('input[name="mehrAnzeigenKundentermin"]').is(":checked")) {

            me.enableValidator(akquise_both.obj['standard'], false);
            // me.enableValidator(akquise_both.obj['kundentermin'], false);
            me.enableValidator(akquise_both.obj['zustaendigkeit'], false);
            me.enableValidator(akquise_both.obj['wiedervorlage'], true);
        
        // Andersfalls
        }   else {

            me.enableValidator(akquise_both.obj['standard'], true);
            // me.enableValidator(akquise_both.obj['kundentermin'], false);
            me.enableValidator(akquise_both.obj['zustaendigkeit'], false);
            me.enableValidator(akquise_both.obj['wiedervorlage'], false);
        }
    }
} 