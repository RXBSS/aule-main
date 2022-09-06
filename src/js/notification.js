/**
 * Das ist die Notification App
 * 
 * Hier werden alle funktionien geladen die man über diese Sidebar steuern kann
 * Die Notification werden Dargestellt und können angesteuert werden. Geht man auf einen Notification drauf wird man auf die jeweilige
 * Akquise oder Auftrag etc. weitergeleitet und kann diese bearbeiten oder man kann sich alle Anzeigen lassen
 * 
 * ---------------------------------------------------------------------------------------------------------------------
 * NOTIFICATION SEITE wird noch programmiert (Pickliste ansicht, onPick etc.)
 */

// 
var notification = {
    
    
    init() {

        var me = this;

        // Nur aktivieren, falls eine Menüleiste da ist
        if($('.navbar-action-container').length) {

            // Cookie Setzen damit das bei Notification.Js abgefangen wird --- Wenn auf der Akquise Seite draufgeklickt wird soll die seite nicht neu geladen werden
            document.cookie = 'akq=false'

            // Notification Icon
            me.notification = new Notification({
                icon: "fa-solid fa-bell",
                color: 'warning',
                blink: 'slow'
            });

            // Notification Sidebar
            me.sidebar = new Sidebar({
                name: 'some-name',
                width: 400,
                clickToClose: true, // Wenn man Weg klickt
            });

            // Notification Load
            me.loadNotificationIcon();

            // Custome CSS Beim Start
            me.customCSS();

            // EventListener
            me.addEventListener();
        }
    },


    // EventListener
    addEventListener() {
        
        var me = this; 

        // Wenn der URL Trigger getriggert wird Soll das href ausgelesen werden und als Location übergeben werden
        $('.url-redirect-trigger').on('click', function() {

            // Aktuelle URL des Events
            var aktiveID = $(this).attr('href');

            // console.log("TESSSTT");

            // Korrekte URL wird geschrieben
            // window.location.href = locationURL;

        });


        // --------------------------------------------------------------------------------------------------------
        // --------------------------------------------------------------------------------------------------------
        // --------------------------------------------------------------------------------------------------------
        // --------------------------------------------------------------------------------------------------------

        // Wenn der Icon geklickt wird geprüft ob es Daten gibt - Sidebar wird geöffnet
        me.notification.on('click', function() {
            me.sidebar.open();
        });

        // Wenn die Sidebar geöffnet wird
        me.sidebar.on('open', function() {
            
            // Sidebar Öffnen
            me.sidebarLoader();


            me.customCSS();

            // Blinken Löschen
            // me.notification.container.removeClass('action-signal action-warning')
        });

        // ToDo: TOBI FRAGEN ???? Ich habe so meine Zweifel ob das die beste IDEE ist
        me.sidebar.container.on('click', '.url-redirect-trigger', function() {

            var akquisePage = document.cookie.split(`; akq=`)[1]

            // Holt Sich das Akquise Cookie
            if(akquisePage == 'false') {

                // Custom Redirect Funktion
                me.redirect($(this));
            }

        });

    },

    // Eine Funktion die beim Laden der Sidebar eigene CSS hinterlegen soll
    customCSS() {

        var me = this;

        // console.log("TEGDGFRG");

        // $('p').css('margin-bottom', '0');

        // me.sidebar.container.find('p').css('margin-bottom', '0');

        // $('p').attr('style', 'margin-bottom: 0 !important');

    },

    // Wenn die Seite neu geladen wird soll es direkt blinken oder halt nicht je nachdem ob eine der Nachrichten gelesen ist
    loadNotificationIcon() {

        var me = this;

        // Ajax
        app.simpleRequest("load-notification", "../notification-handle.php", null, 
        
            // Success
            function(response) {

                // Nur wenn es Daten Gibt 
                if(response.data.length > 0) {

                    // Geht durch die letzten 5 Einträge --
                    $.each(response.data, function(key, value) {

                        // Holt die letzen 5 Einträge aus der Datenbank - Wenn eins davon ungelesen ist dann soll Icon Blinken
                        if(value['gelesen'] == '0') {
                            me.notification.container.addClass('action-signal action-warning');
                        } else {
                            me.notification.container.removeClass('action-signal action-warning');
                        }

                    });

                // Ansonsten ist es immer nicht blinkend
                } else {
                    me.notification.container.removeClass('action-signal action-warning');
                }
               

               
            },

            // Error
            function(xhr) {

                console.log("------------ Fehler beim Laden -------------------");

            }
            
        );

    },

    // Funktion die alle beinhaltet was passieren soll wenn auf eine Notification geklickt wird
    redirect(selector) {

        var me = this;

        var aktiveNotificationID = selector.find('input[name="aktiveID"]').val();
        var aktion = selector.find('input[name="aktion"]').val();
        var gelesen = selector.find('input[name="gelesen"]').val();

        var data = [
            id = aktiveNotificationID,
            aktion = aktion
        ];

        // Custom Cookie
        var cookie = 'dia='+ aktiveNotificationID + ''

        // Nur wenn es nicht gelesen wurde soll es auf GELESEN gesetzt werden
        if(gelesen == '0') {

            //  Ajax
            app.simpleRequest("redirect-notification", "../notification-handle.php", data, 
            
                // Success
                function(response) {

                    // Set Cookie
                    document.cookie = cookie;

                    // Redirect to Akquise PHP
                    app.redirect('../akquise.php');
                }, 

                // Error
                function(xhr) {
                    app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                }
                
            );
        } else {
            
            // Set Cookie
            document.cookie = cookie;

            // Redirect to Akquise PHP
            app.redirect('../akquise.php');
        }
    },


    // Wenn die Sidebar geöffnet wird werden folgende Dinge geladen
    sidebarLoader() {

        var me = this;

        me.notification.container.removeClass("action-signal action-warning")

        // Ajax
        app.simpleRequest("load", "../notification-handle.php", null, 
            
            // Success
            function(response) {
                // TODO: Was wenn die Abfrage Nicht Erfolgreich war dann geht man gar nicht in den Error

                // 
                var setData = "";


                // Wenn Success und es Ergebnise gibt
                if(response.success && response.successSQL === false && response.result !== false) {

                    // Schleife geht durch alle Einträge die von der Datenbank zurückkommen
                    $.each(response.result.data, function(key, value) {


                        if(response.result.data[key]['gelesen'] == '0') {
                            me.notification.container.addClass("action-signal action-warning")
                        }

                        // ToDo: Als json abspeichern und laden  ?????????
                        // KeyWords zu richtigen sinnvollen Text umgewandelt
                        var myValues = {
                            new_auftrag: "Neuer Auftrag erfasst!",
                            akquise_status_offen : "Akquise Status offen!",
                            create_akquise: "Neue Akquise erstellt!",
                            akquise_status_nicht_erfolgreich: "Akquise Status nicht erfolgrecih!",
                            akquise_status_erfolgreich: "Akquise Status erfolgreich!",
                            akquise_status_geloescht: "Akquise Status gelöscht!",
                            akquise_aktion_geloescht: "Akquise aus Aktion gelöscht!",
                            add_kontaktPerson_akquise: "Akquise Kontaktperson hinzugefügt!",
                            akquise_abonniert: "Akquise abonniert",
                            akquise_automatisch_abonniert: "Akquise wurde automatisch abonniert! ",
                            change_zustaendigkeit_akquise: "Akquise Zuständigkeit geändert!",
                            akquise_add_text: "Ein Text wurde hinzugefügt",
                            akquise_change_wiedervorlage: "Die wiedervorlage wurde geändert"
                        }

                        // URL die geschrieben wird
                        // var url = "notification-details.php?id=" + response.result.data[key]['id'] + "";

                        // Daten die an die Sidebar übergeben werden sollen
                        setData += '<a class="action-item url-redirect-trigger"  href="javascript:void(0);"> '
                        
                            + '<div class="row" id="sidebar-container" style="color: black">'
                            + '<input type="hidden" name="aktiveID" value="' + response.result.data[key]['data'] +  '">'
                            + '<input type="hidden" name="aktion" value="' + response.result.data[key]['aktion'] +  '">'
                            + '<input type="hidden" name="gelesen" value="' + response.result.data[key]['gelesen'] +  '">'

                            + '<div class="col col-lg-10">'

                            + '<p class="date-container" style="margin-bottom: 5px;">'
                            + '<i class="fa-solid fa-calendar-days" style="font-size: 18px; color: #7ab929"></i> <custom class="date">' + moment(response.result.data[key]['zeitstempel_erstellt']).format('DD.MM.YYYY') + ' </custom> '
                            + '| <i class="fa-solid fa-user" style="font-size: 18px; color: #7ab929"></i> <custom class="date"> ' + response.resultMitarbeiter[key] + ' </custom>' 
                            
                            + '</p>'

                            + '</div>'
                            + '<div class="col col-lg-2">';

                            if(response.result.data[key]['gelesen'] == '0') {
                                setData += '<i class="fa-solid fa-circle text-danger text-end"></i>';
                            }
                            

                            setData += '</div>'
                            

                        
                            + '<h5 class="title">' + myValues[response.result.data[key]['aktion']] + '</h5>';
                            
                            // Wenn die Aktion ein Text hinzufügen war und es einen Text gibt
                            if(response.result.data[key]['aktion'] == 'akquise_add_text' && response.result.data[key]['text']) {
                                setData += '<h6 class="subtext"><strong>Beschreibung</strong>: ' + response.result.data[key]['text'] + '</h6>';
                            }

                            // ToDo: Nicht Final
                            // Wenn es einen Beschreibung gibt dann Schreib Sie
                            if(response.result.data[key]['data']) {
                                setData += '<h6 class="subtext"> <strong> Zusatzinformation: (Akquise-ID) </strong>' + response.result.data[key]['data'] + '</h6>';
                            }

                            

                            setData += '<hr>'

                        + '</div>'
                        + '</a>';
                        
                    });

                    // Alle Anzeigen Button
                    setData += '<a class="action-item text-center" href="../notification.php" data-bs-toggle="tooltip" data-bs-placement="top" title="Text">Alle Anzeigen</a>';

                } else {

                    setData += "<div class='alert alert-soft-warning mt-lg-4'> Es sind noch keine Daten vorhanden </div>"

                }

                // Set Sidebar Data
                me.sidebar.setHtml(setData);

            }, 

            // Error
            function(xhr) {

                // Fehlermeldung
                app.notify.error.fire("Nicht Erfolgriech","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                
            }
        );

    }
};


$(document).on('app:ready', function() {
    notification.init();
});