<?php


function curl($url, $data = [], $method = 'GET', $options = [])
{
    $default_options = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_SSL_VERIFYPEER => false,
    ];

    if ($method === 'GET') {
        $url .= (strpos($url, '?') === false) ? '?' : '&';
        $url .= http_build_query($data);
    } 
    if ($method === 'POST') {
        $options[CURLOPT_POSTFIELDS] = http_build_query($data);
    } 
    if ($method === 'JSON') {
        $options[CURLOPT_POSTFIELDS] = json_encode($data);
        $options[CURLOPT_HTTPHEADER][] = 'Content-Type:application/json';
    }

    $ch = curl_init($url);
    curl_setopt_array($ch, array_replace($default_options, $options));

    $result = curl_exec($ch);
    if ($result === false) {
        throw new ErrorException("Curl error: ".curl_error($ch), curl_errno($ch));
    }
    curl_close($ch);
    return $result;
}


$token = '7497801203:AAEnhqFxcPxVgAr0sGuhUVIF_MOzqQbJ7FI';
$chat_id = "576117695";

$rep = json_encode([
    'inline_keyboard' => [
        [
            [
                'text' => 'Button 1',
                'callback_data' => 'test_2',
            ],
            [
                'text' => 'Button 2',
                'callback_data' => 'test_2',
            ],
        ]
    ],
]);


$url = "https://api.telegram.org/bot$token/sendMessage";

$getQuery = [
    "chat_id" => $chat_id,
    "text" => "Новое сообщение из формы",
    "parse_mode" => "html",
    'reply_markup' => json_encode([
    'inline_keyboard' => [
        [
            [
                'text' => 'Добавить сорт',
                'callback_data' => 'test_2',
            ],
            [
                'text' => 'Удалить сорт',
                'callback_data' => 'test_2',
            ],
        ],
        [
            [
                'text' => 'Изменить сорт',
                'callback_data' => 'test_2',
            ],
            [
                'text' => 'Удалить сорт',
                'callback_data' => 'test_2',
            ],
        ]
    ],
    'one_time_keyboard' => true,
    'resize_keyboard' => false,
])

];
echo curl($url, $getQuery);