<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

class GmailService
{
    public static function send(
        $to,
        $subject,
        $body,
        $attachmentPath = null
    ) {
        try {

            if (!$to) {
                throw new \Exception('Email tujuan kosong');
            }

            $client = new Client();

            $client->setAuthConfig(
                storage_path('app/google/credentials.json')
            );

            $client->addScope(Gmail::GMAIL_SEND);

            $tokenPath = storage_path(
                'app/google/token.json'
            );

            if (!file_exists($tokenPath)) {
                throw new \Exception(
                    'token.json tidak ditemukan'
                );
            }

            $token = json_decode(
                file_get_contents($tokenPath),
                true
            );

            $client->setAccessToken($token);

            if ($client->isAccessTokenExpired()) {

                if (!$client->getRefreshToken()) {
                    throw new \Exception(
                        'Refresh token tidak ditemukan'
                    );
                }

                $client->fetchAccessTokenWithRefreshToken(
                    $client->getRefreshToken()
                );

                file_put_contents(
                    $tokenPath,
                    json_encode(
                        $client->getAccessToken(),
                        JSON_PRETTY_PRINT
                    )
                );
            }

            $gmail = new Gmail($client);

            /*
            |--------------------------------------------------------------------------
            | EMAIL TANPA ATTACHMENT
            |--------------------------------------------------------------------------
            */

            if (
                !$attachmentPath ||
                !file_exists($attachmentPath)
            ) {

                $rawMessage =
                    "To: {$to}\r\n" .
                    "Subject: {$subject}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: text/plain; charset=UTF-8\r\n\r\n" .
                    $body;
            }

            /*
            |--------------------------------------------------------------------------
            | EMAIL DENGAN ATTACHMENT
            |--------------------------------------------------------------------------
            */
            else {

                $boundary = uniqid('boundary');

                $fileName = basename($attachmentPath);

                $mimeType =
                    mime_content_type($attachmentPath);

                $fileData = chunk_split(
                    base64_encode(
                        file_get_contents(
                            $attachmentPath
                        )
                    )
                );

                $rawMessage =
                    "To: {$to}\r\n" .
                    "Subject: {$subject}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n\r\n";

                // BODY EMAIL
                $rawMessage .=
                    "--{$boundary}\r\n" .
                    "Content-Type: text/plain; charset=UTF-8\r\n" .
                    "Content-Transfer-Encoding: 7bit\r\n\r\n" .
                    $body . "\r\n\r\n";

                // ATTACHMENT
                $rawMessage .=
                    "--{$boundary}\r\n" .
                    "Content-Type: {$mimeType}; name=\"{$fileName}\"\r\n" .
                    "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n" .
                    "Content-Transfer-Encoding: base64\r\n\r\n" .
                    $fileData . "\r\n\r\n";

                // END BOUNDARY
                $rawMessage .=
                    "--{$boundary}--";
            }

            $encodedMessage = rtrim(
                strtr(
                    base64_encode($rawMessage),
                    '+/',
                    '-_'
                ),
                '='
            );

            $message = new Message();
            $message->setRaw($encodedMessage);

            $gmail->users_messages->send(
                'me',
                $message
            );

            \Log::info(
                'EMAIL BERHASIL KE: ' . $to
            );

            if ($attachmentPath) {

                \Log::info([
                    'attachment' => $attachmentPath,
                    'exists' => file_exists(
                        $attachmentPath
                    ),
                ]);
            }

            return true;

        } catch (\Exception $e) {

    dd([
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
    ]);

}
    }
}