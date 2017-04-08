<?php

namespace AppBundle\Helpers;

use Symfony\Component\Filesystem\Filesystem;

class PDFHelper
{
    CONST EXTENSION = 'pdf';

    public static function isPdf($extension)
    {
        return self::EXTENSION === $extension;
    }

    public static function createPdfThumbnail($directory, $uuid)
    {
        $im = new \Imagick();
        $im->setResolution(300, 300);
        $im->readImage($directory . '/' . $uuid . '.pdf[0]');
        $im->trimImage(0); // trim white space
        $width = $im->getImageWidth();
        $height = $im->getImageHeight();
        switch ($width) {
            case $width >= 450:
                if ($height < $width / 1.5) {
                    $im->borderImage('white', 0, ($width - $height) / 2);
                    $im->cropImage($width / 2, $width / 2, 0, 0);
                }
                break;
            default:
                $im->borderImage('white', (450 - $width) / 2, (450 - $height) / 2);
                break;
        }
        $im->setImageFormat('jpeg');

        file_put_contents($directory . '/' . $uuid . '.jpg', $im);
    }
}