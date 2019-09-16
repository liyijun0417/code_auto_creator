<?php
//该代码由原型架构器自动生成----------李沂君（2019-09-16 17:10:02）
namespace Admin\Controller;
use Think\Controller;

use Yijun\Page;

class MassCatsController extends BaseController {
public function all(){

	$count =  M('MassCats')->where()->count();
	$Page = new Page($count);	//实例化分页类
    $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
	$show = $Page->show();	//分页显示输出
	$mass_catsList =  M('MassCats')->where()->page($nowPage.','.$Page->listRows)->select();	//分页查询
	$this->assign('page',$show);	//赋值分页输出
	$this->assign('mass_catsList', $mass_catsList);
	$this->display();
}

public function add(){
	if(IS_POST){
		$mass_catsModel = M('MassCats');
		$mass_catsModel ->create();
		$flag = $mass_catsModel ->add();
		if($flag){
                $return['state'] = 100;
                $return['msg'] = '操作成功!' ;
            }else{
                $return['state'] = 200;
                $return['sql'] = $mass_catsModel->_sql();
                $return['msg'] = '操作失败!' ;
            }
            echo json_encode($return);
            exit;
	}else{
		$this->display(); 
	}
}

public function edit(){
	$mass_catsModel = M('MassCats');
	if(IS_POST){
		$mass_catsModel ->create();
		$flag = $mass_catsModel ->save();
		if($flag){
            $return['state'] = 100;
            $return['msg'] = '操作成功!' ;
        }else{
            $return['state'] = 200;
            $return['sql'] = $mass_catsModel->_sql();
            $return['msg'] = '操作失败!' ;
        }
        echo json_encode($return);
        exit;
	}else{
		$id = I('id'); 
		$mass_cats = $mass_catsModel->find($id);
		$this->assign('mass_cats', $mass_cats);
		$this->display();
	}
}

public function delete(){
	$mass_catsModel = M('mass_cats');
	$map['id'] = I('id');
	$flag = $mass_catsModel->where($map)->delete();
	if($flag){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
     }else{
        $return['state'] = 200;
        $return['sql'] = $mass_catsModel->_sql();
        $return['msg'] = '操作失败!' ;
    }
    echo json_encode($return);
    exit;
}

}