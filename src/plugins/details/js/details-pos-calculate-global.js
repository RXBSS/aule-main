var detailHelperPosCalculate = {


    /**
    * Kalkulationverbund aktivieren
    */
    initCalculation() {

        var me = this;

        // TODO: Ggf. noch den Default Wert aus den Einstellungen holen?
        me.calcTableFormat = false;

        console.log('Init Calculation Verbund');

        // Kalkulationsverbund initalisieren
        me.verbund = new Kalkulationsverbund('#positionen-kalkulationsverbund', me.positionForm);

        // Activation Checkbox
        me.verbundCheckbox = new ActivationCheckbox('#test-checkbox', [{
            el: '.rabatt-is-checked'
        }], me.positionForm);
    },




    /**
     * Berechnet die Gesamtsumme der Positionen 
     * Es wird erwartet, dass im Handler die `position-handle` eingefügt ist oder die `positionen-summe` abgefangen wird
     * 
     * Response sollte wie folgt aussehen: 
     * 
     *  {
     *      netto: 200,
     *      brutto: 238,
     *      mwst: {
     *          19: 38
     *      }
     *  }
     * 
     * 
     */
    calculateTotal() {

        var me = this;

        if (!me.handler) {
            throw "Es wurde kein Handler mitgeben!";
        }

        // Ladeanzeige
        $('#positionen-gesamtsumme').html(app.getLoaderSvg(100, 50));



        // Daten aus dem Ajax Request holen
        app.simpleRequest("positionen-summe", me.handler, me.id, function (response) {


            // Große Tabelle
            // -------------
            var table = "<table>";
            table += "<tr class='table-extended' " + ((me.calcTableFormat != 'large') ? "style='display:none;'" : "") + "><td>Einkaufspreis</td><td>" + app.formatter.formatWaehrung(response.data.ek) + " €</td></tr>";
            table += "<tr class='table-extended text-success' " + ((me.calcTableFormat != 'large') ? "style='display:none;'" : "") + "><td>Marge</td><td class='text-success'>+" + app.formatter.formatWaehrung(response.data.marge) + " €</td></tr>";


            // Rabat nur anzeigen, wenn vorhandens
            if (response.data.rabatt > 0) {
                table += "<tr class='table-extended' " + ((me.calcTableFormat != 'large') ? "style='display:none;'" : "") + "><td>Zwischensumme</td><td></strong>" + app.formatter.formatWaehrung(response.data.netto) + " €</strong></td></tr>"
                table += "<tr class='table-extended text-danger' " + ((me.calcTableFormat != 'large') ? "style='display:none;'" : "") + "><td>Rabatt (~ X,XX %)</td><td class='text-danger'>-  " + app.formatter.formatWaehrung(response.data.rabatt) + " €</td></tr>";
                table += "<tr class='table-extended text-success' " + ((me.calcTableFormat != 'large') ? "style='display:none;'" : "") + "><td>Marge Rabatt</td><td class='text-success'>" + app.formatter.formatWaehrung(response.data.marge_rabatt) + " €</td></tr>";
            }

            // Kleine Tabelle
            table += "<tr><td><strong>Netto</strong></td><td></strong>" + app.formatter.formatWaehrung(response.data.netto_rabatt) + " €</strong></td></tr>"

            $.each(response.data.steuer_saetze, function (index, value) {
                table += "<tr><td>MwSt. (" + app.formatter.formatAutoFloat(index, 1, 1) + " %)</td><td>" + app.formatter.formatWaehrung(value) + " €</td></tr>";
            });

            table += "<tr><td>Brutto</td><td>" + app.formatter.formatWaehrung(response.data.brutto) + " €</td></tr>"
            table += "</table>";


            // HTML einfügen
            $('#positionen-gesamtsumme').html(table);



            // // Wenn es Rabatt gibt, dann ein- und ausblenden
            me.positionList.colVisible(['rabatt_kombi'], response.data.hasRabatt);
        });
    }
}