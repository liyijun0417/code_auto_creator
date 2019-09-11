<?php
namespace Admin\Controller;
use Think\Controller;
use Yijun\Page;

class TeacherController extends BaseController {
    public function index(){
      if(!empty($_GET['teacher_name'])){
  			$map['teacher_name'] = array('like','%'.I('teacher_name').'%');
  		}

  		if(!empty($_GET['teacher_cat_id'])){
  			$map['teacher_cat_id'] = array('eq',I('teacher_cat_id'));
  		}

      

      $count = M('teacher')->where($map)->count();
      $Page  = new Page($count);
      $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
      $data = M('teacher')->where($map)->order('teacher_uptime desc')->page($nowPage.','.$Page->listRows)->select();
      foreach ($data as $key => $value) {
        # code...
        $map5['cat_id'] = $data[$key]['teacher_cat_id'];
        $data[$key]['teacher_cat'] = M('cats')->where($map5)->getfield('cat_name');
      }
	//$ms['parent_id'] = array('neq',0);
	  $this->cats = M('cats')->where($ms)->select();
      $this->result = $data;
      $this->pageView = $Page->show();

      $this->display();
    }


    public function teacherType(){
      $map['teacher_id'] = I('teacher_id');
      $data['teacher_type'] = I('teacher_type');
      if(M('teacher')->where($map)->save($data)){
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


    public function updateteacher(){
      if(IS_POST){
        $maps['teacher_id'] = I('teacher_id');
        $save['teacher_name'] = I('teacher_name');
		$save['tel'] = I('tel');
		$save['px'] = I('px');
		$save['teacher_job'] = I('teacher_job');
		$save['teacher_image'] = I('pic');
        $save['teacher_brief'] = I('teacher_brief');
        $save['teacher_cat_id'] = I('teacher_cat_id');
		$save['teacher_uptime'] = time();
        if(M('teacher')->where($maps)->save($save)){
          $return['state'] = 100;
          $return['msg'] = '修改成功!' ;
        }else{
          $return['state'] = 200;
          $return['msg'] = '未做修改!' ;
        }
        echo json_encode($return);
        exit;
      }else{
        $map['teacher_id'] = I('id');

        $data = M('teacher')->where($map)->find();
        if(!$data){
          redirect(U('Index/error'));
        }else{
          $this->data = $data;

          //找到所有的视频分类
			//$ms['parent_id'] = array('neq',0);
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

    public function addteacher(){
      $data['teacher_name'] = I('teacher_name');
	  $data['teacher_job'] = I('teacher_job');
	  $data['tel'] = I('tel');
	  $data['px'] = I('px');
      $data['teacher_cat_id'] = I('teacher_cat_id');
      $data['teacher_brief'] = I('teacher_brief');
	  $data['teacher_image'] = I('pic');
	  $data['teacher_uptime'] = time();
	  $data['passwords'] = MD5('123456');
	  
	  $m['teacher_name'] = $data['teacher_name'];
	  $m['teacher_cat_id'] =  $data['teacher_cat_id'];
      if(M('teacher')->where($m)->find()){
        $return['state'] = 300;
  			$return['msg'] = '该部门下已经有这个人员名称了，不需要重复添加!' ;
        echo json_encode($return);
    		exit;
      }

      if(M('teacher')->add($data)){
        $return['state'] = 100;
  			$return['msg'] = '人员添加成功!' ;
  		}else{
  			$return['state'] = 200;
  			$return['msg'] = '人员添加失败!' ;
  		}
  		echo json_encode($return);
  		exit;
    }



    public function del_teacher(){
      $map['teacher_id'] = I('teacher_id');
   
      if(M('teacher')->where($map)->delete()){
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
