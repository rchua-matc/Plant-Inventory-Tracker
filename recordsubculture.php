<?php
    // Start the session
    require_once('startsession.php');

    // Insert the page header
    $page_title = 'Record Subculture';
    require_once('header.php');

    require_once("appvars.php");
    require_once("connectvars.php");
    require_once("displaycategory.php");

    // Ensure authorization
    if (!isset($_SESSION['user_id']))
    {
        echo '<p>You are not authorized to edit subculture records.Please '
                . '<a href="login.php">log in</a> as an authorized user '
                . 'to make changes.</p>';
        exit();
    }

    // Connect to the DB
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            or die('Could not connect to the database.');

    if (isset($_POST['submit']))
    {
        $date = mysqli_real_escape_string($dbc, trim($_POST['date']));

        if (!empty($date))
        {
            // Write to the GENOTYPE_SUBCULTURE table
            if (!empty($_POST['genotype']))
            {
                foreach ($_POST['genotype'] as $genotype)
                {
                    $quantity_field = "quantity$genotype";
                    $health_field = "health$genotype";
                    if (!empty($_POST[$quantity_field]) && is_numeric($_POST[$quantity_field]))
                    {
                        $quantity = mysqli_real_escape_string($dbc, trim($_POST[$quantity_field]));
                    }
                    else
                    {
                        $quantity = DEFAULT_QUANTITY;
                    }
                    if (!empty($_POST[$health_field]))
                    {
                        $health = mysqli_real_escape_string($dbc, trim($_POST[$health_field]));
                    }
                    else
                    {
                        $health = '';
                    }
                    $query = "INSERT INTO genotype_subculture VALUES (0, $genotype, '$date', $quantity, \"$health\")";
                    mysqli_query($dbc, $query)
                            or die('Error updating subculture records.');
                }

                echo 'Subculture records updated';
            }
        }
        else
        {
            echo 'Subculture date must not be blank.';
        }
    }


?>
<div class="container-fluid">
    <h1 class="mt-3">Record Transfers</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="row">
            <label for="date" class="col-form-label col">Subculture Date:</label>
            <input type="date" class="form-control col" id="date" name="date" value="<?= date('Y-m-d') ?>">
        </div>
        <?php
            // Display current inventory
            $categories = array('Cultivars', 'MCD x ATL', 'ATL x SUP', 'Transgenic',
                    'Peruvian / Native', 'Cold Breeding', 'Other');

            foreach ($categories as $category)
            {
                subcultureCategory($dbc, $category);
            }
        ?>
        <input type="submit" name="submit" value="Record Subculture">
    </form>
</div>
