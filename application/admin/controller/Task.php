<?php
namespace app\admin\controller;

class Task extends \think\Controller
{
    public function index()
    {
        return $this->fetch();
    }    
	public function write()
    {
        return $this->fetch();
    }

    public function look(){
    	   //如果没有传入年份则获取当前系统年份
     	$year=input('y')>0?input('y'):date('Y');
    	//如果没有传入月份则获取当前系统月份
    	$month=input('m')>0?input('m'):date('m');
    	$this->assign('year',$year);
    	$this->assign('month',intval($month));
    	//获取当前月有多少天
   		 $days=date('t',strtotime("{$year}-{$month}-1"));
    		$this->assign('t_days',$days);
 
    		return $this->fetch();
    }
    public function check()
    {
        return $this->fetch();
    }          
	public function gather()
    {
        return $this->fetch();
    }       

}

