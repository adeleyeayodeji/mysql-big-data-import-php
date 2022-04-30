<?php

 // Name of the file
    $filename = 'file.sql';
    // MySQL host
    $mysql_host = "localhost";
    // MySQL username
    $mysql_username = "username";
    // MySQL password
    $mysql_password = "password";
    // Database name
    $mysql_database = "database";

    // Connect to MySQL server
    $co = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysqli_error($co));
    // Select database
    mysqli_select_db($co, $mysql_database) or die('Error selecting MySQL database: ' . mysqli_error($co));

    // Temporary variable, used to store current query
    $templine = '';
    // Read in entire file
    $lines = file($filename);
    // Loop through each line
    foreach ($lines as $line)
    {
    // Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;

    // Add this line to the current segment
    $templine .= $line;
    // If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';')
    {
        //check if the table already exists
        $check = mysqli_query($co, 'SHOW TABLES LIKE "'.$mysql_database.'"');
        if(mysqli_num_rows($check) == 0){
            // Perform the query
            if(mysqli_query($co, $templine)){
                echo "Success <br>";
            }else{
                print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($co) . '<br /><br />');
            }
        }else{
            //skip
            continue;
        }
        // Reset temp variable to empty
        $templine = '';
    }
    }
    $success = "Tables imported successfully";
    echo $success;
    ?>
