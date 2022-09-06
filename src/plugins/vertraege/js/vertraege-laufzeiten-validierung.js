
/**
 * Dieses Objekt wird sowohl auf der Vorlagen-Details benötigt und auf der Verträge-Details 
 * 
 * Damit die Validierung nicht doppelt geschrieben werden muss wird das hier in eine Funktion gepackt um
 * die Field somit "Global" zu machen und auf beiden Seiten genutzt werden kann
 */
var l_validierung = {


    // Eine Funktion die in den Vorlagen und Details Seite Nötig ist
    initLaufzeitValidierung() {

        // Custom Validation
        var fields = {
            laufzeit: {
                validators: {
                    callback: {
                        message: "Feld muss gefüllt sein!",
                        callback: function (input) {

                            // console.log(input);


                        },
                    },
                },
            },
            verlaengerung_laufzeit: {
                validators: {
                    callback: {
                        message: "Verlängerung Laufzeit darf nicht größer als Vertragslaufzeit sein!",
                        callback: function (input) {

                            var laufzeit = $('input[name="laufzeit"]').val();
                            var verlaengerung_laufzeit = $('input[name="verlaengerung_laufzeit"]').val();

                            return (parseInt(laufzeit) > parseInt(verlaengerung_laufzeit));

                        },
                    },
                },
            },
            kuendigungsfrist_laufzeit: {
                validators: {
                    callback: {
                        message: "Kündigungs Laufzeit darf nicht größer als Vertragslaufzeit und Verlängerungslaufzeit sein!",
                        callback: function (input) {

                            var verlaengerung_laufzeit = $('input[name="verlaengerung_laufzeit"]').val();
                            var kuendigungsfrist_laufzeit = $('input[name="kuendigungsfrist_laufzeit"]').val();
                            var laufzeit = $('input[name="laufzeit"]').val();

                            parseInt(verlaengerung_laufzeit);
                            parseInt(kuendigungsfrist_laufzeit);
                            parseInt(laufzeit);

                            return (parseInt(verlaengerung_laufzeit) > parseInt(kuendigungsfrist_laufzeit));
                        },
                    },
                },
            },
            laufzeit_interval: {
                validators: {
                    callback: {
                        message: "",
                        callback: function (input) {

                            var laufzeit = $('input[name="laufzeit"]').val();

                            parseInt(laufzeit);

                            // Wenn Laufzeit Eingetrage wurde muss der Intervall (Tage, Monate, ...) auch gewählt werden 
                            if (laufzeit != null) {
                                return true;
                            } else {
                                return false;
                            }

                        },
                    },
                },
            },
            verlaengerung_laufzeit_interval: {
                validators: {
                    callback: {
                        message: "",
                        callback: function (input) {

                            var verlaengerung_laufzeit = $(
                                'input[name="verlaengerung_laufzeit"]').val();

                            // Wenn Laufzeit Eingetrage wurde muss der Intervall (Tage, Monate, ...) auch gewählt werden 
                            if (verlaengerung_laufzeit != null) {
                                return true;
                            } else {
                                return false;
                            }

                        },
                    },
                },
            },
            kuendigungsfrist_laufzeit_interval: {
                validators: {
                    callback: {
                        message: "",
                        callback: function (input) {

                            var kuendigungsfrist_laufzeit = $(
                                'input[name="kuendigungsfrist_laufzeit"]').val();

                            // Wenn Laufzeit Eingetrage wurde muss der Intervall (Tage, Monate, ...) auch gewählt werden 
                            if (kuendigungsfrist_laufzeit != null) {
                                return true;
                            } else {
                                return false;
                            }

                        },
                    },
                },
            },

        }

        return fields;

    }



}