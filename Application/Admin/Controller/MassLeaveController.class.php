<?php
//由ThinkphpHelper自动生成,请根据需要修改
namespace Admin\Controller;
use Think\Controller;

class MassLeaveController extends Controller {
public function all(){
	$mass_leaveModel = M('MassLeave');
	$count = $mass_leaveModel->where()->count();
	$Page = new \Think\Page($count,15);	//实例化分页类 传入总记录数和每页显示的记录数(15)
	$show = $Page->show();	//分页显示输出
	$mass_leaveList = $mass_leaveModel->where()->limit($Page->firstRow.','.$Page->listRows)->select();	//分页查询
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
			$this->success('新建成功',U('MassLeave/all')); 
		}else{
			$this->error('新建失败',U('MassLeave/all')); 
		}
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
			$this->success('编辑成功',U('MassLeave/all')); 
		}else{
			$this->error('编辑失败',U('MassLeave/all')); 
		}
	}else{
		$id = I('id'); 
		$mass_leave = $mass_leaveModel->find($id);
		$this->assign('mass_leave', $mass_leave);
		$this->display();
	}
}

public function delete(){
	$mass_leaveModel = M('mass_leave');
	$id = I('id'); 
	$flag = $mass_leaveModel->where('id='.$id)->delete();
	if($flag){
		$this->success('删除成功', U('MassLeave/all'));
	}else{
		$this->error('删除失败', U('MassLeave/all'));
	}
}

}