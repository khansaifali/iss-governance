<?php

namespace Image;

interface ModeInterface
{
    public function resize($imageA, $imageB);
}

class ContainMode implements ModeInterface
{
    public function resize($imageA, $imageB)
    {
        $ratioA = $imageA['width'] / $imageA['height'];
        $ratioB = $imageB['width'] / $imageB['height'];

        if ($ratioA < $ratioB) {
            $scaledWidth = $imageA['height'] * $ratioB;
            $scaledHeight = $imageA['height'];
        } else {
            $scaledWidth = $imageA['width'];
            $scaledHeight = $imageA['width'] / $ratioB;
        }

        return ['width' => round($scaledWidth, 2), 'height' => round($scaledHeight, 2)];
    }
}

class CoverMode implements ModeInterface
{
    public function resize($imageA, $imageB)
    {
        $ratioA = $imageA['width'] / $imageA['height'];
        $ratioB = $imageB['width'] / $imageB['height'];

        if ($ratioA > $ratioB) {
            $scaledWidth = $imageA['height'] * $ratioB;
            $scaledHeight = $imageA['height'];
        } else {
            $scaledWidth = $imageA['width'];
            $scaledHeight = $imageA['width'] / $ratioB;
        }

        return ['width' => round($scaledWidth, 2), 'height' => round($scaledHeight, 2)];
    }
}

class CalculateImageSize
{
    private $imageA;
    private $imageB;

    public function __construct($imageA, $imageB)
    {
        $this->imageA = $imageA;
        $this->imageB = $imageB;
    }

    public function implementModes(ModeInterface $mode)
    {
        $scaledImageB = $mode->resize($this->imageA, $this->imageB);
        echo get_class($mode)."\n";
        echo "w:{$scaledImageB['width']}, h:{$scaledImageB['height']}\n\n";
    }
}

$imageA = ['width' => 250, 'height' => 500];
$imageB = ['width' => 500, 'height' => 90];

$calculator = new CalculateImageSize($imageA, $imageB);

$containMode = new ContainMode();
$calculator->implementModes($containMode);
$coverMode = new CoverMode();
$calculator->implementModes($coverMode);

?>
