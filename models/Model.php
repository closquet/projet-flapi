<?php
/**
 * Created by PhpStorm.
 * User: Eric
 * Date: 27-04-17
 * Time: 16:02
 */

namespace Models;


class Model
{
    protected function connect_db(){
        $db_config = parse_ini_file(DB_INI_FILE);
        $db_host = $db_config['DB_HOST'];
        $db_name = $db_config['DB_NAME'];
        $db_user = $db_config['DB_USER'];
        $db_password = $db_config['DB_PASSWORD'];

        $dsn = sprintf('mysql:dbname=%s;host=%s;charset=UTF8', $db_name, $db_host);
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
        ];
        return new \PDO($dsn, $db_user, $db_password, $options);
    }
}