<?php
namespace app\admin\controller;

class News extends \think\Controller
{
    public function index()
    {
        $news_list  =  db('newslist')->order('id desc')->paginate(5);
        $this->assign('news_list',$news_list);
        $news_cate  =  db('newscate')->select();
        $this->assign('news_cate',$news_cate);
        return $this->fetch();
    }

    public function add()
    {
        $cate_list = db('newscate')->select();
        $this->assign('cate_list',$cate_list);
        return $this->fetch();
    }

    public function save()
    {
        $data  = input();
        $thumb = request()->file('thumb');
        $time=date('Y-m-d H:i:s');
        $data['time'] = $time;
        if ($thumb) {
            $info = $thumb->move(ROOT_PATH.'/public/uploads');
            if ($info) {
                $data['thumb'] = $info->getSaveName();
            }else{
                echo $info->getError();
            }
        }
        db('newslist')->insert($data);
        $this->success('添加成功','index');
    }
    public function edit(){
        $edit = db('newslist')->select(['id'=>$_REQUEST['id']]);
        $this->assign('edit',$edit);
        $news_cate = db('newscate')->select();
        $this->assign('news_cate',$news_cate);
        return $this->fetch();
    }
    public function update()
    {
        $data  = input();
        $id = input('id');
        $thumb = request()->file('thumb');
        $time=date('Y-m-d H:i:s');
        $data['time'] = $time;
        if ($thumb) {
            $info = $thumb->move(ROOT_PATH.'/public/uploads');
            if ($info) {
                $data['thumb'] = $info->getSaveName();
            }else{
                echo $info->getError();
            }
        }
        db('newslist')->where("id=$id")->update($data);
        $this->success('编辑成功','index');
    }
    public function del(){
        db('newslist')->delete(['id'=>$_REQUEST['id']]);
        $this->success('删除成功','index');
    }
}
