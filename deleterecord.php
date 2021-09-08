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
        $name = $_GET['name'];

        // Get the remaining data from the DB
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to MySQL server");
        $query = "SELECT * FROM genotype_subculture WHERE subculture_id = $id";
        $data = mysqli_query($dbc, $query)
                or die('Error querying database.');

        $row = mysqli_fetch_array($data);
        $date = $row['subculture_date'];
        $quantity = $row['quantity'];
    }
    else if (isset($_POST['id']) && isset($_POST['date'])
            && isset($_POST['name']))
    {
        $id = $_POST['id'];
        $date = $_POST['date'];
        $name = $_POST['name'];
    }
    else
    {
        echo 'Sorry, you are not authorized to delete subculture records.';
    }

    if (isset($_POST['submit']))
    {
        if ($_POST['confirm'] == 'Yes')
        {
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die("Error connecting to MySQL server");
            $query = "DELETE FROM genotype_subculture WHERE subculture_id = $id LIMIT 1";
            mysqli_query($dbc, $query)
                    or die('Error deleting record.');
            mysqli_close($dbc);

            // Confirmation message
            echo "<p>The record for $name on $date was removed.</p>";
        }
        else
        {
            echo '<p class="error">The record was not removed</p>';
        }
    }
    else if (isset($id) && isset($date))
    {
?>
        <div class="container mt-3">
            <p>Are you sure you want to delete this record?</p>
            <p>Genotype: <?= $name; ?></p>
            <p>Date: <?= date("m-d-Y", strtotime($date)); ?></p>
            <p>Quantity: <?= $quantity; ?></p>
            <form method="POST" action="<?= $_SERVER['PHP_SELF']; ?>" class="mx-auto">
                <fieldset>
                    <input type="radio" class="form-check-input" id="no" name="confirm" value="No" checked>
                    <label for="no" class="form-check-label me-2">No</label>
                    <input type="radio" class="form-check-input" id="yes" name="confirm" value="Yes">
                    <label for="yes" class="form-check-label">Yes</label>
                </fieldset>
                <input type="hidden" name="id" value="<?= $id; ?>">
                <input type="hidden" name="date" value="<?= $date; ?>">
                <input type="hidden" name="name" value="<?= $name; ?>">
                <input type="submit" class="mt-3" name="submit" value="Delete">
            </form>
        </div>
<?php
    }

    require_once('footer.php');
?>