<?php
namespace app\admin\controller;

class Crm extends \app\admin\Auth
{
    public function index()
    {
         //查询公司分类
        $companycate_list = db('companycate')->select();
        $this->assign('companycate_list',json_encode($companycate_list));
         $where_data=[];
          if(input('companycate_id')>0){
            $where_data['companycate_id'] = input('companycate_id');
        }

        //查询公司阶段
        $companystage_list = db('companystage')->select();
        $this->assign('companystage_list',json_encode($companystage_list));
        $where_datastage=[];
        if(input('companystage_id')>0){
            $where_datastage['companystage_id'] = input('companystage_id');
        }

        //查询客户来源
        $usersource_list = db('usersource')->select();
        $this->assign('usersource_list',json_encode($usersource_list));
        $where_datasource=[];
        if(input('usersource_id')>0){
            $where_datasource['usersource_id'] = input('usersource_id');
        }

        //模糊查询
        if(input('company_name')){
            $where_data['company_name'] = ['like','%'.input('company_name').'%'];
        }
        $list = db('userinfo')->alias('u')//给userinfo表设置简写u
                              ->field('u.id, u.companycate_id, u.company_name, u.user_name, u.user_phone, u.remark, u.time, c.company_cate')//解决ID排序问题
                              ->join('companycate c','u.companycate_id=c.id','left')//设置公司分类表简写为c，用u的id和c的id比较
                              ->where($where_data)
                              ->join('companystage s','u.companystage_id=s.id','left')
                              ->where($where_datastage)
                              ->join('usersource sou','u.usersource_id=sou.id','left')
                              ->where($where_datasource)
                              ->order('u.id desc')//设置排序为从大到小
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
    //查询每个客户信息
    public function edit(){
        $id = input('id');
        $info = db('userinfo')->where("id=$id")->find();
        $this->assign('info',$info);
        return $info;
    }
    //编辑每个用户信息
    public function update_userinfo(){
      $id = input('id');
      $info=input();
      db('userinfo')->where("id=$id")->update($info);
      $this->success('','index');
    }
    
    //客户来源数据词典
    public function usersource(){
        $list = db('usersource')->paginate(10);
        $this->assign('list',$list);
        return $this->fetch();
    }
       //更改客户来源数据词典
    public function update_usersource(){
        foreach ($_REQUEST['user_source'] as $key => $value) {
            db('usersource')->where("id=$key")->update(['user_source'=>$value]);
        }
     $this->success('','usersource');
       
 }
 //客户类型信息
 public function companycate(){
      $list = db('companycate')->paginate(10);
     $this->assign('list',$list);
     return $this->fetch();
 }
 //更改客户类型
  public function update_companycate(){
        foreach ($_REQUEST['companycate'] as $key => $value) {
            db('companycate')->where("id=$key")->update(['company_cate'=>$value]);
        }
     $this->success('','companycate');
       
 }



 //查看每个用户的信息
 public function userinfo(){
       $id=input('id'); 
       //查询公司类型
       $companycate_list = db('companycate')->select();
        $this->assign('companycate_list',$companycate_list);
        $where_data=[];
        if(input('companycate_id')>0){
            $where_data['companycate_id'] = input('companycate_id');
        }
       //查询客户来源
        $usersource_list = db('usersource')->select();
        $this->assign('usersource_list',$usersource_list);
        $where_data2=[];
        if(input('usersource_id')>0){
            $where_data['usersource_id'] = input('usersource_id');
        }
        //查询表
        
       $info = db('userinfo')->alias('u')
                        ->join('companycate c','u.companycate_id=c.id','left')
                        ->join('usersource s','u.usersource_id=s.id','left')
                        ->field('u.id,u.company_name,u.time,u.state,u.remark,u.companycate_id,u.usersource_id,u.user_phone,u.user_telephone,u.province_address,u.city_address,u.area_address,u.detailed_address,u.company_url,u.three_one_dinxin,u.three_one_dinji,u.three_one_dinliang,c.company_cate,s.user_source')
                        ->where("u.id=$id")
                        ->where($where_data)
                        ->where($where_data2)
                        ->find();
                        $this->assign('info',$info);
      //查询跟单
      $with = db('with')->alias('w')
                        ->join('userinfo u','w.user_id=u.id','left')
                        ->field('w.with_time,w.with_title,w.with_content,w.user_id,u.id')
                        ->where("w.user_id=$id")
                        ->order('w.id desc')
                        ->select();
                        $this->assign('with',$with);
                       
                        
  
  return $this->fetch();
 }
 //保存跟单信息
 public function with(){
  $id = input('id');
  $data = input();
  // $data['user_id'] = input('id');
  db('with')->insert($data);
 }
 //显示跟单情况
 
}
