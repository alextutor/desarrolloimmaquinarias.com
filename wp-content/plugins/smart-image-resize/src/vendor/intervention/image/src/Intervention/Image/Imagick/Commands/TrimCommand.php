<?php

namespace Intervention\Image\Imagick\Commands;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Imagick\Color;

class TrimCommand extends AbstractCommand {
    /**
     * Trims away parts of an image
     *
     * @param  \Intervention\Image\Image $image
     * @return boolean
     */
    public function execute($image) {
        $base = $this->argument(0)->type('string')->value();
        $away = $this->argument(1)->value();
        $tolerance = $this->argument(2)->type('numeric')->value(0);
        $feather = $this->argument(3)->type('numeric')->value(0);

        $width = $image->getWidth();
        $height = $image->getHeight();

        // define borders to trim away
        if (is_null($away)) {
            $away = ['top', 'right', 'bottom', 'left'];
        } elseif (is_string($away)) {
            $away = [$away];
        }

        // lower border names
        foreach ($away as $key => $value) {
            $away[$key] = strtolower($value);
        }

        // trim on clone to get only coordinates
        $trimed = clone $image->getCore();

        // trim image
        $trimed->trimImage(65850 / 100 * $tolerance);

        // get coordinates of trim
        $imagePage = $trimed->getImagePage();
        list($crop_x, $crop_y) = [$imagePage['x'], $imagePage['y']];

        list($crop_width, $crop_height) = [$trimed->width, $trimed->height];

        // adjust settings if right should not be trimed
        if (!in_array('right', $away)) {
            $crop_width = $crop_width + ($width - ($width - $crop_x));
        }

        // adjust settings if bottom should not be trimed
        if (!in_array('bottom', $away)) {
            $crop_height = $crop_height + ($height - ($height - $crop_y));
        }

        // adjust settings if left should not be trimed
        if (!in_array('left', $away)) {
            $crop_width = $crop_width + $crop_x;
            $crop_x = 0;
        }

        // adjust settings if top should not be trimed
        if (!in_array('top', $away)) {
            $crop_height = $crop_height + $crop_y;
            $crop_y = 0;
        }

        // add feather
        if ($feather) {
            $feather_x = min($feather, max(0, (($height - ($crop_height + $crop_y)) / 2)));
            $feather_y = min($feather, max(0, (($width - ($crop_width + $crop_x)) / 2)));
            $crop_width = min($width, ($crop_width + $feather_x * 2));
            $crop_height = min($height, ($crop_height + $feather_y * 2));
            $crop_x = max(0, ($crop_x - $feather_x));
            $crop_y = max(0, ($crop_y - $feather_y));
            $image->getCore()->cropImage($crop_width, $crop_height, $crop_x, $crop_y);
            $image->getCore()->setImagePage(0, 0, 0, 0);
            $trimed->destroy();
        } else {
            $trimed->setImagePage(0, 0, 0, 0);
            $image->setCore($trimed);
        }

        return true;
    }
}
