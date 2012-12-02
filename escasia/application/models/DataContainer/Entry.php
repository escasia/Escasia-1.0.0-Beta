<?php
class Application_Model_DataContainer_Entry {
	
	private $name;
	private $type;
	private $contact;
	private $description;
	private $img;
	
	public function __construct(){
		
	}
	
	public function setType($type){
		$this->type;
	}
	
	public function getType(){
		return $this->type;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setContact($contact){
		$this->contact = $contact;
	}
	
	public function getContact(){
		return $this->contact;
	}
	
	public function setDescription($description){
		$this->description = $description;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
}