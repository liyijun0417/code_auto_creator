<?php
//该代码由原型架构器自动生成----------李沂君（2018-08-07 18:25:55）
namespace Admin\Controller;
use Think\Controller;

use Yijun\Page;

class SysUserInfoController extends BaseController {
public function all(){

	$count =  M('SysUserInfo')->count();
	$Page = new Page($count);	//实例化分页类
    $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
	$show = $Page->show();	//分页显示输出
	$sys_user_infoList =  M('SysUserInfo')->alias('a')
        ->field('a.id,a.user_name,a.create_time,a.update_time,a.last_login_time,a.status,b.name')
        ->join('sys_role as b ON b.id = a.role','LEFT')
        ->where()
        ->page($nowPage.','.$Page->listRows)
        ->order('create_time desc')
        ->select();	//分页查询
	$this->role = M('SysRole')->where(['status'=>1])->select();//所有已激活了的角色
    $this->assign('page',$show);	//赋值分页输出
	$this->assign('sys_user_infoList', $sys_user_infoList);
	$this->display();
}

public function add(){
	if(IS_POST){
        $username = I('post.user_name');
        $password = I('post.password');
		$sys_user_infoModel = M('SysUserInfo');
		$sys_user_infoModel ->create();
        $sys_user_infoModel->password = sha1($password);
        $sys_user_infoModel->create_time = date('Y-m-d H:i:s',time());
        $sys_user_infoModel->update_time = date('Y-m-d H:i:s',time());
        if($sys_user_infoModel->where(['user_name'=>$username])->find()){
            $return['state'] = 200;
            $return['msg'] = '该账号已被使用!' ;
            echo json_encode($return);
            exit;
        }
        if($username=='liyijun'){
            $return['state'] = 200;
            $return['msg'] = '不能添加该账号!' ;
            echo json_encode($return);
            exit;
        }
		$flag = $sys_user_infoModel ->add();
		if($flag){
                $return['state'] = 100;
                $return['msg'] = '操作成功!' ;
            }else{
                $return['state'] = 200;
                $return['sql'] = $sys_user_infoModel->_sql();
                $return['msg'] = '操作失败!' ;
            }
            echo json_encode($return);
            exit;
	}else{
		$this->display(); 
	}
}

public function edit(){
	$sys_user_infoModel = M('SysUserInfo');
	if(IS_POST){
		//$sys_user_infoModel->create();
        $map['id'] = I('id');
        $save['update_time'] = date('Y-m-d H:i:s',time());
        $save['tel'] = I('tel');
        $save['role'] = I('role');
        $save['status'] = I('status');
		$flag = $sys_user_infoModel->where($map)->save($save);
		if($flag){
            $return['state'] = 100;
            $return['msg'] = '操作成功!' ;
        }else{
            $return['state'] = 200;
            $return['sql'] = $sys_user_infoModel->_sql();
            $return['msg'] = '操作失败!' ;
        }
        echo json_encode($return);
        exit;
	}else{
		$id = I('id'); 
		$sys_user_info = $sys_user_infoModel->find($id);
        $this->role = M('SysRole')->where(['status'=>1])->select();//所有已激活了的角色
		$this->assign('sys_user_info', $sys_user_info);
		$this->display();
	}
}

public function delete(){
	$sys_user_infoModel = M('sys_user_info');
	$map['id'] = I('id');
	$flag = $sys_user_infoModel->where($map)->delete();
	if($flag){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
     }else{
        $return['state'] = 200;
        $return['sql'] = $sys_user_infoModel->_sql();
        $return['msg'] = '操作失败!' ;
    }
    echo json_encode($return);
    exit;
}

    public function userType(){
        $sys_user_infoModel = M('sys_user_info');
        $map['id'] = I('id');
        $save['status'] = I('type');
        $save['update_time'] = date('Y-m-d H:i:s',time());
        $flag = $sys_user_infoModel->where($map)->save($save);
        if($flag){
            $return['state'] = 100;
            $return['msg'] = '操作成功!' ;
        }else{
            $return['state'] = 200;
            $return['sql'] = $sys_user_infoModel->_sql();
            $return['msg'] = '操作失败!' ;
        }
        echo json_encode($return);
        exit;
    }

}