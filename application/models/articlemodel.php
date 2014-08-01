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
            $sql = "INSERT INTO `messages` (messages_title, messages_content, messages_author, messages_time, messages_draft) VALUES(?, ?, ?, ?, ?);";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['title'], $data['content'], $data['author'], $data['time'], $data['draft']));
        } catch(Exception $e) {
            throw new Exception($e->getMessage(), 810);
        }

        return true;
    }

    function updatePost($data) {
        try {
            $sql = "UPDATE `messages` SET `messages_title` = ?, `messages_content` = ?, `messages_author` = ?, `messages_time` = ?, `messages_draft` = ? WHERE `messages_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['title'], $data['content'], $data['author'], $data['time'], $data['draft'], $data['post_id']));
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

    function listPost($page = 0, $limit = 15, $position = 0) {
        try {

            if($position == 0 ) { // 0 = 前台
                $sql = "SELECT `messages_id`, `messages_title`, `messages_time` FROM `messages` ORDER BY `messages_time` DESC LIMIT $page, $limit WHERE `messages_draft` = '0';";
            } else if($position == 1) { // 1 = 後台
                $sql = "SELECT `messages_id`, `messages_draft`, `messages_title`, `messages_time`, `messages_author` FROM `messages` ORDER BY `messages_time` DESC LIMIT $page, $limit;";
            }
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 800);
        }

        return $result;
    }

    function deletePost($list) {
        foreach ($list as $id) {
            try {
                $sql = "DELETE FROM `messages` WHERE `messages_id` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array($id));
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
            return true;
        }
    }

    function publicPost($list) {
        foreach ($list as $id) {
            try {
                $sql = "UPDATE `messages` SET `messages_draft` = ? WHERE `messages_id` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array(0, $id));
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
            return true;
        }
    }

    function draftPost($list) {
        foreach ($list as $id) {
            try {
                $sql = "UPDATE `messages` SET `messages_draft` = ? WHERE `messages_id` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array(1, $id));
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
            return true;
        }
    }

    function getPages($dpp) {
        try {
            $sql = "SELECT (COUNT(*) DIV $dpp) AS pages, (COUNT(*) MOD $dpp) AS mode  FROM `messages`;";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetch();
            if($result->mode > 0)
                return $result->pages+1;
            else
                return $result->pages;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}