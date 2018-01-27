<?php
 
namespace app\apis\controller;
/*use think\Db;*/

 

class Users extends \think\Controller
{
   public function index()
   {
    
       print_r( $_COOKIE);
   }
    public function bind()
    {
        $user_name = input('user_name');
        $weixinname = input('weixinname');
        $pwd = input('pwd');
         //1.检查账号密码是否正确
        $ruser = db('user')->where(array('user_name'=>$user_name))->find();
        if(empty($ruser)){
                
            $ruser['id'] = db('user')->insertGetId(['user_name'=>$user_name,'password'=>$pwd,'last_login'=>time()]);          
        }
        
        if($ruser['password'] != $pwd && $ruser['password']){
            return json(array('status'=>-1,'msg'=>'账号或密码错误','result'=>''));
        }else{

            db('oauthusers')->insert(array('oauth'=>'weixin' , 'weixinname'=>$weixinname ,'user_id'=>$ruser['id'] ));
             $user = db('user')->field('id')->where("id", $ruser['id'])->find();
           
           

            return json(array('status'=>1,'msg'=>'绑定成功','uinfo'=> $user,'weixinname'=>$weixinname));

        }
    }

    public function login()
    {
        /*$data = db('Plugin')->where("code='weixin' and  type = 'login' ")->find();
        $config = unserialize($data['config_value']); // 配置反序列化

          //开发者使用登陆凭证 code 获取 session_key 和 openid
        $APPID =  $config['appid'];
        $AppSecret = $config['secret'];
        $code = I('get.code');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$APPID."&secret=".$AppSecret."&js_code=".$code."&grant_type=authorization_code";
        $arr = vget($url);  // 一个使用curl实现的get方法请求
        $arr = json_decode($arr,true);
        $openid = $arr['openid'];
        $session_key = $arr['session_key'];
       */
        // 数据签名校验
        $signature = input('get.signature');
        /*$signature2 = sha1($_GET['rawData'].$session_key);  //记住不应该用TP中的I方法，会过滤掉必要的数据
        if ($signature != $signature2) {
           return json(['msg'=>'数据签名验证失败！','status'=>-1]);die;
        }*/

        
        $thirdUser = db('oauthusers')->where(['weixinname'=>input('name')])->find();
        if (empty($thirdUser)) {
            return json(['msg'=>'请先绑定用户','status'=>0,'weixinname'=>input('name')]);die;
        }else{
             $user = db('user')->field('id')->where("id", $thirdUser['user_id'])->find();
           
             return json(['status'=>1,'uinfo'=> $user,'weixinname'=>input('name')]);die;
        }
    }

   public function getUsernews(){
      $id=input("id");
      $user=db("user")->where("id",$id)->
        find();//切记这里不能用select
      $user_name=$user["user_name"];
      $company_name=$user["company_name"];
      $password=$user["password"];
      $user_cate=$user["user_cate"];
      $user_mark=$user["mark"];

      return json(array('status'=>1,'msg'=>'显示成功','user_name'=> $user_name,'company_name'=> $company_name,'password'=> $password,'user_cate'=> $user_cate,'user_mark'=> $user_mark));
    //根据ID访问出用户的信息
    }
   

}

 function vget($url){
    $info=curl_init();
    curl_setopt($info,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($info,CURLOPT_HEADER,0);
    curl_setopt($info,CURLOPT_NOBODY,0);
    curl_setopt($info,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($info,CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($info,CURLOPT_URL,$url);
    $output= curl_exec($info);
    curl_close($info);
    return $output;
}
