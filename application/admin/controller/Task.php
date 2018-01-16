<?php
namespace app\admin\controller;
use \think\Session;
class Task extends \think\Controller
{
    public function index()
    {   
        //获取当前用户信息
        $user_data=Session::get();
        //搜索用户
        $u_where_data = [];
        if(input('user_name')){
            $u_where_data['user_name'] = ['like','%'.input('user_name').'%'];
        }    
        //作业列表的用户  
        $user_list=db("user")->where($u_where_data)->select(); 
        $this->assign('user_list',$user_list);          
        //添加条件
        $where_data = [];
        if($user_data['user_cate']=='学生'){
            $where_data['u_id']=$user_data['u_id'];
        }if(input('user_name')){
            $where_data['u_id']=$user_list[0]["id"];
        }
        //当前用户
        $user=db('user')->where("user_name",$user_data['user_name'])->select();
        $this->assign("user",$user);
        //作业列表
        $work_list  =  db('work')->where($where_data)->order('id desc')->paginate(5);
        $this->assign('work_list',$work_list); 
        return $this->fetch();
    }    
    //交作业的页面
	public function add()
    {
        $time=date('Y-m-d');
        $this->assign("time",$time);
        return $this->fetch();
    }
    //交作业时保存
    public function save()
    {
        $data=input();
        //获取当前时间
        $time=date('Y-m-d H:i:s');
        $data['time'] = $time;        
        //获取当前用户ID
        $u_id=Session::get('u_id');
        $data['u_id'] = $u_id;
        //获取文件
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
    //查看提交情况
    public function look(){
    	//如果没有传入年份则获取当前系统年份
     	$year=input('y')>0?input('y'):date('Y');
        $this->assign('year',$year);
    	//如果没有传入月份则获取当前系统月份
    	$month=input('m')>0?input('m'):date('m');
    	$this->assign('month',intval($month));
    	//获取当前月有多少天
   		$days=date('t',strtotime("{$year}-{$month}-1"));
    	$this->assign('t_days',$days);
         //获取当前用户信息
        $user_data=Session::get();
        //当前用户
        $user=db('user')->where("user_name",$user_data['user_name'])->select(); 
        $this->assign("user",$user);  
        //所有学生用户
        $user_list=db("user")->where("user_cate","学生")->select();
        $this->assign('user_list',$user_list); 
        //添加条件
        $where_data = [];
        if($user_data['user_cate']=='学生'){
            $where_data['u_id']=$user_data['u_id'];
        }else{
            $where_data=[];
        }
        //查询当年当月的数据（临时）
        $t_work_list  = db('work')->field("DATE_FORMAT(time, '%d') d,u_id")
                                ->where($where_data)
                                ->where("DATE_FORMAT(time, '%Y%m') = ".$year.$month)
                                ->select();
        $this->assign('t_work_list',json_encode($t_work_list));  
        $work_list = [];
        //改变当天的数据类型
        foreach ($t_work_list as $key => $value) {
            $work_list[intval($value['d'])] = true;
        }
        $this->assign('work_list',json_encode($work_list));   
    	return $this->fetch();
    }
    //批改作业页面
    public function check()
    {
        $id = input('id');
        $check = db('work')->where("id=$id")->select();
        $this->assign('check',$check);     
   
        $user_name=Session::get('user_name');
        $user=db('user')->where("user_name",$user_name)->select();
        $this->assign("user",$user);      
        return $this->fetch();
    }       
    //布置作业页面   
	public function arrange()
    {
        $time=date('Y-m-d');
        $this->assign("time",$time);        
        return $this->fetch();
    }  
    public function update()
    {
         $id = input('id');
         $data=input();
        db('work')->where("id=$id")->update($data);
        $this->success('操作成功','index');      
    } 
}

