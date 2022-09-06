<?php include('01_init.php');

$_page = [
    'title' => "Details Dokumentation"
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>

    <style>
        pre {
            background: #333;
            color: #fff;
            padding: 5px;
            border-radius: 2px;
        }
    </style>


</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-book"></i> Dokumentation zur Erstellung einer Detail-Seite</h4>
                    <h6 class="subtext">Hier werden alle Bereiche und Standard-Funktionen beschrieben, die zur Erstellung einer Details Seite genutzt werden. </h6>

                    <p>
                        <strong>Vorwort</strong><br>
                        Natürlich kann jede Detail-Seite individuell erstellt werden. Es gibt aber ein paar Dinge, die immer wiederkehren.
                        Da es das bestreben eines jeden Programmieres ist, so wenig Code wie möglich doppelt zu schreiben, habe ich aus den Erfahrungen beim bauen der ersten
                        Detail-Seiten Grundlagen-Funktionen extrahiert und in einer Funktions-Sammlung zur Verfügung gestellt. Mancher Code sollte aber explizit doppelt
                        geschrieben werden um so flexibel wie möglich zu sein. Dafür kann man dann hier zur Verfügung gestellt Vorlagen verwenden.
                    </p>


                    <hr>

                    <strong>Dateistruktur</strong>

                    <p>
                        Die Dateisturktur eines sieht wie folgt aus und wird aus dem Konzept von Orthor vorgegeben.
                    </p>

                    <br>

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th class="col-2">auftraege.php</th>
                                <td class="col-9">Die Hauptseite, die dann auch aufgerufen wird</td>
                            </tr>
                            <tr>
                                <th>auftraege.js</th>
                                <td>
                                    Hier wird die komplette JavaScript-Logik untergebracht. In der Regel ist das für die Hauptseite
                                    anzeigen der Pickliste, sowie das Neu erstellen, Bearbeiten und Löschen
                                </td>
                            </tr>
                            <tr>
                                <th>auftraege.css</th>
                                <td>Falls es nur speziell für die Unterseite CSS Code gibt. Die Datei existiert meistens nicht.</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr class="m-0">
                                </td>
                            </tr>
                            <tr>
                                <th>auftrag-details.php</th>
                                <td>
                                    Die Unterseite, die bei der Auswahl immer aufgerufen wird. Hierbei sollte als <code>$_GET</code> Parameter immer
                                    die eindeutige Identifikation mitgegeben werden: z.B.: <code>auftrag-details.php?id=xxx</code>
                                </td>
                            </tr>
                            <tr>
                                <th>auftrag-details.js</th>
                                <td>
                                    Hier wird die komplette JavaScript-Logik für die Detail-Seite untergebracht.
                                    Da in einer Detail-Seite realtiv viel passieren kann, wird diese Datei manchmal erweitert. Siehe dazu weiter unten.
                                </td>
                            </tr>
                            <tr>
                                <th>auftrag-details.css</th>
                                <td>Falls es nur speziell für die Unterseite CSS Code gibt. Die Datei existiert meistens nicht</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr class="m-0">
                                </td>
                            </tr>
                            <tr>
                                <th>auftrag-api.php</th>
                                <td>
                                    Die API ist in der Regel das Herzstück. Sie besteht rein aus PHP Code und sollte so angelegt werden, dass Sie
                                    unabhängig von jeglicher GUI ist. So kann man diese auch in anderen Bereichen oder zum Beispiel aus anderen APIs heraus nutzen.
                                    Die API ist immer eine PHP Klasse. Die API wird niemals direkt von der Unterseite bzw. dem Ajax-Call angesprochen.
                                </td>
                            </tr>
                            <tr>
                                <th>auftrag-handle.php</th>
                                <td>
                                    Die Handle Datei ist eine Datei die zwischen die API und die eigentliche Unterseite geschaltet ist.
                                    Sie soll die Eingaben übernehmen und die Kommunikation regeln.
                                </td>
                            </tr>
                        </tbody>
                    </table>


                    <hr>

                    <strong>Ablauf</strong>


                    <div class="row">
                        <div class="col-6">
                            <p>
                                Mit Hilfe von Orthor kann man sich die Dateien ganz einfach erstellen lassen. Dazu einach <code>orthor template plugin --name=mein-name</code>.
                                Anschließend kann man mit <code>orthor template pickliste --name=mein-name</code> eine entsprechende Pickliste erstellen.
                            </p>
                            <p>
                                Nun richtet man die Pickliste auf der Unterseite ein. Hierbei ist vieles Standard und Bedarf eigentlich keiner weiteren Erklärung. Die Seite `example.php`
                                kann hier als Vorlage genommen werden.
                            </p>
                            <p>
                                Die Unterseite der Details hingegen kann schnell etwas umfangreicher werden und hier gibt es verschiedene Konzepte, die ich im folgenden
                                gerne erläutern würde.
                            </p>
                        </div>
                        <div class="col-6">
                            <pre>1. <code>orthor template plugin --name=pluginname</code>
2. <code>orthor template pickliste --name=pluginname</code></pre>
                        </div>
                    </div>

                    <hr>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <strong>SQL-Dateien</strong><br>
                            <em>Hier folgt noch eine genauere Erklärung zum Thema SQL. Da dies aber bereits genutzt wird, hat diese Erklärung nicht die höchste Priorität</em>

                        </div>
                    </div>
                    <br>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <strong>JavaScript Struktur</strong><br>
                            Es ist sinnvoll die JavaScript Dateien in mehrere Dateien aufzuteilen. Meinstens gibt es auf der Positionsseite verschiedene Bereiche.
                            Für jeden dieser Bereiche kann man dann eine eigenen Funktion bauen. <br>

                            <br>
                            <em>Beispiel:</em><br>
                            example-details.js = Hauptdatei<br>
                            example-details-form.js = Unter Datei für alles was Form angeht<br>
                            example-details-positionen.js = Unter Datei für alles was Positionen angeht<br>
                            ...<br>
                            <br>
                            Dabei muss man darauf achten, dass die Unter-Dateien nicht automatisch mit auf der Seite eingebunden werden.
                            Diese muss man im Skript mit hinzufügen. Dies muss vor den Skripten passieren.<br>


                        </div>
                        <div class="col-6">
                            Einbinden der Dateien, die nicht im Page Level sind
                            <pre><code>...
&lt;!-- Alle Details--&gt;
&lt;script src=&quot;js/pagelevel/example-details-form.js&quot;&gt;&lt;/script&gt;
&lt;script src=&quot;js/pagelevel/example-details-positionen.js&quot;&gt;&lt;/script&gt;

&lt;?php include(&#39;04_scripts.php&#39;); ?&gt;
...
</code></pre>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-6">
                            Die JavaScript Dateien sollten aus Objekten bestehen, die mit einer eindeutigen Bezeichnung versehen sind.
                            Auf der rechten Seite sieht man wie sich eine solche Struktur dann zusammen setzt.<br>
                            <br>
                            Die Zusammensetzung erfolgt mit <code>Object.assign</code>. So hat man später nur ein Objekt das man aufrufen und initalisieren muss/kann.
                            Der Vorteil ist, dass man nun über <code>this;</code> bzw. <code>var me = this;</code> einfach auf Unterfunktionen zugreifen kann.<br>
                            <br>
                            Dabei ist wichtig zu wissen, dass sich die Funktionen überschreiben, wenn Sie den gleichen Namen haben. Das muss beachtet werden, kann aber auch
                            enorme Vorteile bieten. Dies zeigt zum Beispiel die Klasse <strong>detailHelper</strong>. Dort ist eine Sammlung an Unterfunktionen eingebracht,
                            die man dann nach belieben überschrieben kann oder sogar muss (siehe weiter unten).
                        </div>
                        <div class="col-6">
                            <nav>
                                <div class="nav nav-tabs" id="tab-nav-example-blank">
                                    <button class="nav-link active" id="tab-nav-example-blank-1" data-bs-toggle="tab" data-bs-target="#tab-content-example-blank-1" type="button">...details.php</button>
                                    <button class="nav-link" id="tab-nav-example-blank-2" data-bs-toggle="tab" data-bs-target="#tab-content-example-blank-2" type="button">...details.js</button>
                                    <button class="nav-link" id="tab-nav-example-blank-3" data-bs-toggle="tab" data-bs-target="#tab-content-example-blank-3" type="button">...details-form.js</button>
                                    <button class="nav-link" id="tab-nav-example-blank-4" data-bs-toggle="tab" data-bs-target="#tab-content-example-blank-4" type="button">...details-position.js</button>
                                </div>
                            </nav>
                            <br>
                            <div class="tab-content" id="tab-content-example-blank">
                                <div class="tab-pane show active" id="tab-content-example-blank-1">
                                    <pre><code>// Detail Helper hinzufügen
ex = Object.assign(ex, detailHelper);

// Andere JavaScript Klassen hinzufügen
ex = Object.assign(ex, exForm);
ex = Object.assign(ex, exPos);

// Initalisieren
ex.init();</code></pre>
                                </div>
                                <div class="tab-pane" id="tab-content-example-blank-2">
                                    <pre><code><?php echo file_get_contents("js/pagelevel/example-details-blank.js"); ?></code></pre>
                                </div>
                                <div class="tab-pane" id="tab-content-example-blank-3">
                                    <pre><code><?php echo file_get_contents("js/pagelevel/example-details-form-blank.js"); ?></code></pre>
                                </div>
                                <div class="tab-pane" id="tab-content-example-blank-4">
                                    <pre><code><?php echo file_get_contents("js/pagelevel/example-details-position-blank.js"); ?></code></pre>
                                </div>
                            </div>



                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <strong>Daten / Initalisieren</strong><br>
                            Das erste was passieren muss, ist das die Daten aus der Datenbank abgerufen werden.
                            Mit der ID
                        </div>
                        <div class="col-6">
                            
                        </div>
                    </div>


                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <strong>Status</strong><br>
                            Viele Unterseiten können einen Status haben. Ein Auftrag kann Beispielsweise ein Entwurf, Produktiv, Gesperrt, ... usw. sein.
                            Je nachdem welchen Status eine Unterseite hat, sollen Funktionen erscheinen, Dinge angezeigt werden, etc. <br>
                            Das wichtigeste ist, dass der Status unter <code>me.status</code> immer abgespeichert wird. So kann man über einfache <code>if-Abfragen</code>
                            entsprechend entscheiden. 
                            Mit Hilfe der <code>data-status</code> Felder kann man einfach bestimmen, ob ein HTML Objekt ein- oder ausbelndet sein soll.
                        </div>
                        <div class="col-6">
                            <pre><code>// Status sollte immer nummerisch sein und sich auf die Datenbank beziehen
me.status = 1;</code></pre>
<br>
<pre><code>&lt;div data-status=&quot;1&quot;&gt;
    Ich werde bei Status 1 angezeigt
&lt;/div&gt;
&lt;div data-status=&quot;2&quot;&gt;
    Ich werde bei Status 2 angezeigt
&lt;/div&gt;</code></pre>
                        </div>
                    </div>





                </div>
            </div>

        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        // Do Something
    });
</script>

</html>