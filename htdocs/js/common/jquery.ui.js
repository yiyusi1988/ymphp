(function($) {
    $.fn.selects = function(o) {
        var op = $.extend({},
        $.fn.selects.defaults, o),
        obj = $(this),
        get,
        g,
        tagname = obj.attr("tagName");
        if (op.relativewidth == "") {
            op.relativewidth = op.width;
        }
        var bakdata = op.data;
        get = {
            getData: function() {
                return op.data;
            },
            getClass: function() {
                return op.classname;
            },
            getDefaultval: function() {
                return op.defaultval;
            }
        };
        var h_ = 28 * op.defaultLine;
        var border = "";
        if (op.data.length == 0) {
            if (op.firstnum == '') {
                h_ = 0;
                border = "border:0px;"
            } else {
                h_ = 40
            }
        } else if (op.data.length > 0) {
            if (op.data.length <= op.defaultLine) {
                h_ = "";
            }
        }
        g = {
            createBoth: function() {
                if (obj.next('.select_div').length != 0) {
                    obj.next('.select_div').remove();
                    obj.parent().after(obj).remove();
                }
                obj.wrap('<div style="position:relative;font-weight:normal;z-index:' + op.zindex + '; padding:0;marign:0;display:' + op.display + ';"></div>');
				if($('#siteIddHidden', parent.document).val()!=''){
					var siteId=$('#siteIddHidden', parent.document).val();
				}else{
					var siteId=$('#monSiteId', parent.document).val();
				}
                if (op.left == undefined) {
                    var menu = '';
                    if (op.createAd) {
                        menu = '<div class="select_div" style="top:' + op.top + 'px;height:' + h_ + 'px;left:0;' + border + '"><ul id="'+op.isMaxBtn+'" class="' + get.getClass() + '" style="height:' + h_ + 'px;width:' + op.width + 'px;' + border + '"></ul><div class="selectcreateli" href="javascript:void(0)" style=" width:' + op.width + 'px;"><a href=javascript:JqueryDialog.Open("添加新广告主","/manage-advertiser/add-ad-account",920,630);><b>+ 添加新广告主</b></a></div></div>';
                    } else if (op.moniter) {
                        menu = '<div class="select_div" style="top:' + op.top + 'px;height:' + h_ + 'px;left:0;' + border + '"><ul id="'+op.isMaxBtn+'" class="' + get.getClass() + '" style="height:' + h_ + 'px;width:' + op.width + 'px;' + border + '"></ul><div class="selectcreateli" href="javascript:void(0)" style=" width:' + op.width + 'px;"><a href=javascript:JqueryDialog.Open("添加监测站点","/monitor-set/add-site-tab/advertiserId/' + $('#adAccountId', parent.document).val() + '/campaignId/'+$('#activityId', parent.document).val()+'",500,250);><b>+ 添加监测站点</b></a></div></div>';
                    } else if (op.monidia) {
                        menu = '<div class="select_div" style="top:' + op.top + 'px;height:' + h_ + 'px;left:0;' + border + '"><ul id="'+op.isMaxBtn+'" class="' + get.getClass() + '" style="height:' + h_ + 'px;width:' + op.width + 'px;' + border + '"></ul><div class="selectcreateli" href="javascript:void(0)" style=" width:' + op.width + 'px;"><a href=javascript:JqueryDialog.Open("添加监测点","/monitor-set/add-site-point-tab/advertiserId/' + $('#adAccountId', parent.document).val() + '/siteId/' + siteId + '",500,250);><b>+ 添加监测点</b></a></div></div>';
                    } else {
                        menu = '<div class="select_div" style="top:' + op.top + 'px;left:0;height:' + h_ + 'px;' + border + ';"><ul id="'+op.isMaxBtn+'" class="' + get.getClass() + '" style="height:' + h_ + 'px;width:' + op.width + 'px;' + border + '"></ul></div>';
                    }
                    obj.after(menu);
                } else {
                    if (op.createAd) {
                        menu = '<div class="select_div" style="top:' + op.top + 'px;left:' + op.left + 'px;height:' + h_ + 'px;' + border + '"><ul  id="'+op.isMaxBtn+'" class="' + get.getClass() + '" style="height:' + h_ + 'px;width:' + op.width + 'px;' + border + '"></ul><div class="selectcreateli" href="javascript:void(0)" style=" width:' + op.width + 'px;"><a href=javascript:JqueryDialog.Open("添加新广告主","/manage-advertiser/add-ad-account",920,630);><b>+ 添加新广告主</b></a></div></div>';
                    } else if (op.moniter) {
                        menu = '<div class="select_div" style="top:' + op.top + 'px;height:' + h_ + 'px;left:0;' + border + '"><ul  id="'+op.isMaxBtn+'" class="' + get.getClass() + '" style="height:' + h_ + 'px;width:' + op.width + 'px;' + border + '"></ul><div class="selectcreateli" href="javascript:void(0)" style=" width:' + op.width + 'px;"><a href=javascript:JqueryDialog.Open("添加监测站点","/monitor-set/add-site-tab/advertiserId/' + $('#adAccountId', parent.document).val() + '/campaignId/'+$('#activityId', parent.document).val()+'",500,250);><b>+ 添加监测站点</b></a></div></div>';
                    } else if (op.monidia) {
                        menu = '<div class="select_div" style="top:' + op.top + 'px;height:' + h_ + 'px;left:0;' + border + '"><ul  id="'+op.isMaxBtn+'" class="' + get.getClass() + '" style="height:' + h_ + 'px;width:' + op.width + 'px;' + border + '"></ul><div class="selectcreateli" href="javascript:void(0)" style=" width:' + op.width + 'px;"><a href=javascript:JqueryDialog.Open("添加监测点","/monitor-set/add-site-point-tab/advertiserId/' + $('#adAccountId', parent.document).val() + '/siteId/' + siteId + '",500,250);><b>+ 添加监测点</b></a></div></div>';
                    } else {
                        menu = '<div class="select_div" style="top:' + op.top + 'px;left:' + op.left + 'px;height:' + h_ + 'px;' + border + ';"><ul  id="'+op.isMaxBtn+'" class="' + get.getClass() + '" style="height:' + h_ + 'px;width:' + op.width + 'px;' + border + '"></ul></div>';
                    }
                    obj.after(menu);
                }
                obj.unbind('click');
                obj.click(function(event) {
                    $(".option").hide();
                    event.stopPropagation();
                    if (obj.next().is(":hidden")) {
                        $('.select_div').hide();
                        obj.next().slideDown(1);
                    } else {
                        obj.next().slideUp(1);
                    }
					/*if(op.ischecked){
					$('.select_div').bind("mouseleave",function(){
					$('.select_div').hide();
					});
					}*/
                    $(document).bind('click',function(e) {
						if(op.ischecked){
                        
						}else{
							if ($('.select_div').length > $('.select_div:hidden').length) {
								$('.select_div').hide();
							}
						}
                    });
                });
				var str=op.defaultvalkey;
				if(str!=""){
					if(!isNaN(str)){
					    obj.next().append('<input type="hidden" id="'+op.valueid+'" value="'+op.defaultvalkey+'"/>');
					}else{
					    if(str.indexOf("@")>-1){
						   obj.next().append('<input type="hidden" id="' + op.valueid + '" value=""/>');
						}else{
						   obj.next().append('<input type="hidden" id="'+op.valueid+'" value="'+op.defaultvalkey+'"/>');
						}
					}
				}else{
				    obj.next().append('<input type="hidden" id="'+op.valueid+'" value="'+op.defaultvalkey+'"/>');
				}
				if(op.ischecked){
				  obj.next().append('<div style="border:solid 1px #ccc;border-top:none;background:#fcfbfd;padding:3px 10px 3px 0px;text-align:right;"><a class="input_five select_ok" href="javascript:void(0);"><span>确定</span></a>&nbsp;&nbsp;<a class="input_five select_esc" href="javascript:void(0);"><span>取消</span></a></div>');
				  
				}
            },
            createList: function() {
                var data = op.data,
                h = '';
				if(op.isMax){
                    $('#'+op.isMaxBtn).html("");
					if (op.firstnum != '') {
						$('#'+op.isMaxBtn).append('<li class="list" style=" width:' + op.width + 'px;"><a key="" text="' + op.firstnum + '" href="javascript:void(0)">' + op.firstnum + '</a></li>');
					}
				}else{
					obj.next().find("ul").html("");
					if (op.firstnum != '') {
						obj.next().find("ul").append('<li class="list" style=" width:' + op.width + 'px;"><a key="" text="' + op.firstnum + '" href="javascript:void(0)">' + op.firstnum + '</a></li>');
					}
				}
				var strAry=[];
				var str=op.defaultvalkey;
				
				if(isNaN(str)){
					    if(str.indexOf("@")>-1&&str!=""){
						   strAry=str.split("@");
						}
				}else{
				    strAry.push(str);
				
				}
				var htmlStr=[];
                for (var i = 0; i < data.length; i++) {
                    var val = data[i][op.valueField],
                    txt = '';
                    if (op.viewsubstrs != "") {
                        txt = data[i][op.textField].substring(0, op.viewsubstrs);
                    } else {
                        txt = data[i][op.textField];
                    }
					if(op.isMax){
					    if (i == data.length - 1) {
							
							if(op.ischecked){
								
								if(strAry.length != 0&&$.inArray(val,strAry)>-1){
										htmlStr.push('<li class="list" style=" width:' + op.width + 'px;border-bottom:none;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)"><input name="" type="checkbox" value="" checked />' + txt + '</a></li>');
								}else{
										htmlStr.push('<li class="list" style=" width:' + op.width + 'px;border-bottom:none;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)"><input name="" type="checkbox" value="" />' + txt + '</a></li>');
								}
							}else{
							htmlStr.push('<li class="list" style=" width:' + op.width + 'px;border-bottom:none;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)">' + txt + '</a></li>');
							}
						} else {
							if(op.ischecked){
								
							if(strAry.length != 0&&$.inArray(val,strAry)>-1){
							htmlStr.push('<li class="list" style=" width:' + op.width + 'px;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)"><input name="" type="checkbox" value="" checked />' + txt + '</a></li>');
							}else{
							htmlStr.push('<li class="list" style=" width:' + op.width + 'px;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)"><input name="" type="checkbox" value="" />' + txt + '</a></li>');
							}
							}else{
							htmlStr.push('<li class="list" style=" width:' + op.width + 'px;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)">' + txt + '</a></li>');
							}
						}
					}else{
						if (i == data.length - 1) {
							if(op.ischecked){
								if(strAry.length != 0&&$.inArray(val,strAry)>-1){
							obj.next().find("ul").append('<li class="list" style=" width:' + op.width + 'px;border-bottom:none;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)"><input name="" type="checkbox" value="" checked />' + txt + '</a></li>');
								}else{
								obj.next().find("ul").append('<li class="list" style=" width:' + op.width + 'px;border-bottom:none;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)"><input name="" type="checkbox" value="" />' + txt + '</a></li>');
								}
							}else{
							obj.next().find("ul").append('<li class="list" style=" width:' + op.width + 'px;border-bottom:none;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)">' + txt + '</a></li>');
							}
						} else {
							if(op.ischecked){
							if(strAry.length != 0&&$.inArray(val,strAry)>-1){
							
							obj.next().find("ul").append('<li class="list" style=" width:' + op.width + 'px;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)"><input name="" type="checkbox" value="" checked/>' + txt + '</a></li>');
							}else{
							obj.next().find("ul").append('<li class="list" style=" width:' + op.width + 'px;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)"><input name="" type="checkbox" value="" />' + txt + '</a></li>');
							}
							}else{
							obj.next().find("ul").append('<li class="list" style=" width:' + op.width + 'px;"><a key="' + val + '" text="' + txt + '" alt="' + op.materialid + '" href="javascript:void(0)">' + txt + '</a></li>');
							}
						}
					}
                }
            },
            addClik: function() {
				  $(".select_ok").unbind("click");
				  $(".select_ok").bind("click",function(){
				  $('.select_div').hide();
				  });
				  $(".select_esc").unbind("click");
				  $(".select_esc").bind("click",function(){
				  if(selectSign==1){
				        accountAry = [];
						campaignAry = [];
						orderAry = [];
						$("#adAccountIdDrap").val("account");
						$("#choseAdver").next().find("li a input").each(function() {
							$(this).attr("checked", false);
						});
						$("#choseAdver").find("span").empty().html("全部广告主");
				  }else if(selectSign==2){
				        campaignAry = [];
						orderAry = [];
					    $("#choseActivityId").val("campaign");
										$("#choseCampaign").next().find("li a input").each(function() {
											$(this).attr("checked", false);
										});
										$("#choseCampaign").find("span").empty().html("全部活动");
				  }else if(selectSign==3){
				                                        orderAry = [];
														$("#choseOrderId").val("order");
														$("#choseOrder").next().find("li a input").each(function() {
															$(this).attr("checked", false);
															$("#choseOrder").find("span").empty().html("全部订单");
														});
				   }else if(selectSign==4){
				                        $("#TanxNoCaseId").val("");
										$("#choseTanxNoCase").next().find("li a input").each(function() {
											$(this).attr("checked", false);
										});
										$("#choseTanxNoCase").find("span").empty().html("请选择Tanx分类");
				   }else if(selectSign==5){
				                        $("#TanxCaseId").val("");
										$("#choseTanxCase").next().find("li a input").each(function() {
											$(this).attr("checked", false);
										});
										$("#choseTanxCase").find("span").empty().html("请选择Tanx敏感分类");
				   }
				  $('.select_div').hide();
				  });
                var _target = obj.find('span');
				obj.next().find("li a").each(function() {
					   $(this).find("input").bind("click",function() {
				        if(op.ischecked){
							    var txt = $(this).parent().attr("text");
									var val = $(this).parent().attr("key");
									var alt = $(this).parent().attr("alt");
							    if($(this).attr("checked")){
									$(this).attr("checked",false);
									op.callback(txt, val, alt);
								}else{
								    $(this).attr("checked",true);
									op.callback(txt, val, alt);
								}
						}
					   });
				});
                obj.next().find("li a").each(function() {
                    $(this).bind("click",function() {
						if(op.ischecked){
							    var txt = $(this).attr("text");
									var val = $(this).attr("key");
									var alt = $(this).attr("alt");
							    if($(this).find("input").attr("checked")){
									$(this).find("input").attr("checked",false);
									op.callback(txt, val, alt);
								}else{
								    $(this).find("input").attr("checked",true);
									op.callback(txt, val, alt);
								}
						}else{
								if (op.clickV != 1) {
									var txt = $(this).attr("text");
									var val = $(this).attr("key");
									var alt = $(this).attr("alt");
									if (tagname == "INPUT") {
										obj.attr("value", $(this).attr("text"));
									} else {
										if (op.substrs != "") {
											_target.html($(this).attr("text").substring(0, op.substrs));
										} else {
											_target.html($(this).attr("text"));
										}
		
									}
									$("#" + op.valueid).attr("value", $(this).attr("key"));
									obj.next().slideUp(1);
								}
								op.callback(txt, val, alt);
								return false;
						}
                        
                        
                    })
                });
            },
            initval: function() {
                var searchcss = 'width:' + (op.width - 5) + 'px;height:23px;line-height:23px;border:1px solid #ccc ;border-top:0;color:#ccc;padding-left:5px;';
                obj.next().find("ul").before("<div class='select_top_left' style='width:" + (op.width - 2) + "px;'><div class='select_top_right'><div class='select_top_center'></div></div></div>");
                if (op.issearch) {
                    obj.next().find("ul").before('<div style="width:' + op.width + 'px"><input onfocus=if(this.value=="搜索"){this.value="";this.style.color="#000"} onblur=if(this.value==""){this.value="搜索";this.style.color="#ccc"} value="搜索" class="sel_search" type="text"  style="' + searchcss + '" /></div>');
                }
                if (obj.next().find("div").hasClass("selectcreateli")) {
                    obj.next().find(".selectcreateli").after("<div class='select_bottom_left' style='width:" + (op.width - 2) + "px;'><div class='select_bottom_right'><div class='select_bottom_center'></div></div></div>")
                } else {
                    obj.next().find("ul").after("<div class='select_bottom_left' style='width:" + (op.width - 2) + "px;'><div class='select_bottom_right'><div class='select_bottom_center'></div></div></div>")
                }
                var _target = obj.find('span');
                if (tagname == "INPUT") {
                    obj.attr("value", get.getDefaultval());
                } else {
                    if (op.substrs != "") {
                        _target.html(get.getDefaultval().substring(0, op.substrs));
                    } else {
                        _target.html(get.getDefaultval());
                    }

                }
            },
            //搜索方法
            searchArr: function(word) {
                var newarr = [];
                $(bakdata).each(function(i, items) {
                    if (items[op.textField].indexOf(word) > -1) {
                        newarr.push(items);
                    }
                });
                return newarr;
            }
        };
        g.createBoth();
        g.initval();
        g.createList();
        g.addClik();
		//根据ID对应显示name
        if (op.defaultvalkey) {
            for (var i = 0; i < bakdata.length; i++) {
                if (bakdata[i][op.valueField] == op.defaultvalkey) {
                    if (op.substrs != "") {
                        obj.find("span").html(bakdata[i][op.textField].substring(0, op.substrs));
                    } else {
                        obj.find("span").html(bakdata[i][op.textField]);
                    }

                }
            }
        }

        //搜索
        if (op.issearch) {

            obj.next().find(".sel_search").bind("click",
            function(event) {
                event.stopPropagation();
            }).bind("keyup",
            function(e) {
                //if (e.which == 13){
                var svl = $(this).val();
                if (svl == "" || svl == "搜索") {
                    op.data = bakdata;
                } else {
                    op.data = g.searchArr(svl);
                }
                g.createList();
                g.addClik();
                //	}
            });
        }

    }
    //defaults config
    $.fn.selects.defaults = {
        data: [],//数据
        width: 200,//宽度
        top: 28,
        valueField: 'id',//数据字段id
        textField: 'text',//数据字段名称
        defaultval: "请选择",//默认显示名称
        classname: "select_value",//样式
        valueid: "idval",//隐藏input的id下拉时记录下拉的当前id
        relativewidth: "",
        clickV: 0,
        createAd: false,//创建广告主
        defaultLine: 5,//默认下拉显示条数
        zindex: 10,
        activity: false,//创建活动
        moniter: false,//监测点
        monidia: false,//创建媒体
        defaultvalkey: "",//默认value
        substrs: "",//显示的截取个数
        viewsubstrs: "",//下拉里面的显示个数
        firstnum: "",//第一条数据name
        display: 'inline-block',
        materialid: "",
        issearch: false,//是否启用搜索功能
		isMax:false,
		isMaxBtn:"",
        callback: function() {}//点击下拉时回调函数返回参数(name,id)
    }
})(jQuery);