<?php

return [
	'anything' => [
		'api_key' => env('ANYTHING_LLM_API_KEY'),
		'host' => env('ANYTHING_LLM_HOST', 'http://localhost'),
		'port' => env('ANYTHING_LLM_PORT', 3001),
		'workspace' => env('ANYTHING_LLM_WORKSPACE', 'learn-bulgarian'),
	],
	'ollama' => [
		'host' => env('OLLAMA_HOST', 'http://localhost:11434'),
		'model' => env('OLLAMA_MODEL', 'llama3.1:8b-instruct-q8_0'),
	]
];
