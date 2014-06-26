<?php
@session_start();
class loginModel
{
    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/songs.php for more)
     */
    public function checkUser($loginData) {
        $messages = "";
        if(preg_match('/[[:cntrl:][:punct:][:space:]]/', $loginData['username']) ||
            preg_match('/[[:cntrl:][:punct:][:space:]]/', $loginData['password'])) {
            $messages = "sql inject";
            return $messages;
        }

        try {
            $sql = "SELECT `account`, `password` FROM `".$loginData['type']."` WHERE `account` = '".$loginData['username']."';";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetch();
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

        if($result == null) {
            $messages = "does not exit account";
            return $messages;
        }


        if($result->password == $loginData['password'])
            return true;

        $messages = "wrong password";
        return $messages;
    }
}
?>