<?php
namespace Admin\Model;
use Think\Model;
class MemberModel extends Model {
  protected $tableName = 'smdp_user';
   /**
  * 生成用户Token
  * @return type
  */
   public static function generateToken()
   {
       if (function_exists('com_create_guid')) {
           $uuid = com_create_guid();
       } else {
           mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.随便数播种，4.2.0以后不需要了。
           $charid = strtoupper(md5(uniqid(rand(), true))); //根据当前时间（微秒计）生成唯一id.
           $hyphen = chr(45); // "-"
  //            $hyphen = '';
           $uuid = '' . substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
       }
       return strtolower($uuid);
   }

       /**
     * 登陆密码加密
     * @global type $str
     * @param type $user_password
     * @return type
     */
    public function generatePassword($user_password)
    {
        $str = 'smdp_';
        return md5($str . $user_password);
    }


    //获取内部会员的昵称和token
    public function getTokenList(){
      $u['user_id'] = array('lt',10000);
      $memberInfo = D('Member')->where($u)->field('user_nick_name,user_token')->select();
      return $memberInfo;
    }

}
