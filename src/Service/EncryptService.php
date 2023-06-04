<?php
namespace App\Service;

use Symfony\Component\String\ByteString;

class EncryptService
{
    public function encodeDataWithSignature(string $data, string $secretKey): string
    {
        $timestamp = time() + 300; // Ajouter 5 minutes (300 secondes)
        $dataWithTimestamp = $timestamp . '|' . $data;
        $signature = hash_hmac('sha256', $dataWithTimestamp, $secretKey, true);
        $encodedData = rtrim(strtr(base64_encode($dataWithTimestamp . $signature), '+/', '-_'), '=');

        return $encodedData;
    }

    public function decodeDataWithSignature(string $encodedData, string $secretKey): string
    {
        $decodedData = base64_decode(str_pad(strtr($encodedData, '-_', '+/'), strlen($encodedData) % 4, '=', STR_PAD_RIGHT));
        $dataWithTimestamp = substr($decodedData, 0, -32); 
        $signature = substr($decodedData, -32);

        // Verify the signature
        $expectedSignature = hash_hmac('sha256', $dataWithTimestamp, $secretKey, true);
        if (!hash_equals($expectedSignature, $signature)) {
           
            throw new \RuntimeException('Lien invalide');
        }

        $parts = explode('|', $dataWithTimestamp);
        $timestamp = (int) $parts[0];
        $data = $parts[1];

        if (time() > $timestamp) {
            // Le délai de 5 minutes est dépassé, les données ne sont plus valides
            throw new \RuntimeException('lien expiré');
        }

        return $data;
    }
}