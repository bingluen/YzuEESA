<?php
class ArticleModel
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

    function post($data) {
        try {
            $sql = "INSERT INTO `messages` (messages_title, messages_content, messages_author, messages_time) VALUES(?, ?, ?, ?);";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['title'], $data['content'], $data['author'], $data['time']));
        } catch(Exception $e) {
            throw new Exception($e->getMessage(), 810);
        }

        return true;
    }

    function updatePost($data) {
        try {
            $sql = "UPDATE `messages` SET `messages_title` = ?, `messages_content` = ?, `messages_author` = ?, `messages_time` = ? WHERE `messages_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['title'], $data['content'], $data['author'], $data['time'], $data['post_id']));
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 811);
        }

        return true;
    }

    function getPost($id) {
        try {
            $sql = "SELECT `messages_title`, `messages_content` FROM `messages` WHERE `messages_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 801);
        }
        return $result;
    }

    function listPost($limit = 15) {
        try {
            $sql = "SELECT `messages_id`, `messages_title`, `messages_time` FROM `messages` ORDER BY `messages_time` DESC LIMIT $limit;";
            $query = $this->db->prepare($sql);
            $query->excute();
            $result = $query->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 800);
        }

        return $result;
    }
}