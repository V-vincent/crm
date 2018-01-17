<?php
 
namespace app\apis\controller;

class Work  extends \think\Controller
{
	public function getWork()
	{
		$work = db('work')->select();
		return json(['status'=>1,'data'=>$work]);	
	}
	public function getList()
	{
		$work = db('worklist')->select();
		return json(['status'=>1,'data'=>$work]);	
	}	
}