<?php

/* * *****************************************************************************
 * File Name: soapserver.php
 * Project: SOAP XML API
 * Author: Matt Nutsch
 * Date Created: Oct 4, 2016[11:47:24 AM]
 * Description: This script will receive an XML file over a SOAP connection.
 * Notes: based in part on: http://stackoverflow.com/questions/4194489/how-to-parse-soap-xml
 * **************************************************************************** */

//==================================================================== BEGIN PHP

//set to display errors, remove after development
//ini_set('display_errors',1);
//error_reporting(E_ALL|E_STRICT);

//include the other files
require_once('objectarray.php'); //for saving the values as an object
require_once('mysqlinsert.php'); //for inserting into the MySQL DB

//this function strips SOAP tags from the XML, so that the XML can be parsed

function stripSOAP($argSOAPXML)
{ 
  $clean_xml = str_ireplace(['<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">', 'SOAP-ENV:', 'SOAP:', '</envelope>', '<Body>', '</Body>'], '', $argSOAPXML);
		
  return $clean_xml;
}

// server
class MySoapServer
{
		
  //this function will send a response to the client
  //originally based on: https://gist.github.com/elvisciotti/4586286#file-gistfile1-php-L18
  public function sendMessage($argXML)
  {
    //DEV NOTE: insert code here to log API call in MySQL database
	
    try 
    {
	  
      //Prepare the XML by converting it from SOAP XML to regular XML
      $temp1 = stripSOAP($argXML);
      $temp2 = utf8_encode($temp1);
      $xml = simplexml_load_string($temp2);
	  
      //extract the values and save them to variables
      $VendorID = $xml->VendorID;
      $InvoiceNumber = $xml->InvoiceNumber;
      $InvoiceTransDate = $xml->InvoiceTransDate;
      $InvoiceTotal = $xml->InvoiceTotal;
      $AmountToPay = $xml->AmountToPay;
      $DiscountAllowed = $xml->DiscountAllowed;
      $DiscountToTake = $xml->DiscountToTake;
      $TermsCode = $xml->TermsCode;
      $VendorName = $xml->VendorID;
      $VendorType = $xml->VendorType;
      $VendorAddress1 = $xml->VendorAddress1;
      $VendorAddress2 = $xml->VendorAddress2;
      $VendorCity = $xml->VendorCity;
      $VendorState = $xml->VendorState;
      $VendorZip = $xml->VendorZip;
      $DueDate = $xml->DueDate;
      $PayDate = $xml->PayDate;
      $APAccount = $xml->APAccount;
      $TenNinetyNineType = $xml->TenNinetyNineType; //FKA 1099Type
      $InvoiceDocDate = $xml->InvoiceDocDate;
      $bPOBased = $xml->bPOBased;
      $CreateDate = $xml->CreateDate;
      $CreatedBy = $xml->CreatedBy;
      $LastModified = $xml->LastModified;
      $LineNumber = $xml->LineNumber;
      $Description = $xml->Description;
      $ExpenseAcct = $xml->ExpenseAcct;
      $Amount = $xml->Amount;
      $AmountPaid = $xml->AmountPaid;
      $CurrentBalance = $xml->CurrentBalance;
      $Qty = $xml->Qty;
      $UnitCost = $xml->UnitCost;
      $IsTenNinetyNine = $xml->IsTenNinetyNine; //FKA 1099?
      $InvoiceHeaderRecord = $xml->InvoiceHeaderRecord;
      
      //DEV NOTE: load variables into objects - requires cymaobjects.php be included
      $importedObject = new sandboxObject(); 
      
      $importedObject->setVariable("VendorID", "$VendorID");
      $importedObject->setVariable("InvoiceNumber", "$InvoiceNumber");
      $importedObject->setVariable("InvoiceTransDate", "$InvoiceTransDate");
      $importedObject->setVariable("InvoiceTotal", "$InvoiceTotal");
      $importedObject->setVariable("AmountToPay", "$AmountToPay");
      $importedObject->setVariable("DiscountAllowed", "$DiscountAllowed");
      $importedObject->setVariable("DiscountToTake", "$DiscountToTake");
      $importedObject->setVariable("TermsCode", "$TermsCode");
      $importedObject->setVariable("VendorName", "$VendorName");
      $importedObject->setVariable("VendorType", "$VendorType");
      $importedObject->setVariable("VendorAddress1", "$VendorAddress1");
      $importedObject->setVariable("VendorAddress2", "$VendorAddress2");
      $importedObject->setVariable("VendorCity", "$VendorCity");
      $importedObject->setVariable("VendorState", "$VendorState");
      $importedObject->setVariable("VendorZip", "$VendorZip");
      $importedObject->setVariable("DueDate", "$DueDate");
      $importedObject->setVariable("PayDate", "$PayDate");
      $importedObject->setVariable("APAccount", "$APAccount");
      $importedObject->setVariable("TenNinetyNineType", "$TenNinetyNineType"); //FKA 1099Type
      $importedObject->setVariable("InvoiceDocDate", "$InvoiceDocDate");
      $importedObject->setVariable("bPOBased", "$bPOBased");
      $importedObject->setVariable("CreateDate", "$CreateDate");
      $importedObject->setVariable("CreatedBy", "$CreatedBy");
      $importedObject->setVariable("LastModified", "$LastModified");
      $importedObject->setVariable("LineNumber", "$LineNumber");
      $importedObject->setVariable("Description", "$Description");
      $importedObject->setVariable("ExpenseAcct", "$ExpenseAcct");
      $importedObject->setVariable("Amount", "$Amount");
      $importedObject->setVariable("AmountPaid", "$AmountPaid");
      $importedObject->setVariable("CurrentBalance", "$CurrentBalance");
      $importedObject->setVariable("Qty", "$Qty");
      $importedObject->setVariable("UnitCost", "$UnitCost");
      $importedObject->setVariable("IsTenNinetyNine", "$IsTenNinetyNine"); //FKA 1099?
      $importedObject->setVariable("InvoiceHeaderRecord", "$InvoiceHeaderRecord");
            
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
      $source_for_db = "EAM";
      $data_processed_for_db = $argXML;
      $resultOfMySQLInsert = insertIntoMySQL($source_for_db, $data_processed_for_db, $result_status_for_db);
      
      //DEV NOTE: Add if MSSQL insert is a success as an additional criteria
      if($resultOfMySQLInsert == 1)
      {
        return "Success!";
      }
      else 
      {
        return "Failure to access MySQL log: " . $resultOfMySQLInsert;
      }
    } 
    catch (Exception $e) 
    {
      return 'Caught exception: ' . $e->getMessage() . "\n";
    }
  }  
  
}

$options= array('uri'=>'http://sandbox');
$server=new SoapServer(NULL,$options);
$server->setClass('MySoapServer');
$server->handle();

//====================================================================== END PHP
?>