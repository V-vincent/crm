<?php
namespace app\admin\controller;
use \think\Session;
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
        //查询公告
        //$id = input('id');
        $notice_info = db('notice')->select();
        $this->assign('notice_info',$notice_info);
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
    //保存公告
  public function noticesave(){
        $time=date('y-m-d');
        $time="20".$time;
        $data=input();
        $data['time']=$time;
        db('notice')->where("id=1")->update($data);
        $this->success('添加成功',"index");
    }
    //添加学生
    public function studentsave(){
        $uid=Session::get('u_id');
        $time=date('y-m-d');
        $time="20".$time;
        $data=input();
        $data['time']=$time;
        $data["uid"]=$uid;
        $have=db("studentsinfo")->where(['uid'=>$uid])->find();
        if($have){
            db('studentsinfo')->where(['uid'=>$uid])->update($data);
            
            $student = db('studentsinfo')->alias('s')//给userinfo表设置简写u
                              ->field('s.uid,s.password')//解决ID排序问题
                              ->join('user u','s.uid=u.id','left')//设置公司分类表简写为c，用u的id和c的id比较
                              ->where(['u.id'=>$uid])->find();
            $password=$student["password"];
             $user = db('user')->alias('u')//给userinfo表设置简写u
                              ->field('u.id,u.password')//解决ID排序问题
                              ->join('studentsinfo s','u.id=s.uid','left')//设置公司分类表简写为c，用u的id和c的id比较
                              ->where(['u.id'=>$uid])
                              ->update(['u.password' => $password]);
            $this->success('更新成功',"index");

        }
        else{
             db('studentsinfo')->insert($data);
             $student = db('studentsinfo')->alias('s')//给userinfo表设置简写u
                              ->field('s.uid,s.password')//解决ID排序问题
                              ->join('user u','s.uid=u.id','left')//设置公司分类表简写为c，用u的id和c的id比较
                              ->where(['u.id'=>$uid])->find();
            $password=$student["password"];
             $user = db('user')->alias('u')//给userinfo表设置简写u
                              ->field('u.id,u.password')//解决ID排序问题
                              ->join('studentsinfo s','u.id=s.uid','left')//设置公司分类表简写为c，用u的id和c的id比较
                              ->where(['u.id'=>$uid])
                              ->update(['u.password' => $password]);
             $this->success('添加成功',"index");
        }
    }
}