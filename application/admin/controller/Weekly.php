<?php
namespace app\admin\controller;

class Weekly extends \app\admin\Auth
{
    public function index(){
        return $this->fetch();
    }
    public function weeklysave(){
        $data = input();
        db('weekly')->insert($data);
        $this->success("",'index/index');
      }

}
?>