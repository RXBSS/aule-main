<?php include('01_init.php');

$_page = [
    'title' => "Neues Ticket"
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


            <div class="row">
                <div class="col-md-8">
                    <div class="summernote"></div>
                </div>
            </div>


        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {


        $('.summernote').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true,
            lang: 'de-DE',

            // Callbacks
            callbacks: {
                onPaste: function() {
                    app.notify.success.fire("Erfolgreich", "Erfolgreich reinkopiert");
                }
            }

        });
    });
</script>

</html>