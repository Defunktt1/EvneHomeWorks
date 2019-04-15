<?php


use Vanderlee\Syllable\Syllable;

class HomeWork5 extends Controller
{
    const A = 206.835;
    const B = 1.015;
    const C = 84.6;

    const T1 = 15.16;
    const T2 = 14.66;
    const T3 = 14.16;


    public function index()
    {
        $this->view->show('hw5_view.php');
    }

    public function textAnalyz()
    {
        $text = $_POST["text"];
        $text = trim($text);
        $ending = substr($text, -1);

        if ($ending != '.' || $ending != '?' || $ending != '!')
        {
            $text .= '.';
        }

        $wordsCount = $this->getWordsCount($text);
        $sentencesCount = $this->getSentencesCount($text);
        $syllablesCount = $this->getSyllablesCount($text);
        $spaceCount = $this->getSpaceCount($text);
        $charCount = $this->getCharCount($text);
        $speed = $this->speedEstimate($charCount, $spaceCount);

        $response = [];
        $response["readability"] = $this->readabilityIndex($wordsCount, $sentencesCount, $syllablesCount);
        $response["speed"] = $speed;
        echo json_encode($response);
    }

    private function getWordsCount($text)
    {
        return str_word_count($text);
    }

    private function getSentencesCount($text)
    {
        preg_match_all('/[^\s](\.|\!|\?)(?!\w)/',$text,$matches);
        return count($matches[0]);
    }

    private function getSyllablesCount($text)
    {
        $syllable = new Syllable('en-us');
        return $syllable->countSyllablesText($text);
    }

    private function readabilityIndex($words, $sentences, $syllables)
    {
        $index =  self::A - self::B * ($words / $sentences) - self::C * ($syllables / $words);
        if ($index > 100) {
            $index = 100;
        } elseif ($index < 0) {
            $index = 0;
        }

        return round($index, 2);
    }

    private function speedEstimate($symbols, $spaces)
    {
        $estimates = [];
        $tc = $symbols - $spaces;
        $estimates[] = round($tc / self::T1, 2);
        $estimates[] = round($tc / self::T2, 2);
        $estimates[] = round($tc / self::T3, 2);

        return $estimates;
    }

    private function getSpaceCount($text)
    {
        $spaceCounter = 0;
        $chars = str_split($text);
        foreach ($chars as $char) {
            if ($char == ' ') {
                $spaceCounter++;
            }
        }

        return $spaceCounter;
    }

    private function getCharCount($text)
    {
        return strlen($text);
    }
}
