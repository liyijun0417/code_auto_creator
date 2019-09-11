<?php
//该代码由原型架构器自动生成----------李沂君（2018-08-21 11:13:54）
namespace Admin\Controller;
use Think\Controller;

use Yijun\Page;

class SysNodeController extends BaseController {
public function all(){

	$count =  M('SysNode')->where()->count();
	$Page = new Page($count);	//实例化分页类
    $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
	$show = $Page->show();	//分页显示输出
	$sys_nodeList =  M('SysNode')->where()->page($nowPage.','.$Page->listRows)->select();	//分页查询
	$this->assign('page',$show);	//赋值分页输出
	$this->assign('sys_nodeList', $sys_nodeList);
	$this->display();
}

public function add(){
	if(IS_POST){
		$sys_nodeModel = M('SysNode');
		$sys_nodeModel ->create();
		$flag = $sys_nodeModel ->add();
		if($flag){
                $return['state'] = 100;
                $return['msg'] = '操作成功!' ;
            }else{
                $return['state'] = 200;
                $return['sql'] = $sys_nodeModel->_sql();
                $return['msg'] = '操作失败!' ;
            }
            echo json_encode($return);
            exit;
	}else{
		$this->display(); 
	}
}

public function edit(){
	$sys_nodeModel = M('SysNode');
	if(IS_POST){
		$sys_nodeModel ->create();
		$flag = $sys_nodeModel ->save();
		if($flag){
            $return['state'] = 100;
            $return['msg'] = '操作成功!' ;
        }else{
            $return['state'] = 200;
            $return['sql'] = $sys_nodeModel->_sql();
            $return['msg'] = '操作失败!' ;
        }
        echo json_encode($return);
        exit;
	}else{
		$id = I('id'); 
		$sys_node = $sys_nodeModel->find($id);
		$this->assign('sys_node', $sys_node);
		$this->display();
	}
}

public function delete(){
	$sys_nodeModel = M('sys_node');
	$map['id'] = I('id');
	$flag = $sys_nodeModel->where($map)->delete();
	if($flag){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
     }else{
        $return['state'] = 200;
        $return['sql'] = $sys_nodeModel->_sql();
        $return['msg'] = '操作失败!' ;
    }
    echo json_encode($return);
    exit;
}

}