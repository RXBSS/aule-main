
const fs = require('fs');
const cp = require('child_process');


// Argumente
var args = process.argv;

// Hier sind alle Befehle
var pAule = {

    publish: function(arg) {

        if(arg[3]) {

            console.log('Update auf System >' + arg[3] + '< durchführen!');

        } else {
            console.log('Bitte geben Sie das System an, dass Sie aktualisieren wollen!');
        }
    },


    framework: {

        version: function() {
            console.log('Aktuell ist die Version xxx installiert');
        },

        update: function() {

            console.log('Starte Orthor Update');

            var path = './orthor';

            try {
                var version = fs.readFileSync(path + '/dist/VERSION_ORTHOR').toString();
            } catch(ex) {
                console.log('Version File nicht gefunden!');
            }

            console.log('Aktuelle Version >' + version + '<');
            console.log('Starte Github Pull');

            // Git Clonen
            // cp.execSync('cd ./orthor');
            cp.execSync('orthorupdate.cmd');
            // cp.execSync('cd..');

            var newVersion = fs.readFileSync(path + '/dist/VERSION_ORTHOR').toString();

            if(version == newVersion) {

                console.log('Es wurde kein Update durchgeführt');
            
            } else {
                
                // Mergen der VSCode Datei
                pAule.framework.mergeSnippets();
                
                // Composer Datei aktualisieren
                pAule.framework.composer();
                

                console.log('Neue Version >' + version + '<');
            }

            console.log('Fertig');

            

            

        },

        // Mergen der Snippets
        mergeSnippets: function() {

            console.log('Hier werden die VSCode Snippets geprüft');

            // Aule Snippets einlesen
            var auleSnippet = fs.readFileSync('./.vscode/javascript.json.code-snippets').toString();

            // Aule geparst
            var auleParse = JSON.parse(auleSnippet);

            // Orthor Snippets einlesen
            var orthorSnippet = fs.readFileSync('./orthor/.vscode/javascript.json.code-snippets').toString();

            // Orthor geparst
            var orthorParse = JSON.parse(orthorSnippet);

            //durch die JSON loopen
            for(item in orthorParse){
                if(orthorParse != auleParse){
                    auleParse[item] = orthorParse[item];

                    // neues Snippet wird wieder in die richtige Stelle geschrieben
                    fs.writeFileSync('./.vscode/javascript.json.code-snippets', JSON.stringify(auleParse, null, 4), 'utf8');
                
                    
                }
            }

            console.log("Aule Snippet wurde aktualisiert!");
        },

        composer: function() {
            
            console.log('Hier werden die Composer Plugins geprüft');

            // die Datei composer.json von Aule bekommen
            var auleComposer = fs.readFileSync('composer.json').toString();

            // composer.json von Aule Parsen
            var auleComposerParser = JSON.parse(auleComposer);

            // die Datei composer.json von Orthor bekommen
            var orthorComposer = fs.readFileSync('./orthor/composer.json').toString();

            // composer.json von Orthor Parsen
            var orthorComposerParser = JSON.parse(orthorComposer);

            //durch die JSON loopen
            for(item in orthorComposerParser){
                if(orthorComposerParser != auleComposerParser){
                    auleComposerParser[item] = orthorComposerParser[item];

                    // neues Snippet wird wieder in die richtige Stelle geschrieben
                    fs.writeFileSync('composer.json', JSON.stringify(auleComposerParser, null, 4), 'utf8');
                
                }
            }

            console.log("Aule Composer wurde aktualisiert!");
        }
    },


    doc: function(arg) {

        console.log('Dokumentation wird erstellt!');

    }


}








/**
 * 3. Input in Funktion übergeben
 */
 if (pAule[args[2]]) {
    if (pAule[args[2]][args[3]]) {
        pAule[args[2]][args[3]](args);
    } else {

        if (typeof pAule[args[2]] == 'function') {
            pAule[args[2]](args);
        } else {
            console.log('Zu wenig oder falscher Parameter angegeben');
            console.log('Probiere "aule help"');
        }
    }
} else {
    console.log('Diese Funktion gibt es nicht!');
    console.log('Probiere "aule help"');
}