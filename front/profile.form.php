<?php

include ('../../../inc/includes.php');

// Gestion des données du formulaire

//Session::checkRight("profile", UPDATE);
Session::haveRight("profile", UPDATE);

$prof = new PluginDjilyProfile();

if (isset($_POST['update'])) {
   $prof->update($_POST);
   Html::back();
}



// Ajout de mon profil daans la BDD si ce n'est pas le profil super-admin
