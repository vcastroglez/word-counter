<?php

namespace App\Livewire;

use App\Http\Controllers\OllamaController;
use App\Models\Word;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class WordViewer extends Component
{
    public Word $current;
	public int $index = 0;
	public int $frequency;

    public function __construct()
    {
		$session_index = Session::get("word_index");
		$this->index = $session_index ?? 0;
		$this->init();
    }

	private function init(): void
	{
		Session::put("word_index", $this->index);
		$this->current = (new Word)->query()->orderBy('count', 'DESC')->skip($this->index)->first();
		$percent = ($this->current->count / (new Word)->sum('count')) * 100;
		$this->frequency = round($percent, 2);
		if ($this->current->description){
			$this->generateDescription();
		}
	}

	/**
	 * @return void
	 */
	public function prev(): void
	{
		$this->index = max(0, $this->index - 1);
		$this->init();
	}

	/**
	 * @return void
	 */
	public function next(): void
	{
		$this->index ++;
		$this->init();
	}

	/**
	 * @return void
	 * @throws GuzzleException
	 */
	public function generateDescription(): void
	{
        /** @var OllamaController $llama */
        $llama = app(OllamaController::class);
        $this->current->description = $llama->generateDescription($this->current->word);
        $this->current->save();
    }

    public function render()
    {
        return view('livewire.word-viewer');
    }
}
