<?php namespace Premmerce\DevTools\DataGenerator\Providers;


use Faker\Provider\Base;

class ExplodeProvider extends Base{

	public function explodeNumber($input, $parts){
		$avg = $input / $parts;

		$temp = [];
		if($parts <= 1){
			$temp [] = $input;
		}else{
			for($i = 1;$i < $parts;$i ++){
				$max = ceil($avg * 1.3);
				$min = ceil($avg * 0.3);
				$max = $max > $input? $input : $max;
				$min = $min > $input? $input : $min;

				$num = rand($min, $max);

				$input      -= $num;
				$temp[ $i ] = $num;

			}
			$temp[] = $input;

		}

		return $temp;
	}

	public function explodeArray($array, $parts){
		$numbers = $this->explodeNumber(count($array), $parts);

		$explodes = [];

		$keys = array_keys($array);

		foreach($numbers as $num){
			$sliceKeys = array_slice($keys, 0, $num);
			$keys      = array_slice($keys, $num);
			$part      = [];
			foreach($sliceKeys as $sliceKey){
				$part[ $sliceKey ] = $array[ $sliceKey ];
			}
			$explodes[] = $part;
		}

		return $explodes;
	}
}