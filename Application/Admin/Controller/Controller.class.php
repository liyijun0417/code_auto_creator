<?php
//该代码由原型架构器自动生成----------李沂君（2019-09-11 18:31:33）
namespace Admin\Controller;
use Think\Controller;

use Yijun\Page;

class Controller extends BaseController {
public function all(){

	$count =  M('')->where()->count();
	$Page = new Page($count);	//实例化分页类
    $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
	$show = $Page->show();	//分页显示输出
	$List =  M('')->where()->page($nowPage.','.$Page->listRows)->select();	//分页查询
	$this->assign('page',$show);	//赋值分页输出
	$this->assign('List', $List);
	$this->display();
}

public function add(){
	if(IS_POST){
		$Model = M('');
		$Model ->create();
		$flag = $Model ->add();
		if($flag){
                $return['state'] = 100;
                $return['msg'] = '操作成功!' ;
            }else{
                $return['state'] = 200;
                $return['sql'] = $Model->_sql();
                $return['msg'] = '操作失败!' ;
            }
            echo json_encode($return);
            exit;
	}else{
		$this->display(); 
	}
}

public function edit(){
	$Model = M('');
	if(IS_POST){
		$Model ->create();
		$flag = $Model ->save();
		if($flag){
            $return['state'] = 100;
            $return['msg'] = '操作成功!' ;
        }else{
            $return['state'] = 200;
            $return['sql'] = $Model->_sql();
            $return['msg'] = '操作失败!' ;
        }
        echo json_encode($return);
        exit;
	}else{
		$id = I('id'); 
		$ = $Model->find($id);
		$this->assign('', $);
		$this->display();
	}
}

public function delete(){
	$Model = M('');
	$map['id'] = I('id');
	$flag = $Model->where($map)->delete();
	if($flag){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
     }else{
        $return['state'] = 200;
        $return['sql'] = $Model->_sql();
        $return['msg'] = '操作失败!' ;
    }
    echo json_encode($return);
    exit;
}

}