<?php
namespace app\admin\controller;

class Index extends \app\admin\Auth
{
    public function index()
    {
    	$list = db('companycate')->select();
    	$this->assign('list',$list);
        $user_source = db('usersource')->select();
        $this->assign('user_source',$user_source);
        return $this->fetch();
    }
    //添加客户
    public function save(){       
        $time=date('y-m-d');
        $time="20".$time;
        $data=input();
        $data['time']=$time;
        db('userinfo')->insert($data);
        $this->success('添加成功','index');
    }
}