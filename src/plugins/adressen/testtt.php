<?php include('01_init.php');

$_page = [
    'title' => "Template"
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid" >

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-icon"></i> Titel</h4>
            
                    <h6 class="subtext">Das ist der Subtext</h6>
            
                    
                        <div class="form-group form-floating-check">
                            <label class="form-label " >Checkbox Linebreak</label>
                            <!-- <a class="action-item btn-bankverbindung-add" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Hinzufügen Öffnungszeiten"><i class="fa-solid fa-plus"></i></a> -->

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input editable" id="tesssss" name="name" value="1" />
                                <label class="form-check-label label-info" for="id" >Wert</label>
                            </div>
                        </div>
                        <div id="test">
                            <div class="collapse collapse-horizontal" id="collapseWidthExample">
                                <div class="card card-body" style="width: 300px;">
                                This is some placeholder content for a horizontal collapse. It's hidden by default and shown when triggered.
                                </div>
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


        // $('#tesssss').hover(function() {

        //     console.log("TEST");
        //     $('#collapseWidthExample').slideToggle();
        // });

        $('#tesssss').hover(function () {
            $("#collapseWidthExample").slideDown();
        }, function(){
            $("#collapseWidthExample").slideUp();
        });
    });
</script>
</html>