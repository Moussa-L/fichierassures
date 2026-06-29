<?php

$serverName = "55.38.4.121";
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