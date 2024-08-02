<?php

namespace App\Livewire;

use App\Http\Controllers\Llama31Controller;
use App\Models\Word;
use Livewire\Component;

class WordViewer extends Component
{
    public Word $current;

    public function __construct()
    {
        $this->next();
    }

    public function next()
    {
        $this->current = (new Word)->query()->inRandomOrder()->first();
    }

    public function generateDescription()
    {
//        if(!empty($this->current->description)){
//            return;
//        }
        /** @var Llama31Controller $llama */
        $llama = app(Llama31Controller::class);
        $this->current->description = $llama->getSync("What is the meaning of the bulgarian word: \"{$this->current->word}\", describe it in at least 1 paragraph")['response'] ?? null;
        $this->current->save();
    }

    public function render()
    {
        return view('livewire.word-viewer');
    }
}
