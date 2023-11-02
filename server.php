<?php
$data = file_get_contents('php://input');
$json = json_decode($data);

if ($json && isset($json->buttonType) && isset($json->timestamp)) {
    $buttonType = $json->buttonType;
    $timestamp = $json->timestamp;
   

    // タイムスタンプをDateTimeオブジェクトに変換
    $dateTime = new DateTime($timestamp);

    // スタートボタンが押された場合
    if ($buttonType === 'start') {
        // タイムスタンプに1日を加算
        $dateTime->add(new DateInterval('P1D'));
        $result = $dateTime->format('Y-m-d H:i:s');
        // echo をすることで、JavaScript側に応答を返す
        echo json_encode(['startAt' => $result]);
    }

    // エンドボタンが押された場合
    elseif ($buttonType === 'end') {
        
        // 例: ログにエンドボタンの押されたタイムスタンプを記録
        // $logFile = fopen('log.txt', 'a');
        // fwrite($logFile, "End Button Pressed: $timestamp\n");
        // fclose($logFile);

        $dateTime->add(new DateInterval('P1D'));
        $result = $dateTime->format('Y-m-d H:i:s');
        echo json_encode(['endAt' => $result]);
    }
} else {
    echo json_encode(['error' => 'Invalid Data']);
}
?>
