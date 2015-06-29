<?php

require_once('C:\Program Files (x86)\EasyPHP-DevServer-14.1VC9\data\localweb\myFrontController\model\DBCon.class.php');

class DBConTest extends PHPUnit_Framework_TestCase
{
  public function setUp(){ }
  public function tearDown(){ }

  public function test_postOnBlog()
  {
    
    $connObj = new DBCon();
	
    $Author='Gigel';
	$Category='ce vrei tu';
	$ActualPost='etc etc';
	$Title='titlu';
    $this->assertTrue($connObj->newPost($Author,$Category,$Text,$Title) === 1);
  }
}
?>