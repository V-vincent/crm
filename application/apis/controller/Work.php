<?php
 
namespace app\apis\controller;

class Work  extends \think\Controller
{
	public function getallWork()
	{
		$work = db('work')->select();
		return json(['status'=>1,'data'=>$work]);	
	}//获取所有学生作业
	public function getWork()
	{
		$uid=input("uid");
		$work = db('work')->where(['u_id'=>$uid])->select();
		return json(['status'=>1,'data'=>$work]);	
	}//获取某ID学生作业
	public function getList()
	{
		$work = db('worklist')->select();
		return json(['status'=>1,'data'=>$work]);	
	}	
}