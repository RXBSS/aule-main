<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-chart-area\"></i> Software Report",
    'breadcrumbs' => ['Stammdaten', '<a href="weitere-stammdaten">Weitere Stammdatan</a>', '<a href="software"><i class=\"fa-solid fa-code-branch\"></i> Software</a>']
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

            <h1></h1>

            <div class="alert alert-dark">
                <strong>ELO IX (Indexserver)</strong>
            </div>


            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-chart-pie"></i> Versionsstände</h4>
                            <h6 class="subtext">In diesem Graph sind die unterschiedlichen Versionsstände abgebildet</h6>

                            <canvas id="myChart" style="width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    - Arten im Umlauf (Produktiv, Beta, ...)<br>
                    - Gesperre Versionen<br>
                    - Prozentual Aktuell<br>
                    - Liste der Kunden?<br>
                    - Durchschnitt Releasezeit<br>
                </div>
            </div>







        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        const ctx = document.getElementById('myChart');

        const config = {
            type: 'pie',
            data: {
                labels: ["20.06.000.60", "20.05.000.66", "20.04.000.1446", "20.03.002.7", "20.02.000.685", "20.01.000.624"],
                datasets: [{
                    label: "Versionen",
                    backgroundColor: ["#1abc9c", "#f1c40f", "#3498db", "#e74c3c", "#9b59b6", "#2ecc71"],
                    data: [2478, 0, 5267, 734, 784, 433]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        };

        const myChart = new Chart(ctx, config);
    });
</script>

</html>