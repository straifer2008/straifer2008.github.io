<?php

$tel = strip_tags(htmlspecialchars($_POST['tel']));

$login = 'fastcoll@sevenkids.site'; // замените test@domain.tld на адрес электронной почты, с которого производится отправка. Поскольку логин совпадает с адресом отправителя - данная переменная используется и как логин, и как адрес отправителя.

$password = 'fastcoll2018';  // Замените 'password' на пароль от почтового ящика, с которого производится отправка.
$to = 'seven.kids.ua@gmail.com';  // замените to@domain.tld на адрес электронной почты получателя письма.
$text='Номер телефона клиента: '.$tel;  // Содержимое отправляемого письма
function get_data($smtp_conn)  // функция получения кода ответа сервера.
{
    $data="";
    while($str = fgets($smtp_conn,515))
    {
        $data .= $str;
        if(substr($str,3,1) == " ") { break; }
    }
    return $data;
}
// формируем служебный заголовок письма.
$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n";
$header.="From: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode("SEVENKIDS.SITE")))."?= <$login>\r\n";
$header.="X-Mailer: Test script hosting Ukraine.com.ua \r\n";
$header.="Reply-To: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode("Прозьба передзвонить клиенту")))."?= <$login>\r\n";
$header.="X-Priority: 3 (Normal)\r\n";
$header.="Message-ID: <12345654321.".date("YmjHis")."@ukraine.com.ua>\r\n";
$header.="To: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode('Получателю тестового письма')))."?= <$to\r\n";
$header.="Subject: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode("Прозьба передзвонить клиенту с 'sevenkids.site'")))."?=\r\n";
$header.="MIME-Version: 1.0\r\n";
$header.="Content-Type: text/plain; charset=UTF-8\r\n";
$header.="Content-Transfer-Encoding: 8bit\r\n";
$smtp_conn = fsockopen("mail.ukraine.com.ua", 25,$errno, $errstr, 10); //соединяемся с почтовым сервером mail.ukraine.com.ua , порт 25 .
if(!$smtp_conn) {print "соединение с серверов не прошло"; fclose($smtp_conn); exit;}
$data = get_data($smtp_conn);
fputs($smtp_conn,"EHLO mail.ukraine.com.ua\r\n"); // начинаем приветствие.
$code = substr(get_data($smtp_conn),0,3); // проверяем, не возвратил ли сервер ошибку.
if($code != 250) {print "ошибка приветсвия EHLO"; fclose($smtp_conn); exit;}
fputs($smtp_conn,"AUTH LOGIN\r\n"); // начинаем процедуру авторизации.
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "сервер не разрешил начать авторизацию"; fclose($smtp_conn); exit;}

fputs($smtp_conn,base64_encode("$login")."\r\n"); // отправляем серверу логин от почтового ящика (на хостинге "Украина" он совпадает с именем почтового ящика).
$code = substr(get_data($smtp_conn),0,3);
if($code != 334) {print "ошибка доступа к такому юзеру"; fclose($smtp_conn); exit;}

fputs($smtp_conn,base64_encode("$password")."\r\n");       // отправляем серверу пароль.
$code = substr(get_data($smtp_conn),0,3);
if($code != 235) {print "неправильный пароль"; fclose($smtp_conn); exit;}

fputs($smtp_conn,"MAIL FROM:$login\r\n"); // отправляем серверу значение MAIL FROM.
$code = substr(get_data($smtp_conn),0,3);
if($code != 250) {print "сервер отказал в команде MAIL FROM"; fclose($smtp_conn); exit;}

fputs($smtp_conn,"RCPT TO:$to\r\n"); // отправляем серверу адрес получателя.
$code = substr(get_data($smtp_conn),0,3);
if($code != 250 AND $code != 251) {print "Сервер не принял команду RCPT TO"; fclose($smtp_conn); exit;}

fputs($smtp_conn,"DATA\r\n"); // отправляем команду DATA.
$code = substr(get_data($smtp_conn),0,3);
if($code != 354) {print "сервер не принял DATA"; fclose($smtp_conn); exit;}

fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n"); // отправляем тело письма.
$code = substr(get_data($smtp_conn),0,3);

if($code != 250) {print "ошибка отправки письма"; fclose($smtp_conn); exit;}
if($code == 250) {
    require 'index.html';
}

fputs($smtp_conn,"QUIT\r\n");   // завершаем отправку командой QUIT.
fclose($smtp_conn); // закрываем соединение.
?>