<?php
//该代码由原型架构器自动生成----------李沂君（2018-08-21 11:13:55）
namespace Admin\Controller;
use Think\Controller;

use Yijun\Page;

class SysRoleController extends BaseController {
public function all(){

	$count =  M('SysRole')->where()->count();
	$Page = new Page($count);	//实例化分页类
    $nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
	$show = $Page->show();	//分页显示输出
	$sys_roleList =  M('SysRole')->where()->page($nowPage.','.$Page->listRows)->select();	//分页查询
	$this->assign('page',$show);	//赋值分页输出
	$this->assign('sys_roleList', $sys_roleList);
	$this->display();
}

public function add(){
	if(IS_POST){
		$sys_roleModel = M('SysRole');
		$sys_roleModel ->create();
        $sys_roleModel->date = date('Y-m-d H:i:s',time());
        $map['name'] = I('name');
        if(M('SysRole')->where($map)->find()){
            $return['state'] = 200;
            $return['msg'] = '该角色名称已被使用!' ;
            echo json_encode($return);
            exit;
        }
		$flag = $sys_roleModel ->add();
		if($flag){
                $return['state'] = 100;
                $return['msg'] = '操作成功!' ;
            }else{
                $return['state'] = 200;
                $return['sql'] = $sys_roleModel->_sql();
                $return['msg'] = '操作失败!' ;
            }
            echo json_encode($return);
            exit;
	}else{
		$this->display(); 
	}
}

    public function access(){
        $role = url_base64_decode ( I('role') );
        $map['id'] = $role;
        $roleInfo  = M('SysRole')->where($map)->find();
        $authInfo  = explode(",", $roleInfo['authcode']);
        $whereMap['level']  = array('neq',1);
        $result = M('SysNode')->where($whereMap)->order('level')->select();
        $nodeTree = array();
        foreach($result as $key=>$value){
            if($value['level']==2){
                $nodeTree[$value['controller']]['title']=$value['title'];
                $nodeTree[$value['controller']]['name'] =$value['name'];
            }else{
                if( in_array($value['code'],$authInfo) ){
                    $value['checked'] = 1;
                }else{
                    $value['checked'] = 0;
                }
                $nodeTree[$value['controller']]['detail'][]=$value;
            }
        }
        //print_r($nodeTree);exit;
        $this->roleInfo = $roleInfo;
        $this->nodeTree = $nodeTree;

        if(session('administrator')){
            $this->administrator = 1;
        }else{
            $this->administrator = 0;
        }
        $this->display();
    }

    public function setAccess(){
        $role = I('role');
        $map['id'] = $role;
        $node = I('node');
        if(is_array($node)&&!empty($node)){
            $sqlData['authcode'] = implode(',',$node);
            $authstr = M('SysNode')->where(array('code'=>array('in',$sqlData['authcode'])))->field('title')->select();
            foreach($authstr as $k=>$v){
                $authstr[$k] = $v['title'];
            }
            $sqlData['authstr'] = implode(',',$authstr);
        }

        $sqlData['date']     = date('Y-m-d H:i:s');
        $result = M('SysRole')->where($map)->save($sqlData);
        if($result){
            $return['state'] = 100;
            $return['msg']   = "设置成功";
            $return['url']   = U("SysRole/all");
        }else{
            $return['state'] = 200;
            $return['msg']   = "设置失败";
        }
        echo json_encode($return);
        exit;
    }


    public function node(){
        if (IS_POST) {
            $sqlData = array();
            $sqlData ['module'] = 'Admin';
            $sqlData ['title']  = I('title');
            switch( I('level') ){
                case 'Action':
                    $sqlData ['name']   = $sqlData ['module'].'-'.I('Controller').'-'.I('Action');
                    $sqlData ['controller'] = I('Controller');
                    $sqlData ['action'] = I('Action');
                    $sqlData ['level']  = 3;
                    $sqlData ['code'] = md5( strtoupper($sqlData ['module'].$sqlData ['controller'].$sqlData ['action']) );
                    break;
                case 'Controller':
                    $sqlData ['name']   = $sqlData ['module'].'-'.I('Controller');
                    $sqlData ['controller'] = I('Controller');
                    $sqlData ['level']  = 2;
                    $sqlData ['code'] = md5( strtoupper($sqlData ['module'].$sqlData ['controller']) );
                    break;
            }

            $result = M('SysNode')->add($sqlData);
            if($result){
                $return['state'] = 100;
                $return['msg']   = "添加成功";
            }else{
                $return['state'] = 200;
                $return['msg']   = "添加失败";
            }
            echo json_encode($return);
            exit;
        }
        $this->display();
    }

public function edit(){
	$sys_roleModel = M('SysRole');
	if(IS_POST){
		$sys_roleModel ->create();
		$flag = $sys_roleModel ->save();
		if($flag){
            $return['state'] = 100;
            $return['msg'] = '操作成功!' ;
        }else{
            $return['state'] = 200;
            $return['sql'] = $sys_roleModel->_sql();
            $return['msg'] = '操作失败!' ;
        }
        echo json_encode($return);
        exit;
	}else{
		$id = I('id'); 
		$sys_role = $sys_roleModel->find($id);
		$this->assign('sys_role', $sys_role);
		$this->display();
	}
}

public function delete(){
	$sys_roleModel = M('sys_role');
	$map['id'] = I('id');
	$flag = $sys_roleModel->where($map)->delete();
	if($flag){
        $return['state'] = 100;
        $return['msg'] = '操作成功!' ;
     }else{
        $return['state'] = 200;
        $return['sql'] = $sys_roleModel->_sql();
        $return['msg'] = '操作失败!' ;
    }
    echo json_encode($return);
    exit;
}

}