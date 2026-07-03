<?php
//DB : assures
//port: 1433
$serverName = "55.38.4.121";

$connectionOptions = [
    "Database" => "assures",
    "Uid" => "lidya",
    "PWD" => "MotDepasseFort123!" 
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
    echo "Connexion SQL Server OK !";
}else{
    echo "Erreur de connexion :\n";
    print_r(sqlsrv_errors());
}

$conenectionOptions = [
    "Database" => "assures",
    "Uid" => "bounou",
    "PWD" => "MotDePasseFort123!"
];

$conn = sqlsrv_connect($serverName, $conenectionOptions);

if ($conn) {
    echo "Connexion SQL Server OK !";
} else {
    echo "Erreur de connexion : \n";
    print_r(sqlsrv_errors());
}