<?php
@session_start();
class webMan extends Controller {
    private function displayEventMan($eventName) {
        $content = fread(fopen('application/views/eventMan/'.$eventName.'.php', 'r'), filesize('application/views/eventMan/'.$eventName.'.php'));
        $content += ""
        echo json_encode($content);
    }

    private function displayEventComponent($componentName) {
        $content = fread(fopen('application/views/eventMan/component/'.$componentName.'.php', 'r'), filesize('application/views/eventMan/component/'.$componentName.'.php'));
        echo json_encode($content);
    }

    private function savelog($log) {
        $logModel = $this->loadModel('logmodel');
        //var_dump($log);
        $logModel->writeLog($log);
    }

    private function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
          $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }


    public function event() {
        $log['page'] = 'eventMan';
        $log['ip'] = $this->getIP();
        $log['messages'] = 'read eventMan page';
        $log['time'] = date('Y-m-d H:i:s');
        $log['type'] = 'event';
        require 'application/views/eventMan/index.php';
        $this->savelog($log);
    }

    public function login($page = 0, $eventName = 0) {
        $log['ip'] = $this->getIP();
        $log['time'] = date('Y-m-d H:i:s');
        if($page === 'event') {
            $log['page'] = 'login for eventMan';
            if(isset($_POST['account']) && isset($_POST['account'])) {
                $loginData = array(
                    'username' => $_POST['account'],
                    'password' => $_POST['password'],
                    'type' => 'eventManager'
                );
            } else {
                echo "error";
                $log['type'] = 'error';
                $log['messages'] = 'login fail: login data is empty!';
                $this->savelog($log);
                exit;
            }
            $loginModel = $this->loadModel('loginmodel');
            $loginResult = $loginModel->checkUser($loginData);
            if($loginResult === true) {
                $log['messages'] = 'login eventMan success';
                $log['type'] = 'successLogin';
                $this->savelog($log);
                $_SESSION['username'] = $loginData['username'];
                $_SESSION['token'] = md5(time().$loginData['username'].$loginData['password']);
                if($eventName != 0) {
                    $this->displayEventMan($eventName);
                }
            } else if($loginResult == "sql inject") {
                $log['messages'] = 'Caution: SQL injection attack. Login data format is incorrect , include special character. It probably is SQL injection attack.';
                $log['type'] = 'attack';
                $this->savelog($log);
                echo json_encode('<div class="alert alert-danger" id="login-error"><strong>登入錯誤 未授權存取!</strong></div>');
                exit;
            } else if($loginResult == "does not exit account"){
                $log['type'] = 'error';
                $log['messages'] = 'login fail: account *'. $loginData['username'] .'* not exit.';
                $this->savelog($log);
                echo json_encode('<div class="alert alert-danger" id="login-error"><strong>登入錯誤 未授權存取!</strong></div>');
                exit;
            } else if($loginResult == "wrong password") {
                $log['type'] = 'wrong pw';
                $log['messages'] = 'login fail: account *'. $loginData['username'] .'* login with wrong password. It probably is ID theft.';
                $this->savelog($log);
            }
        }
    }

}
?>