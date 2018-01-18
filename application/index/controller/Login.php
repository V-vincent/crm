<?php
namespace app\index\controller;
use \think\Session;
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
            $data["mark"]=0;
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
            Session::set('user_name',$realpassword["user_name"]);
            Session::set('user_cate',$realpassword["user_cate"]);
            Session::set('u_id',$realpassword["id"]);
            Session::set('u_mark',$realpassword["mark"]);
        	return true;
        }
        else
        	return false; 
    }

    public function logout(){
            Session::delete('user_name');
            Session::delete('user_cate');
            Session::delete('u_id');
            $this->success('退出成功','index/login/index');
    }
}
