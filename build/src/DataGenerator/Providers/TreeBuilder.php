<?php namespace Premmerce\DevTools\DataGenerator\Providers;

class TreeBuilder{
	public function toItemParent($tree, $addTopItems = true){
		$array = [];

		foreach($tree as $parent => $items){
			if($addTopItems){
				$array += [$parent => 0];
			}
			if(is_array($items)){
				$cip   = array_combine(array_keys($items), array_fill(0, count($items), $parent));
				$array += $cip;
				$array += $this->toItemParent($items, false);
			}
		}

		return $array;
	}

	public function createTree($items, $numLevels){

		if(empty($items)){
			return [];
		}
		$npl = $this->numPerLevel(count($items), $numLevels);

		$npl     = $npl > 0? $npl : count($items);
		$items   = array_fill_keys($items, []);
		$chunks  = array_chunk($items, $npl, true);
		$parents = array_shift($chunks);
		$tree    = $this->buildTree($parents, $chunks, $numLevels);


		return $tree;
	}

	public function findParent($tree, $el){
		foreach($tree as $parent => $items){
			if(array_key_exists($el, $items)){
				return $parent;
			}
			$parent = $this->findParent($items, $el);

			if($parent){
				return $parent;
			}
		}

		return null;
	}

	public function numPerLevel($count, $levels){
		if(1 === $levels){
			return $count;
		}
		if($levels >= $count){
			return 1;
		}
		$x = 2;
		while($x < 100){
			$num = ($x * (pow($x, $levels) - 1)) / ($x - 1);
			if($num >= $count){
				return $x;
			}
			$x ++;
		}
	}

	private function buildTree($parents, &$chunks, $level){

		if($level > 1){
			-- $level;
			foreach($parents as &$parent){
				if(empty($chunks)){
					return $parents;
				}else{
					$parent = $this->buildTree(array_shift($chunks), $chunks, $level);
				}
			}

			return $parents;
		}else{
			return $parents;
		}
	}


}