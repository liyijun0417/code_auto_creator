<?php
//	代码自动生成器
//	
//	李沂君
//	3322169285@qq.com
//	2018年9月18日
namespace TPH\Controller;
use Think\Controller;
use Think\Model;
use Yijun\Page;

class CRUDController extends Controller {

    /**
     * @var 模板风格 、 目前支持两种 、 bootstrap4 （view） 和 ace-admin
     */
    private $tmplate = 'ace-admin';//view

	public function crud(){	//生成CRUD代码
		$this->assign('tableNameList', getTableNameList());
		$this->assign('moduleNameList', getModuleNameList());
		$this->assign('selectTableName', $this->getSessionTableName());
		$this->assign('db_prefix',C('DB_PREFIX'));
		$this->display();
    }

	public function getSessionTableName(){
		$selectTableName = implode("','", session('selectTableName'));
		return "['".$selectTableName."']";
	}
	
	public function getPageCode($tableName){	//	分页代码  未使用???
		$Model = M($tableName); // 实例化对象
		$count = $Model->where('status=1')->count();// 查询满足要求的总记录数
		$Page = new Page($count);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$nowPage = isset($_GET['page']) ? $_GET['page'] : 1 ;
		$show = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list =	$Model->where('status=1')->order('create_time')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);
	}
	
	//列出所有记录页面代码（片段）
	public function generateAllPageCode(){
		$templateFilePath = MODULE_PATH. "Template/View/allCode.html";
		$tableName = I('table');
		$TableName = tableNameToModelName($tableName);
		$tableInfoArray = getTableInfoArray($tableName);
		$columnNameKey = getColumnNameKey();
        $comment = parseColumChinaName($tableName);
        $commentArray = array();
		foreach($columnNameKey as $v){
            array_push($commentArray,$comment[$v]);
        }
		$this->assign('tableName', $tableName);
		$this->assign('TableName', $TableName);
		$this->assign('tableInfoArray', $tableInfoArray);
		$this->assign('columnNameKey', $columnNameKey);
		$this->assign('columnNameComment', $commentArray);
		$resultCode = $this->fetch($templateFilePath);
		return $resultCode;
	}
	
	public function allPageCode(){
		echo $this->generateAllPageCode();
	}
	
	
	//列出所有记录页面，读取并填充数据
	public function previewAllPage(){ 
		$tableName = I('table'); 
		$Model = M($tableName);
		$resultCode = "<table class=\"table table-striped table-bordered table-hover\">\r\n<thead>\r\n<tr>\r\n";
		$tableInfoArray = getTableInfoArray($tableName);
        $names = parseColumChinaName($tableName);

		foreach($tableInfoArray as $tableInfo){ //拼接表头
			$name = $tableInfo[getColumnNameKey()];
            $all_name = !empty($names[$name])?$names[$name]:$name;
			$resultCode .= "<th><center>".$all_name."</center></th>\r\n";
		}
		$resultCode .= "<th>操 作</th>\r\n</tr>\r\n</thead>\r\n";
		for($i = 0; $i < 5; $i++){//填充5个数据
			foreach($tableInfoArray as $tableInfo){ 
				$resultCode .= "<td>" .$tableInfo[getColumnNameKey()]. "</td>\r\n";
			}
			$resultCode .= '<td><a href="'.U(tableNameToModelName($tableName).'/edit?id='.$i).'">编辑</a> | '	
					.'<a href="'.U(tableNameToModelName($tableName).'/delete?id='.$i).'" onclick=\'return confirm("确定删除吗？")\'>删除</a></td></tr>'."\r\n";
		}
		$resultCode .= "</table>\r\n";
		echo $resultCode;
	}
	
	//生成所有记录代码
	public function generateAllCode(){
		$tableName = I('table');
		$isPage = I('isPage');
		$this->assign('tableName', $tableName);
		$this->assign('TableName', tableNameToModelName($tableName));//修正为驼峰命名，首字母大写
		$resultCode = $this->makeControllerTemplate("all.html");
		return $resultCode;
	}
	
	public function allCode(){
		echo $this->generateAllCode();
	}
	
	//生成新建页面代码（片段）
	public function generateAddPage(){ 
		$templateFilePath = MODULE_PATH. "Template/View/addCode.html";
		$tableName = I('table'); 
		$TableName = tableNameToModelName($tableName);
		$tableInfoArray = getTableInfoArray($tableName);
		$columnNameKey = getColumnNameKey();
		
		$this->assign('tableName', $tableName);
		$this->assign('TableName', $TableName);
		$this->assign('tableInfoArray', $tableInfoArray);
		$this->assign('columnNameKey', $columnNameKey);
		$resultCode = $this->fetch($templateFilePath);
		return $resultCode;
	}
	
	//生成新建前台页面代码
	public function addPage(){
		echo $this->generateAddPage();
	}
	
	//新建操作代码
	public function generateAddCode(){	
		$tableName = I('table'); 
		$this->assign('tableName', $tableName);
		$this->assign('TableName', tableNameToModelName($tableName));//修正为驼峰命名，首字母大写
		$resultCode = $this->makeControllerTemplate("add.html");
		return $resultCode;
	}
	
	public function addCode(){
		echo $this->generateAddCode();
	}
	
	//编辑页面
	public function generateEditPage(){	
		$templateFilePath = MODULE_PATH. "Template/View/editCode.html";
		$tableName = I('table'); 
		$TableName = tableNameToModelName($tableName);
		$tableInfoArray = getTableInfoArray($tableName);
		$columnNameKey = getColumnNameKey();

		
		$this->assign('tableName', $tableName);
		$this->assign('TableName', $TableName);
		$this->assign('tableInfoArray', $tableInfoArray);
		$this->assign('columnNameKey', $columnNameKey);
		$resultCode = $this->fetch($templateFilePath);
		return $resultCode;
	}

	public function editPage(){	
		echo $this->generateEditPage();
	}
	
	//生成编辑代码
	public function generateEditCode(){ 
		$tableName = I('table'); 
		$this->assign('tableName', $tableName);
		$this->assign('TableName', tableNameToModelName($tableName));//修正为驼峰命名，首字母大写
		$resultCode = $this->makeControllerTemplate("edit.html");
		return $resultCode;
	}
	
	public function editCode(){
		echo $this-> generateEditCode();
	}
	
	//删除代码
	public function generateDeleteCode(){
		$tableName = I('table'); 
		$this->assign('tableName', $tableName);
		$this->assign('TableName', tableNameToModelName($tableName));//修正为驼峰命名，首字母大写
		$resultCode = $this->makeControllerTemplate("delete.html");
		return $resultCode;
	}
	
	public function deleteCode(){
		echo $this->generateDeleteCode();
	}
	
	
	//生成所有代码对应的文件，
	public function creatAllFiles(){
		$tableName = I('selectTableName');
		$moduleName = I('moduleName');
		$controllerPath = APP_PATH. tableNameToModelName($moduleName). "/Controller/";
		
		for($i = 0;$i < count($tableName); $i++){
			$_POST['table'] = $tableName[$i];
			$viewPath = APP_PATH. tableNameToModelName($moduleName). "/View/".tableNameToModelName($tableName[$i])."/";
			$controllerStr = "<?php\r\n";
			$controllerStr .= "//该代码由原型架构器自动生成----------李沂君（".date('Y-m-d H:i:s',time())."）\r\n";
			$controllerStr .= "namespace ".tableNameToModelName($moduleName)."\Controller;\r\n";
			$controllerStr .= "use Think\Controller;\r\n\r\n";
			$controllerStr .= "use Yijun\Page;\r\n\r\n";
			$controllerStr .= "class ". tableNameToModelName($tableName[$i]) ."Controller extends BaseController {\r\n";
			$controllerStr .= $this->generateAllCode()."\r\n\r\n";
			$controllerStr .= $this->generateAddCode()."\r\n\r\n";
			$controllerStr .= $this->generateEditCode()."\r\n\r\n";
			$controllerStr .= $this->generateDeleteCode()."\r\n\r\n}";
			
			$originalAllViewStr = $this->generateAllPageCode();
			$allViewStr = $this->makeViewTemplate("all.html", $tableName[$i], $originalAllViewStr);
			$originalAddViewStr = $this->generateAddPage();
			$addViewStr = $this->makeViewTemplate("add.html", $tableName[$i], $originalAddViewStr);
			$originalEditViewStr = $this->generateEditPage();
			$editViewStr = $this->makeViewTemplate("edit.html", $tableName[$i], $originalEditViewStr);
			FileUtil::createDir($controllerPath);
			file_put_contents($controllerPath.tableNameToModelName($tableName[$i])."Controller.class.php", $controllerStr);//生成Controller文件
			FileUtil::createDir($viewPath);
			file_put_contents($viewPath."all.html", $allViewStr);
			file_put_contents($viewPath."add.html", $addViewStr);
			file_put_contents($viewPath."edit.html", $editViewStr);
		}
		echo "生成完成。";
	}
	
	//解析前台View模板
	public function makeViewTemplate($templateFileName, $tableName, $content){
		$templateFilePath = MODULE_PATH. "Template/aceAdmin/" .$templateFileName;
		$this->assign('tableName', $tableName);
		$this->assign('content', $content);
		$fileContent = $this->fetch($templateFilePath);
		return $fileContent;
	}
	
	//解析后台Controller模板
	public function makeControllerTemplate($templateFileName){
		$templateFilePath = MODULE_PATH. "Template/Controller/" .$templateFileName;
		$fileContent = $this->fetch($templateFilePath);
		return $fileContent;
	}
	
	
}