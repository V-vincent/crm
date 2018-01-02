<?php
namespace app\admin\controller;

class Map extends \think\Controller
{
    public function index()
    {
        return $this->fetch();
        
    }
    public function sign(){
    	$signlist=db('sign')->select();
    	$this->assign("signlist",$signlist);
    	return $this->fetch();
    }
    public function addmap(){
        $addData = input();
        print_r($addData);
    	$addData['time'] = time();
    	$addData['uid'] = 1;
    	db('sign')->insert($addData);
    }
    public function business(){
    	return $this->fetch();
    }
    public function visit(){
    	return $this->fetch();
    }
    public function field(){
    	return $this->fetch();
    }
    public function photo(){
    	return $this->fetch();
    }
    public function check(){
    	return $this->fetch();
    }
    public function set(){
    	return $this->fetch();
    }
}

