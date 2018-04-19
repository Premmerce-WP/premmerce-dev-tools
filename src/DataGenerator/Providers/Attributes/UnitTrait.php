<?php namespace Premmerce\DevTools\DataGenerator\Providers\Attributes;

trait UnitTrait
{


    protected $weightUnits = ['g', 'kg', 'lb', 'oz', 'pg', 'mg'];

    protected $lengthUnits = ['km', 'cm', 'm', 'mm', 'um', 'nm', 'in', 'ft', 'yd', 'mi'];

    protected $ciPrefixes = ['h', 'k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'];

    protected $clothesSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

    public function clothesSize() {
        return $this->generator->randomElement($this->clothesSizes);
    }

    public function lengthUnit() {
        return $this->generator->randomElement($this->lengthUnits);
    }

    public function weightUnit() {
        return $this->generator->randomElement($this->weightUnits);
    }


    public function ciPrefix() {
        return $this->generator->randomElement($this->ciPrefixes);
    }
}