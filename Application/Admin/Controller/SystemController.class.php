<?php
namespace Admin\Controller;
use Think\Controller;
use Yijun\Page;


class SystemController extends BaseController {

	public function index(){


			$count = M('admin')->where($map)->count();
			$Page  = new Page($count);
			
			$nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
			$result= M('admin')->where($map)->order($qyorder)->page($nowPage.','.$Page->listRows)->select();
			

			$this->result  = $result;

			$this->pageView = $Page->show();

			$this->display();
	}

	public function add(){
			$map['admin_name'] = I('username');
			if($map['admin_name'] == 'liyijun'){
				$return['state'] = 300;
				$return['msg'] = '不能添加该账号!' ;
				echo json_encode($return);
				exit;
			}
			if(M('admin')->where($map)->find()){
				$return['state'] = 300;
				$return['msg'] = '该用户名已存在，请使用其他用户名!' ;
				echo json_encode($return);
				exit;
			}
			$password = I('password');
			$data['admin_name'] = I('username');
			$data['admin_password'] = sha1($password);
			$data['admin_status'] = 1;
			$result = M('admin')->add($data);
			if($result){
				$return['state'] = 100;
				$return['msg'] = '添加管理员成功!' ;
				echo json_encode($return);
				exit;
			}else{
				$return['state'] = 200;
				$return['msg'] = '添加管理员失败!' ;
				echo json_encode($return);
				exit;
			}
	}


	public function cats(){
		$count = M('cats')->where($map)->count();
		$map['parent_id'] = 0;
		$Page  = new Page($count);
		$nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
		$data = M('cats')->where($map)->page($nowPage.','.$Page->listRows)->select();
		foreach($data as $k=>$v){
			$mad['parent_id'] = $data[$k]['cat_id'];
			$data[$k]['c_category'] = M('cats')->where($mad)->select();
		}
		//print_r($data);

		$this->result = $data;
		$this->pageView = $Page->show();

		$this->display();
	}
	
