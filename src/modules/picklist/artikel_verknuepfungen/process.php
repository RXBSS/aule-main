<?php include('./../../../01_init.php');



// Eigene Klasse erstellen
class DtArtikelBez extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {

        // Prüfen, ob es notwendig ist, die bestimmung durchzuführen
        if (in_array($key, ['artikel_id', 'artikel_bezeichnung', 'hersteller_bezeichnung', 'icon', 'art', 'gehezu'])) {

            // Wenn ja
            $result = $this->getMain($row);

            // Prüfen ob eine der Nummern dazu gehört
            if ($result) {


                // Status
                $status = [
                    '1a' => [
                        'status' => 'Nachfolger',
                        'icon' => '<i class="fa-solid fa-arrow-right text-success"></i>'
                    ],
                    '1b' => [
                        'status' => 'Vorgänger',
                        'icon' => '<i class="fa-solid fa-arrow-left text-danger"></i>'
                    ],
                    '2' => [
                        'status' => 'Alternativ',
                        'icon' => '<i class="fa-solid fa-clone"></i>'
                    ]
                ];

                
                if ($key == 'artikel_id') {
                    $default = $result['id'];
                } else if ($key == 'artikel_bezeichnung') {
                    $default = $result['bezeichnung'];
                } else if ($key == 'hersteller_bezeichnung') {
                    $default = $result['hersteller'];
                } else if ($key == 'icon') {
                    $default = $status[$result['art']]['icon'];
                } else if ($key == 'art') {
                    $default = $status[$result['art']]['status'];
                } else if ($key == 'gehezu') {
                    $default = '<a href="artikel-details?id=' . $result['id'] . '"><i class="fa-solid fa-up-right-from-square"></i></a>';
                }
            }
        }


        return $default;
    }

    // 
    function getMain($row) {

        $result = false;

        if ($row['_artikel_id1'] == $this->request['additional']) {
            $result = [
                'id' => $row['_artikel_id2'],
                'hersteller' => $row['_hersteller_bezeichnung2'],
                'bezeichnung' => $row['_artikel_bezeichnung2'],
                'art' => ($row['_art_id'] == 1) ? "1a" : $row['_art_id']
            ];
        } else if ($row['_artikel_id2'] == $this->request['additional']) {
            $result = [
                'id' => $row['_artikel_id1'],
                'hersteller' => $row['_hersteller_bezeichnung1'],
                'bezeichnung' => $row['_artikel_bezeichnung1'],
                'art' => ($row['_art_id'] == 1) ? "1b" : $row['_art_id']
            ];
        }

        return $result;
    }
}


// Get Variable übergeben
$dt = new DtArtikelBez($_GET, "artikel_verknuepfungen");

$dt->fixedFilter = "`artikel_verknuepfungen`.`artikel_id1` = '" . $dt->request['additional'] . "' OR `artikel_verknuepfungen`.`artikel_id2` = '" . $dt->request['additional'] . "'";

// Verarbeiten
$dt->process();

// Output
$dt->output();
