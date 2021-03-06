<?php
/**
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class getGroupingsReturn {
	/** 
	* @var groupingRecord[]
	*/
	public $groupings;

	/**
	* default constructor for class getGroupingsReturn
	* @return getGroupingsReturn
	*/	 public function getGroupingsReturn() {
		 $this->groupings=array();
	}
	/* get accessors */

	/**
	* @return groupingRecord[]
	*/
	public function getGroupings(){
		 return $this->groupings;
	}

	/*set accessors */

	/**
	* @param groupingRecord[] $groupings
	* @return void
	*/
	public function setGroupings($groupings){
		$this->groupings=$groupings;
	}

}

?>
