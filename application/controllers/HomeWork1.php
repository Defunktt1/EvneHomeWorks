<?php

use application\models\Search;
use application\models\Text;


class HomeWork1 extends Controller
{
    public function index()
    {
        $text = new Text();
        $text = $text->all();

        $searches = new Search();
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }

        $searches = $searches->paginate($page);
        $data = ['text' => $text, 'searches' => $searches];

        $this->view->show('hw1_view.php', null, $data);
    }

//    public function get()
//    {
//        $searches = new Search();
//        var_dump(json_encode($searches->all()));
//    }

    public function updated()
    {
        // get text from database
        $text = new Text();
        $text = $text->all();
        $text = $text[0]['text'];

        $query = $_POST["query"];


        $queries = [];
        $colors = ['yellow', 'silver', 'blue', 'green', 'pink', 'purple', 'red'];

        if ($query[0] == '"' && $query[strlen($query) - 1] == '"') {
             $queries[] = trim($query, '"'); // remove "" from query
        } else { // or split query by space
            $queries = explode(' ', $query);
        }

        $index = 0; // this index for color picker :/
        $totalMatchesCount = 0;
        foreach ($queries as $singleQuery) {
            $pattern = '/(' . $singleQuery . ')/i'; // set the regex pattern. 'i' means ignore case :)
            preg_match_all($pattern, $text, $matches); // get count of matches
            $matchesCount = count($matches[0]);
            for ($i = $matchesCount - 1; $i >= 0; $i--) { // we are starting from end, because after adding <span> our indexes in 'preg_match_all' will changed
                preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE); // PREG_OFFSET_CAPTURE set all matches in array with index
                $text = substr_replace($text, '</span>', $matches[0][$i][1] + strlen($singleQuery), 0);
                $text = substr_replace($text, '<span style="background-color:' . $colors[$index] . '">', $matches[0][$i][1], 0);
                $totalMatchesCount++;
            }
            $index++;
        }

        // save query to database
        $searches = new Search();
        $searches->insert(htmlspecialchars($query), $totalMatchesCount);

        echo $text;
    }

    public function getAll()
    {
        $searches = new Search();
        $searches = $searches->all();

        print_r(json_encode($searches));
    }
}