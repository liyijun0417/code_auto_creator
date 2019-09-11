<?php
namespace Admin\Model;
use Think\Model;
class CommentModel extends Model {
  protected $tableName = 'smdp_comment';
  /**
*递归获取评论列表
   */
   public function getCommlist($share_id = 0,$parent_id = 0,&$result = array()){
    $arr = M('smdp_comment')->where("comment_reply = '".$parent_id."' and comment_share_id = '".$share_id."'")->order("comment_time desc")->select();
    if(empty($arr)){
        return array();
    }
    foreach ($arr as $c=>$v) {
        $thisArr=&$result[];
        $v["children"] = $this->getCommlist($share_id,$v["comment_id"],$thisArr);
        $thisArr = $v;
    }
    return $result;
   }
}
