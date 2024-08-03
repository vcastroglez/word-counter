<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AnythingController extends Controller
{
	/**
	 * @return void
	 * @throws GuzzleException
	 * @throws Exception
	 */
	public function auth(): void
	{
		$endpoint = "/v1/auth";
		$response = $this->call($endpoint);
		if (!$response['authenticated']) {
			throw new Exception("Something went wrong authenticating to AnythingLLM");
		}
	}

	/**
	 * @return array
	 * @throws GuzzleException
	 */
	public function getWorkspace(): array
	{
		$this->auth();
		$endpoint = '/v1/workspace/'.config('llm.anything.workspace');
		$response = $this->call($endpoint);

		return $response['workspace'][0] ?? $this->createWorkspace();
	}

	/**
	 * @param string $endpoint
	 * @param string $method
	 * @param array  $body
	 * @param bool   $use_key
	 *
	 * @return mixed
	 * @throws GuzzleException
	 */
	private function call(string $endpoint, string $method = 'GET', array $body = [], bool $use_key = true)
	{
		$client = new Client();
		$headers = [
			'Content-Type' => 'application/json',
			'Accept' => 'application/json',
		];

		if ($use_key) {
			$headers['Authorization'] = "Bearer " . config('llm.anything.api_key');
		}
		$port = config('llm.anything.port');
		$uri = config('llm.anything.host') . ":$port" . "/api$endpoint";
		$response = $client->request($method, $uri, [
			'headers' => $headers,
			'body' => json_encode($body)
		]);

		return json_decode($response->getBody()->getContents(), true);
	}

	/**
	 * @return mixed
	 * @throws GuzzleException
	 */
	private function createWorkspace(): array
	{
		$name = config('llm.anything.workspace');
		$endpoint = '/v1/workspace/new';

		$response = $this->call($endpoint, 'POST', ['name' => $name]);
		return $response['workspace'];
	}
}
