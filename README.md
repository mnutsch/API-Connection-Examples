# API-Connection-Examples
This repository contains Server and Client side examples of SOAP XML and REST JSON API connections in PHP.

Files:

objectarray.php - This file contains a dynamic object which can be used to store values received via the API.
mysqlinsert.php - This file contains functions for logging API interactions in a MySQL database table

jsonrestserver.php - This file contains a working API script to run on the server. It receives REST connections sending JSON formatted data.
jsonrestclient.php - This file contains an example client to connect to the server.

soapserver.php - This file contains a working API script to run on the server. It receives SOAP connections sending XML formatted data.
soapclient.php - This file contains an example client to connect to the server. 

This set up utilizes a MySQL database table for logging. The following is a description of the columns for that database:
uid - unique ID (auto-indexed)
source - the system that interacted with the API server
timestamp - The date and time of the transaction
data_processed - The data processed through the API 
result_status - The result of the transaction (i.e. success, or failure).