	public function action(){
		$count = M('action')->where($map)->count();
		$map['parent_id'] = 0;
		$Page  = new Page($count);
		$nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
		$data = M('action')->where($map)->page($nowPage.','.$Page->listRows)->select();
		

		$this->result = $data;
		$this->pageView = $Page->show();

		$this->display();
	}
	
	
	public function recovery(){
		if(!empty($_GET['teacher_name'])){
  			$map4['teacher_name'] = I('teacher_name');
			$map['teacher_id'] = M('teacher')->where($map4)->getfield('teacher_id');
  		}
		
		$count = M('recovery')->where($map)->count();
		$Page  = new Page($count);
		$nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
		$data = M('recovery')->where($map)->page($nowPage.','.$Page->listRows)->order('addtime desc')->select();
		foreach($data as $k=>$v){
			$map['teacher_id'] = $data[$k]['teacher_id'];
			$data[$k]['people'] = M('teacher')->where($map)->getfield('teacher_name');
			
			$map1['cat_id'] = $data[$k]['action_id'];
			
			$data[$k]['cat_name'] = M('action')->where($map1)->getfield('cat_name');
		}

		$this->result = $data;
		$this->pageView = $Page->show();

		$this->cat = M('action')->select();
		
		$this->display();
	}
	
	
	public function vocation(){
		if(!empty($_GET['teacher_name'])){
  			$map4['teacher_name'] = I('teacher_name');
			$map['teacher_id'] = M('teacher')->where($map4)->getfield('teacher_id');
  		}
		
		
		if(!empty($_GET['start'])&&!empty($_GET['over'])){
  			$start_time = $_GET['start'];
			$start_time = strtotime($start_time);
			
			$end_time = $_GET['over'];
			$end_time = strtotime($end_time);
			
			if($start_time==$end_time){
				$map['addtime'] = $start_time;
			}else{
				$mfg = $start_time.','.$end_time;
				$map['addtime'] = array('between',$mfg);

				$mapd['addtime'] = array('between',$mfg);
				$mapd1['addtime'] = array('between',$mfg);
				$mapd2['addtime'] = array('between',$mfg);
				$mapd5['addtime'] = array('between',$mfg);
				$mapd6['addtime'] = array('between',$mfg);
				$mapd7['addtime'] = array('between',$mfg);
				$mapd8['addtime'] = array('between',$mfg);
				$mapda['addtime'] = array('between',$mfg);
				$mapdb['addtime'] = array('between',$mfg);
				$mapdc['addtime'] = array('between',$mfg);
				$mapd3['addtime'] = array('between',$mfg);

				//$map['st'] = array('egt',$start_time);//array('between',$mfg);
				//$map['et'] = array('elt',$end_time);

			}
			
  		}
		
		$count = M('vocation')->where($map)->count();
		$Page  = new Page($count);
		$nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
		$data = M('vocation')->where($map)->group('teacher_id')->page($nowPage.','.$Page->listRows)->order('et desc')->select();
		//这里的分页有问题 ， 但是我不想改了 。 原因在于要先查人员 ，再查请假记录 ， 分页是以人员数量来分 。 谁以后改一下。
		// print_r(M('vocation')->_sql());
		
		foreach($data as $k=>$v){
			$maps['teacher_id'] = $data[$k]['teacher_id'];
			$data[$k]['people'] = M('teacher')->where($maps)->getfield('teacher_name');
			
			$map1['cat_id'] = $data[$k]['action_id'];
			
			$data[$k]['cat_name'] = M('action')->where($map1)->getfield('cat_name');
			//公休
			$mapd['teacher_id'] = $data[$k]['teacher_id'];
			$mapd['action_id'] = 7;
			$data[$k]['gongxiu'] = M('vocation')->where($mapd)->sum('day_num');
			//事假
			$mapd1['teacher_id'] = $data[$k]['teacher_id'];
			$mapd1['action_id'] = 5;
			$data[$k]['shijia'] = M('vocation')->where($mapd1)->sum('day_num');
			//病假
			$mapd2['teacher_id'] = $data[$k]['teacher_id'];
			$mapd2['action_id'] = 6;
			$data[$k]['bingjia'] = M('vocation')->where($mapd2)->sum('day_num');
			//学习
			$mapd5['teacher_id'] = $data[$k]['teacher_id'];
			$mapd5['action_id'] = 18;
			$data[$k]['xuexi'] = M('vocation')->where($mapd5)->sum('day_num');
			
			//peixun
			$mapd6['teacher_id'] = $data[$k]['teacher_id'];
			$mapd6['action_id'] = 20;
			$data[$k]['peixun'] = M('vocation')->where($mapd6)->sum('day_num');
			
			//chanjia
			$mapd7['teacher_id'] = $data[$k]['teacher_id'];
			$mapd7['action_id'] = 27;
			$data[$k]['chanjia'] = M('vocation')->where($mapd7)->sum('day_num');
			
			//hunjia
			$mapd8['teacher_id'] = $data[$k]['teacher_id'];
			$mapd8['action_id'] = 26;
			$data[$k]['hunjia'] = M('vocation')->where($mapd8)->sum('day_num');
			
			
			
			
			//buxiu
			$mapda['teacher_id'] = $data[$k]['teacher_id'];
			$mapda['action_id'] = 19;
			$data[$k]['buxiu'] = M('vocation')->where($mapda)->sum('day_num');
			
			//kaihui
			$mapdb['teacher_id'] = $data[$k]['teacher_id'];
			$mapdb['action_id'] = 8;
			$data[$k]['kaihui'] = M('vocation')->where($mapdb)->sum('day_num');
			
			//tijian
			$mapdc['teacher_id'] = $data[$k]['teacher_id'];
			$mapdc['action_id'] = 28;
			$data[$k]['tijian'] = M('vocation')->where($mapdc)->sum('day_num');
			
			
			$mapd3['teacher_id'] = $data[$k]['teacher_id'];
			
			$data[$k]['total'] = M('vocation')->where($mapd3)->sum('day_num');
            $this->pageView = $Page->show();
		}

		$this->result = $data;


		$this->cat = M('action')->select();
		
		$this->display();
	}
	
