<?php
//appel de la fermeture de la variable session et redirection vers la page d'index.php
Session::getInstance()->stop();
header('Location: ./adm.php');
?>