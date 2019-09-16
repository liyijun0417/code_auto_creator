<?php
//该代码由原型架构器自动生成----------李沂君（2019-09-16 19:06:15）
namespace Admin\Controller;
use Think\Controller;

use Yijun\Page;

class MassLeaveController extends BaseController {
public function all(){

	$count =  M('MassLeave')->where()->count();
	$Page = new Page($count);	//实例化分页类
    $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
	$show = $Page->show();	//分页显示输出
	$mass_leaveList =  M('MassLeave')->where()->page($nowPage.','.$Page->listRows)->select();	//分页查询
	$this->assign('page',$show);	//赋值分页输出
	$this->assign('mass_leaveList', $mass_leaveList);
	$this->display();
}

public function add(){
	if(IS_POST){
		$mass_leaveModel = M('MassLeave');
		$mass_leaveModel ->create();
		$flag = $mass_leaveModel ->add();
		if($flag){
                $return['state'] = 100;
                $return['msg'] = '操作成功!' ;
            }else{
                $return['state'] = 200;
                $return['sql'] = $mass_leaveModel->_sql();
                $return['msg'] = '操作失败!' ;
            }
            echo json_encode($return);
            exit;
	}else{
		$this->display(); 
	}
}

public function edit(){
	$mass_leaveModel = M('MassLeave');
	if(IS_POST){
		$mass_leaveModel ->create();
		$flag = $mass_leaveModel ->save();
		if($flag){
            $return['state'] = 100;
            $return['msg'] = '操作成功!' ;
        }else{
            $return['state'] = 200;
            $return['sql'] = $mass_leaveModel->_sql();
            $return['msg'] = '操作失败!' ;
        }
        echo json_encode($return);
        exit;
	}else{
		$id = I('id'); 
		$mass_leave = $mass_leaveModel->find($id);
		$this->assign('mass_leave', $mass_leave);
		$this->display();
	}
}

public function delete(){
	$mass_leaveModel = M('mass_leave');
	$map['id'] = I('id');
	$flag = $mass_leaveModel->where($map)->delete();
	if($flag){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
     }else{
        $return['state'] = 200;
        $return['sql'] = $mass_leaveModel->_sql();
        $return['msg'] = '操作失败!' ;
    }
    echo json_encode($return);
    exit;
}

}