	public function vocation2(){
		if(!empty($_GET['teacher_name'])){
  			$map4['teacher_name'] = I('teacher_name');
			$map['teacher_id'] = M('teacher')->where($map4)->getfield('teacher_id');
  		}
		
		
		$count = M('vocation')->where($map)->count();
		$Page  = new Page($count);
		$nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
		$data = M('vocation')->where($map)->page($nowPage.','.$Page->listRows)->order('et desc')->select();
		
		foreach($data as $k=>$v){
			$maps['teacher_id'] = $data[$k]['teacher_id'];
			$data[$k]['people'] = M('teacher')->where($maps)->getfield('teacher_name');
			
			$map1['cat_id'] = $data[$k]['action_id'];
			
			$data[$k]['cat_name'] = M('action')->where($map1)->getfield('cat_name');
			
		}
		//print_r($data);
		$this->result = $data;
		$this->pageView = $Page->show();

		$this->cat = M('action')->select();
		
		$this->display();
	}
	
	
	public function updateAction(){
      $map['id'] = I('id');
	  $save['action_id'] = I('action_id');

      if(M('recovery')->where($map)->save($save)){
			$return['state'] = 100;
  			$return['msg'] = '修改成功!' ;
			
  		}else{
  			$return['state'] = 200;
  			$return['msg'] = '未做任何修改!' ;
  		}
  		echo json_encode($return);
  		exit;
    }
	
	
	
	

	public function updateCats(){
      $data['cat_name']  = I('cat_name');
      $data['px']  = I('px');
      $map['cat_id'] = I('id');

      if(M('cats')->where($map)->save($data)){
        $return['state'] = 100;
  			$return['msg'] = '修改成功!' ;
			$return['cat_name'] = $data['cat_name'];
			$return['px'] = $data['px'];
  		}else{
  			$return['state'] = 200;
  			$return['msg'] = '未做任何修改!' ;
  		}
  		echo json_encode($return);
  		exit;
    }
	
	
	public function updateActionCats(){
      $data['cat_name']  = I('cat_name');
      $data['px']  = I('px');
      $map['cat_id'] = I('id');

      if(M('action')->where($map)->save($data)){
        $return['state'] = 100;
  			$return['msg'] = '修改成功!' ;
			$return['cat_name'] = $data['cat_name'];
			$return['px'] = $data['px'];
  		}else{
  			$return['state'] = 200;
  			$return['msg'] = '未做任何修改!' ;
  		}
  		echo json_encode($return);
  		exit;
    }
	
	public function updateCatName(){
      $data['cat_name']  = I('cat_name');
      $map['cat_id'] = I('id');

      if(M('cats')->where($map)->save($data)){
        $return['state'] = 100;
  			$return['msg'] = '修改成功!' ;
			$return['cat_name'] = $data['cat_name'];
  		}else{
  			$return['state'] = 200;
  			$return['msg'] = '未做任何修改!' ;
  		}
  		echo json_encode($return);
  		exit;
    }
	
	public function updateActionName(){
      $data['cat_name']  = I('cat_name');
      $map['cat_id'] = I('id');

      if(M('action')->where($map)->save($data)){
        $return['state'] = 100;
  			$return['msg'] = '修改成功!' ;
			$return['cat_name'] = $data['cat_name'];
  		}else{
  			$return['state'] = 200;
  			$return['msg'] = '未做任何修改!' ;
  		}
  		echo json_encode($return);
  		exit;
    }
	
