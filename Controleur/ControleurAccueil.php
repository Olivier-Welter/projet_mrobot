<?php

require_once 'modele/MediaManager.php';
require_once 'modele/Parametres.php';
require_once 'vue/Vue.php';

class ControleurAccueil {

  // Affiche la liste de tous les billets du blog
  public function accueil() {

  try {
    $vue = new Vue("Accueil");
    $vue->generer(array());
    $parametres = new Parametres();
  }
 catch (Exception $e) {
  $msgErreur = $e->getMessage();
  require 'vue/vueErreur.php';

}
    $mediaManager = new MediaManager();
    
    if (isset($_FILES['mon_fichier'])){
        //Vérification image uploadée
    if ($_FILES['mon_fichier']['error'] > 0) {
    echo 'Erreur lors du transfert';
    }
else{
    //  NOUVELLE INSTANCE DE LA CLASS MEDIA = OBJET $media
    $media = new Media([
          'oldName' => $_FILES["mon_fichier"]["name"],                          
          'fileSize' => $_FILES["mon_fichier"]["size"], 
          'evenement'=>  $parametres->getEvenement()        
            ]);
 
    $vignette= Media::VIGN_PATH.$media->newName();
    $mediaManager->add($media);
    $media->updateNewName($mediaManager);   
}
    }
  }
}