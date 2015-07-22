<?php

class Entry{
	public $_key;
	public $_value;

	function  __construct($_key, $_value){
		$this->key = $_key;
		$this->value = $_value;
	}
}

class HashTable{

	function  __construct($maxSize=2){
		$this->maxSize = $maxSize;
		$this->size = 0;
		$this->slot = array_fill(0, $this->maxSize, NULL);
	}

	function _hash($key){
		$h=0;
		$a=31;
		$str = strval($key);
		for ($i=0; isset($str[$i]); $i++) { 
			$h=$h*$a+$str[$i];
		}
		return $h;
	}

	function find($key){
		$i = $this->hash($key)%$this->maxSize;
		while ($this->slot[$i]!= NULL && $this->slot[i]->$_key!=$key) {
			$i = ($i+1)%$this->maxSize;
		}
		return $i;
	}

	function resize($size){
		for ($i=0; $i < $size-$this->maxSize; $i++) { 
			array_push($this->slot, NULL);
		}
		$this->maxSize = $size;
	}

	function set($key, $value){
		$i = find($key);
		if ($this->size/$this->maxSize<0.7) {
			$this->slot[$i]= new Entry($key, $value);
			$this->size++;
		}
		else{
			$this->resize($this->maxSize*2);
			$this->insert($key, $value);
		}

	}

	function get($key){
		$i = find($key);
		if ($this->slot[$i]==NULL) {
			return NULL;
		}
		else{
			return $this->slot[$i]->$value;
		}
	}

	function remove($key){
		$i = find($key);
		if($this->slot[$i]!= NULL){
			//$this->slot[$i] = NULL;
			$flag=TRUE;
			$h=$i;
			while ($flag) {
				$j=$i;
				$hash=$this->hash($key);
				while ($this->slot[$j]!=NULL) {
					$j=($j+1)%$this->maxSize;
					if ($this->hash($this->slot[$j]->key)==$hash)
						$h = $j;
				}
				if ($h==$i)
					$flag= FALSE;
				$key=$this->slot[$h]->key;
				$this->slot[$i]=$this->slot[$h];
				$this->slot[$i]=NULL;
				$i=$h;
			}
			$this->size--;
		}
	}
}
$t = new HashTable();
echo strval("abrakadabra");
echo $t->_hash("abrakadabra");

?>