<?php

class OeffnungszeitenGoogle {

public $table = "adressen_oeffnungszeiten";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {
        
        global $db;
        $data = false;
        $arr = [];

        $query = "SELECT * FROM `".$this->table."` WHERE `adressen_id` = '".$id."'";

        $result = $db->query($query);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        } else {
            $arr = [];
        }

        return [
            'data' => $arr,
            'result' => $result
        ];
    }

    // Neu erstellen
    public function newSingleTime($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

        // Wochen Array
        $array = [false, false, false, false, false, false, false];
        $arrayDay = ['mo', 'di', 'mi', 'do', 'fr', 'sa', 'so'];

        // Hier schreiben wir alle Tage rein, die verarbeitet werden sollen
        $toProcess = [];

        // 
        foreach($array AS $day => $value) {

            // Richtiger Tag
            $richtigerTag = $day + 1;

            // Bin ich einer der tage die Eintragen werden sollen!
            // Bin ich der Tag selbst?
            // Bin ich zusätzlich angehakt?
            if($data['tag']['value'] == $richtigerTag || $data[$arrayDay[$day]]['checked'] == 'true') {
                $toProcess[] = $richtigerTag;
            }
        } 
        
        if($data['offen']['checked'] === 'false') {
            $data['von1'] = false;
            $data['bis1'] = false;
            $data['von2'] = false;
            $data['bis2'] = false;
        }

        // der Montag ist ja der Tag der Grundsätzlich ausgewählt wurde
        // di und mi wurden über die unternen Checkboxen ausgewählt

        foreach($toProcess as $key => $dayValue) {

            $data['tag'] = $dayValue;

            $sub = new Request($data);

            $sub->checkDuplicateCombination('Dieser Tag ist bereits vergeben! Bitte nutzen Sie die Editier-Funktion!', $this->table, ['tag' => $data['tag'], 'adressen_id' =>  $data['id'] ], $data['id']);
            
            if(!$sub->error) {
                $process = [
                    ['t', 'id', 'adressen_id'],
                    ['t', 'tag'],
                    ['c', 'offen', 'offen', $data['offen']['value']],
                    ['dt', 'von1', 'von1',  ($data['von1']) ? $data['von1'] : NULL ],
                    ['dt', 'bis1', 'bis1',  ($data['bis1']) ? $data['bis1'] : NULL],
                    ['dt', 'von2', 'von2', ($data['von2']) ? $data['von2'] : NULL],
                    ['dt', 'bis2', 'bis2', ($data['bis2']) ? $data['bis2'] : NULL]
                ];

                $sub->insert($this->table, $process);
            }
        }

        // Antwort schreiben
        return $sub->answer();

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

    public function edit($id, $data) {

        global $db;
        $success = $error = false;

        if($data['offen']['checked'] === 'false') {
            $data['von1'] = false;
            $data['bis1'] = false;
            $data['von2'] = false;
            $data['bis2'] = false;
        }

        $req = new Request($data);

        $process = [
            ['s', 'tag', 'tag', $data['tag']['value']],
            ['c', 'offen', 'offen', $data['offen']['value']],
            ['dt', 'von1', 'von1',  ($data['von1']) ? $data['von1'] : NULL ],
            ['dt', 'bis1', 'bis1',  ($data['bis1']) ? $data['bis1'] : NULL],
            ['dt', 'von2', 'von2', ($data['von2']) ? $data['von2'] : NULL],
            ['dt', 'bis2', 'bis2', ($data['bis2']) ? $data['bis2'] : NULL]
        ];

        // Ergebnis
        $req->update($this->table, $process, 'WHERE `id` = '.$id.'');

        // Antwort schreiben
        return $req->answer();

    }

    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $id = (is_array($id)) ? $id : [$id];
        

        $query = "DELETE FROM `".$this->table."` WHERE `id` IN ('".implode("','",$id)."');";

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
?>