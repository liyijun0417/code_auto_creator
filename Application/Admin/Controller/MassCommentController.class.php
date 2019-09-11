<?php
//该代码由原型架构器自动生成----------李沂君（2019-09-11 18:33:06）
namespace Admin\Controller;
use Think\Controller;

use Yijun\Page;

class MassCommentController extends BaseController {
public function all(){

	$count =  M('MassComment')->where()->count();
	$Page = new Page($count);	//实例化分页类
    $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
	$show = $Page->show();	//分页显示输出
	$mass_commentList =  M('MassComment')->where()->page($nowPage.','.$Page->listRows)->select();	//分页查询
	$this->assign('page',$show);	//赋值分页输出
	$this->assign('mass_commentList', $mass_commentList);
	$this->display();
}

public function add(){
	if(IS_POST){
		$mass_commentModel = M('MassComment');
		$mass_commentModel ->create();
		$flag = $mass_commentModel ->add();
		if($flag){
                $return['state'] = 100;
                $return['msg'] = '操作成功!' ;
            }else{
                $return['state'] = 200;
                $return['sql'] = $mass_commentModel->_sql();
                $return['msg'] = '操作失败!' ;
            }
            echo json_encode($return);
            exit;
	}else{
		$this->display(); 
	}
}

public function edit(){
	$mass_commentModel = M('MassComment');
	if(IS_POST){
		$mass_commentModel ->create();
		$flag = $mass_commentModel ->save();
		if($flag){
            $return['state'] = 100;
            $return['msg'] = '操作成功!' ;
        }else{
            $return['state'] = 200;
            $return['sql'] = $mass_commentModel->_sql();
            $return['msg'] = '操作失败!' ;
        }
        echo json_encode($return);
        exit;
	}else{
		$id = I('id'); 
		$mass_comment = $mass_commentModel->find($id);
		$this->assign('mass_comment', $mass_comment);
		$this->display();
	}
}

public function delete(){
	$mass_commentModel = M('mass_comment');
	$map['id'] = I('id');
	$flag = $mass_commentModel->where($map)->delete();
	if($flag){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
     }else{
        $return['state'] = 200;
        $return['sql'] = $mass_commentModel->_sql();
        $return['msg'] = '操作失败!' ;
    }
    echo json_encode($return);
    exit;
}

}