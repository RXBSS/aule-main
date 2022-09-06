<?php

/**
 * ### Navigation
 * 
 * Die Navigation besteht aus mehreren Teilen: 
 * 
 * 1. Navbar 
 * 1.1 Logo -> Das Logo des Systems
 * 1.2 Page Title -> Seitentitel aus der Page Variable
 * 1.3 Actions -> Actions
 * 
 * 2. Breadcrumbs -> Navigation aus der Page Variable
 * 
 * 3. Sidebar
 * 3.1 User -> Leiste für den eingeloggten Benutzer
 * 3.2 Default Navigation -> Bringt eine Standard Funktion für ein ArrayToNav mit
 * 3.3 Version
 * 
 */
?>

<!-- 1. Navbar -->
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid justify-content-start align-items-center">


        <!-- 1.1 Logo -->
        <div id="navbar-banner" class="navbar-brand" style="min-width: 258px;">
            <div class="d-flex align-items-center">
                <div>

                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;" width="50px" height="50px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <defs>
                            <path id="path" d="M50 15A15 35 0 0 1 50 85A15 35 0 0 1 50 15" fill="none"></path>
                            <path id="patha" d="M0 0A15 35 0 0 1 0 70A15 35 0 0 1 0 0" fill="none"></path>
                        </defs>
                        <g transform="rotate(0 50 50)">
                            <use xlink:href="#path" stroke="#fff" stroke-width="3"></use>
                        </g>
                        <g transform="rotate(60 50 50)">
                            <use xlink:href="#path" stroke="#fff" stroke-width="3"></use>
                        </g>
                        <g transform="rotate(120 50 50)">
                            <use xlink:href="#path" stroke="#fff" stroke-width="3"></use>
                        </g>
                        <g transform="rotate(0 50 50)">
                            <circle cx="50" cy="15" r="9" fill="#7ab929">
                                <animateMotion dur="6s" repeatCount="indefinite" begin="0s">
                                    <mpath xlink:href="#patha"></mpath>
                                </animateMotion>
                            </circle>
                        </g>
                        <g transform="rotate(60 50 50)">
                            <circle cx="50" cy="15" r="9" fill="#7ab929">
                                <animateMotion dur="6s" repeatCount="indefinite" begin="-1s">
                                    <mpath xlink:href="#patha"></mpath>
                                </animateMotion>
                            </circle>
                        </g>
                        <g transform="rotate(120 50 50)">
                            <circle cx="50" cy="15" r="9" fill="#7ab929">
                                <animateMotion dur="6s" repeatCount="indefinite" begin="-2s">
                                    <mpath xlink:href="#patha"></mpath>
                                </animateMotion>
                            </circle>
                        </g>
                    </svg>
                </div>

                <div>
                    <a href="index.php"><strong>ERP-SYSTEM</strong></a>
                </div>
            </div>
        </div>

        <!-- 1.2 Title -->
        <?php include('includes/01_nav_title.php'); ?>


        <!-- 1.3 Actions-->
        <div class="navbar-action-container d-flex btn-group">


        </div>


    </div>
</nav>

<!--  2. Breadcrumbs -->
<?php include('includes/03_nav_breadcrumbs.php'); ?>

<!-- 3. Sidebar -->
<aside class="sidebar text-white">

    <div class="sidebar-inner d-flex flex-column">

        <!-- 3.1 User Login -->
        <?php include('includes/04_nav_user_login.php'); ?>

        <ul class="list-unstyled nav-autoclose">

            <!-- Home Icon -->
            <li class="mb-2">
                <a href="index.php" class="btn btn-toggle"><i class="fa-solid fa-puzzle-piece"></i> Dashboard</a>
            </li>

            <!-- 3.2 Default Navigation -->
            <?php 
            
            // Array
            // TODO: Muss vermutlich noch erweitert werden um Berechtigungen und Module, etc
            $_navigation = [
                'Stammdaten' => [
                    'icon' => 'fa-solid fa-database',
                    'links' => [
                        ['adressen', 'Adressen', 'fa-solid fa-info-circle'],
                        ['kontakte', 'Kontakte', 'fa-solid fa-info-circle'],
                        ['artikel', 'Artikel', 'fa-solid fa-info-circle'],
                        ['ident', 'Ident', 'fa-solid fa-info-circle'],
                        // ['modelle', 'Modelle', 'fa-solid fa-info-circle'],
                        // ['hersteller', 'Hersteller', 'fa-solid fa-info-circle'],
                        ['mitarbeiter', 'Mitarbeiter', 'fa-solid fa-info-circle'],
                        ['inventar', 'Inventar', 'fa-solid fa-info-circle'],
                        ['weitere-stammdaten', 'Weitere Stammdaten', 'fa-solid fa-info-circle'],
                    ]
                ],
                'Prozesse' => [
                    'icon' => 'fa-solid fa-cogs',
                    'links' => [
                        ['akquise', 'Akquise', 'fa-solid fa-search'],
                        ['angebote', 'Angebote', 'fa-solid fa-exclamation-triangle'],
                        ['auftraege', 'Aufträge', 'fa-solid fa-table'],
                        ['kommissionen', 'Kommissionen', 'fa-solid fa-table'],
                        ['bestellungen', 'Bestellungen', 'fa-solid fa-calendar-alt'],
                        ['bedarfsmeldungen', 'Bedarfsmeldungen', 'fa-solid fa-calendar-alt'],
                        ['wareneingaenge', 'Wareneingänge', 'fa-solid fa-check'],
                        // ['lieferungen', 'Lieferungen', 'fa-solid fa-chart-bar'],
                        ['rechnungen', 'Rechnungen', 'fab fa-bootstrap'],
                        ['service', 'Service', 'fa-solid fa-key'],
                        ['tickets', 'Tickets', 'fa-solid fa-key'],
                        ['vertraege', 'Verträge', 'fa-solid fa-key'],
                    ]
                ],
                'Controlling' => [
                    'icon' => 'fa-solid fa-chart-line',
                    'links' => [
                        ['berichte', 'Berichte', 'fa-solid fa-sign-in-alt'],
                        ['kassenbuch', 'Kassenbuch', 'fa-solid fa-dollar'],
                        ['zeiten', 'Zeiten', 'fa-solid fa-user']       
                    ]
                ],
                'Einstellungen' => [
                    'icon' => 'fa-solid fa-sliders-h',
                    'links' => [
                        ['einstellungen-allgemein', 'Allgemein', 'fa-solid fa-sign-in-alt'],
                        ['einstellungen-user', 'Meine Einstellungen', 'fa-solid fa-user'],
                        ['einstellungen-admin', 'Administration', 'fa-solid fa-user'],
                        ['einstellungen-mails', 'E-Mails', 'fa-solid fa-envelope']
                    ]
                ]
            ];
            
            
            
            
            include('includes/05_nav_default_nav.php'); 
            
            
            ?>

        </ul>

        <!-- 3.3 Version -->
        <?php include('includes/06_nav_version.php'); ?>

        <div class="sidebar-toggler">
            <a href="javascript:void(0);">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
        </div>

    </div>

</aside>