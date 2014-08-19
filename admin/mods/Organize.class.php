<?php
class Organize extends ABase
{
	static public $_class = __CLASS__;
	static public $_table = '#_organize';
	
	static function getInfoById($id)
	{
		$info = self::getOne(array("id" => $id));
		return $info;
	}
	
	static function getInfoByCode($code)
	{
		$info = self::getOne(array("code"=>$code));
		return $info;
	}
	
	static function getCode($id)
	{
		$info = self::getInfoById($id);
		return isset($info['code']) ? $info['code'] : null; 
	}
	
	static function getId($code)
	{
		$info = self::getInfoByCode($code);
		return isset($info['id']) ? $info['id'] : null;
	}
	
}


