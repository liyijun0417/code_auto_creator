<?php
namespace Admin\Controller;
use Think\Controller;
use Yijun\Page;

class MessageController extends BaseController {
    public function index(){
      if(!empty($_GET['name'])){
  			$map['name'] = array('like','%'.I('name').'%');
  		}

  		if(!empty($_GET['message_cat_id'])){
  			$map['message_cat_id'] = array('eq',I('message_cat_id'));
  		}

      

      $count = M('message')->where($map)->count();
      $Page  = new Page($count);
      $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
      $data = M('message')->where($map)->order('message_uptime desc')->page($nowPage.','.$Page->listRows)->select();
	  foreach($data as $k=>$v){
		$mak['cat_id'] = $data[$k]['message_cat_id'];
		$data[$k]['cat_name'] = M('cats')->where($mak)->getfield('cat_name');
	  }
      
		
	  $this->cats = M('cats')->select();
      $this->result = $data;
      $this->pageView = $Page->show();

      $this->display();
    }

	 public function messageType(){
      $map['message_id'] = I('message_id');
      $data['message_type'] = I('message_type');
      if(M('message')->where($map)->save($data)){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
      }else{
        $return['state'] = 200;
        $return['sql'] = M('teacher')->_sql();
        $return['msg'] = '操作失败!' ;
      }
      echo json_encode($return);
      exit;
    }


   

}
