<?php namespace Premmerce\DevTools\DataGenerator\Providers\Attributes;

trait ProcessorTrait
{

    protected $processorManufacturer = [
        'Intel',
        'AMD',
        'Qualcomm',
        'MediaTek',
        'ARM',
        'Atmel',
        'NVIDIA',
        'VIA',
        'IBM',
        'Cyrix',
    ];

    protected $processorModel = [
        'Core',
        'Celeron',
        'Pentium',
        'Xeon',
        'Atom',
        'Athlon',
        'Turion',
        'Phenom',
        'Sempron',
        'Snapdragon',
    ];

    protected $processorVersion = [
        'i#',
        'A#',
        'S#',
        '{{versionArabic}}',
        '####',
    ];

    protected $arabicNumbers = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X',];

    public function processorName() {
        $name = $this->processorManufacturer();
        $model = '';
        $version = '';

        if ($this->generator->boolean) {
            $model = ' ' . $this->processorModel();
        }

        if ($this->generator->boolean) {
            $version = ' ' . $this->processorVersion();
        }


        return $name . $model . $version;
    }


    public function processorManufacturer() {
        return $this->generator->boolean ? $this->processorManufacturerReal() : $this->processorManufacturerFake();
    }

    public function processorModel() {
        return $this->generator->boolean ? $this->processorModelReal() : $this->processorModelFake();
    }

    public function processorVersion() {
        $version = $this->generator->randomElement($this->processorVersion);
        $version = $this->generator->parse($version);
        $version = $this->generator->bothify($version);

        return $version;
    }

    public function processorModelReal() {
        return $this->generator->randomElement($this->processorModel);
    }

    public function processorManufacturerReal() {
        return $this->generator->randomElement($this->processorManufacturer);
    }


    public function processorManufacturerFake() {
        return $this->generator->mixTwo($this->processorManufacturerReal(), $this->processorManufacturerReal());
    }

    public function processorModelFake() {
        return $this->generator->mixTwo($this->processorModel(), $this->processorModel());
    }

    public function versionArabic() {
        return $this->generator->randomElement($this->arabicNumbers);
    }
}