<?php
/**
 * Created by PhpStorm.
 * User: Imen
 * Date: 20/08/2018
 * Time: 16:27
 */

//mail('asmatest0@gmail.com', "confirmation de votre compte", "A fin de valider votre compte merci de cliquer sur ce lien");

//$to = "asmatest0@gmail.com";
//$subject = "confirmation de votre compte";
//$message = "A fin de valider votre compte merci de cliquer sur ce lien";
////$headers = "From: webmaster@example.com" . "\r\n" .
////"CC: somebodyelse@example.com";
//
//mail($to,$subject,$message);


//$headers =  'MIME-Version: 1.0' . "\r\n";
//$headers .= 'From: Your name <asmatest0@gmail.com>' . "\r\n";
//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//
//mail($to, $subject, $body, $headers);


$header = "MIME-Version: 1.0\r\n";
$header.= 'From:<asmatest0@gmail.com>'."\n";
$header.= 'Content-Type: text/html; charset="UTF-8"'."\n";
$header.= 'Content-Transfer-Encoding:8bit';

