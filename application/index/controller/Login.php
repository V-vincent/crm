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
    	$have=db('user')->where('user_name',$data['user_name'])->find();
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
        find();
        if(!empty($realpassword)){
            Session::init([
    'prefix'         => 'module',
    'type'           => '',
    'auto_start'     => true,
]);
            session_start(); Session::set('uid',$realpassword["id"]);
            echo $Session["uid"];
        	return true;
        }
        else
        	return false;
        
    }
}
