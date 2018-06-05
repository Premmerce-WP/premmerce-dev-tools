<?php namespace Premmerce\DevTools\DataGenerator\Providers\Attributes;

trait DisplayTrait
{
    protected $display = [
        'LED',
        'RED',
        'IPS',
        'Backlit',
        'Screen',
        'LCD',
        'TFT',
        'Plasma',
        'Liquid',
        'Laser',
        'Quantum',
        'AMOLED',
        'OLED',
        'Retina',
        'Glass',
    ];

    public function aspectRatio($glue = ':') {
        return implode($glue, $this->aspectRatioArray());
    }


    public function aspectRatioX() {
        return $this->aspectRatio('x');
    }

    public function aspectRatioArray($min = 3, $max = 21) {
        return [
            $this->generator->numberBetween($min, $max),
            $this->generator->numberBetween($min, $max),
        ];
    }

    public function resolution() {
        $ar = $this->aspectRatioArray();
        $base = $this->powTwo();

        return $ar[0] * $base . 'x' . $ar[1] * $base;

    }

    public function displayType() {
        return $this->prefix() . ' ' . $this->generator->randomElement($this->display) . ' ' . $this->suffix();
    }


    public function sizeX() {
        return implode('x', $this->aspectRatioArray(1, 1000));

    }


}