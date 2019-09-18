<?php
//该代码由原型架构器自动生成----------李沂君（2019-09-18 16:35:15）
namespace Admin\Controller;
use Think\Controller;

use Yijun\Page;

class MassDriverinforController extends BaseController {
public function all(){

	$count =  M('MassDriverinfor')->where()->count();
	$Page = new Page($count);	//实例化分页类
    $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
	$show = $Page->show();	//分页显示输出
	$mass_driverinforList =  M('MassDriverinfor')->where()->page($nowPage.','.$Page->listRows)->select();	//分页查询
	$this->assign('page',$show);	//赋值分页输出
	$this->assign('mass_driverinforList', $mass_driverinforList);
	$this->display();
}

public function add(){
	if(IS_POST){
		$mass_driverinforModel = M('MassDriverinfor');
		$mass_driverinforModel ->create();
		$flag = $mass_driverinforModel ->add();
		if($flag){
                $return['state'] = 100;
                $return['msg'] = '操作成功!' ;
            }else{
                $return['state'] = 200;
                $return['sql'] = $mass_driverinforModel->_sql();
                $return['msg'] = '操作失败!' ;
            }
            echo json_encode($return);
            exit;
	}else{
		$this->display(); 
	}
}

public function edit(){
	$mass_driverinforModel = M('MassDriverinfor');
	if(IS_POST){
		$mass_driverinforModel ->create();
		$flag = $mass_driverinforModel ->save();
		if($flag){
            $return['state'] = 100;
            $return['msg'] = '操作成功!' ;
        }else{
            $return['state'] = 200;
            $return['sql'] = $mass_driverinforModel->_sql();
            $return['msg'] = '操作失败!' ;
        }
        echo json_encode($return);
        exit;
	}else{
		$id = I('id'); 
		$mass_driverinfor = $mass_driverinforModel->find($id);
		$this->assign('mass_driverinfor', $mass_driverinfor);
		$this->display();
	}
}

public function delete(){
	$mass_driverinforModel = M('mass_driverinfor');
	$map['id'] = I('id');
	$flag = $mass_driverinforModel->where($map)->delete();
	if($flag){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
     }else{
        $return['state'] = 200;
        $return['sql'] = $mass_driverinforModel->_sql();
        $return['msg'] = '操作失败!' ;
    }
    echo json_encode($return);
    exit;
}

}