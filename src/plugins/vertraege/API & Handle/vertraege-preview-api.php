<?php

class VertragPreview {


    public function getKlauselnInHTML($id) {


        $api = new Vertraege();
        $result = $api->getKlauselnWithGroups(2);


        // echo "<pre>";
        // print_r($result['data']);
        // echo "</pre>";

        


    //     $req = new Request();

    //     // Query
    //     $query = "
        
    //         SELECT vkv.*, va.*, vk.*, vg.id as vertraegeGruppenId, vg.reihenfolge as reihenfolgePara, vg.paragraph as paragraph
    //         FROM `vertraege_klauseln_vertraege` vkv

    //         LEFT JOIN vertraege_vorlagen va ON va.id = vkv.vorlagen_id
    //         LEFT JOIN vertraege_klauseln vk ON vk.id = vkv.klausel_id
    //         LEFT JOIN vertraege_gruppen vg ON vg.id = vk.vertraegegruppen_id

    //         WHERE vkv.vertraege_id = '" . $id . "' AND vkv.geloescht = 0
    //         ORDER BY reihenfolgePara asc;

    //     ";
    
    //     echo $query;


    //     // Query Abfrage
    //     $req->getMultiQuery($query, true);

    //     // Objekt legt alle Gruppen zusammen jede Klausel zu einer Klausel zuordnen
    //     $gruppen = [];

    //     // Counter
    //     $counter = 1;
        
    //     // HTML DOM Element was zurück geht
    //     $html = "<div></div>";

    //     // Schleife geht durch alle Ergebnisse
    //     foreach($req->result as $key => $value) {


    //         if ($key >= 1) {

    //             if ($value['paragraph'] == $req->result[$key - 1]['paragraph']) { 


    //                 $html .= " <li>".$value['text']."</li>";

    //                 // echo "<pre>";
    //                 // print_r($value['text']);
    //                 // echo "</pre>";
    //             }

    //             else {
    //                 $html .= "<ul>§ ". $counter ." ".  $value['paragraph'] . " <li>". $value['text'] . "</li> </ul>";
                    
    //                 $counter++;

    //                 // print_r($value['paragraph']." ".$value['text']);
    //             }
            
    //         } else {

    //             $html .= "<ul>§ ". $counter ." ".  $value['paragraph'] . " <li>". $value['text'] . "</li> </ul>";

    //             $counter++;

    //             // print_r($value['paragraph']." ".$value['text']);
    //         }
    //     }

    //     echo "<pre>";
    //     print_r($html);
    //     echo "</pre>";

        

    //     // Schleife geht alle Gruppen Durch und Printet die
    //     foreach($gruppen as $key => $value) {

    //         $html .= "<div>§ ".$counter ." ". $value ."</div>";

            

    //     }


    //     // Neue req
    //     $req2 = new Request();

    //     $query2 = "
    //         SELECT * 
    //         FROM vertraege_gruppen;
    //     ";

    //     // Holt Alle Gruppen
    //     $req2->getMultiQuery($query2, true);

    //     // Schleife geht durch alle Ergebnisse Durch
    //     foreach($req2->result as $key => $value) {

    //         foreach($gruppen as $key2 => $value2) {


    //             // if($value['paragrap'])

               


    //         //    echo "<pre>";
    //         //    print_r($value);
    //         //    echo "</pre>";

    //         //    echo "<hr>";

    //         //    echo "<pre>";
    //         //    print_r($value2);
    //         //    echo "</pre>";

    //         }

    //     }


    // //     echo "<pre>";
    // //     print_r($req);
    // //     echo "</pre>";
    // //     die();


    // //    echo "<pre>";
    // //    print_r($html);
    // //    echo "</pre>";


      

    //     // Rückgab
    //     return $req->answer();


    }


}












?>