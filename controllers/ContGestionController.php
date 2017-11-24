<?php

class ContGestionController {

    // fonction qui affiche le formulaire d'ajout d'un Controleur Gestion
    public function add() {
        $sub_title = "Ajout d'un Controleur Gestion";
        $functionUrl = "doAdd";
        include_once VIEWS . DS . 'ajoutContGestion.php';
    }

    public function doAdd() {
        if (isset($_POST['userNom']) && isset($_POST['userPrenom']) && isset($_POST['userAddr']) &&
                isset($_POST['userPhone']) && isset($_POST['userEmail']) && isset($_POST['userPwd'])) {
            //Nettoyage des paramètres saisis par l'Controleur Gestion
            $uNom = filter_input(INPUT_POST, 'userNom', FILTER_SANITIZE_STRING);
            $uPrenom = filter_input(INPUT_POST, 'userPrenom', FILTER_SANITIZE_STRING);
            $uAdresse = filter_input(INPUT_POST, 'userAddr', FILTER_SANITIZE_STRING);
            $uPhone = filter_input(INPUT_POST, 'userPhone', FILTER_SANITIZE_NUMBER_INT);
            $uEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_STRING);
            $uPwd = filter_input(INPUT_POST, 'userPwd', FILTER_SANITIZE_STRING);
            $um = new ModelContGestion();
            if ($um->add($uNom, $uPrenom, $uAdresse, $uPhone, $uEmail, $uPwd)) {
                $message = "Le Controleur Gestion a bien été ajouté en base de données";
                var_dump($message);
            } else {
                $message = "Une erreur n'a pas permis d'ajouter le Controleur Gestion en base de données.";
                var_dump($message);
            }
            header('Location: ' . URL_BASE . '/ContGestion/lists');
        } else {
            //Les paramètres attendus ne sont pas présents!!
            $message = "Tentative d'ajout d'un Controleur Gestion mais avec les mauvais paramètres.";
            var_dump($message);
            header('Location: ' . URL_BASE . '/ContGestion/add');
        }
    }

    /* fonction qui met en relation les données 
     * renvoyées par la fonction gettAll()
     * du modèle ContGestion 
     * et la vue qui affihe les Controleur Gestions
     */

    public function lists() {
        $m = new ModelContGestion();
        $list = $m->getAll();
        include_once VIEWS . DS . 'listContGestions.php';
    }

    /* fonction qui met en relation les donnéss 
     * renvoyées par la fonction getOne()
     * du modèle ContGestion 
     * et le formulaire pour modifier un Controleur Gestion
     */

    public function update() {
        $id = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_NUMBER_INT);
        $m = new ModelContGestion();
        $ctrl = $m->getOne($id);
        $sub_title = "Modification d'un Controleur Gestion";
        $functionUrl = "doUpdate";
        include_once VIEWS . DS . 'ajoutContGestion.php';
    }

    /* fonction qui met en relation les données 
     * renvoyées par le formulaire de modification d'un Controleur Gestion
     * et la fonction update() du modeèle Controleur Gestion
     * pour la mise à jour d'un Controleur Gestion
     */

    public function doUpdate() {
        $id = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_STRING);
        $uNom = filter_input(INPUT_POST, 'userNom', FILTER_SANITIZE_STRING);
        $uPrenom = filter_input(INPUT_POST, 'userPrenom', FILTER_SANITIZE_STRING);
        $uAdresse = filter_input(INPUT_POST, 'userAddr', FILTER_SANITIZE_STRING);
        $uPhone = filter_input(INPUT_POST, 'userPhone', FILTER_SANITIZE_NUMBER_INT);
        $uEmail = filter_input(INPUT_POST, 'userEmail', FILTER_SANITIZE_STRING);
        $uPwd = filter_input(INPUT_POST, 'userPwd', FILTER_SANITIZE_STRING);
        $m = new ModelContGestion();
        if ($m->update($uNom, $uPrenom, $uAdresse, $uPhone, $uEmail, $uPwd, $id)) {
            $message = "Le Controleur Gestion a bien été mise a jour";
            var_dump($message);
        } else {
            $message = "Une erreur n'a pas permis de mettre a jour le Controleur Gestion";
            var_dump($message);
          //die();
        }

        header('Location: ' . URL_BASE . '/ContGestion/lists');
    }

    /* fonction qui appelle la fonction deleteContGestion()
     * du modèle ContGestion pour supprimer un Controleur Gestion
     */

    public function delete() {
        $id = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_STRING);
        $m = new ModelContGestion();
        $m->delete($id);
        header('Location: ' . URL_BASE . '/ContGestion/lists');
    }

}
