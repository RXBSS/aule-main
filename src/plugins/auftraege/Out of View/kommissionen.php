<?php include('01_init.php');

$_page = [
    'title' => "Kommissionen"
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



            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fa-solid fa-box"></i> Liste der offenen Aufträge</h4>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-floating-check">
                                <label class="form-label">Teillieferungen</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" id="teillieferungen" name="teillieferungen" value="1" />
                                    <label class="form-check-label" for="teillieferungen">Teillierungen ebenfalls anzeigen</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group form-floating">
                                <select class="form-select init-select2 editable" name="kostenstellen" placeholder="Kostenstellen">
                                    <option value="">bitte wählen</option>
                                </select>
                                <label>Kostenstellen</label>
                            </div>
                        </div>
                    </div>


                    <br>
                    <br>




                    <?php

                    $query = "SELECT * `` ";




                    ?>




                    <button class="btn btn-primary">Jetzt kommissionieren</button>

                </div>
            </div>





            <!--
            
            -->



            <?php






            ?>




        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script type="text/javascript" src="http://unpkg.com/@zxing/library@latest/umd/index.min.js"></script>
<script type="text/javascript">
    window.addEventListener('load', function() {
        let selectedDeviceId;


        /*

        const codeReader = new ZXing.BrowserMultiFormatReader();
    
        // 
       

             */
    })
</script>

</html>