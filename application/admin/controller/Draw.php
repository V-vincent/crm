<?php
namespace app\admin\controller;

class Draw extends \app\admin\Auth
{
    public function index(){
        return $this->fetch();
    }
    public function save(){
        db('draw')->where("id=5")->update(input());
    }
    public function start(){
    	$list = db('draw')->where("id=5")->select();
        $this->assign('list',$list);
        return $this->fetch();
    }
}
?>