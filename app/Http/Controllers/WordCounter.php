<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordCounter extends Controller
{
    public function countWords(string $textContent): void
    {
        $textContent = $this->cleanText($textContent);

        $textContent = explode("\n", $textContent);
        foreach ($textContent as $word) {
            if (empty($word)) continue;
            $word = mb_strtolower($word);
            $word_model = (new Word)->firstOrCreate([
                'word' => $word,
            ]);

            $word_model->count = $word_model->count + 1;
            $word_model->save();
        }

        echo "done";
    }

    /**
     * @param string $textContent
     *
     * @return null|string|array|string[]
     */
    public function cleanText(string $textContent): string|array|null
    {
        $textContent = htmlentities($textContent, null, 'utf-8');
        $textContent = preg_replace('/&nbsp;/', "\n", $textContent);
        $textContent = preg_replace('~[^\p{Cyrillic}a-zA-Z\s-]+~ui', "\n", $textContent);
        $textContent = preg_replace('/[a-zA-Z0-9]/', "\n", $textContent);
        $textContent = preg_replace('~[^\p{Cyrillic}a-zA-Z\s-]+~ui', "\n", $textContent);
        $textContent = preg_replace('/[\t\-]/', "\n", $textContent);
        $textContent = preg_replace('/\\\u/', "\n", $textContent);
        $textContent = preg_replace('/\s+/', "\n", $textContent);
        $textContent = preg_replace('/\\\u/', "\n", $textContent);
        $textContent = preg_replace('/\n\n/', "\n", $textContent);
        $textContent = html_entity_decode($textContent);
        return trim($textContent);
    }
}
