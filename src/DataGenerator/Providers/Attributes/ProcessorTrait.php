<?php namespace Premmerce\DevTools\DataGenerator\Providers\Attributes;

trait ProcessorTrait{

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
		'i{{versionOdd}}',
		'A{{versionEven}}',
		'S{{versionNum}}',
		'{{versionArabic}}',
		'{{versionHS}}',
	];

	public function processorName(){
		$name    = $this->processorManufacturer();
		$model   = '';
		$version = '';

		if($this->generator->boolean){
			$model = ' ' . $this->processorModel();
		}

		if($this->generator->boolean){
			$version = ' ' . $this->processorVersion();
		}


		return $name . $model . $version;
	}


	public function processorManufacturer(){
		return $this->generator->boolean? $this->processorManufacturerReal() : $this->processorManufacturerFake();
	}

	public function processorModel(){
		return $this->generator->boolean? $this->processorModelReal() : $this->processorModelFake();
	}

	public function processorVersion(){
		$version = self::randomElement($this->processorVersion);
		$version = $this->generator->parse($version);

		return $version;
	}

	public function processorModelReal(){
		return self::randomElement($this->processorModel);
	}

	public function processorManufacturerReal(){
		return self::randomElement($this->processorManufacturer);
	}


	public function processorManufacturerFake(){
		return $this->generator->mixTwo($this->processorManufacturerReal(), $this->processorManufacturerReal());
	}

	public function processorModelFake(){
		return $this->generator->mixTwo($this->processorModel(), $this->processorModel());
	}
}