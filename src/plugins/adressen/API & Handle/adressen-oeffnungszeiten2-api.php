<?php



class Oeffnungszeiten {

    public $table = "adressen_oeffnungszeiten";



    function doesExist($adressId) {

        $req = new Request();

        // Abfrage ob es irgendwas gibt
        $req->getMultiQuery("SELECT id FROM `" . $this->table . "` WHERE `adressen_id` = '" . $adressId . "'");

        // Gibt true oder false zurück, je nach dem ob für diese Adresse schon Daten existieren
        return $req->success;
    }


    // 
    function writeToDatabase($adressId, $data) {

        // 
        $req = new Request();

        // Default
        $array = [false, false, false, false, false, false, false];
        $arrayDay = ['mo', 'di', 'mi', 'do', 'fr', 'sa', 'so'];

        // 
        foreach ($array as $day => $value) {

            // Richtiger Tag
            $richtigerTag = $day + 1;

            if ($data['tag']['value'] == $richtigerTag || $data[$arrayDay[$day]]['checked'] == 'true') {
                if ($data['offen']['checked'] == 'true') {
                    $array[$day] = [
                        'von1' => $data['von1'],
                        'bis1' => $data['bis1']
                    ];

                    if ($data['von2']) {
                        $array[$day]['von2'] = $data['von2'];
                    }

                    if ($data['bis2']) {
                        $array[$day]['bis2'] = $data['bis2'];
                    }
                } else {
                    $array[$day] = 0;
                }
            }
        }


        // Insert or Update
        $exists = $this->doesExist($adressId);


        // Process Array
        $process = [
            ['t', 'adressen_id'],
            ['t', 'tag'],
            ['t', 'offen'],
            ['t', 'von1'],
            ['t', 'bis1'],
            ['t', 'von2'],
            ['t', 'bis2']
        ];



        foreach ($array as $day => $value) {

            $data = [
                'adressen_id' => $adressId,
                'tag' => $day + 1,
                'offen' => ($value === false || $value === 0) ? 0 : 1,
                'von1' => ($value === 0 || !isset($value['von1'])) ? false : $value['von1'],
                'bis1' => ($value === 0 || !isset($value['bis1'])) ? false : $value['bis1'],
                'von2' => ($value === 0 || !isset($value['von2'])) ? false : $value['von2'],
                'bis2' => ($value === 0 || !isset($value['bis2'])) ? false : $value['bis2']
            ];


            // SubRequest
            $subRequest = new Request($data);

            // Wenn bereits existiert
            if ($exists) {

                // Prüfen ob der Tag ausgewählt wurde
                if($value !== false) {
                    $subRequest->update($this->table, $process, "WHERE `adressen_id` = '" . $adressId . "' AND `tag` = '" . ($day + 1) . "'");
                }

            // Wenn noch nicht existiert immer schreiben
            } else {
                $subRequest->insert($this->table, $process);
            }
        }
        

        $req->success = true;


        return $req->answer();
    }


    public function getDayData() {

    }

    // Neu erstellen
    public function new($data, $id) {

        global $db;
        $success = $error = false;

        $array = [
            1 => false,
            2 => false,
            3 => false,
            4 => false, 
            5 => false,
            6 => false, 
            7 => false
        ];

        // Schreibt an den Richtigen Tag die Richtigen Values von dem oben definierten Array
        foreach($data AS $key => $value) {

            $tag = $value['open']['day'];

            if($tag == 0) {

                foreach($array as $key => $valueData) {
                   
                    $array[$key] = [
                        'offen' => 1, 
                        'von1' => $value['open']['time']."00",
                        'bis1' => "235959"
                    ];
                }
               
            } else if($array[$tag] === false) {

               
                $array[$tag] = [
                    'offen' => 1, 
                    'von1' => $value['open']['time']."00", 
                    'bis1' => $value['close']['time']."00"
                ];
            } else if(!isset($array[$tag]['von2'])) {
                
                $array[$tag]['von2'] = $value['open']['time']."00";
                $array[$tag]['bis2'] = $value['close']['time']."00";
            }

        }

        $querys = [];
        $querysWhere = [];

        // Stellt für jedes Neues Oeffnugnszeiten eine Query her
        foreach($array AS $key => $value) {

            if($value) {
                $querys[] = 
                "`adressen_id` = ".$id.", `tag` = ".$key.", `offen` = 1, `von1` = '".$value['von1']."', `bis1` = '".$value['bis1']."', `von2` =  ".((isset($value['von2'])) ? $value['von2'] : "NULL").", `bis2` = ".((isset($value['bis2'])) ? $value['bis2'] : "NULL")."";
            } else {
                $querys[] = "`adressen_id` = ".$id.", `tag` = ".$key.", `offen` = 0, `von1` = NULL, `bis1` = NULL, `von2` = NULL, `bis2` = NULL";
            }

            $querysWhere[] = "WHERE `adressen_id` = ".$id." AND `tag` = ".($key) ? $key : NULL." ";

        }

        // gibt es schon einträge
        $hasOeffnungszeiten = $this->hasOeffnungszeiten($id);

        // Entscheidet ob Insert oder Update
        $queryHead = (!$hasOeffnungszeiten) ? "INSERT INTO `".$this->table."` SET" : "UPDATE `".$this->table."` SET";

        $req = new Request($data);

        foreach($querys AS $key => $query) {

            if($db->query($queryHead." ".$query." ".((!$hasOeffnungszeiten) ? "" : $querysWhere[$key]).";") ) {
                $id = $db->insert_id;

                $success = true;
    
            } else {
                $error = $db->error;
            }
        }

        return [
            'success' => $success,
            'error' => $error,
            'id' => $id
        ];
        
    }

    public function hasOeffnungszeiten($address_id) {

        global $db;
        $data = false;
        
        $query = "SELECT * FROM `".$this->table."` WHERE `adressen_id` = '".$address_id."'";
        $result = $db->query($query);
        if($result->num_rows > 0) {
            // $data = $result->fetch_assoc();

            return true;
        } else {
            return false;
        }
    }

    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $id = (is_array($id)) ? $id : [$id];

        // DELETE FROM adressen_oeffnungszeiten where adressen_id = 12;
        

        $query = "DELETE FROM `".$this->table."` WHERE `adressen_id` IN ('".implode("','",$id)."');";

        // echo "<pre>";
        // print_r($query);
        // echo "</pre>";
        // die();

        if($db->query($query)) {
            $success = true;

        } else {
            $error = $db->error;
        }

        return [
            'success' => $success,
            'error' => $error
        ];
    }
}
