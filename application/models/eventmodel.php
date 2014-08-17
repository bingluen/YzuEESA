<?php
class EventModel
{
    function catchEventDetail($url) {
        $content = '';
        $host = 'http://yzueesa.kktix.cc/events/'.$url;
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

        //catch Time
        preg_match_all('/class="timezoneSuffix">(.*)<\/span> ~ /', $content, $catch);
        $data['start'] = $catch['1']['0'];
        preg_match_all('/~ <span class="timezoneSuffix">(.*)<\/span> /', $content, $catch);
        $data['end'] = $catch['1']['0'];

        //catch Location
        preg_match_all('/class="fa fa-map-marker"><\/i>(.*)<\/span>/', $content, $catch);
        $data['location'] = $catch['1']['0'];

        //catch the number of participants
        preg_match_all('/class="fa fa-male"><\/i>\x0A[ ]+(.*)/', $content, $catch);
        $data['people'] = $catch['1']['0'];        

        //catch event description text
        //preg_match_all('/<div class="description">((.|\n)*)<\/div>/', $content, $catch);
        $Needle['start'] = strpos($content, '<div class="description">') + 25;
        $Needle['end'] = strpos($content, '</div>', $Needle['start']);
        $data['description'] = substr($content, $Needle['start'], $Needle['end']-$Needle['start']);

        return $data;
    }
}
?>