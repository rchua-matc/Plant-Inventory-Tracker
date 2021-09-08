<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" 
                rel="stylesheet" 
                integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" 
                crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="style.css">


        <?php
            echo '<title>Plant Inventory - ' . $page_title . '</title>';
        ?>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">Tissue Culture 
                            Inventory</a>
                    <div class="navbar-nav col justify-content-left">
                        <a class="nav-item nav-link" href="index.php">Home<a>
                        <?php
                            if (isset($_SESSION['user_id']))
                            {
                        ?>
                                <a class="nav-link" href="recordsubculture.php">
                                        Record Subculture</a>
                                <a class="nav-link" href="addgenotype.php">
                                        Add A Genotype</a>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="navbar-nav justify-content-end">
                        <?php
                            if (!isset($_SESSION['user_id']))
                            {
                        ?>
                                <button type="button" class="btn btn-primary">
                                    <a class="nav-link text-white" href="login.php">Log In</a>
                                </button>
                        <?php
                            }
                            else
                            {
                        ?>
                                    <span class="navbar-text">Signed in as <?= $_SESSION['username']; ?></span>
                                    <a class="nav-link" href="logout.php">Log Out</a>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                
            </nav>
        </header>
        <main class="container">