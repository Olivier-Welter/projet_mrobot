<?php

class ConnectDB
{
    //*******************************Variables membres*****************************
    const DBTYPE='mysql';
    const DBUSER='root';
    const DBPWD='mynewpassword';
    const DBURL='localhost';
    const DBNAME='snapspot';

    /*Fonction dbConnect()
    *Argument : Aucun
    *Description: Créer une connexion à la base de données selon les informations de l'objet ConnectDB.
    *Cette connexion est affectée à la variable membre $dbConnection.
    *
    */
    private static function dbConnect()
    {
        //Tentative de connexion à la base de données
        try
        {
            $dbc = new PDO(self::DBTYPE.":host=".self::DBURL.";dbname=".self::DBNAME, self::DBUSER, self::DBPWD);
            $dbc->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $dbc;
        }
        catch(PDOException $pdoe)
        {
            echo '<p class=error>Erreur de connexion à la base de données</p>';
            echo '<p class=error>Vérifiez les informations de connexion à la base de données</p>';
        }
    }
    
    /*Fonction dbQuery()
    *Argument:
    *$query: chaine de caractère représentant la requete à exécuter sur la base de données.
    *
    *Description:
    *Retourne le résultat de la requete sous la forme d'un tableau de tableaux associatif'
    */
    public static function dbQRY($query)
    {
        $dbc = self::dbConnect();
        try
        {
            //prépare la requête à être exécutée.
            $res = $dbc->prepare($query);
            $res->execute();

            if($res != false)
            {
                //si la requete produit des résultat, ils sont retournés sinon la méthode retourne NULL
                return $res->fetchAll(PDO::FETCH_ASSOC);
            }
            return NULL;
        }
        catch(PDOException $pdoe)
        {
            echo '<p class="error">'.$query.'</p>';
            echo '<p class=error>ConnectDB : Erreur lors de la requête dans la base de données.</p>';
        }
    }


    //===================================
    /*Fonction dbCRUD()
    *Argument:
    *$query: chaine de caractère représentant la requete à exécuter sur la base de données.
    *
    *Description:
    *Retourne le résultat de la fonction exec() cette méhode permet de gérer l'exception que peut générer exec().
    *
    */
    public static function dbCRUD($query)
    {
        $dbc = self::dbConnect();
        try
        {
            $res = $dbc->exec($query);
            return $res;
        }
        catch(PDOException $pdoe)
        {
           echo '<p class="error">'.$query.'</p>';
           echo '<p class="error">Erreur de requete</p>';
        }
    }
}
