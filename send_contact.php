<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 폼 데이터 가져오기 및 정리
    $name    = strip_tags(trim($_POST["name"]));
    $name    = str_replace(array("\r","\n"),array(" "," "),$name);
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // 필수 값이 비어 있거나 이메일 형식이 올바르지 않으면 오류 처리
    if ( empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        http_response_code(400);
        echo "Please complete the form and try again.";
        exit;
    }

    // 이메일 수신자 주소 (여기에 자신의 이메일 주소를 입력하세요)
    $recipient = "lsy051104@gmail.com";

    // 이메일 제목
    $subject = "New contact from $name";

    // 이메일 본문 내용 구성
    $email_content  = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // 이메일 헤더 구성
    $email_headers = "From: $name <$email>";

    // 이메일 전송
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    // POST 요청이 아닌 경우
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>