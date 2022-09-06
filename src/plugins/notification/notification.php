<?php include('01_init.php');

$_page = [
    'title' => "<i class='fa-solid fa-bell'></i> Notification"
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

            <input type="hidden" name="sessionID" value="<?php echo $_SESSION['user']['id'] ?>">
        
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><i class="fa-solid fa-bell"></i> Notification</h4>
            
                    <h6 class="subtext">Hier finden Sie alle Benachrichtigungen zu ihrer eigenen Akquise bzw. die Sie abonniert haben.</h6>

                    <div id="pickliste-notification"></div>
            
            
                </div>
            </div>

        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        // Init Notification
        noti.init();

    });
</script>
</html>