<?php
namespace Admin\Controller;
use Think\Controller;
use Yijun\Page;

class VideoController extends BaseController {
    public function index(){
      if(!empty($_GET['video_name'])){
  			$map['video_name'] = array('like','%'.I('video_name').'%');
  		}

  		if(!empty($_GET['video_cat_id'])){
  			$map['video_cat_id'] = array('eq',I('video_cat_id'));
  		}

      

      $count = M('video')->where($map)->count();
      $Page  = new Page($count);
      $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
      $data = M('video')->where($map)->order('video_uptime desc')->page($nowPage.','.$Page->listRows)->select();
      foreach ($data as $key => $value) {
        # code...
        $map5['cat_id'] = $data[$key]['video_cat_id'];
        $data[$key]['video_cat'] = M('cats')->where($map5)->getfield('cat_name');
      }
		
		$ms['parent_id'] = array('neq',0);
	  $this->cats = M('cats')->where($ms)->select();
	  $this->teachers = M('teacher')->select();
      $this->result = $data;
      $this->pageView = $Page->show();

      $this->display();
    }


    public function videoType(){
      $map['video_id'] = I('video_id');
      $data['video_type'] = I('video_type');
      if(M('video')->where($map)->save($data)){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
      }else{
        $return['state'] = 200;
        $return['sql'] = M('video')->_sql();
        $return['msg'] = '操作失败!' ;
      }
      echo json_encode($return);
      exit;
    }


    public function updatevideo(){
      if(IS_POST){
        $maps['video_id'] = I('video_id');
        $save['video_name'] = I('video_name');
		$save['video_teacher'] = I('video_teacher');
		$save['video_content'] = $_POST['video_content'];
		$save['video_image'] = I('pic');
        $save['video_brief'] = I('video_brief');
        $save['video_cat_id'] = I('video_cat_id');
		$save['video_uptime'] = time();
        if(M('video')->where($maps)->save($save)){
          $return['state'] = 100;
          $return['msg'] = '修改成功!' ;
        }else{
          $return['state'] = 200;
          $return['msg'] = '未做修改!' ;
        }
        echo json_encode($return);
        exit;
      }else{
        $map['video_id'] = I('id');

        $data = M('video')->where($map)->find();
        if(!$data){
          redirect(U('Index/error'));
        }else{
          $this->data = $data;
			$this->teachers = M('teacher')->select();
          //找到所有的视频分类
          $ms['parent_id'] = array('neq',0);
          $cata = M('cats')->where($ms)->select();
          $this->cats = $cata;
          //print_r($data);
          $this->display();
        }

      }
    }

	public function uploadImg(){
		$config = array(    
        	'maxSize'    =>    10240000,    
        	'rootPath'   =>    'Public/data/img/',
        	'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
        	'saveName'   =>    array('uniqid',''),    
        	'autoSub'    =>    false,
        );
        $upload = new \Think\Upload($config);   //实例化上传类  
        $info   = $upload->uploadOne($_FILES['photo']);
        if (!$info) {
        	$ReturnInfo['msg']   = $upload->getError();
            $ReturnInfo['state'] = 0;
        } else {
        	$ReturnInfo['msg']   = '上传成功';
        	$ReturnInfo['url']   = $info['savename'];
            $ReturnInfo['state'] = 1; 	
        }
        echo json_encode($ReturnInfo);
	}

    public function addvideo(){
      $data['video_name'] = I('video_name');
	  $data['video_content'] = $_POST['video_content'];
	  $data['video_teacher'] = I('video_teacher');
      $data['video_cat_id'] = I('video_cat_id');
      $data['video_brief'] = I('video_brief');
	  $data['video_image'] = I('pic');
	  $data['video_uptime'] = time();
	  
	  $m['video_name'] = $data['video_name'];
	  $m['video_cat_id'] =  $data['video_cat_id'];
      if(M('video')->where($m)->find()){
        $return['state'] = 300;
  			$return['msg'] = '该村组下已经有这个视频名称了，不需要重复添加!' ;
        echo json_encode($return);
    		exit;
      }

      if(M('video')->add($data)){
        $return['state'] = 100;
  			$return['msg'] = '视频添加成功!' ;
  		}else{
  			$return['state'] = 200;
  			$return['msg'] = '视频添加失败!' ;
  		}
  		echo json_encode($return);
  		exit;
    }



    public function del_video(){
      $map['video_id'] = I('video_id');
   
      if(M('video')->where($map)->delete()){
        $return['state'] = 100;
        $return['msg']   = '已成功删除!';
      }else{
        $return['state'] = 200;
        $return['msg']   = '删除失败，请联系技术人员!';
      }
      echo json_encode($return);
      exit;
    }


   

}
