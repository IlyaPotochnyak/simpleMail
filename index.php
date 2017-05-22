<?php
session_start();

//var_dump($_SESSION);


if (isset($_POST["send"])) {
//        print_r($_POST);

    $from = htmlspecialchars($_POST["from"]);
    $to = htmlspecialchars($_POST["to"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

        $_SESSION["from"] = $from;
        $_SESSION["to"] = $to;
        $_SESSION["subject"] = $subject;
        $_SESSION["message"] = $message;

    $error = false;
    $error_from = "";
    $error_to = "";
    $error_subject = "";
    $error_message = "";

    if ($from == "" || !preg_match("/@/", $from)) {
        $error_from = "Введите корректный email";
        $error = true;
    }
    if ($to == "" || !preg_match("/@/", $to)) {
        $error_to = "Введите корректный email";
        $error = true;
    }
    if (strlen($subject) == 0) {
        $error_subject = "Введите тему сообщения";
        $error = true;
    }

    if (strlen($message) == 0) {
        $error_message = "Введите сообщение";
        $error = true;
    }

    if (!$error){
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        $headers = "From: $from\r\nReply-to: $from\r\nContent-type: text/plain; charset=utf-8\r\n";

        mail($to, $subject, "от " . $from . ': ' . $message, $headers);
        header("Location: success.php?send=1");
        exit;
    }



}



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<form name="feedback" action="index.php" method="post">
    <label>От кого</label><br>
    <input type="text" name="from" value="<?php echo  $_SESSION["from"]; ?>">
    <span style="color: red"><?php echo $error_from; ?></span>
    <br>
    <label>Кому</label><br>
    <input type="text" name="to" value="<?php echo  $_SESSION["to"]; ?>">
    <span style="color: red"><?php echo $error_to; ?></span>
    <br>
    <label>Тема</label><br>
    <input type="text" name="subject" value="<?php echo  $_SESSION["subject"]; ?>">
    <span style="color: red"><?php echo $error_subject; ?></span>
    <br>
    <label>Сообщение</label><br>
    <textarea name="message" cols="80" rows="20" ><?php echo  $_SESSION["message"]; ?></textarea>
    <span style="color: red"><?php echo $error_message; ?></span>
    <br>
    <input type="submit" name="send" value="Отправить">


</form>

</body>
</html>






