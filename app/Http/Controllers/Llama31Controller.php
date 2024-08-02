<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Llama31Controller extends Controller
{
    protected $model = 'llama3.1';
    private string $generation_path = "http://localhost:11434/api/generate";

    public function getSync(string $prompt)
    {

        $request = [
            'stream' => false,
            'model' => $this->model,
            'prompt' => $prompt,
            'keep_alive' => '5m',
        ];

        $client = new Client();
        $response = $client->post($this->generation_path, [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($request),
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
