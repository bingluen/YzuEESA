<?php

class logModel
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
    public function writeLog($logData) {
        $sql = "INSERT INTO `log` (time, ip, page, messages) VALUES(?, ?, ?, ?);";
        $query = $this->db->prepare($sql);
        $result = $query->execute(array($logData['time'], $logData['ip'], $logData['page'], $logData['messages']));
        if($result)
            return true;
        return false;
    }
}
?>