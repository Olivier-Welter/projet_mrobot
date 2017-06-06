<?php
//création du formulaire de connexion via la méthode __toString()
class FormConnexion {
    function __toString(){
	       return ("<form action='adm.php?page=connexion' method='post'>
                        <center>
                        <label>Pseudo</label><input type='text' name='pseudo' value='' autofocus required><br>
                        <label>Mot de passe</label><input type='password' name='mdp' value='' required>
                        <input class='btn' type='submit' value='Valider'>
                        </center>
                    </form>");
	}


    function check($user_login, $mdp)
    {
	    if(!Authentification::getInstance()->checkUser($user_login,$mdp))
        {
            echo $this;
            echo "<span class='error'>Le login et le mot ne correspondent à aucun utilisateur.</span>";
        }
        else
        {
            header('Location: ./adm.php');
        }
    }
}