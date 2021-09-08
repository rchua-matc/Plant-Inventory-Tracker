<?php
    // Displays each genotype in the passed category with the most recent
    // subculture date and quantity
    function displayCategory($dbc, $category)
    {
        $query = 'SELECT g.id, g.name, gs.subculture_date, gs.quantity, '
                . 'gs.health FROM genotype_subculture gs JOIN (SELECT '
                . 'genotype_id, MAX(subculture_date) as "newest_date" FROM '
                . 'genotype_subculture GROUP BY genotype_id) x on '
                . 'x.newest_date = subculture_date JOIN genotype g on g.id = '
                . 'x.genotype_id WHERE gs.genotype_id = x.genotype_id AND '
                . 'category = "' . $category . '" ORDER BY g.name asc';
        $data = mysqli_query($dbc, $query)
                or die("Error querying database.");

        // Loop through the results, formatting them in an HTML table
        if (!empty($data) && mysqli_num_rows($data) > 0)
        {
            echo '<h3 class="mt-3">' . $category . ':</h3>';
            echo '<table class="table table-striped table-hover"><thead><tr><th>Genotype</th><th>Date</th><th>Quantity</th><th>Health</th><th>Overdue</th></tr></thead>';
            while ($row = mysqli_fetch_array($data))
            {
                echo '<tr><td><a href="viewgenotype.php?id=' . $row['id']
                        . '">' . $row['name'] . '</a></td>';
                echo '<td>' . date("m-d-Y", strtotime($row['subculture_date'])) . '</td>';
                echo '<td>' . $row['quantity'] . '</td>';
                echo '<td>' . $row['health'] . '</td>';

                // Check if the line is overdue
                $old_date = date("Y-m-d", strtotime("-28 days"));

                if ($old_date >= $row['subculture_date'])
                {
                    echo '<td class="text-danger">*</td></tr>';
                }
                else
                {
                    echo '<td></td></tr>';
                }
            }
            echo '</table>';
        }
    }

    // Displays each genotype in the passed category as part of a form to
    // record subculture dates, quantities, and health
    function subcultureCategory($dbc, $category)
    {
        $query = 'SELECT id, name FROM genotype WHERE category = "' . $category . '" ORDER BY name';
        $data = mysqli_query($dbc, $query)
                or die("Error querying database.");

        // Loop through the results, formatting them as form input
        if (!empty($data) && mysqli_num_rows($data) > 0)
        {
            echo '<h3 class="mt-3">' . $category . ':</h3>';
            while ($row = mysqli_fetch_array($data))
            {
?>
                <div class="row mb-3 align-items-center">
                    <div class="col-3">
                        <input type="checkbox" class="form-check-input" id="<?= $row['name']; ?>" name="genotype[]" value="<?= $row['id'];?>">
                        <label for="<?= $row['name']; ?>" class="form-check-label ms-3"><?= $row['name']; ?></label>
                    </div>
                    <div class="col">
                        <div class="row">
                            <label for="quantity<?= $row['id']; ?>" class="col-form-label col-4 text-end">Quantity</label>
                            <input type="text" class="form-control col" id="quantity<?= $row['id']; ?>" name="quantity<?= $row['id']; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <label for="health<?= $row['id']; ?>" class="col-form-label col-4 text-end">Health</label>
                            <input type="text" class="form-control col" id="health<?= $row['id']; ?>" name="health<?= $row['id']; ?>">
                        </div>
                    </div>
                </div>
                
<?php

            }
        }
    }
?>