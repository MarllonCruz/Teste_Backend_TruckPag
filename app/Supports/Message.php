<?php

namespace App\Supports;

class Message
{
    public function success(string $text)
    {
        return ['success' => $text];
    }

    public function error(string $text)
    {
        return [
            'errors' => [
                'main' => $text
            ]
        ];
    }
}