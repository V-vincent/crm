<?php
namespace app\admin\controller;

class Task extends \think\Controller
{
    public function index()
    {
        $work_list  =  db('work')->order('id desc')->paginate(5);
        $this->assign('work_list',$work_list);                   
        return $this->fetch();
    }    
	public function add()
    {
        $time=date('Y-m-d');
        $this->assign("time",$time);
        return $this->fetch();
    }
    public function save()
    {
        $data=input();
        $time=date('Y-m-d H:i:s');
        $data['time'] = $time;        
        $work = request()->file('work');
        if($work){
            $info = $work->move(ROOT_PATH.'/public/uploads');
            if($info){
                $data['work'] = $info->getSaveName();
            }else{
                 echo $info->getError();
            }
        }
        db("work")->insert($data);
        $this->success('添加成功','index');
    }     
    public function look(){
    	   //如果没有传入年份则获取当前系统年份
     	$year=input('y')>0?input('y'):date('Y');
    	//如果没有传入月份则获取当前系统月份
    	$month=input('m')>0?input('m'):date('m');
    	$this->assign('year',$year);
    	$this->assign('month',intval($month));
    	//获取当前月有多少天
   		 $days=date('t',strtotime("{$year}-{$month}-1"));
    		$this->assign('t_days',$days);
    		return $this->fetch();
    }
    public function check()
    {
        $id = input('id');
        $check = db('work')->where("id=$id")->select();
        $this->assign('check',$check);           
        return $this->fetch();
    }          
	public function gather()
    {
        return $this->fetch();
    }  
   
    public function update()
    {
         $id = input('id');
         $data=input();
        db('work')->where("id=$id")->update($data);
        $this->success('编辑成功','index');      
    } 
}

