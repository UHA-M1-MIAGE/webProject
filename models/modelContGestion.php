<?php

/* Model qui gère:
 *  l'ajout
 *  la suppression
 *  la modification
 *  la selection des respondables administratif
 */

class ModelContGestion{
     public function logincheck($uname, $upwd) {
        $bdd = Connexion::getInstance();
        $sql = "SELECT * FROM controleurgestion WHERE controleurEmail=? AND controleurPasse=?";
        $req = $bdd->prepare($sql);
        $req->bindParam(1, $uname, PDO::PARAM_STR);
        $req->bindParam(2, $upwd, PDO::PARAM_STR);
        $req->execute();
        $res = $req->fetchAll();
        return $res;
    }
    // fonction qui ajoute un respondable administratif dans la base de données
    public function add($nom,$prenom,$adresse,$phone,$email,$pwd) {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare('INSERT INTO controleurgestion (controleurNom,controleurPrenom,controleurAdresse,controleurPhone,controleurEmail,controleurPasse)'
                . ' VALUES (:nom, :prenom, :adresse,:phone,:email,:passe)');
        $req->execute(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,            
            'phone' => $phone,
            'email' => $email,
            'passe' => $pwd
            
                )
        );
        
    }

    // fonction qui renvoi toutes les responsables administratif de la base de données
    public function getAll() {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare("SELECT * FROM controleurgestion ORDER BY controleurNom ASC");
        $req->execute();
        $vacs = $req->fetchAll();
        return $vacs;
    }

    // fonction qui renvoi un responsable administratif de la base de données
    public function getOne($id) {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare("SELECT * FROM controleurgestion WHERE controleurId= :id ");
        $req->bindValue(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $vac = $req->fetchAll();
        return $vac;
    }
     
    // fonction qui met à jour les inadministratif d'un responsable administratif
    public function update($nom,$prenom,$adresse,$phone,$email,$pwd, $id) {
        $bdd = Connexion::getInstance();
       // echo "$nom,$prenom,$adresse,$phone,$email,$pwd,$administratif,$id";
        $req = $bdd->prepare('UPDATE controleurgestion SET controleurNom = :nom ,controleurPrenom = :prenom ,'
                . 'controleurAdresse = :adresse, controleurPhone = :phone,controleurEmail = :email, controleurPasse = :pass'
                . ' WHERE controleurId = :id');
        $req->execute(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,            
            'phone' => $phone,
            'email' => $email,
            'pass' => $pwd,
            'id' => $id
        ));
        
    }
    // fonction qui met à jour le mot de passe 
    public function updateUserPwd($pwd, $id) {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare('UPDATE controleurgestion SET controleurPasse = :pass WHERE controleurId = :id');
        if ($req->execute(array('pass' => $pwd, 'id' => $id))) {
            return true;
        } else {
            return false;
        }
    }
    // fonction qui supprime  un responsable administratif de la base de données
    public function delete($id) {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare('DELETE FROM controleurgestion WHERE controleurId = :id');
        $req->execute(array('id' => $id));
    }

}

