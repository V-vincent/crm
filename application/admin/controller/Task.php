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
    	return $this->fetch();
    }      
}

