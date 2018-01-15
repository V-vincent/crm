<?php
namespace app\admin\controller;

class Map extends \think\Controller
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
         if (input('id')) {
            $where_data.= 'and id ='.input('id');
        }

    	$signlist=db('sign')->alias('m')->order('m.id desc')->where($where_data)->select();
        // echo db('sign')->getLastSql();exit();
    	$this->assign("signlist",$signlist);
    	return $this->fetch();
    }
    public function checksign(){
        $data=input();
        print_r($data);
    }
    public function addmap(){
        $addData = input();
        print_r($addData);
    	$addData['time'] = time();
    	$addData['uid'] = 1;
    	db('sign')->insert($addData);
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

