<?php
namespace app\admin;

class Auth extends \think\Controller
{
     function _initialize()
     {
     	if(!session('user_name')){
          $this->success('您还没有登录,现在返回到登录界面','index/login/index');
        }
     	
     }
}