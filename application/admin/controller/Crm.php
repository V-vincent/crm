<?php
namespace app\admin\controller;

class Crm extends \think\Controller
{
    public function index()
    {
         //查询公司分类
        $companycate_list = db('companycate')->select();
        $this->assign('companycate_list',$companycate_list);
        $where_data=[];
        //如果有传搜索条件
        //那么就加一个链式操作
        if(input('company_name')){
            $where_data['company_name'] = ['like','%'.input('company_name').'%'];
        }
        //如果是分类查询执行
        if(input('companycate_id')>0){
            $where_data['companycate_id'] = input('companycate_id');
        }
        $list = db('userinfo')->alias('u')//给userinfo表设置简写u
                              ->field('u.id, u.companycate_id, u.company_name, u.user_name, u.user_phone, u.remark, u.time, c.company_cate')//解决ID排序问题
                              ->join('companycate c','u.companycate_id=c.id','left')//设置公司分类表简写为c，用u的id和c的id比较
                              ->order('u.id desc')//设置排序为从大到小
                              ->where($where_data)
                              ->paginate(10);
        $this->assign('list',$list);
        return $this->fetch();
    }
    //保存客户信息
    public function save(){
        db('userinfo')->insert(input());
    }
    //删除客户
    public function delete(){
    	$id = input('id');
    	if($id>0){
    		db('userinfo')->where("id=$id")->delete();
    	}
    }
    //编辑客户信息
    public function edit(){
         //编辑查询一条信息,编辑
        $id = input('id');
        $info = db('userinfo')->where("id=$id")->find();
        return $info;
    }
}
