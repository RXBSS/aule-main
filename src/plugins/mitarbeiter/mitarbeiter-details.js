
var mtr_d = {

    init: function() {

        var me = this;

        me.id = app.getUrlId();



        // Init aller Forms auf der Details Seite
        me.initForm();
       
        // Init der AddEventListeners
        me.addEventListener();

        // var test = new CardSizer(['#mitarbeiter-stammdaten','#zeiterfassung-aktivieren']);

    },

    initForm() {

        var me = this;

        // Init der Card Stammdaten
        me.form = new CardForm('#form-mitarbeiter-details');
        me.form.initValidation();

        // Init der Zeiterfassung
        // me.zeiterfassungForm = new CardForm("#zeiterfassung-aktivieren");
        // me.zeiterfassungForm.initValidation();
 
        // // Init der Urlaubsplaner
        // me.urlaubsplanerForm = new CardForm("#urlaubsplaner-aktivieren");
        // me.urlaubsplanerForm.initValidation();

    },

    addEventListener() {

        var me = this;

        me.form.load('load', 'mitarbeiter-handle.php', me.id, function(){
            
        });

        me.form.on('submit', function(res) {
            me.form.save('mtr_d-submit', 'mitarbeiter-handle');
        });
    }


}