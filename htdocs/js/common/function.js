// JavaScript Document
$(function(){
	var selectopen
	init();
	})
function init(){
	selectFunc();
	}
	
function changeIco(obj,num){
	obj.removeClass();
	obj.addClass('sta'+num);
}
function selectFunc(){
	$(".but_right").click(function(){
		if($(this).next().attr('class')!=='select_div'){
		createSelectOption($(this),$(this).attr('id'),$(this).attr('dataurl'));
		}
		if($(this).next(".select_div").is(":hidden")){
			$(this).next(".select_div").show();
			}else{
				$(this).next(".select_div").hide();
				}
		});
	$("body").delegate('.select_value li a','click',function(){
		var text=$(this).attr('text');
		var value=$(this).attr('value');
		$(this).parents("div").eq(1).find('.but_right span').html(text);
		var id=$(this).parents("div").eq(1).find('.but_right').attr('id');
		$("input[name="+id+"]").val(value);
		$(".select_div").hide();
		});
	$("body").delegate('.select_div','mouseleave',function(){
		$(".select_div").hide();	
	});
	}
function createSelectOption(dom,id,url){
	$.get(url,function(result){
		strhtml='<div style="height:140px;" class="select_div"><div style="width:143px;" class="select_top_left"><div class="select_top_right"><div class="select_top_center"></div></div></div><ul style="height:140px;width:145px;" class="select_value">';
		for(var i=0;i<result.length;i++){
			strhtml+='<li style=" width:145px;" class="list"><a href="javascript:void(0)" alt="" text="'+result[i]['name']+'" value="'+result[i]['id']+'">'+result[i]['name']+'</a></li>';
			}
		strhtml+='</ul><div style="width:143px;" class="select_bottom_left"><div class="select_bottom_right"><div class="select_bottom_center"></div></div></div></div><input name="'+id+'" value="" type="hidden"/>';
		dom.after(strhtml);
		},'json');
	}
	
function postFormData(formid,url,localUrl){
	var postdata={};
	var objInput=$("#"+formid+" input");
	var objSelect=$("#"+formid+" select");
	var objTextarea=$("#"+formid+" textarea");
	var objCheckBox=$("#"+formid+" input:checked[type=checkbox]");
	postdata=eachform(objInput,objSelect,objTextarea,objCheckBox);
	$.post(url,postdata,function(result){
		alert(result.msg);
		if(localUrl){
			location.href=localUrl;
			}else{
				location.reload();
			}
		},'json');
}


function eachform(objInput,objSelect,objTextarea,objCheckBox){
	var postdata={};
	$.each(objInput,function(){
		var value=$(this).val();
		var name=$(this).attr('name');
		if($(this).prop("type")!='checkbox'){
		 postdata[name]=value;
			}
		})
	$.each(objSelect,function(){
		var value=$(this).val();
		var name=$(this).attr('name');
		postdata[name]=value;
		})
	$.each(objTextarea,function(){
		var value=$(this).val();
		var name=$(this).attr('name');
		postdata[name]=value;
		})
	$.each(objCheckBox,function(){
		var value=$(this).val();
		var name=$(this).attr('name');
		if(typeof(name)=='undefined'){
    	return true;
    	} 
		if(typeof(postdata[name])=='undefined'){
        postdata[name] = [];
     	}
		postdata[name].push(value);
		})
	return postdata;
}

function setPage(methon,url){
	var pager=$("#page_nums").val();
	if(pager==''){
		pager=1;	
	}
	var url=url.replace('_page_nums',pager);
	location.href=url;
}

function submitForm(id){
	$("#"+id).submit();	
}