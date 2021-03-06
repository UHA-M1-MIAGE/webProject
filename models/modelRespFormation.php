<?php

/* Model qui gère:
 *  l'ajout
 *  la suppression
 *  la modification
 *  la selection des respondables formation
 */

class ModelRespFormation{
    public function logincheck($uname, $upwd) {
        $bdd = Connexion::getInstance();
        $sql = "SELECT * FROM responsableformation WHERE respFormEmail=? AND respFormPasse=?";
        $req = $bdd->prepare($sql);
        $req->bindParam(1, $uname, PDO::PARAM_STR);
        $req->bindParam(2, $upwd, PDO::PARAM_STR);
        $req->execute();
        $res = $req->fetchAll();
        return $res;
    }
    // fonction qui ajoute un respondable formation dans la base de données
    public function add($nom,$prenom,$adresse,$phone,$email,$pwd,$formation) {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare('INSERT INTO responsableformation (respFormNom,respFormPrenom,respFormAdresse,respFormPhone,respFormEmail,respFormPasse,formationId)'
                . ' VALUES (:nom, :prenom, :adresse,:phone,:email,:passe, :formation)');
        $req->execute(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,            
            'phone' => $phone,
            'email' => $email,
            'passe' => $pwd,
            'formation' => $formation
            
                )
        );
        
    }

    // fonction qui renvoi toutes les responsables formation de la base de données
    public function getAll() {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare("SELECT * FROM responsableformation ORDER BY respFormNom ASC");
        $req->execute();
        $vacs = $req->fetchAll();
        return $vacs;
    }

    // fonction qui renvoi un responsable formation de la base de données
    public function getOne($id) {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare("SELECT * FROM responsableformation WHERE respFormId= :id ");
        $req->bindValue(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $vac = $req->fetchAll();
        return $vac;
    }
     
    // fonction qui met à jour les information d'un responsable formation
    public function update($nom,$prenom,$adresse,$phone,$email,$pwd,$formation, $id) {
        $bdd = Connexion::getInstance();
       // echo "$nom,$prenom,$adresse,$phone,$email,$pwd,$formation,$id";
        $req = $bdd->prepare('UPDATE responsableformation SET respFormNom = :nom ,respFormPrenom = :prenom ,'
                . 'respFormAdresse = :adresse, respFormPhone = :phone,respFormEmail = :email, respFormPasse = :pass,'
                . ' formationId = :formation WHERE respFormId = :id');
        $req->execute(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'adresse' => $adresse,            
            'phone' => $phone,
            'email' => $email,
            'pass' => $pwd,
            'formation' => $formation,
            'id' => $id
        ));
        
    }
    // fonction qui met à jour le mot de passe 
    public function updateUserPwd($pwd, $id) {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare('UPDATE responsableformation SET respFormPasse = :pass WHERE respFormId = :id');
        if ($req->execute(array('pass' => $pwd, 'id' => $id))) {
            return true;
        } else {
            return false;
        }
    }
    // fonction qui supprime  un responsable formation de la base de données
    public function delete($id) {
        $bdd = Connexion::getInstance();
        $req = $bdd->prepare('DELETE FROM responsableformation WHERE respFormId = :id');
        $req->execute(array('id' => $id));
    }

}

