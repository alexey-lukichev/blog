<?php
    session_start();

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    use Entities\FileStorage;
    use Entities\TelegraphText;

    require_once './autoload.php';

    $message = '';
    $errorMessage = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (isset($_POST['text']) && isset($_POST['author']))
        {
            $text = $_POST['text'];
            $author = $_POST['author'];
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';

            $newTelegraphText = new TelegraphText('Title', $author, $text);
            $fileStorage = new FileStorage();
            $fileStorage->create($newTelegraphText);
            $_SESSION['message'] = 'Текст успешно добавлен в Телеграф!';
            if (!empty($email))
            {
                $mail = new PHPMailer(true);
                try {
                    //Настройки сервера
                    $mail->SMTPDebug = SMTP::DEBUG_OFF;
                    $mail->isSMTP();
                    $mail->Host = /* ваш хост */;
                    $mail->SMTPAuth = true;
                    $mail->CharSet = 'UTF-8';
                    $mail->Username = /* ваша почта */;
                    $mail->Password = /* ваш ключ */;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = /* ваш порт */;
                    //Получатель
                    $mail->setFrom(/* ваша почта */, 'Mailer');
                    $mail->addAddress($email);
                    //Контент
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->Subject = $author;
                    $mail->Body = $text;
                    $mail->AltBody = $text;

                    $mail->send();
                    $_SESSION['message'] .= ' Сообщение было успешно отправлено на ваш email';
                } catch (Exception $e) {
                    $_SESSION['errorMessage'] = 'Ошибка при отправке сообщения: ' . $mail->ErrorInfo;
                }
            }
            header("Location: ./input_text.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>BLOG</title>
    <style>
        body {
            margin: 0;
            background-color: #d5d5d5;
        }

        .form {
            display: flex;
            flex-direction: column;
            max-width: 300px;
            margin: 0 auto;
            margin-top: 150px;
            padding: 10px;
            border: 1px solid grey;
            border-radius: 10px;
            box-shadow: 0 0 15px black;
        }

        .form-btn {
            display: flex;
            justify-content: center;
        }

        .message { border: 1px solid green; background-color: #d4f4d4; padding: 10px; margin-bottom: 15px; }
        .error { border: 1px solid red; background-color: #f4d4d4; padding: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="message"><?= $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['errorMessage'])): ?>
        <div class="errorMessage"><?= $_SESSION['errorMessage']; ?></div>
        <?php unset($_SESSION['errorMessage']); ?>
    <?php endif; ?>

    <form class="form" action="./input_text.php" method="POST" accept-charset="UTF-8">
        <div class="mb-3">
            <label class="form-label">Автор</label>
            <input type="text" class="form-control" name="author" placeholder="Введите имя" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Текст</label>
            <textarea name="text" class="form-control" rows="3" placeholder="Введите ваш текст"></textarea>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Адрес электронной почты</label>
            <input type="email" name="email" class="form-control" placeholder="name@example.com">
        </div>
        <div class="form-btn">
            <button type="submit" class="btn btn-dark">Опубликовать</button>
        </div>
    </form>
</body>
</html>
