<?php
namespace Admin\Controller;
use Think\Controller;
use Yijun\Rbac;
use OSS\OssClient as OssClass;
use OSS\Core\OssException;

class BaseController extends Controller {

    protected function _initialize(){

        $explore = $_SERVER["HTTP_USER_AGENT"];
        //浏览器判断
        if( strpos($explore,"MSIE 9.0") || strpos($explore,"MSIE 8.0") || strpos($explore,"MSIE 7.0") || strpos($explore,"MSIE 6.0") ){
            layout(false);
            echo "当前浏览器的版本较低，请使用W3C标准的新版本浏览器,以获得更完美的用户体验(比如“火狐、谷歌Chrome、360浏览器（极速模式(点击地址栏中的浏览器图标选择“极速模式”）等....”)";
            header('Content-Type:text/html; charset=utf-8');
            exit;
        }

        if( session('account')==null ){
			   redirect(U('Admin/Login/index'));
        }
        header('Content-Type:text/html; charset=utf-8');


        if(!Rbac::checkAuth()){
            if(IS_POST){
                $return['state'] = 200;
                $return['msg'] = '对不起，您没有该功能的操作权限!' ;
                echo json_encode($return);
            }else{
                $this->display("Public:auth");
            }
            exit;
        }
	}


    public function uploadToOss($path){
        vendor('oss.autoload');
        $bucket = $this->getBucketName();
        $ossClient = $this->getOssClient();
        $result = $ossClient->uploadFile($bucket, $path, C('UPLOAD_PATH').$path);
        //上传成功后可以把本地的文件删除了
        unlink(C('UPLOAD_PATH').$path);
        return $result;
    }

    private function getOssClient()
    {
        try {
            $ossClient = new OssClass(C('ALIOSS_CONFIG.KEY_ID'), C('ALIOSS_CONFIG.KEY_SECRET'), C('ALIOSS_CONFIG.END_POINT'), false);
        } catch (OssException $e) {
            printf(__FUNCTION__ . "creating OssClient instance: FAILED\n");
            printf($e->getMessage() . "\n");
            return null;
        }
        return $ossClient;
    }

    private function getBucketName()
    {
        return C('ALIOSS_CONFIG.BUCKET');
    }

  



}
