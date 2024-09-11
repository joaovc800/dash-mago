<?php

class Hash
{

    private static $secretKey;

    public static function secret($key)
    {
        self::$secretKey = $key;
    }

    public static function encrypt($content)
    {
        $secretKey = self::$secretKey ?? 'jcçe%6a!1gk5!d5ddgçha#1@7@#317$f';

        try {
            if (empty($secretKey)) throw new \Exception("The secret key is empty use the secret method to set the value", 1);

            $bytes = openssl_random_pseudo_bytes(16);

            $encryptedText = openssl_encrypt($content, 'aes-256-cbc', $secretKey, 0, $bytes);

            $encrypted = $bytes . $encryptedText;

            return base64_encode($encrypted);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public static function decrypt($content)
    {
        $secretKey = self::$secretKey ?? 'jcçe%6a!1gk5!d5ddgçha#1@7@#317$f';

        try {
            if (empty($secretKey)) throw new \Exception("The secret key is empty use the secret method to set the value", 2);

            $content = base64_decode($content);

            $bytes = substr($content, 0, 16);

            $encryptedText = substr($content, 16);

            $decryptedText = openssl_decrypt($encryptedText, 'aes-256-cbc', $secretKey, 0, $bytes);

            return $decryptedText;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}