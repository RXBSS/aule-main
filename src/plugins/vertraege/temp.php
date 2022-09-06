<?php include('01_init.php');

$_page = [
    'title' => "Hello"
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">

            
            <?php
            
                // $preview = new Vertraege();

                // $result = $preview->createAbrechnung(1);

            //     $currentDate = new DateTime();

            //     echo "<pre>";
            //     // print_r();
            //     echo "<br>";

            //     print_r(date("d.m.Y H:i:s"));
            //     echo "<br>";

            //     print_r(date("d.m.Y H:i:s"));
            //     echo "</pre>";
               
            //    die();

                // $posApi = new VertraegePos();
                // $resultPos = $posApi->getSumPauschalPos(7);

                // echo "<pre>";
                // print_r($resultPos);
                // echo "</pre>";
                // die();
                
                // $pauschale = 0;

                // foreach($resultPos['data'] as $value) {

                //     $pauschale = intval($value['pauschale']);

                //    echo "<pre>";
                //    print_r($value['pauschale']);
                //    echo "</pre>";

                //    if($value['pauschale'] > 0) {

                //         $value['pauschale']

                //    }

                    

                // }

                // return $pauschale;


                
            


            ?>

                <div class="form-group form-floating-check">
                    <label class="form-label">Checkbox</label>
                    <div class="form-check form-switch">
                        <input type="checkbox" class="form-check-input editable" id="example-1" name="example-1" value="1" />
                        <label class="form-check-label" for="example-1">Wert</label>
                    </div>
                </div>

                <div id="div-checked-1" class="border mt-3">
                    <i class="fa-solid fa-check text-success"></i> Ich werde nur einblendet wenn die Checkbox angehakt ist
                </div>

            
            

        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        // Do Something

        var cb1 = new ActivationCheckbox('#example-1', '#div-checked-1');


        cb1.on('callback', function (el, isChecked, isInit) {

            console.log(isChecked);
            console.log(el);

            if (isChecked) {
                
                // console.log("SDFSFSD");

                // me.loadZaehler();
            }
        });


    });
</script>
</html>