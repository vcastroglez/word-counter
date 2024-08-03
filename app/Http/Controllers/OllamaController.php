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
			'options' => [
				'temperature'=> 0.2,
			]
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
		$base_prompt = "Describe the bulgarian word \"$word\" with 3 sections,
		the first section with a header with the text \"Pronunciation\" and wrapped in <h2>  describing the pronunciation,
		the second section with a header with the text \"Meaning\" and wrapped in <h2>  describing the meaning,
		and a third section with a header with the text \"Examples\" and wrapped in <h2> with 3 examples in bulgarian of the use of the word and for each example the related english sentence.
		Answer with only the 3 sections and in HTML format. Answer in english and exactly what I order.";
		if(strlen($word) <= 2){
			$base_prompt .= "It is a word.";
		}

		return $base_prompt;
	}
}
