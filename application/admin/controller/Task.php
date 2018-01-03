<?php
namespace app\admin\controller;

class Task extends \think\Controller
{
    public function index()
    {
        return $this->fetch();
    }    
}

