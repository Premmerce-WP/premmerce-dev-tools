<?php namespace Premmerce\DevTools\DataGenerator\Providers;

use Faker\Provider\Base;

class MixProvider extends Base
{
    public function mixTwo($a, $b) {
        return substr($a, 0, round(strlen($a) / 2)) . substr($b, round(strlen($b) / 2));
    }

    public function mixThree($a, $b, $c) {

        $lenA = round(strlen($a) / 3);
        $lenB = round(strlen($b) / 3);
        $lenC = round(strlen($c) / 3);

        $result = substr($a, 0, $lenA) . substr($b, $lenB, $lenB) . substr($c, $lenC);

        return $result;
    }

    public function mixOne($a) {

        $lenA = round(strlen($a) / 2);

        $a = substr($a, $lenA) . substr($a, 0, $lenA);

        return $a;
    }

}