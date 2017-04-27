<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 27-04-17
 * Time: 16:02
 */

namespace Models;


class Scores extends Model
{
    public function get_scores(){
        try{
            $dbh = $this->connect_db();
            $sql = 'SELECT * FROM scores ORDER BY score DESC LIMIT 10';
            $sth = $dbh->query($sql);
            return $sth->fetchAll();

        }catch (\PDOException $e){
            die(json_encode(['erreur' => $e->getMessage()], JSON_UNESCAPED_UNICODE));
        }
    }


    public function insert_score(){
        try{
            $dbh = $this->connect_db();
            $sql = 'INSERT INTO scores (`score`) VALUES (:score)';
            $sth = $dbh->prepare($sql);
            return $sth->execute([':score' => intval($_POST['score'])]);

        }catch (\PDOException $e){
            die(json_encode(['erreur' => $e->getMessage()], JSON_UNESCAPED_UNICODE));
        }
    }
}