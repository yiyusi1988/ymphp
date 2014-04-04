<?php

/**
 * 分页类
 * 2014-03-31 @Yimiao
 */
class Core_Pager {

    private $_navigationItemCount = 8;                //导航栏显示导航总页数
    private $_pageSize = null;                        //每页项目数
    private $_align = "right";                        //导航栏显示位置
    private $_itemCount = null;                        //总项目数
    private $_pageCount = null;                        //总页数
    private $_currentPage = null;                    //当前页
    private $_front = null;                            //前端控制器
    private $_PageParaName = "page";                //页面参数名称
    private $_firstPageString = "首页";                //导航栏中第一页显示的字符
    private $_nextPageString = "下一页";                //导航栏中前一页显示的字符
    private $_previousPageString = "上一页";            //导航栏中后一页显示的字符
    private $_lastPageString = "尾页";                //导航栏中最后一页显示的字符
    private $_splitString = " | ";

    //页数字间的间隔符 /

    public function __construct($itemCount, $pageSize) {
        if (!is_numeric($itemCount) || (!is_numeric($pageSize))) {
            errorLog("Pagination Error:not Number");
        }
        $this->_itemCount = $itemCount;
        $this->_pageSize = $pageSize;
        $this->_front = Core_Front::getInstance();
        $this->_pageCount = ceil($itemCount / $pageSize);            //总页数
        $page = $this->_front->_request->getParam($this->_PageParaName);
        if (empty($page) || (!is_numeric($page))) {    //为空或不是数字，设置当前页为1
            $this->_currentPage = 1;
        } else {
            if ($page < 1) {
                $page = 1;
            }
            if ($page > $this->_pageCount) {
                $page = $this->_pageCount;
            }
            $this->_currentPage = $page;
        }
    }

    /**
     * 返回当前页
     * @param int 当前页
     */
    public function getCurrentPage() {
        return $this->_currentPage;
    }

    /**
     * 返回导航栏目
     * @return string 导航html   class="PageNavigation" 
     */
    public function getNavigation() {
        $navigation = '<div class="acc_footer" style="text-align:' . $this->_align . '"><ul>';

        $pageCote = ceil($this->_currentPage / ($this->_navigationItemCount - 1)) - 1;    //当前页处于第几栏分页
        $pageCoteCount = ceil($this->_pageCount / ($this->_navigationItemCount - 1));    //总分页栏
        $pageStart = $pageCote * ($this->_navigationItemCount - 1) + 1;                    //分页栏中起始页
        $pageEnd = $pageStart + $this->_navigationItemCount - 1;
        //分页栏中终止页
        if ($this->_pageCount < $pageEnd) {
            $pageEnd = $this->_pageCount;
        }
//        $navigation .= "<li>总共：{$this->_itemCount}条　{$this->_pageCount}页 </li>";
        if ($this->_currentPage != 1) {                                //首页导航
            $navigation .= "<a href=\"{$this->createHref(1)}\"><li title=\"{$this->_firstPageString}\" class=\"lastpage_1\"></li></a>";
        } else {
            $navigation.="<li class=\"lastpage_1_no\" title=\"{$this->_firstPageString}\" style=\"cursor:default\"></li>";
        }
        if ($this->_currentPage != 1) {                    //上一页导航
            $navigation .= "<a href=\"{$this->createHref($this->_currentPage - 1)}\"><li title=\"{$this->_previousPageString}\" class=\"lastpage_2\"></li></a>";
        } else {
            $navigation .= "<li title=\"{$this->_previousPageString}\" class=\"lastpage_2_no\" style=\"cursor:default\"></li>";
        }
        $navigation.="<li class=\"number\" style=\"cursor:default;\">{$this->_currentPage}/{$this->_pageCount}</li>"; //数字显示

        if ($this->_currentPage != $this->_pageCount) {    //下一页导航
            $navigation .="<a href=\"{$this->createHref($this->_currentPage + 1)}\"><li class=\"nexttpage_1\" title=\"{$this->_nextPageString}\"></li></a>";
        } else {
            $navigation .="<li class=\"nexttpage_1_no\" title=\"{$this->_nextPageString}\" style=\"cursor:default\"></li>";
        }
        if ($this->_currentPage != $this->_pageCount) {                //末页导航
            $navigation.="<a href=\"{$this->createHref($this->_pageCount)}\"><li class=\"nexttpage_2\" title=\"{$this->_lastPageString}\"></li></a>";
        } else {
            $navigation.="<li class=\"nexttpage_2_no\" title=\"{$this->_lastPageString}\" style=\"cursor:default\"></li>";
        }
        $navigation.="<li class=\"acc_in_p\"><input type=\"text\" class=\"nextinput\" id=\"page_nums\"></li>";
        $navigation.="<li class=\"nextgo\" title=\"go\" onclick=\"setPage('go','{$this->createHref('_page_nums')}');\"></li>";
        $navigation .= "</ul></div>";
        return $navigation;
    }

    /**
     * 取得导航栏显示导航总页数
     *
     * @return int 导航栏显示导航总页数
     */
    public function getNavigationItemCount() {
        return $this->_navigationItemCount;
    }

    /**
     * 设置导航栏显示导航总页数
     *
     * @param int $navigationCount:导航栏显示导航总页数
     */
    public function setNavigationItemCoun($navigationCount) {
        if (is_numeric($navigationCount)) {
            $this->_navigationItemCount = $navigationCount;
        }
    }

    /**
     * 设置首页显示字符
     * @param string $firstPageString 首页显示字符
     */
    public function setFirstPageString($firstPageString) {
        $this->_firstPageString = $firstPageString;
    }

    /**
     * 设置上一页导航显示字符
     * @param string $previousPageString:上一页显示字符
     */
    public function setPreviousPageString($previousPageString) {
        $this->_previousPageString = $previousPageString;
    }

    /**
     * 设置下一页导航显示字符
     * @param string $nextPageString:下一页显示字符
     */
    public function setNextPageString($nextPageString) {
        $this->_nextPageString = $nextPageString;
    }

    /**
     * 设置未页导航显示字符
     * @param string $nextPageString:未页显示字符
     */
    public function setLastPageString($lastPageString) {
        $this->_lastPageString = $lastPageString;
    }

    /**
     * 设置导航字符显示位置
     * @param string $align:导航位置
     */
    public function setAlign($align) {
        $align = strtolower($align);
        if ($align == "center") {
            $this->_align = "center";
        } elseif ($align == "right") {
            $this->_align = "right";
        } else {
            $this->_align = "left";
        }
    }

    /**
     * 设置页面参数名称
     * @param string $pageParamName:页面参数名称
     */
    public function setPageParamName($pageParamName) {
        $this->_PageParaName = $pageParamName;
    }

    /**
     * 获取页面参数名称
     * @return string 页面参数名称
     */
    public function getPageParamName() {
        return $this->_PageParaName;
    }

    /**
     * 生成导航链接地址
     * @param int $targetPage:导航页
     * @return string 链接目标地址
     */
    private function createHref($targetPage = null) {
        $params = $this->_front->_request->getParams();
        $module = strtolower(Core_Init::getMainName());
        $controller = strtolower(Core_Init::getControllerName());
        $action = strtolower(Core_Init::getActionName());
        $targetUrlArr = array('_m' => $module, '_c' => $controller, '_a' => $action);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $targetUrlArr[$key] = $value;
            }
        }
        if (isset($targetPage)) {
            $targetUrlArr[$this->_PageParaName] = $targetPage; //指定目标页
        }
        $targetUrl = Core_Init::seturl($targetUrlArr);
        return $targetUrl;
    }

}
