<?php

$paymentKey = $_GET['paymentKey'];
$orderId = $_GET['orderId'];
$amount = $_GET['amount'];

$secretKey = 'test_ak_ZORzdMaqN3wQd5k6ygr5AkYXQGwy';

$url = 'https://api.tosspayments.com/v1/payments/' . $paymentKey;

$data = ['orderId' => $orderId, 'amount' => $amount];

$credential = base64_encode($secretKey . ':');

$curlHandle = curl_init($url); // 이거는 어떤 api 이지?
//curl를 초기화하는 api 입니다

curl_setopt_array($curlHandle, [
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => [
        'Authorization: Basic ' . $credential,
        'Content-Type: application/json'
    ],
    CURLOPT_POSTFIELDS => json_encode($data)
]);

//curl를 setopt를 array로 만드는 api 입니다
//CURLOPT_POST => HTTP METHOD가 POST 인지 아닌지 확인
//CURLOPT_RETURNTRANSFER => 

/*
TRUE 설정 시 curl_exec () 반환 값의 문자열을 반환
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
*/

//CURLOPT_POSTFIELDS =>
/*
HTTP "POST"작업으로 게시 할 전체 데이터. 
curl_setopt($ch, CURLOPT_POSTFIELDS, Array());
*/





$response = curl_exec($curlHandle);

$httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
$isSuccess = $httpCode == 200;
$responseJson = json_decode($response);

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <title>결제 성공</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
</head>
<body>
<section>
    <?php
    if ($isSuccess) { ?>
        <h1>결제 성공</h1>
        <h3>상품명: 토스 티셔츠</h3>
        <p>결과 데이터: <?php echo json_encode($responseJson, JSON_UNESCAPED_UNICODE); ?></p>
        <?php
    } else { ?>
        <h1>결제 실패</h1>
        <p><?php echo $responseJson->message ?></p>
        <span>에러코드: <?php echo $responseJson->code ?></span>
        <?php
    }
    ?>

</section>
</body>
</html>