	public function updatePx(){
      $data['px']  = I('px');
      $map['cat_id'] = I('id');

      if(M('cats')->where($map)->save($data)){
        $return['state'] = 100;
  			$return['msg'] = '修改成功!' ;
			$return['px'] = $data['px'];
  		}else{
  			$return['state'] = 200;
  			$return['msg'] = '未做任何修改!' ;
  		}
  		echo json_encode($return);
  		exit;
    }
	
	public function updateActionPx(){
      $data['px']  = I('px');
      $map['cat_id'] = I('id');

      if(M('action')->where($map)->save($data)){
        $return['state'] = 100;
  			$return['msg'] = '修改成功!' ;
			$return['px'] = $data['px'];
  		}else{
  			$return['state'] = 200;
  			$return['msg'] = '未做任何修改!' ;
  		}
  		echo json_encode($return);
  		exit;
    }
	
	public function section(){
		if(IS_POST){
			 $data['cat_section']  = $_POST['cat_section'];
			  $map['cat_id'] = I('cat_id');

			  if(M('cats')->where($map)->save($data)){
				$return['state'] = 100;
					$return['msg'] = '修改成功!' ;
				}else{
					$return['state'] = 200;
					$return['sql'] = M('cats')->_sql();
					$return['msg'] = '未做任何修改!' ;
				}
				echo json_encode($return);
				exit;
		}else{
			$map['cat_id'] = I('cat_id');
			$this->data = M('cats')->where($map)->find();
			$this->display();
		}
    }

	public function del_it(){
		$map['admin_id'] = I('id');
		if(M('admin')->where($map)->delete()){
			$return['state'] = 100;
			$return['msg'] = '删除管理员成功!' ;
		}else{
			$return['state'] = 200;
			$return['msg'] = '删除管理员失败!' ;
		}
		echo json_encode($return);
		exit;
	}
	
	    public function addCat(){
		  $data['cat_name'] = I('cat_name');
		
		  if(M('cats')->where($data)->find()){
			$return['state'] = 300;
				$return['msg'] = '该部门已存在，不需要重复添加!' ;
				echo json_encode($return);
				exit;
		  }

		  if(M('cats')->add($data)){
			$return['state'] = 100;
				$return['msg'] = '添加成功!' ;
			}else{
				$return['state'] = 200;
				$return['msg'] = '添加失败!' ;
			}
			echo json_encode($return);
			exit;
		}
		
		 public function addActionCat(){
		  $data['cat_name'] = I('cat_name');
		
		  if(M('action')->where($data)->find()){
			$return['state'] = 300;
				$return['msg'] = '该部门已存在，不需要重复添加!' ;
				echo json_encode($return);
				exit;
		  }

		  if(M('action')->add($data)){
			$return['state'] = 100;
				$return['msg'] = '添加成功!' ;
			}else{
				$return['state'] = 200;
				$return['msg'] = '添加失败!' ;
			}
			echo json_encode($return);
			exit;
		}
		
		
		public function addCat2(){
		  $data['cat_name'] = I('category2');
		  $data['parent_id'] = I('category');
		  if(M('cats')->where($data)->find()){
			$return['state'] = 300;
				$return['msg'] = '该部门已存在，不需要重复添加!' ;
				echo json_encode($return);
				exit;
		  }
		  $res = M('cats')->add($data);
		  if($res){
			$return['state'] = 100;
				$return['msg'] = '添加成功!' ;
				$return['cat_name'] =  $data['cat_name'];
				$return['cat_id'] = $res;
			}else{
				$return['state'] = 200;
				$return['msg'] = '添加失败!' ;
			}
			echo json_encode($return);
			exit;
		}
		
