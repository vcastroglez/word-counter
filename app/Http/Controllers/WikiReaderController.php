<?php

namespace App\Http\Controllers;

use DOMElement;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class WikiReaderController extends Controller
{
    public function __construct(protected WordCounter $counter)
    {
    }

    public function index(Request $request)
    {
        $times = $request->get('times', 1);
        for ($i = 0; $i < $times; $i++) {
            $this->countWordsInRandomArticle();
            sleep(2);
        }
    }

    public function stripTagContent($text): array|string|null
    {
        return preg_replace('/<[^<]+?>/', '', $text);
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function countWordsInRandomArticle(): void
    {
        $random_url = "https://bg.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B5%D1%86%D0%B8%D0%B0%D0%BB%D0%BD%D0%B8:%D0%A1%D0%BB%D1%83%D1%87%D0%B0%D0%B9%D0%BD%D0%B0_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0";

        $content = (new Client())->get($random_url);
        $html_content = $content->getBody()->getContents();
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html_content);
        $finder = new \DOMXPath($dom);
        $classname = "mw-content-ltr";
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        /** @var DOMElement $node */
        foreach ($nodes as $node) {
            $this->counter->countWords($node->textContent);
        }
    }
}
