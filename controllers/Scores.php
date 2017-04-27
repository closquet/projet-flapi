<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 27-04-17
 * Time: 16:02
 */

namespace Controllers;

use Models\Scores as Scores_model;

class Scores extends Controller
{
    private $scores_model = null;
    public  function __construct()
    {
        $this->scores_model = new Scores_model();
    }


    public function index(){
        $scores = $this->scores_model->get_scores();
        return ['scores' => $scores];
    }


    public function store(){
        if (isset($_POST['score'])){
            if (ctype_digit($_POST['score'])){
                $check = $this->scores_model->insert_score();
                if ($check){
                    return ['success' => 'Le score a été enregistré.'];
                }else{
                    return ['error' => 'La requête SQL n’a pu se faire...'];
                }
            }else{
                return ['error' => 'Le score doit être un entier positif'];
            }
        }else{
            return['error' => 'Il faut envoyer un score'];
        }
    }
}