<?php

namespace Yijun;

class Rbac {

    static public function getAuth($role_id) {
        $map['id'] = array('eq',$role_id);
        $roleInfo  = M('SysRole')->where($map)->find();
        $authInfo  = explode(",", $roleInfo['authcode']);
        $return    = Rbac::_initAuth($authId);
        foreach ($authInfo as $value) {
            if( array_key_exists($value,$return) ){
                $return[$value] = 1;
            }
        }
        return $return;
    }

    static public function checkAuth() {
        if(session('administrator')){
            $return = true;
        }else{
            $authCode  = md5( strtoupper( MODULE_NAME.CONTROLLER_NAME.ACTION_NAME ) );
            $authArray = session('auth');
            if(array_key_exists($authCode,$authArray) ){
                if($authArray[$authCode] == 1 ){
                    $return = true;
                }else{
                    $return = false;
                }
            }else{
                $return = true;//没有声明的权限就是公共权限
            }
        }
        return $return;
    }

    protected function _initAuth() {
        $map['state'] = array('eq',1);
        $map['level'] = array('eq',3);
        $authInfo     = M('SysNode')->field("code")->where($map)->select();
        foreach ($authInfo as $key => $value) {
            $return[$value['code']] = 0;
        }
        return $return;
    }
    
}