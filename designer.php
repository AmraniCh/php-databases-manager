<?php

# Include Data Loader
include 'modules/loader.php';
# Include Twig Loader
include 'vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

# Setting up twig 
$settings = new FilesystemLoader("$root/views/templates");
$loader = new Environment($settings);

# Check if there's a database parameter
if (!isset ($_GET['db']))
{
    # Display error page instead
    die ($loader->render ('exception.html.twig', ['title' => '\'db\' GET parameter is expected', 'message' => 'A parameter that holds the name of the database is required.']));
}

# Load database
$database = new Database ($_GET['db'], new mysqli ($host, $user, $pass));

# Render schema designer page
echo $loader->render ('index.html.twig', ['database' => $_GET['db'], 'tables' => $database->tables]);