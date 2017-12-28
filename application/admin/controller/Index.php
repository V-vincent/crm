<?php
namespace app\admin\controller;

class Index extends \think\Controller
{
    public function index()
    {
    	$list = db('companycate')->select();
    	$this->assign('list',$list);
        return $this->fetch();
    }
    //添加客户
    public function save(){
        db('userinfo')->insert(input());
        $this->success('添加成功','index');
    }
}