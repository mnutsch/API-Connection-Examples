<?php

/* * *****************************************************************************
 * File Name: jsonrestserver.php
 * Project: JSON REST API
 * Author: Matt Nutsch
 * Date Created: Oct 5, 2016[1:54:06 PM]
 * Description: This code receives a POST of JSON
 * Notes: 
 * **************************************************************************** */

//==================================================================== BEGIN PHP

//include the other files
require_once('objectarray.php'); //for saving the values as an object
require_once('mysqlinsert.php'); //for inserting into the MySQL DB

if ($_POST['json_value']) //json data was sent
{  
  //DEV NOTE add code to escape out harmful characters
  $json_data = $_POST["json_value"]; 
  $json_decoded = json_decode($json_data, true);
  
  //extract the values and save them to variables
  $invoiceNumber = $json_decoded['invoiceNumber'];
  $invoiceSubTotal = $json_decoded['invoiceSubTotal'];
  $salesTax = $json_decoded['salesTax'];
  $invoiceTotal = $json_decoded['invoiceTotal'];
  
  //DEV NOTE: load variables into objects - requires cymaobjects.php be included
  $importedObject = new sandboxObject(); 
  
  $importedObject->setVariable("invoiceNumber", "$invoiceNumber");
  $importedObject->setVariable("invoiceSubTotal", "$invoiceSubTotal");
  $importedObject->setVariable("salesTax", "$salesTax");
  $importedObject->setVariable("invoiceTotal", "$invoiceTotal");
  
  //DEV NOTE: insert code here to insert objects into MSSQL database
  
  //Log the transaction in the MySQL database
  if(1 == 1) //DEV NOTE: change this to check if the MSSQL database insertion was successful
  {
    $result_status_for_db = "success";   
  }
  else
  {
    $result_status_for_db = "failure";   
  }
  $source_for_db = "SalesForce";
  $data_processed_for_db = $json_data;
  $resultOfMySQLInsert = insertIntoMySQL($source_for_db, $data_processed_for_db, $result_status_for_db);

  echo "API connection successful. ";  
  //DEV NOTE: Add if MSSQL insert is a success as an additional criteria
  if($resultOfMySQLInsert == 1)
  {
    echo "Successful log in MySQL!";
  }
    else 
  {
    echo "Failure to access MySQL log: " . $resultOfMySQLInsert;
  }
}
else //json data was not sent
{
  echo "API Connection failure. JSON was not received.";
}

//====================================================================== END PHP
?>