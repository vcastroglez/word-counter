<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class OllamaController extends Controller
{
	protected string $model;
	private string $host;

	public function __construct()
	{
		$this->model = config('llm.ollama.model');
		$this->host = config('llm.ollama.host') . "/api/generate";
	}

	/**
	 * @param string $prompt
	 *
	 * @return mixed
	 * @throws GuzzleException
	 */
	public function getSync(string $prompt): mixed
	{

		$request = [
			'stream' => false,
			'model' => $this->model,
			'prompt' => $prompt,
			'keep_alive' => '5m',
		];

		$client = new Client();
		$response = $client->post($this->host, [
			'headers' => [
				'Content-type' => 'application/json'
			],
			'body' => json_encode($request),
		]);

		return json_decode($response->getBody()->getContents(), true);
	}

	/**
	 * @param string $word
	 *
	 * @return null|mixed
	 * @throws GuzzleException
	 */
	public function generateDescription(string $word): mixed
	{
		$prompt = $this->getPrompt($word);
		return $this->getSync($prompt)['response'] ?? null;
	}

	private function getPrompt(string $word): string
	{
		return "Describe the bulgarian word \"$word\" with 3 sections,
		the first section describing the pronunciation,
		the second section explaining the meaning
		and a 3rd section with 3 examples in bulgarian of use of the word and for each example the english sentence.
		Answer with only the 3 sections and in HTML format. Answer in english.";
	}
}
