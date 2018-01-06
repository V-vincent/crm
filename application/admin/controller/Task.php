<?php
namespace app\admin\controller;

class Task extends \think\Controller
{
    public function index()
    {
        return $this->fetch();
    }    
	public function add()
    {
        $time=date('Y-m-d');
        $this->assign("time",$time);
        return $this->fetch();
    }
    public function check()
    {
        return $this->fetch();
    }        
    public function look()
    {
    	return $this->fetch();
    }      
	public function gather()
    {
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

}

