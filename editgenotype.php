<?php
    // Start the session
    require_once('startsession.php');

    // Insert the page header
    $page_title = 'Edit Genotype';
    require_once('header.php');

    require_once('connectvars.php');

    // Make sure the user is logged in
    if (!isset($_SESSION['user_id']))
    {
        echo '<p class="login">Please <a href="login.php">log in</a> '
                . 'to access this page.</p>';
        exit();
    }

    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_POST['submit']))
    {
        // Get the new genotype information
        $id = $_POST['id'];
        $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
        $category = $_POST['category'];
        $calcium = mysqli_real_escape_string($dbc, trim($_POST['calcium']));
        $transgenic = $_POST['transgenic'];
        $notes = mysqli_real_escape_string($dbc, trim($_POST['notes']));
        $error = false;

        // Update the genotype data in the database
        if (!empty($id) && !empty($name) && !empty($calcium)
                && !empty($transgenic))
        {
            if (is_numeric($calcium))
            {
                $query = "UPDATE genotype SET name = '$name', "
                        . "category = '$category', "
                        . "calcium = $calcium, "
                        . "transgenic = '$transgenic' "
                        . "WHERE id = $id";

                mysqli_query($dbc, $query)
                        or die('Error updating genotype information');

                // Redirect back to the genotype page
                header("Location: viewgenotype.php?id=$id");
            }
            else
            {
                echo '<p class="text-danger">Calcium must be numeric.</p>';
            }
        }
        else
        {
            echo '<p class="text-danger">You must enter all of the '
                    . 'genotype information (except notes).</p>';
        }
    }
    else if (isset($_GET['id']))
    {
        // Grab the profile data from the database
        $query = "SELECT name, category, calcium, transgenic, "
                . "notes FROM genotype WHERE "
                . "id = '" . $_GET['id'] . "'";
        $data = mysqli_query($dbc, $query)
                or die('Error querying database');
        $row = mysqli_fetch_array($data);

        if ($row != NULL)
        {
            $name = $row['name'];
            $category = $row['category'];
            $calcium = $row['calcium'];
            $transgenic = $row['transgenic'];
            $notes = $row['notes'];
        }
        else
        {
            echo '<p class="text-danger">There was a problem accessing the '
                    . 'genotype information.</p>';
        }
    }

    mysqli_close($dbc);
?>

<div class="container-fluid">
<h1 class="mt-3">Edit Genotype</h1>
<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="mx-auto">
    <div class="row g-6 mt-3">
        <div class="col">
            <label for="name" class="form-label">Genotype Name:</label>
            <input type="text" id="name" class="form-control" name="name" value="<?php if (!empty($name)) echo $name; ?>">
        </div>
        <div class="col">
            <label for="category" class="form-label">Category:</label>
            <select id="category" class="form-select" name="category">
                <option value="Other" <?php if (!empty($category) && $category == "Other") echo 'selected="selected"'; ?>>Other</option>
                <option value="Cold Breeding" <?php if (!empty($category) && $category == "Cold Breeding") echo 'selected="selected"'; ?>>Cold Breeding</option>
                <option value="Transgenic" <?php if (!empty($category) && $category == "Transgenic") echo 'selected="selected"'; ?>>Transgenic</option>
                <option value="MCD x ATL" <?php if (!empty($category) && $category == "MCD x ATL") echo 'selected="selected"'; ?>>MCD x ATL</option>
                <option value="Peruvian / Native" <?php if (!empty($category) && $category == "Peruvian / Native") echo 'selected="selected"'; ?>>Peruvian / Native</option>
                <option value="ATL x SUP" <?php if (!empty($category) && $category == "ATL x SUP") echo 'selected="selected"'; ?>>ATL x SUP</option>
                <option value="Cultivars" <?php if (!empty($category) && $category == "Cultivars") echo 'selected="selected"'; ?>>Cultivars</option>
            </select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <label for="calcium" class="form-label">Calcium (mM):</label>
            <input type="text" class="form-control" id="calcium" name="calcium" value="<?php if (!empty($calcium)) echo $calcium; ?>">
        </div>
        <div class="col">
            <label class="form-label">Transgenic:</label>
            <fieldset>
                <input type="radio" class="form-check-input" id="no" name="transgenic" value="N" <?php if (!isset($transgenic) || $transgenic == "N") echo 'checked'; ?>>
                <label for="no" class="form-check-label me-2">No</label>
                <input type="radio" class="form-check-input" id="yes" name="transgenic" value="Y" <?php if (!empty($transgenic) && $transgenic == "Y") echo 'checked'; ?>>
                <label for="yes" class="form-check-label">Yes</label>
            </fieldset>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <label for="notes" class="form-label">Notes:</label>
            <textarea id="notes" class="form-control" name="notes"><?php if (!empty($notes)) echo $notes; ?></textarea>
        </div>
    </div>
    <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
    <input type="submit" name="submit" value="Save Changes" class="mt-3">
</form>
</div>

<?php
require_once('footer.php');
?>
