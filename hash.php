<?php

class Entry{
	public $_key;
	public $_value;

	function  __construct($_key=NULL, $_value=NULL){
		$this->key = $_key;
		$this->value = $_value;
	}
}

class HashTable{

	function  __construct($maxSize=97){
		$this->maxSize = $maxSize;
		$this->size = 0;
		$this->slot = array_fill(0, $this->maxSize, new Entry());
	}

	function hash($key){
		// $h=0;
		// $a=31;
		// $i=0;
		// //$str = strval($key);
		// //for ($i=0; isset($str[$i]); $i++) { 
		// while ( isset($key[$i])) {
		// 	$i++;
		// 	$b=&$key
		// 	$h=$h*$a + ;
		// }
		return md5($key);
	}

	function find($key){
		$i = $this->hash($key)%$this->maxSize;
		while ($this->slot[$i]->key!= NULL && $this->slot[$i]->key!=$key) {
			$i = ($i+1)%$this->maxSize;
		}
		return $i;
	}

	function resize($size){
		for ($i=0; $i < $size-$this->maxSize; $i++) { 
			array_push($this->slot, new Entry());
		}
		$this->maxSize = $size;
	}

	function set($key, $value){
		$i = $this->find($key);
		if ($this->size/$this->maxSize<0.7) {
			$this->slot[$i]= new Entry($key, $value);
			$this->size++;
		}
		else{
			$this->resize($this->maxSize*2);
			$this->set($key, $value);
		}

	}

	function get($key){
		$i =$this->find($key);
		if ($this->slot[$i]->value==NULL) {
			return NULL;
		}
		else{
			return $this->slot[$i]->value;
		}
	}

	function remove($key){
		$i = $this->find($key);
		if($this->slot[$i]->key!= NULL){
			//$this->slot[$i] = NULL;
			$flag=TRUE;
			$h=$i;
			while ($flag) {
				$j=$i;
				$hash=$this->hash($key);
				while ($this->slot[$j]->key!=NULL) {
					$j=($j+1)%$this->maxSize;
					if ($this->hash($this->slot[$j]->key)==$hash)
						$h = $j;
				}
				if ($h==$i)
					$flag= FALSE;
				$key=$this->slot[$h]->key;
				$this->slot[$i]=$this->slot[$h];
				$this->slot[$i]=new Entry();
				$i=$h;
			}
			$this->size--;
		}
	}
}

function Test(){
	$t = new HashTable();
	$text = "YEAR OF GLAD. I am seated in an office, surrounded by heads and bodies. My posture is consciously congruent to the shape of my hard chair. This is a cold room in University Administration, wood-walled, Remington-hung, double-windowed against the November heat, insulated from Administrative sounds by the reception area outside, at which Uncle Charles, Mr. deLint and I were lately received.";
	$arr=explode(" ", $text);
	foreach ($arr as $item) {
		$item = (string)$item;
	}
	for ($i=0; $i<sizeof($arr); $i++) { 
	 	$t->set($arr[$i], $i);
	}
	$res = array();
	foreach ($arr as $item) {
		array_push($res, $t->get($item));
	}
	print_r($res);
	for ($i=0; $i<10; $i++) { 
	 	$t->remove($arr[$i]);
	}
	foreach ($arr as $item) {
		array_push($res, $t->get($item));
	}
	print_r($res);
 }

Test();
// $slot = array_fill(0, 50, new Entry(1,1)); 
// print_r($slot);
?>