<?php include('01_init.php');

$_page = [
    'title' => "Tickets"
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

            <div id="tickets-pickliste"></div>

        </div>
    </div>

    <!-- Modal new Ticket -->
    <?php include('./ticket-modal.php') ?>

    <!-- FAB-->
    <div class="fab-container">
        <button class="btn btn-primary" id="btn-neues-ticket"><i class="fa-solid fa-plus"></i></button>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        tickets.init();
    });
</script>

</html>