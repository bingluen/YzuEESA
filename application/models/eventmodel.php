<?php
class EventModel
{
    function catchEventDetail($url) {
        $content = '';
        $host = 'http://yzueesa.kktix.cc/events/'.$url;
    //第一次連線
        $connect = curl_init();
        $option = array(
            CURLOPT_URL => $host,
            CURLOPT_HEADER => 0,
            CURLOPT_REFERER => $host,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
            );
        curl_setopt_array($connect, $option);
        $content = curl_exec($connect);
        curl_close($connect);

        return $connect;
    }
}
?>