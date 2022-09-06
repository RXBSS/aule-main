<?php

/**
 * Proxy API
 * 
 * Dient zum Schutz der Daten durch den Proxy
 * 
 */
class Proxy {

    public $salt = "8rtqh";
    public $pepper = "Dirn2S";

    // Kodieren
    public function encode($link) {

        // Die Eingabe base 64 Encoden
        $mainEncode = base64_encode($link);

        // Salt Pepper und HR Time hinzufügen
        $saltAndPepper = $this->salt . $mainEncode . $this->pepper;

        // Den String zu einem Array aufsplitten
        $array = str_split($saltAndPepper);

        // Neues Array anlegen
        $decodeArray = [];

        // 
        $i = 1;

        // Eine Schliefe bauen, die bei jedem Zweiten Wert einen Random Buchstaben einfügt
        foreach ($array as $value) {

            // Buchstabe hinzufügen
            $decodeArray[] = $value;

            // Bei jedem zweiten Wert einen weiteren Buchstaben hinzufügen
            if ($i == 1) {
                $decodeArray[] = $this->getRandom(1);
            } else {
                $i++;
            }
        }

        // URL Encoden
        $encoded = urlencode(base64_encode(implode("",$decodeArray)));

        // Zurückgeben
        return $encoded;
    }




    // Decode
    public function decode($link) {

        $decodedArray = str_split(base64_decode(urldecode($link)));

        // Neues Cleanes Array erstellen
        $cleanArray = [];

        $i = 1;

        // Jeden zweiten Wert entfernen
        foreach ($decodedArray as $value) {

            if ($i == 1) {
                $cleanArray[] = $value;
                $i = 0;
            } else {
                $i++;
            }
        }

        // Cleanes Array
        $saltAndPepper = implode("", $cleanArray);

        // Salt and Pepper entfernen
        $encoded = substr(substr($saltAndPepper, strlen($this->salt)) , 0, - (strlen($this->pepper)));  

        // Base 64 decodieren
        $link = base64_decode($encoded);

        return $link;
    }

    function getRandom($l = 1) {
        return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $l);
    }
}
