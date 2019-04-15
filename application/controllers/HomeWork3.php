<?php
session_start();

class HomeWork3 extends Controller
{
    const PATH = 'C:\Users\Vladyslav\Documents';

    public function index()
    {
        $data = array_slice(scandir(self::PATH), 2);
        $_SESSION["current_path"] = self::PATH;
        $this->view->show('hw3_view.php', null, $data);
    }

    public function scanNewDirOrOpenFile()
    {
        $fileExtensions = ['txt', 'config', 'php'];
        $newPath = $_SESSION["current_path"] . '\\' . $_GET["path"];
        if ($newPath != self::PATH) {
            if (is_dir($newPath)) {
                $data = json_encode(array_slice(scandir($newPath), 1));
                $_SESSION["current_path"] = $newPath;
            } elseif (in_array(pathinfo($newPath, PATHINFO_EXTENSION), $fileExtensions)) {
                $data = json_encode(file_get_contents($newPath));
                $_SESSION["file_name"] = $newPath;
            } else {
                $data = json_encode("Can not read this file");
            }

        } else {
            $data = array_slice(scandir(self::PATH), 2);
            $_SESSION["current_path"] = $newPath;
        }

        echo $data;
    }

    public function clickBack()
    {
        $currentPath = $_SESSION["current_path"];
        $newPath = explode('\\', $currentPath);
        array_pop($newPath);
        $newPath = join('\\', $newPath);
        if ($newPath != self::PATH) {
            $data = json_encode(array_slice(scandir($newPath), 1));
        } else {
            $data = json_encode(array_slice(scandir(self::PATH), 2));
        }

        $_SESSION["current_path"] = $newPath;

        echo $data;
    }

    public function saveChanges()
    {
        $text = $_POST["text"];
        file_put_contents($_SESSION["file_name"], $text);
    }
}