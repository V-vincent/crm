<?php
namespace app\admin\controller;
use \think\Session;

class Map extends \app\admin\Auth
{
    public function index()
    {
        return $this->fetch();
        
    }
    public function sign(){
        $where_data = '1=1 ';

        // 如果有传搜索的条件
        // 那么就加一个链式操作 where 
        if (input('time1')) {
            $where_data.= ' and time>'.strtotime(input('time1'));
        }

         if (input('time2')) {
            $where_data .= ' and time<'.strtotime(input('time2'));
        }
         if (input('name')) {
            $name=input('name');
            $user1=db('user')->where(['user_name'=>$name])->select();
            if($user1!=""){
              $where_data.= 'and uid='.$user1[0]['id'];
            }
        }
        // echo db('sign')->getLastSql();exit();



        $signlist = db('sign')->alias('s')//给userinfo表设置简写u
                              ->field('s.uid,s.id,s.time,s.lng,s.lat')//解决ID排序问题
                              ->join('user u','s.uid=u.id','left')//设置公司分类表简写为c，用u的id和c的id比较
                              ->where($where_data)
                              ->order('s.id asc')//设置排序为从小到大 大到小desc
                              ->paginate(10);

        $user=db("user")->select();
        $this->assign("user",$user);

    	$this->assign("signlist",$signlist);
    	return $this->fetch();
    }
    public function checksign(){
        $data=input();
        print_r($data);
    }
    public function addmap(){
        $uid=Session::get('u_id');
        $addData = input();
    	$addData['time'] = time();
        $year = date('Y',time());
        $month = date('m',time());
        $day = date('d',time());
        $havesign=db('sign')->where(" YEAR(FROM_UNIXTIME(time)) = $year AND MONTH(FROM_UNIXTIME(time)) = $month AND DAY(FROM_UNIXTIME(time)) = $day AND uid= $uid")->find();

        if($havesign){
            return false;
        }

        else{
            db('sign')->insert($addData);
            session('u_mark', session('u_mark')+15);
            db('user')->where('id',session('u_id'))->update(['mark' => session('u_mark')]);
            return true;
        }
    	
    }
    public function business(){
    	return $this->fetch();
    }
    public function visit(){
    	return $this->fetch();
    }
    public function field(){
    	return $this->fetch();
    }
    public function photo(){
    	return $this->fetch();
    }
    public function check(){
    	return $this->fetch();
    }
    public function set(){
    	return $this->fetch();
    }
}

