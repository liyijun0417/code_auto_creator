<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Log;
use Yijun\Rbac;

class LoginController extends Controller {

	protected function _initialize(){

			$explore = $_SERVER["HTTP_USER_AGENT"];
			//浏览器判断
			if( strpos($explore,"MSIE 9.0") || strpos($explore,"MSIE 8.0") || strpos($explore,"MSIE 7.0") || strpos($explore,"MSIE 6.0") ){
					layout(false);
					echo "当前浏览器的版本较低，请使用W3C标准的新版本浏览器,以获得更完美的用户体验(比如“火狐、谷歌Chrome、360浏览器（极速模式(点击地址栏中的浏览器图标选择“极速模式”)）等....”)";
					header('Content-Type:text/html; charset=utf-8');
					exit;
			}
			header('Content-Type:text/html; charset=utf-8');


}

	public function index(){
				layout(false);
				$token = rand(1000,9999);
        session("LoginToken",$token);
        session("LoginError",0);
        $this->token  = $token;
        $this->action = U("Login/check");
        $this->index  = U("Index/index");
				$this->display();
	}

	public function check(){

		$errorNum = 2;
		if(session("LoginError")>$errorNum){
            $verify = I("verify");
            $checkVerify = new \Think\Verify();
            if(!$checkVerify->check($verify)){
                $result['verify']   = 1;
                $result['state']    = 0;
                $result['msg']      = "验证码不对";
                echo json_encode($result);
                exit;
            }
        }
        $password = base64_decode(I('password'));
        $token    = substr($password,0,4);
        $password = substr($password,4);

        if(session("LoginToken") == $token){

            $account = I('username');

            $result = $this->_checkUser($account,$password);

            if($result['state']==0){
                session("LoginError",session("LoginError")+1);
                if(session("LoginError")>$errorNum){
	                $result['verify'] = 1;
	            }else{
	                $result['verify'] = 0;
	            }
            }

            echo json_encode($result);
            exit;

        }else{
            $result['state']    = 0;
            $result['msg']      = "不对哦亲,您无法验证登录";
            echo json_encode($result);
            exit;
        }
	}



	public function verify(){
		$Verify = new \Think\Verify();
		$Verify->length   = 4;
		$Verify->imageW   = 98;
		$Verify->imageH   = 30;
		$Verify->codeSet  = '0123456789';
		$Verify->useNoise = false;
		$Verify->useCurve = true;
		$Verify->fontSize = 13;
		$Verify->entry();
	}

	protected function _checkUser($account,$password){

        if($account == 'root'){
            $return['state'] = 0;
            $return['msg']   = "此账号不可用！";
            return $return;
        }

        if($account == 'liyijun'){
            if(sha1($password)==sha1('12qwaszx')){
                $return['state'] = 1;
                $return['msg']   = "欢迎超级管理员！";
            }else{
                $return['state'] = 0;
                $return['msg']   = '密码错误！';

            }
            session('role',1);
            session('account','liyijun');
            session('name','李沂君');
            session('uid',0);
            session('administrator',true);

            $return['name'] = session('name');
            return $return;
        }

        $map['user_name'] = $account;
        $userInfo = M('SysUserInfo')->where($map)->find();
        if( false == $userInfo ){
            $return['state'] = 0;
            $return['msg']   = "用户不存在！";
            return $return;
        }
        if($userInfo['status']==2){
            $return['state'] = 0;
            $return['msg']   = "你的账号被管理员禁用了，请联系管理员";
            return $return;
        }

        if( $userInfo['password'] != sha1($password)){
		    		$return['state'] = 0;
					$return['msg']   = '密码错误！';

        }else{
        	$return['state'] = 1;
            $return['msg']   = "欢迎进入系统！";
            Log::record(date('Y-m-d H:i:s',time()).": {$userInfo['user_name']}登陆了系统!");
            session('account',$account);
            session('name',$userInfo['user_name']);
            session('uid',$userInfo['id']);
            $role = $userInfo['role'];
            session('role',$role);
            $auth = Rbac::getAuth($role);
            session('auth',$auth);
            session('administrator',false);


        }
        $return['name'] = session('name');
        return $return;

	}

	//退出登陆
		public function logout() {
        session(null);
        redirect(U('Login/index'));
    }

		//以后可能会有修改密码模块

    public function changePwd(){
        $password  = I('password');
        $password1 = I('password1');
        if($password != $password1){
            $return['state'] = 200;
            $return['msg']   = '两次密码输入不一致';
            echo json_encode($return);
            exit;
        }

        if(strlen($password)<8){
            $return['state'] = 200;
            $return['msg']   = '密码安全度不够';
            echo json_encode($return);
            exit;
        }

        $data['password'] = sha1($password);
//        if(session('role')==777){
//            $map['stu_num'] = session('account');
//            $result = M('student')->where($map)->save($data);
//        }else{
            $map['user_name'] = session('account');
            $result = M('SysUserInfo')->where($map)->save($data);
        //}

        if($result){
            $return['state'] = 100;
            $return['msg']   = '修改成功';
            $return['url']   = U('index/index');
        }else{
            $return['state'] = 200;
            $return['msg']   = '修改失败';
        }
        echo json_encode($return);
        exit;
    }

}
