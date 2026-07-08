<?php
//DB : assures
//port: 1433
$serverName = "55.38.4.121";

$connectionOptions = [
    "Database" => "assures",
    "Uid" => "lidya",
    "PWD" => "Lidyamoussa2907!" 
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
    echo "Connexion SQL Server OK !";
}else{
    echo "Erreur de connexion :\n";
    print_r(sqlsrv_errors());
}

