<?php include('01_init.php');

$_page = [
    'title' => "<i class='fa-solid fa-car'></i> Inventar"
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
                    <h6 class="card-title"><i class="fa-solid fa-car"></i> Inventar</h6>
            
                    <div id="inventar-pickliste"></div>
            
            
                </div>
            </div>
        </div>
    </div>


    <!-- Fab Button -->
    <div class="fab-container">
         <button class="btn btn-primary btn-inventar-add"><i class="fa-solid fa-plus"></i></button>
    </div>


    <?php include('./inventar-modal.php') ?>
    <?php include('./inventar-verleih-modal.php') ?>
    
</body>

<?php include('04_scripts.php'); ?>
<script src="../js/pagelevel/inventar-a.js"></script>

<script>
    $(document).on('app:ready', function() {

        Object.assign(i, i_both);

        i.init();


    });
</script>
</html>