<?php
/**
 * 
 * 
 * @package	MoodleWS
 * @copyright	(c) P.Pollet 2007 under GPL
 */
class enrolRecord {
	/** 
	* @var  string
	*/
	public $error;
	/** 
	* @var  string
	*/
	public $userid;
	/** 
	* @var  string
	*/
	public $course;
	/** 
	* @var  integer
	*/
	public $timestart;
	/** 
	* @var  integer
	*/
	public $timeend;
	/** 
	* @var  integer
	*/
	public $timeaccess;
	/** 
	* @var  string
	*/
	public $enrol;
	 public function enrolRecord() {
		 $this->error='';
		 $this->userid='';
		 $this->course='';
		 $this->timestart=0;
		 $this->timeend=0;
		 $this->timeaccess=0;
		 $this->enrol='';
	}
	/* get accessors */
	public function getError(){
		 return $this->error;
	}

	public function getUserid(){
		 return $this->userid;
	}

	public function getCourse(){
		 return $this->course;
	}

	public function getTimestart(){
		 return $this->timestart;
	}

	public function getTimeend(){
		 return $this->timeend;
	}

	public function getTimeaccess(){
		 return $this->timeaccess;
	}

	public function getEnrol(){
		 return $this->enrol;
	}

	/*set accessors */
	public function setError($error){
		$this->error=$error;
	}

	public function setUserid($userid){
		$this->userid=$userid;
	}

	public function setCourse($course){
		$this->course=$course;
	}

	public function setTimestart($timestart){
		$this->timestart=$timestart;
	}

	public function setTimeend($timeend){
		$this->timeend=$timeend;
	}

	public function setTimeaccess($timeaccess){
		$this->timeaccess=$timeaccess;
	}

	public function setEnrol($enrol){
		$this->enrol=$enrol;
	}

}

?>
