<?php

$url = "https://ad.betcity.ru/d/off/events";

$result = curl(
    $url,
    'ids=433',
    [
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0',
        'Accept: application/json, text/plain, */*',
        'Content-Type: application/x-www-form-urlencoded',
    ]
);

$resultJson = json_decode($result, 1);

$events = $resultJson['reply']['sports']['1']['chmps']['433']['evts'];

$total = [];

foreach ($events as $event_key => $event) {

    $total[] = [
        $event['name_ht'],
        $event['name_at'],
        $event['date_ev'],
        $event['date_ev_str'],
        [
            "P1"=>$event['main']['69']['data'][$event_key]['blocks']['Wm']['P1']["kf"],
            "P2"=>$event['main']['69']['data'][$event_key]['blocks']['Wm']['P2']["kf"],
            "X"=>$event['main']['69']['data'][$event_key]['blocks']['Wm']['X']["kf"],
        ],
        [
            "12"=>$event['main']['70']['data'][$event_key]['blocks']['WXm']['12']["kf"],
            "X2"=>$event['main']['70']['data'][$event_key]['blocks']['WXm']['X2']["kf"],
            "1X"=>$event['main']['70']['data'][$event_key]['blocks']['WXm']['1X']["kf"],
        ],
    ];
}
#print_r($total);

#file_put_contents('test3.txt',print_r($total,1));
header('Content-Type: application/json; charset=utf-8');

echo json_encode($total, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

file_put_contents('test3.txt', json_encode($total, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

function curl($url, $post = null, $headers = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER,  false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    if ($post) {
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    }
    if ($headers) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}