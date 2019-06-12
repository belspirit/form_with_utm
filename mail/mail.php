<?php

require_once('phpmailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
$mail->CharSet = 'utf-8';

$name = $_POST['name'];
$phone = $_POST['phone'];


//get cookies from utm
function getUtmField($fieldName){

    if( isset($_POST[$fieldName]) ){
        return $_POST[$fieldName];
    } else {
        return '(none)';
    }
}

$firstSrc = getUtmField('sb_first_src');
$firstMdm = getUtmField('sb_first_mdm');
$firstCmp = getUtmField('sb_first_cmp');
$firstCnt = getUtmField('sb_first_cnt');
$firstTrm = getUtmField('sb_first_trm');
$currentTyp = getUtmField('sb_current_typ');
$currentSrc = getUtmField('sb_current_src');
$currentMdm = getUtmField('sb_current_mdm');
$currentCmp = getUtmField('sb_current_cmp');
$currentCnt = getUtmField('sb_current_cnt');
$currentTrm = getUtmField('sb_current_trm');
$firstAddfd = getUtmField('sb_first_add_fd');
$firstAddep = getUtmField('sb_first_add_ep');
$firstAddRf = getUtmField('sb_first_add_rf');
$currentAddFd = getUtmField('sb_current_add_fd');
$currentAddEp = getUtmField('sb_current_add_ep');
$currentAddRf = getUtmField('sb_current_add_rf');
$sessionPgs = getUtmField('sb_session_pgs');
$sessionCpg = getUtmField('sb_session_cpg');
$udataVst = getUtmField('sb_udata_vst');
$udataUip = getUtmField('sb_udata_uip');
$udataUag = getUtmField('sb_udata_uag');




//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.yandex.ru';                       // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'mail@yandex.ru'; // Ваш логин от почты с которой будут отправляться письма
$mail->Password = 'password'; // Ваш пароль от почты с которой будут отправляться письма
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров

$mail->setFrom('mail@yandex.ru'); // от кого будет уходить письмо?
$mail->addAddress('some.mail@gmail.com');     // Кому будет уходить письмо
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Заявка с сайта';
$mail->Body = '<h3>Контактные данные клиента</h3>';
$mail->Body .= 'Имя клиента: <strong>' . $name . '</strong><br>Номер телефона: <strong>' . $phone . '</strong>';

$mail->Body .= '<h2 style="color:red">Данные по UTM меткам</h2>';

$mail->Body .= '<h3 style="color:red">Первый визит</h3>';
$mail->Body .= '<p>Источник первого визита: <strong>' . $firstSrc . '</strong><br>';
$mail->Body .= 'Канал первого визита: <strong>' . $firstMdm . '</strong><br>';
$mail->Body .= 'Кампания первого визита: <strong>' . $firstCmp . '</strong><br>';
$mail->Body .= 'Контент первого визита: <strong>' . $firstCnt . '</strong><br>';
$mail->Body .= 'Ключевое слово первого визита: <strong>' . $firstTrm . '</strong><br>';
$mail->Body .= 'Дата и время первого визита визита: strong>' . $firstAddfd . '</strong><br>';
$mail->Body .= 'Точка входа первого визита: <strong>' . $firstAddep . '</strong><br>';
$mail->Body .= 'Реферер первого визита: <strong>' . $firstAddRf . '</strong></p>';

$mail->Body .= '<h3 style="color:red">Текущий визит</h3>';
$mail->Body .= '<p>Тип трафика текущего визита: <strong>' . $currentTyp . '</strong><br>';
$mail->Body .= 'Источник текущего визита: <strong>' . $currentSrc . '</strong><br>';
$mail->Body .= 'Канал текущего визита: <strong>' . $currentMdm . '</strong><br>';
$mail->Body .= 'Кампания текущего визита: <strong>' . $currentCmp . '</strong><br>';
$mail->Body .= 'Контент текущего визита: <strong>' . $currentCnt . '</strong><br>';
$mail->Body .= 'Ключевое слово текущего визита: <strong>' . $currentTrm . '</strong><br>';
$mail->Body .= 'Дата и время текущего визита визита: <strong>' . $currentAddFd . '</strong><br>';
$mail->Body .= 'Точка входа текущего визита: strong>' . $currentAddEp . '</strong><br>';
$mail->Body .= 'Реферер текущего визита: <strong>' . $currentAddRf . '</strong></p>';

$mail->Body .= '<h3 style="color:red">Данные о текущей сессии</h3>';
$mail->Body .= '<p>Сколько страниц сайта посмотрел посетитель: <strong>' . $sessionPgs . '</strong><br>';
$mail->Body .= 'URL текущей страницы посетителя: <strong>' . $sessionCpg . '</strong></p>';

$mail->Body .= '<h3 style="color:red">Личные данные</h3>';
$mail->Body .= '<p>Сколько раз пользователь посещал сайт: <strong>' . $udataVst . '</strong><br>';
$mail->Body .= 'Текущий ip-адрес: <strong>' . $udataUip . '</strong><br>';
$mail->Body .= 'Текущий браузер: <strong>' . $udataUag . '</strong></p>';

$mail->AltBody = 'Если клиент не поддерживает html';

if (!$mail->send()) {
    echo '0';
} else {
    echo '1';
}
?>