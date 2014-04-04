yimiao@2014-03-06
一、文件说明
注：
1.除了log和htdocs两个文件夹外 其他所有文件夹均需首字母大写
2.文件命名中 模板文件只能使用小写 其他类文件均需首字母大写
/Application 该文件夹放应用程序 包含控制器和模型 
/Application/Default  该文件夹为url中_m所对应的main文件夹 首字母大写
/Application/Default/Controllers 该文件夹为main中控制器文件夹 首字母大写
/Application/Default/Models 该文件夹为main中模型文件夹 包含应用层操作模型和数据层操作模型 以Db进行区分 首字母大写
/Conf 各项配置文件夹 使用案例 Core_Init::getConf('Conf_Site'); 意为返回Conf/Site.php里的数组
/Docs 各项文档保存地址
/Library 核心操作类文件夹
/Library/Core 核心控制类和模型
/Library/** 核心**操作类
/SmartyTemplates smarty模板文件夹
/SmartyTemplates/Templates smarty模板文件夹  其文件层级和Application一样
/htdocs 入口文件夹和图片、css、js文件夹
/log 异常日志文件夹

二、核心方法说明
控制器中 
调用 init() 将执行子控制器的该方法 该方法最先执行
调用 preDispatch() 将在分发前 调用该子控制器的方法

模型中
mysql查询Core_Model->dbDsp->getAll($sql)
memcache查询Core_Model->memDsp->get($key)
redis查询Core_Model->redisDsp->get($key) 这个类还没写
 
获取url参数 使用$_GET 不能使用$_REQUEST
获取post参数 使用$_POST 可使用$_REQUEST
控制器里获取get/post 使用  $this->_request->getParams();获取所有的信息  $this->_request->getParam($key);获取get/post的key的信息

url http://www.dsp.com/default/index/index/a/b.html ==
    http://www.dsp.com/default/index/index/a/b ==
    http://www.dsp.com/index.php?_m=default&_c=index&_a=index&a=b
支持该3种格式的url 也只能以这3种中其中一种使用哈

三、类注册机制 单例模式 require时 会先对Application和Library中搜索

四、需配置域名+rewrite才能使用

五、更新日志
2014-03-21
a.新增smarty seturl插件 模板调用方法:<*seturl _m=main _c=controllor _a=active option=option*>  _m|_c|_a 为空时 默认为default|index|index 与url相关均用小写
b.新增公共方法php里任何地方可调用 Core_Init::seturl($params); 生成url $params=array('_m'=>'main,'_c'=>'controller','_a'=>'active','option'=>'option');
c.核心控制器已将main、controller、active 传给smarty 模板里可直接调用 <*$_mainName*> <*$_controllerName*> <*$_activeName*>来获取 main、controller、active
d.控制器里设置title方法 定义$this->_cTitle和$this->_aTitle 即可
e.新增配置项 conf_site 新增isHtml 伪静态开关 suffix 伪静态后缀名 如果isHtml 为0 suffix不起任何作用
