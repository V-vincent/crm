<?php
namespace app\index\controller;

class Collect extends \think\Controller
{
    public function index()
    {
        $id=$_REQUEST['id'];
        if($id){
            $id=$id;
        }else{
            $id=1;
        }

        $build=db('buildlist')->where("id=$id")->select();
        $buildId=$build[0]['id'];
        $buildlist=json_decode($build[0]['list']);
        foreach ($buildlist as $key =>$build2){
            $buildlist[$key] = json_decode(json_encode($build2),TRUE);
        }
        $this->assign('buildlist',$buildlist);
        return $this->fetch();
    }
    public function index2()
    {
        $id=$_REQUEST['id'];
        if($id){
            $id=$id;
        }else{
            $id=1;
        }
        $build=db('buildlist')->where("id=$id")->select();
        $buildlist=json_decode($build[0]['list']);
        foreach ($buildlist as $key =>$build2){
            $buildlist[$key] = json_decode(json_encode($build2),TRUE);
        }
        $this->assign('buildlist',$buildlist);
        print_r($buildlist);
        return $this->fetch();
    }
    public function save(){
        $info=input();
        $time=date('Y-m-d');
        $data=[];
        $data['data']=json_encode($info);
        $data['time']=$time;
        $data['user_id']=6;
        db('formdata')->insert($data);
        $this->success('添加成功','index');
    }
}
