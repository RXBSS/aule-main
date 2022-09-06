<?php include('includes/04_scripts_orthor.php');


?>




<!-- Aule Scripts -->
<script src="js/aule.js"></script>


<script>


    // Only for Develop Purpose
    setTimeout(function() {
        checkForDuplicates();
    }, 3000);

    function checkForDuplicates() {
        $('[id]').each(function() {
            var id = $('[id="' + this.id + '"]');
            if (id.length > 1 && id[0] == this) {
                console.warn('[DOM] Duplicate id #' + this.id);
            }
        });
    }
</script>