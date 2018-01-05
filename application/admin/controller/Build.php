<?php
namespace app\admin\controller;

class Build extends \think\Controller
{
    public function index(){
        $buildlist=db('buildlist')->select();
        $this->assign('buildlist',$buildlist);
        return $this->fetch();
    }
    public function add(){
        return $this->fetch();
    }

    public function edit(){
        $buildlist=db('buildlist')->select(['id'=>$_REQUEST['id']]);
        $this->assign('buildlist',$buildlist);
        return $this->fetch();
    }

    public function save(){
        $data=input();
        $time=date('Y-m-d');
        $data['time'] = $time;
        db('buildlist')->insert($data);
        $this->success('添加成功','index');
    }
    public function update(){
        $data=input();
        $time=date('Y-m-d');
        $data['time'] = $time;
        $id = input('id');
        db('buildlist')->where("id=$id")->update($data);
        $this->success('编辑成功','index');
    }
}
?>