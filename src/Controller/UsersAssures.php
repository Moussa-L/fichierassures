<?php

use App\Entity\Users;

// Fichier d'initialisation d'un utilisateur de test utilisé par le contrôleur.
// Cette instance est incluse dans la vue dashboard pour simuler une session active.
// Création d'un utilisateur de démonstration pour le rendu de la vue.
// L'objet est instancié avec un numéro d'agent, un nom complet et un mot de passe fictifs.
$users1 = new Users("J00567", "HedjaZaharir", "12345");
/*$users2 = new Users("J00987", "SouffouDine", "09864");
$users3 = new Users("J00453", "MohamedaAhmed", "56478");
$users4 = new Users("J00637", "SouffouEchat", "25806");

// Ce bloc commenté montre une liste d'utilisateurs de test qui n'est pas utilisée actuellement.
// Il sert de modèle de données supplémentaire pour une évolution future du contrôleur.
$LesUsers = [$users1, $users2, $users3, $users4];  */     

?>
