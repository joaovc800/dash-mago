<?php

class MailService{

    static function send($to, $subject, $content, $cc = []){
        $from = 'mago@iamonstro.com.br';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: ". mb_encode_mimeheader("Não Responda") . " <$from>" . "\r\n";

        if(count($cc) > 0){
            $cc = implode(', ', $cc);
            $headers .= "Cc: $cc\r\n";
        }

        return mail($to, $subject, $content, $headers);
        
    }

    static function sendWithAttachment($to, $subject, $content, $attachment, $cc = []){
        $from = 'mago@iamonstro.com.br';

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";
        $headers .= "From: ". mb_encode_mimeheader("Não Responda") . " <$from>" . "\r\n";

        if(count($cc) > 0){
            $cc = implode(', ', $cc);
            $headers .= "Cc: $cc\r\n";
        }

        $message = "--boundary\r\n";
        $message .= "Content-Type: text/plain; charset=\"utf-8\"\r\n";
        $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $message .= $content . "\r\n\r\n";
        $message .= "--boundary\r\n";
        $message .= "Content-Type: application/pdf; name=\"" . basename($attachment['name']) . "\"\r\n";
        $message .= "Content-Disposition: attachment; filename=\"" . basename($attachment['name']) . "\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $message .= $attachment['attachment'] . "\r\n\r\n";
        $message .= "--boundary--\r\n";

        return mail($to, $subject, $message, $headers);
        
    }

}