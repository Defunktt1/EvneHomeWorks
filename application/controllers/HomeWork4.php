<?php

use application\models\News;

class HomeWork4 extends Controller
{
    const LIGA = "https://www.liga.net/news/rss.xml";

    public function index()
    {
        $news = new News();

        $liga = file_get_contents(self::LIGA);
        $xml = new SimpleXMLElement($liga);

        foreach($xml->channel->item as $entry) {
            $description = $entry->description;
            $title = $entry->title;
            $link = $entry->link;
            $date = $entry->pubDate;
            $image = $entry->enclosure->attributes()->url;
            $html = file_get_contents($link);

            $htmlCode = file_get_contents($link);
            $doc = new DOMDocument();
            $doc->loadHTML($htmlCode);
            $links = [];
            foreach ($doc->getElementsByTagName('meta') as $element) {
                if ($element->hasAttribute('name')) {
                $links[] = $element->getAttribute('content');
                }
            }
            echo '<pre>';
            var_dump($links);
            echo '</pre>';
            die;
        }
    }
}