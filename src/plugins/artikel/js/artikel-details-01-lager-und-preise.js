var artikelLagerUndPreise = {


    initLagerUndPreise() {

        var me = this;

        // Lager 
        me.initLager();
        me.initLagerChart();

        // Preise
        me.initPreise();

        // Event Listner
        me.addLagerListner();
    },

    // Lager
    initLager() {

        var me = this;

        // Form in einer Card
        me.lagerForm = new CardForm('#form-artikel-lager');

        // Initalisieren
        me.initLagerFormCheckboxes();

        // Form
        me.lagerForm.load('load', 'artikel-handle.php', me.id, function (data) {
            me.updateLagerChart();
        });

        // Felder
        var fields = {
            auto_bestand_min: {
                validators: {
                    callback: {
                        message: 'Muss <= sein',
                        callback: me.validateAutoBestellung
                    },
                },
            },
            auto_bestand_max: {
                validators: {
                    callback: {
                        message: 'Muss >= sein',
                        callback: me.validateAutoBestellung
                    },
                },
            },
        };

        // Form Validation aktivieren
        me.lagerForm.initValidation(fields);

        // On Submit
        me.lagerForm.on('submit', function () {            

            var prev = me.lagerForm.initFormData.ident.checked;
           
            me.lagerForm.save('lager-set', 'artikel-handle', function() {
                
                var now = me.lagerForm.initFormData.ident.checked;

                if(prev == false && now) {
                    
                    var triggerEl = document.querySelector('#tab-nav-artikel-2');
                    bootstrap.Tab.getOrCreateInstance(triggerEl).show();
                }

            });
        });

    },

    initLagerFormCheckboxes() {

        var me = this;

        // Auto Order
        me.cbAutoLager = new ActivationCheckbox('#automatische-bestellung', [{
            el: '.auto-order-additional',
        }], me.lagerForm);


        // Identartikel
        me.cbIdent = new ActivationCheckbox('#identartikel', [{
            el: '.identartikel',
        }], me.lagerForm);

        // 
        me.cbIdent.on('callback', function (el, isChecked, isInit, isForm, hasChange) {

            if (hasChange && !isChecked) {

                // Loader
                app.alert.loader.fire();

                me.validateIdentArtikel(function (success, error) {

                    // 
                    app.alert.loader.close();

                    // Ergebnis
                    if (!success) {
                        me.cbBestand.setChecked(true);
                        app.alert.warning.fire("Fehler beim Deaktivieren", error);
                    }
                });
            }
        });


        // Bestand
        me.cbBestand = new ActivationCheckbox('#bestandsfuehrung', [{
            el: '.bestandsfuehrung',
            child: [
                { el: me.cbAutoLager },
                { el: me.cbIdent },
            ]
        }], me.lagerForm);

        // Callback
        me.cbBestand.on('callback', function (el, isChecked, isInit, isForm, hasChange) {

            if (hasChange && !isChecked) {

                // Loader
                app.alert.loader.fire();

                me.validateBestandsUndIdentArtikel(function (success, error) {

                    // 
                    app.alert.loader.close();

                    // Ergebnis
                    if (success) {
                        me.cbIdent.setChecked(false, true);
                        $('.identartikel').hide();
                    } else {
                        me.cbBestand.setChecked(true);
                        app.alert.warning.fire("Fehler beim Deaktivieren",error);
                    }
                });
            }
        });
    },


    /**
     * Lager Lisner 
     */
    addLagerListner() {

        var me = this;

        // Wenn Auto Bestand aktiviert, deaktiviert wird!
        me.lagerForm.container.on('click', 'input[name=auto_bestand_aktiv]', function () {

            // Chart Aktualisieren
            me.updateLagerChart();
        });

        // Wenn Minimal und Maximal Bestände aktiviert, deaktiviert werden!
        me.lagerForm.container.on('keyup', 'input[name=auto_bestand_min], input[name=auto_bestand_max]', function () {

            // Chart aktualisieren
            me.updateLagerChart();

            // Revalidate Other Field
            me.lagerForm.fvInstanz.revalidateField('auto_bestand_min');
            me.lagerForm.fvInstanz.revalidateField('auto_bestand_max');
        });
    },



    validateBestandsUndIdentArtikel(callback) {

        var me = this;

        // Wenn Ident-Artikel True ist
        if (me.cbIdent.getValue()) {

            // Validieren des IdentArtikels
            me.validateIdentArtikel(function (success) {

                // Wenn es ein Problem gab 
                if (success) {
                    me.validateBestandsArtikel(function (success) {
                        callback(success);
                    });

                    // Wenn es kein Problem gab
                } else {
                    callback(false, "Der Bestand kann nicht deaktiviert werden, da noch Identartikel vorhanden sind.");
                }
            });

            // Wenn IdentArtikel nicht true ist
        } else {
            me.validateBestandsArtikel(function (success, error) {
                callback(success, error);
            });
        }
    },


    /**
     * // TODO: Hier muss noch geprüft werden, ob Artikel im Bestand sind
     */
    validateBestandsArtikel(callback) {

        var me = this;

        // Abfrage der Datenbank
        setTimeout(function () {

            // TODO - Hier muss noch die Bestandsprüfung stattfinden
            if (1 == 2) {
                callback(false, "Die Bestandführung kann nicht deaktiviert werden. Es ist noch Bestand vorhanden.");
            } else {
                // app.alert.loader.close();
                callback(true);
            }


        }, 300);
    },


    /**
     * // TODO: Hier muss noch geprüft werden, ob es schon Ident-Nummern gibt
     */
    validateIdentArtikel(callback) {

        var me = this;

        setTimeout(function () {

            // TODO - Hier muss noch die Bestandsprüfung stattfinden
            if (1 == 2) {
                callback(false, "Der Ident-Artikel kann nicht deaktiviert werden, da noch Identnummer existieren");
            } else {
                callback(true);
            }

        }, 300);
    },

    validateAutoBestellung() {

        var result = false;

        var min = $('input[name=auto_bestand_min]').val();
        var max = $('input[name=auto_bestand_max]').val();

        // Nur wenn beide vergeben sind - Empty wird separat validiert
        if (min && max) {

            min = parseInt(min);
            max = parseInt(max);

            if (min > 0 && max > 0 && min <= max) {
                result = true;
            }

        } else {
            result = true;
        }

        return result;

    },

    initLagerChart() {

        var me = this;

        // Chart initalisieren
        var ctx = document.getElementById('lager-chart').getContext('2d');

        // Chart initalisieren
        me.lagerChart = new Chart(ctx, {
            plugins: [ChartDataLabels],
            type: 'bar',
            data: {
                labels: [],
                datasets: [],
            },

            // Optionen
            options: {

                indexAxis: 'y',
                plugins: {

                    legend: false,

                    datalabels: {
                        color: 'black',
                        formatter: Math.round,
                        display: function (context) {
                            return context.dataset.data[context.dataIndex];
                        },
                        font: {
                            weight: 'bold'
                        },
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                        suggestedMin: 0,
                        suggestedMax: 15
                    },
                    y: {
                        stacked: true,

                    }
                }
            }
        });


    },


    // Chart Aktualisieren
    updateLagerChart() {

        var me = this;

        // Daten für das Chart
        var hasAuto = me.lagerForm.container.find('input[name=auto_bestand_aktiv]').prop('checked');
        var min = me.lagerForm.container.find('input[name=auto_bestand_min]').val();
        var max = me.lagerForm.container.find('input[name=auto_bestand_max]').val();

        if (JSON.stringify([hasAuto, min, max]) != JSON.stringify(me.priorChartData)) {

            me.priorChartData = [hasAuto, min, max];


            // 
            app.simpleRequest("lager-chart", "artikel-handle", {
                id: app.getUrlId(),
                has: hasAuto,
                min: min,
                max: max
            }, function (response) {

                if (hasAuto) {

                    // Datenobjekt generieren
                    var dataObj = {

                        // Labels festlegen
                        labels: ['Hauptlager', 'Minimal', 'Maximal', 'Nebenlager', 'Personen', 'Aufträge', 'Kommission', 'Bestellt'],

                        // Datasets festlegen
                        datasets: [
                            {
                                label: 'Bestand',
                                data: [response.data.hauptlager, null, null, response.data.nebenlager, response.data.personen, response.data.auftraege],
                                borderColor: '#999',
                                backgroundColor: '#999',
                            },
                            {
                                label: 'Minimal',
                                data: [null, min, null],
                                borderColor: '#c0392b',
                                backgroundColor: '#c0392b',
                            },
                            {
                                label: 'Maximal',
                                data: [null, null, max],
                                borderColor: '#7AB929',
                                backgroundColor: '#7AB929',
                            },
                            {
                                label: 'Bestellt',
                                data: [null, null, null, null, null, null, null, response.data.bestellt],
                                borderColor: '#3498db',
                                backgroundColor: '#3498db',
                            },
                            {
                                label: 'zu Bestellen',
                                data: [(max - response.data.hauptlager), null, null],
                                borderColor: 'rgba(52, 152, 219, 0.2)',
                                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                            },
                        ],
                    }

                    // Ohne automatische Bestellung
                } else {
                    // Datenobjekt generieren
                    var dataObj = {

                        // Labels festlegen
                        labels: ['Hauptlager', 'Nebenlager', 'Personen', 'Aufträge', 'Kommission', 'Bestellt'],

                        // Datasets festlegen
                        datasets: [
                            {
                                label: 'Bestand',
                                data: [response.data.hauptlager, response.data.nebenlager, response.data.personen, response.data.auftraege],
                                borderColor: '#999',
                                backgroundColor: '#999',
                            },
                            {
                                label: 'Bestellt',
                                data: [null, null, null, null, null, response.data.bestellt],
                                borderColor: '#3498db',
                                backgroundColor: '#3498db',
                            }
                        ],
                    }
                }

                // Aktualisieren
                me.lagerChart.data = dataObj;
                me.lagerChart.update();

            });
        }
    },



    initPreise() {

        var me = this;

        // Form in einer Card
        var form = new CardForm('#form-artikel-preis');

        me.initPreiseChart();

        $('.btn-artikel-preise-kundenindividual').on('click', function () {
            app.alert.info.fire("Kunden-Individualpreise", "Diese Funktion ist zum jetztigen Zeitpunkt noch nicht programmiert!");
        });


        new ActivationCheckbox(form.container.find('input[name="feste_preise"]'), [{
            el: '.feste-preise-aktiv'
        }], form);

        form.load('load', 'artikel-handle.php', me.id);

        // On Submit
        form.on('submit', function () {
            form.save('preise-set', 'artikel-handle');
        });


    },

    initPreiseChart() {

        var me = this;

        // Chart initalisieren
        var ctx = document.getElementById('preis-chart').getContext('2d');

        // Chart initalisieren
        me.preisChart = new Chart(ctx, {
            type: 'line',

            data: {
                labels: [1, 2, 3, 4, 5, 6, 7, 8],
                datasets: [{
                    label: 'EK',
                    data: [17.23, 23.23, 23.43, 23.23, 24.23, 32.23, 32.23, 32.34],
                    backgroundColor: '#3498db',
                    borderColor: '#2980b9'
                }, {
                    label: 'Ø EK',
                    data: [25, 25, 25, 25, 25, 25, 25, 25],
                    backgroundColor: 'rgba(52, 152, 219, 0.5)',
                    borderColor: 'rgba(41, 128, 185, 0.5)'
                }, {
                    label: 'VK',
                    data: [43.25, 45.65, 45.65, 45.67, 56.56, 56.65, 56.56, 56.56],
                    backgroundColor: '#9b59b6',
                    borderColor: '#8e44ad'
                }, {
                    label: 'Ø VK',
                    data: [50, 50, 50, 50, 50, 50, 50, 50],
                    backgroundColor: 'rgba(155, 89, 182, 0.5)',
                    borderColor: 'rgba(142, 68, 173, 0.5)'
                }]
            }
        });
    }
};