<?php

/* * *****************************************************************************
 * File Name: mysqlinsert.php
 * Project: API
 * Author: Matt Nutsch
 * Date Created: Oct 6, 2016[1:06:22 PM]
 * Description: This file contains functions for interfacing with the MySQL
 * database for the Sandbox server.
 * Notes: 
 * **************************************************************************** */

//==================================================================== BEGIN PHP

/********************************************************************************
 * Function Name: insertIntoMySQL
 * Description: This function inserts data into a MySQL database.
 * The first argument should be the name of the system interacting with the server.
 * The second argument should be the data sent to the server.
 * The third argument should be the result from the server of processing the data.
 * If the function returns 1 then it inserted the data into the MySQL database.
 * Otherwise the function will return a detailed error message
 * This function is loosely based on the code found at:
 * http://www.w3schools.com/php/php_mysql_insert.asp
 *******************************************************************************/
function insertIntoMySQL($argSource, $argData, $argResult) 
{

  //DB connection info
  $servername = "localhost";
  $username = "insert_user_name_here";
  $password = "insert_password_here";
  $dbname = "insert_database_name_here";
  $table_name = "insert_table_name_here";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) 
  {
    die("Connection failed: " . $conn->connect_error);
  } 

  $sql = "INSERT INTO $table_name (source, data_processed, result_status)
  VALUES ('$argSource', '$argData', '$argResult')";

  if ($conn->query($sql) === TRUE) 
  {
    return 1;
  } 
  else 
  {
    return "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

}

/*
//Example usage:
$source_for_db = "test source";
$data_processed_for_db = "This is a test of the PHP MySQL connection.";
$result_status_for_db = "success";   
insertIntoMySQL($source_for_db, $data_processed_for_db, $result_status_for_db);
*/

//====================================================================== END PHP
?>