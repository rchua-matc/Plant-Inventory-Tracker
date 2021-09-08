<?php
    // Start the session
    require_once('startsession.php');

    // Insert the page header
    $page_title = 'Delete Record';
    require_once('header.php');

    require_once('connectvars.php');

    if (isset($_GET['id']) && isset($_SESSION['user_id']))
    {
        // Grab the subculture id from the GET
        $id = $_GET['id'];

        // Get the remaining data from the DB
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to MySQL server");
        $query = "SELECT * FROM genotype WHERE id = $id";
        $data = mysqli_query($dbc, $query)
                or die('Error querying database.');

        $row = mysqli_fetch_array($data);
        $name = $row['name'];
    }
    else if (isset($_POST['id']) && isset($_POST['name']))
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
    }
    else
    {
        echo 'Sorry, you are not authorized to remove genotypes.';
    }

    if (isset($_POST['submit']))
    {
        if ($_POST['confirm'] == 'Yes')
        {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to MySQL server");
            $query = "DELETE FROM genotype WHERE id = $id LIMIT 1";
            mysqli_query($dbc, $query)
                    or die('Error deleting record.');
            mysqli_close($dbc);

            // Confirmation message
            echo "<p>$name was removed from the inventory.</p>";
        }
        else
        {
            echo '<p class="error">The genotype was not removed</p>';
        }
    }
    else if (isset($id))
    {
?>
        <div class="container mt-3">
            <p>Are you sure you want to remove this genotype?</p>
            <p>Genotype: <?= $name; ?></p>
            <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>" class="mx-auto">
                <fieldset>
                    <input type="radio" class="form-check-input" id="no" name="confirm" value="No" checked>
                    <label for="no" class="form-check-label me-2">No</label>
                    <input type="radio" class="form-check-input" id="yes" name="confirm" value="Yes">
                    <label for="yes" class="form-check-label">Yes</label>
                </fieldset>
                <input type="hidden" name="id" value="<?= $id; ?>">
                <input type="hidden" name="name" value="<?= $name; ?>">
                <input type="submit" class="mt-3" name="submit" value="Remove">
            </form>
        </div>
<?php
    }

    require_once('footer.php');
?>