		public function addActionCat2(){
		  $data['cat_name'] = I('category2');
		  $data['parent_id'] = I('category');
		  if(M('action')->where($data)->find()){
			$return['state'] = 300;
				$return['msg'] = '该行为已存在，不需要重复添加!' ;
				echo json_encode($return);
				exit;
		  }
		  $res = M('action')->add($data);
		  if($res){
			$return['state'] = 100;
				$return['msg'] = '添加成功!' ;
				$return['cat_name'] =  $data['cat_name'];
				$return['cat_id'] = $res;
			}else{
				$return['state'] = 200;
				$return['msg'] = '添加失败!' ;
			}
			echo json_encode($return);
			exit;
		}
	
	public function del_cats(){
		$map['cat_id'] = I('id');
		$bb['parent_id'] = I('id');
		$bel = M('cats')->where($bb)->select();
		if($bel){
			$return['state'] = 300;
			$return['msg'] = '请先删除该镇下面的部门组!' ;
			echo json_encode($return);
			exit;
		}
		if(M('cats')->where($map)->delete()){
			$return['state'] = 100;
			$return['msg'] = '删除成功!' ;
		}else{
			$return['state'] = 200;
			$return['msg'] = '删除失败!' ;
		}
		echo json_encode($return);
		exit;
	}
	
	public function del_action_cats(){
		$map['cat_id'] = I('id');
		
		if(M('action')->where($map)->delete()){
			$return['state'] = 100;
			$return['msg'] = '删除成功!' ;
		}else{  
			$return['state'] = 200;
			$return['msg'] = '删除失败!' ;
		}
		echo json_encode($return);
		exit;
	}
	
	
	public function kqzx(){
		
	}


	//total + order 
	public function total(){

		$type = I('type');
		$dates = I('day');
		if(empty($dates)){
			$map9['day'] = date('Y-m-d',time());
		}else{
			$map9['day'] = $dates;
		}
			
		if($type=='hours'){
			$list = M('recovery')->distinct(true)->field("hour")->where($map9)->order('addtime desc')->select();
		}else if($type=='day'){
			$list = M('recovery')->distinct(true)->field('day')->order('addtime desc')->select();
		}else{
			
		}
		
		$this->lists = $list;
		$this->day = $map9['day'];
		
		
		//print_r(date('H',time()));
		$this->display();
	}


	public function total2(){
		$hor = I('hour');
		if(!empty($hor)){
			$map2['hour']  = I('hour');
		}
		$cat_id = I('cat_id');
		if(!empty($cat_id)){
			$map['teacher_cat_id'] = $cat_id;
		}
		$action = I('action_id');
		if(!empty($action)){
			$map3['cat_id'] = $action;
		}
		$map3['cat_id'] = array('not in','5,6,7,18,20,26,27,8,19,28');//请假类别的不显示出来
		$start = I('start');
		$end = I('end');
		if(!empty($start)&&!empty($end)){
			$map2['day'] = array('between',$star,$end);
		}else{
			$map2['day'] = I('day');
		}
		
		
		
		$this->action = M('action')->where($map3)->select();
		$result = M('teacher')->where($map)->field('teacher_id,teacher_cat_id,teacher_name')->select();
		foreach($result as $k=>$v){
			$map1['cat_id'] = $result[$k]['teacher_cat_id'];
			$result[$k]['cat_name'] = M('cats')->where($map1)->getfield('cat_name');
			$result[$k]['total'] = M('action')->where($map3)->select();
			foreach($result[$k]['total'] as $d=>$b){
				$map2['action_id'] = $result[$k]['total'][$d]['cat_id'];
				$map2['teacher_id'] = $result[$k]['teacher_id'];
				$result[$k]['total'][$d]['count'] = M('recovery')->where($map2)->count();
			}
			
		}
		$this->result = $result;
		
		$this->cats = M('cats')->select();
		$this->actions = M('action')->select();
		
		//print_r($result);
		
		
		$this->display();
	}
	
	
	public function total3(){
		
		$cat_id = I('cat_id');
		if(!empty($cat_id)){
			$map['teacher_cat_id'] = $cat_id;
		}
		$action = I('action_id');
		if(!empty($action)){
			$map3['cat_id'] = $action;
			
		}
		$map3['cat_id'] = array('not in','5,6,7,18,20,26,27,8,19,28');//请假类别的不显示出来
		$start = I('start');
		$end = I('over');
		
		
		if(!empty($start)&&!empty($end)){
			if($start==$end){
				$map2['day'] = $start;
			}else{
				$mfg = $start.','.$end;
				$map2['day'] = array('between',$mfg);
			}
			
			
		}
		
		$this->action = M('action')->where($map3)->select();
		$result = M('teacher')->where($map)->field('teacher_id,teacher_cat_id,teacher_name')->select();
		foreach($result as $k=>$v){
			$map1['cat_id'] = $result[$k]['teacher_cat_id'];
			$result[$k]['cat_name'] = M('cats')->where($map1)->getfield('cat_name');
			$result[$k]['total'] = M('action')->where($map3)->select();
			//print_r(M('action')->_sql());
			foreach($result[$k]['total'] as $d=>$b){
				$map2['action_id'] = $result[$k]['total'][$d]['cat_id'];
				$map2['teacher_id'] = $result[$k]['teacher_id'];
				$result[$k]['total'][$d]['count'] = M('recovery')->where($map2)->count();
				//print_r(M('recovery')->_sql().'</br>');
			}
			
		}
		$this->result = $result;
		
		$this->cats = M('cats')->select();
		$this->actions = M('action')->select();
		
		//print_r($result);
		
		
		$this->display();
		
	}
	
