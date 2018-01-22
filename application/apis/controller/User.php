<?php
namespace app\apis\controller;

class User extends \think\Controller
{
	
      public function getUserinfo(){
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
                        ->field('u.id,u.company_name,u.time,u.state,u.user_name,u.remark,u.companycate_id,u.usersource_id,u.user_phone,u.user_telephone,u.province_address,u.city_address,u.area_address,u.detailed_address,u.company_url,u.three_one_dinxin,u.three_one_dinji,u.three_one_dinliang,u.qianyue,u.qybeizhu,c.company_cate,s.user_source')
                        ->where($where_data)
                        ->where($where_data2)
                        ->select();
                        $this->assign('info',$info);
        return json(['status'=>1,'data'=>$info]);
    }
    //编辑用户签约信息
    public function updateqianyue(){
      $id = input('id');
      if (!empty(input('qy'))) {
        $qy=input('qy');
        db('userinfo')->where("id=$id")->update(['qianyue'=>$qy]);
      }else if(!empty(input('beizhu'))) {
        $beizhu=input('beizhu');
        db('userinfo')->where("id=$id")->update(['qybeizhu'=>$beizhu]);
      }
    }
}