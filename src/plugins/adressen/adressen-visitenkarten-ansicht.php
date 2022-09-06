<?php

    function cardView($id) {
        
        // HERE DYNAMISCH DIE KARTEN
        // TODO: KANN WEG WIRD NICHT BENUTZT -- DEPRECATED

        // Alle Daten von Kontakte mit dieser id
        $kontakte = new Kontakte();
        $data_kontakte = $kontakte->getA($id);


        // TODO: Daten holen aber zusammenbauen in JS
        echo "<div class='row' id='adressen-kontakte-card'>";

        foreach ($data_kontakte as $value) {
            echo "<div class='col col-lg-6'>
                    <div class='card'>
                        <div class='card-body'>
                            <div class='row'>
                                <div class='col col-lg-3' style='height: 100px; border-radius:50%;'>
                                    
                                    <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSAkjktNk_waKZ6A064JikKQRYLxoKPNIUR_g&usqp=CAU' style='height: 100px; width:100px; border-radius:50%;'>
                                </div>
                                <div class='col col-lg-9'>
                                    <p>" . $value['vorname'] . ' ' . $value['nachname'] . " </p>
                                    <p>" . $value['email'] . "</p>
                                    <p>" . $value['telefon'] . "</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ";
        }

        echo "</div>";

    }

    

?>