<?php
namespace app\admin\controller;

class Draw extends \app\admin\Auth
{
    public function index(){
        return $this->fetch();
    }
}
?>