	function bs(){
		$result = M('recovery')->field('day')->select();
		$ids = M('recovery')->field('id')->select();
		foreach($result as $k=>$v){
			$result[$k] = $result[$k]['day'];
			
			$save[$k]['day_unix'] = strtotime($result[$k]);
			
			
		}
		
		M('recovery')->where($ids)->save($save);
		
		print_r($ids);
		
	}
	
	
	
	
	public function charts(){
		$department = I('cat_id');
		$start = strtotime(I('start'));
		$over = strtotime(I('over'));
		if(!empty($department)){
			$mt['teacher_cat_id'] = $department;
		}else{
			$mt['teacher_cat_id'] = 1;
		}
		
		$name = M('teacher')->field('teacher_name')->where($mt)->select();
		foreach($name as $k=>$v){
			$name[$k] = $name[$k]['teacher_name'];
		}
		$this->name = json_encode($name);
		
		$data = array();
		
		
		$action = M('action')->field('cat_name as name,cat_id')->select();
		foreach($action as $d=>$t){
			$action[$d]['data'] = M('teacher')->field('teacher_name,teacher_id')->where($mt)->select();
			foreach($action[$d]['data'] as $b=>$x){
				$md['action_id'] = $action[$d]['cat_id'];
				$md['teacher_id'] = $action[$d]['data'][$b]['teacher_id'];
				$md['day_unixtimestamp'] = array('between',"$start,$over");
				$action[$d]['data'][$b]['data'] = M('recovery')->where($md)->count();
				$action[$d]['data'][$b] = (int)$action[$d]['data'][$b]['data'];
			
			}
			
		}
		
		
		
		$this->data = json_encode($action);
		
		$this->cats = M('cats')->select();
		
		
		$this->display();
	}
	
	
	
	public function checklist(){


			$count = M('check_recovery')->where($map)->count();
			$Page  = new Page($count);
			
			$nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
			$result= M('check_recovery')->where($map)->order('check_time desc')->page($nowPage.','.$Page->listRows)->select();
			foreach($result as $k=>$v){
				$m['admin_id'] = $result[$k]['admin_id'];
				$result[$k]['admin_name'] = M('admin')->where($m)->getfield('admin_name');
			}

			$this->result  = $result;

			$this->pageView = $Page->show();

			$this->display();
	}
	


}