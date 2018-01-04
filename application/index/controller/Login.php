<?php
namespace app\index\controller;

class Login extends \think\Controller
{
    public function index()
    {
    	$user_list=db('user')->select();
    	$this->assign('user_list',$user_list);
        return $this->fetch();
    }
    public function reg(){
    	$data=input();
    	$have=db('user')->where('user_name',$data['user_name'])->select();
    	if(empty($have))
    	{
    		db('user')->insert($data);
    		return true;
    	}
    	else
    		return false;
    }
    public function loginin(){
    	$data=input();
        $realpassword=db("user")->where("user_name",$data['user_name'])->
        where("company_name",$data["company_name"])->where("password",$data['password'])->
        select();
        if(!empty($realpassword)){
        	return true;
        }
        else
        	return false;

    }
}
