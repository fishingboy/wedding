<?php


class Tool_serv
{
    private $CI;

    public function __construct()
    {
        $this->CI = & get_instance();

    }

    public function getPhotos()
    {
        $dir = opendir("images/photos");
        $photos = [];
        while ($f = readdir($dir)) {
            if ($f == "." || $f == "..") {
                continue;
            }
            $file = "images/photos/" . $f;
            $size = getimagesize($file);
            $type = ($size[0] > $size[1]) ? 'horizontal' : 'straight';
            $photos[] = [
                'type' => $type,
                'file' => "/$file",
                'width' => $size[0],
                'height' => $size[1],
            ];
        }
        return $photos;
    }
}

