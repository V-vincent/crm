<?php
namespace app\index\controller;

class News extends \think\Controller
{
    public function index()
    {
        if(input('cate')){
            $cate=input('cate');
            $news_list2 = db('newslist')->where("cate_id=$cate")->select();
            $news_list  =  db('newslist')->where("cate_id=$cate")->order('id desc')->paginate(8,false,['query' => input()]);
        }else{
            $news_list2 = db('newslist')->select();
            $news_list  =  db('newslist')->order('id desc')->paginate(8);
        }
        $this->assign('news_list',$news_list);
        $this->assign('news_list2',$news_list2);

        $news_cate  =  db('newscate')->select();
        $this->assign('news_cate',$news_cate);
        return $this->fetch();
    }
    
    public function news()
    {
        $news = db('newslist')->select(['id'=>$_REQUEST['id']]);
        $this->assign('news',$news);
        $news_list2=db('newslist')->where(['cate_id'=>$news[0]['cate_id']])->select();
        $this->assign('news_list2',$news_list2);
        $news_cate  =  db('newscate')->select();
        $this->assign('news_cate',$news_cate);
        return $this->fetch();
    }
}