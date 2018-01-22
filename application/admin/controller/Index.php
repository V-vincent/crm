<?php
namespace app\admin\controller;

class Index extends \app\admin\Auth
{
    public function index()
    {
        //查询公司分类
    	$list = db('companycate')->select();
    	$this->assign('list',$list);
        //查询客户来源
        $user_source = db('usersource')->select();
        $this->assign('user_source',$user_source);
        //查询学校名字
        $school_name = db('school')->select();
        $this->assign('school_name',$school_name);
        //查询所报课程
        $lesson_name = db('lessname')->select();
        $this->assign('lesson_name',$lesson_name);
        return $this->fetch();
    }
    //添加客户
    public function customersave(){       
        $time=date('y-m-d');
        $time="20".$time;
        $data=input();
        $data['time']=$time;
        db('userinfo')->insert($data);
        $this->success('添加成功','index');
    }
    //添加学生
    public function studentsave(){
        $time=date('y-m-d');
        $time="20".$time;
        $data=input();
        $data['time']=$time;
        db('studentsinfo')->insert($data);
        $this->success('添加成功','index');
    }
}