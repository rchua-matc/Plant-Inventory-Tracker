<?php
    // Start the session
    require_once('startsession.php');

    // Insert the page header
    $page_title = 'Home';
    require_once('header.php');

    require_once('connectvars.php');
    require_once('displaycategory.php');

    // Connect to the DB
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Could not connect to the database.');

    // Display current inventory
    $categories = array('Cultivars', 'MCD x ATL', 'ATL x SUP', 'Transgenic',
            'Peruvian / Native', 'Cold Breeding', 'Other');
    
    foreach ($categories as $category)
    {
        displayCategory($dbc, $category);
    }

    // Insert the page footer
    require_once('footer.php');
?>
