class ArtikelHistorySidebar extends HistorySidebar {

    // Daten übergeben
    render(template, data) {

        console.log(data);

        // Switch Statment
        switch (data.identifier) {

            // Erstellen
            case "create":
                template.icon = "fa-solid fa-plus";
                template.content = "Hat einen Neuen Auftrag als Entwurf erstellt";
                break;

            // Erstellen
            case "process":
                template.icon = "fa-solid fa-cog";
                template.content = "Hat aus einem Entwurf einen fertigen Auftrag erstellt";
                break;


            // Erstellen
            case "neue_lieferung":
                template.icon = "fa-solid fa-shipping-fast";
                template.content = "Hat eine neue Lieferung mit der ID <strong>" + data.referenz_id2 + "</strong> erstellt";
                break;


            // Erstellen
            case "status_beliefert":
                template.icon = "fa-solid fa-check";
                template.content = "Der Auftrag ist jetzt vollständig beliefert und kann berechnet werden";
                break;


            default:
                template.icon = "fa-solid fa-info-circle";
                template.content = "<em>Für dieses Event wurde noch kein Text festgelegt</em>";
                break;
        }

        // Daten zurückgeben
        return template;
    }
}
