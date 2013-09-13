

/* File: /scripts/location.js */

function containerReload(){var Content;if($.browser.msie&&$.browser.version==6){try{xmlhttp=new XMLHttpRequest();}
catch(ee){try{xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");}
catch(e){try{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
catch(E){xmlhttp=false;}}}
try{Content=document.getElementById('LocationbaseAdvancedSearch').innerHTML;document.getElementById('LocationbaseAdvancedSearch').innerHTML="";document.getElementById('LocationbaseAdvancedSearch').innerHTML=Content;}catch(e){Content=document.getElementById('formsLocation').innerHTML;document.getElementById('formsLocation').innerHTML="";document.getElementById('formsLocation').innerHTML=Content;}}}
function loadLocationSitemgrMembers(url,edir_locations,level,childLevel,id){var edir_locations=edir_locations.split(',');if(!isNaN(id)){for(i=0;i<edir_locations.length;i++){if(edir_locations[i]>level){text=$("#l_location_"+edir_locations[i]).attr("text");$("#location_"+edir_locations[i]).html("<option id=\"l_location_"+edir_locations[i]+"\" value=\"\">"+text+"</option>");$('#div_location_'+edir_locations[i]).css('display','none');$('#new_location'+edir_locations[i]+'_field').attr('value','');$('#div_new_location'+edir_locations[i]+'_field').css('display','none');}}
$("#div_location_"+childLevel).css("display","");$('#location_'+childLevel).css('display','none');$('#div_img_loading_'+childLevel).css('display','');$('#box_no_location_found_'+childLevel).css('display','none');try{$('#div_select_'+childLevel).css('display','none');}catch(e){}
$.get(url+"/location.php",{id:id,level:level,childLevel:childLevel,type:'byId'},function(location){if(location!="empty"){var text=$("#l_location_"+childLevel).attr("text");$("#location_"+childLevel).html(location);$("#l_location_"+childLevel).html(text);$('#location_'+childLevel).css('display','');try{$('#div_select_'+childLevel).css('display','');}catch(e){}
display_level_limit=childLevel;}else{if(!id)
$("#div_location_"+childLevel).css("display",'none');else{try{$('#div_select_'+childLevel).css('display','');}catch(e){}
$('#box_no_location_found_'+childLevel).css('display','');}}
if(childLevel&&id)
$('#div_new_location'+childLevel+'_link').css('display','');else
$('#div_new_location'+childLevel+'_link').css('display','none');$('#div_img_loading_'+childLevel).css('display','none');});}
containerReload();}
function loadLocation(url,edir_locations,level,childLevel,id,showClear){var aux_edir_locations=edir_locations;var edir_locations=edir_locations.split(',');if(!isNaN(id)){for(i=0;i<edir_locations.length;i++){if(edir_locations[i]>level){text=$("#l_location_"+edir_locations[i]).attr("text");$("#location_"+edir_locations[i]).html("<option id=\"l_location_"+edir_locations[i]+"\" value=\"\">"+text+"</option>");$('#div_location_'+edir_locations[i]).css('display','none');$('#new_location'+edir_locations[i]+'_field').attr('value','');$('#div_new_location'+edir_locations[i]+'_field').css('display','none');}}
$("#div_location_"+childLevel).css("display","");$('#location_'+childLevel).css('display','none');$('#location_'+level).attr('disabled','true');$('#div_img_loading_'+childLevel).css('display','');if($('#locations_clear')){$('#locations_clear').css('display','none');}
$('#box_no_location_found_'+childLevel).css('display','none');try{$('#div_select_'+childLevel).css('display','none');}catch(e){}
$.get(url+"/location.php",{id:id,level:level,childLevel:childLevel,type:'byId'},function(location){if(location!="empty"){var text=$("#l_location_"+childLevel).attr("text");$("#location_"+childLevel).html(location);$("#l_location_"+childLevel).html(text);$('#location_'+childLevel).css('display','');try{$('#div_select_'+childLevel).css('display','');}catch(e){}
display_level_limit=childLevel;}else{if(!id)
$("#div_location_"+childLevel).css("display",'none');else{try{$('#div_select_'+childLevel).css('display','');}catch(e){}
$('#box_no_location_found_'+childLevel).css('display','');}}
if(childLevel&&id)
$('#div_new_location'+childLevel+'_link').css('display','');else
$('#div_new_location'+childLevel+'_link').css('display','none');$('#location_'+level).attr('disabled','');$('#div_img_loading_'+childLevel).css('display','none');if($('#locations_clear')){$('#locations_clear').css('display','');}
if(location!="empty"){for(i=0;i<edir_locations.length;i++){if(edir_locations[i]!=childLevel){$('#div_location_'+edir_locations[i]).css('display','none');}}}else{$('#div_location_'+childLevel).css('display','none');}
fillLocations(aux_edir_locations);if(showClear){$('#locations_clear').css('display','');}});}
containerReload();}
function loadLocationsChildtb(url,level,id,childLevel){if(!isNaN(id)){$.get(url+"/location.php",{id:id,level:level,childLevel:childLevel,type:'byId'},function(location){var text=$("#l_location_"+childLevel).attr("text");if(location!="empty"){$("#select_L"+childLevel).html(location);$("#l_location_"+childLevel).html(text);}else
$("#select_L"+childLevel).html('<option id=\"l_location_'+childLevel+'\" value=\"\">'+text+'</option>');});}else
containerReload();}
function loadAllLocationstb(url,level){$.get(url+"/location.php",{level:level,type:'All'},function(location){if(location!="empty"){var text=$("#l_location_"+level).attr("text");alert('all text: '+text);$("#select_L"+level).html(location);$("#l_location_"+level).html(text);}});containerReload();}
function loadLocationsChild(url,level,id,childLevel){if(!isNaN(id)){$.get(url+"/location.php",{id:id,level:level,childLevel:childLevel,type:'byId'},function(location){var text=$("#l_location_"+childLevel).attr("text");if(location!="empty"){$("#default_L"+childLevel+"_id").html(location);$("#l_location_"+childLevel).html(text);}else
$("#default_L"+childLevel+"_id").html('<option id=\"l_location_'+childLevel+'\" value=\"\">'+text+'</option>');});}
containerReload();}
function loadAllLocations(url,level){$.get(url+"/location.php",{level:level,type:'All'},function(location){if(location!="empty"){var text=$("#l_location_"+level).attr("text");$("#default_L"+level+"_id").html(location);$("#l_location_"+level).html(text);}});containerReload();}
function formLocations_submit(level,form){if(level<=3){for(i=(level+1);i<=4;i++)
if($('#select_location'+i).val())
$('#select_location'+i).remove();}
form.submit();}
function showNewLocationField(level,edir_locations,back,text){var edir_locations=edir_locations.split(',');for(i=0;i<edir_locations.length;i++){if(edir_locations[i]>=level){$('#location_'+edir_locations[i]+' option[value=]').attr('selected',true);$('#div_location_'+edir_locations[i]).css('display','none');$('#new_location'+edir_locations[i]+'_field').attr('value','');$('#div_new_location'+edir_locations[i]+'_field').css('display','none');}}
$('#div_new_location'+level+'_field').css('display','');$('#div_new_location'+level+'_link').css('display','none');if(!back)
$('#div_new_location'+level+'_back').css('display','none');else
$('#div_new_location'+level+'_back').css('display','');if(text){$('#new_location'+level+'_field').val(text);}}
function hideNewLocationField(level,edir_locations){var edir_locations=edir_locations.split(',');for(i=0;i<edir_locations.length;i++){if(edir_locations[i]>=level){$('#location_'+edir_locations[i]+' option[value=]').attr('selected',true);$('#new_location'+edir_locations[i]+'_field').attr('value','');$('#div_new_location'+edir_locations[i]+'_field').css('display','none');}}
$('#div_location_'+level).css('display','');$('#div_new_location'+level+'_link').css('display','');}
function fillFieldWhere(location_title){if(document.getElementById("where")){if(document.getElementById("where").value!=''){document.getElementById("where").value+=', '+location_title;}else{document.getElementById("where").value+=location_title;}}}
function fillLocations(levels){var edir_locations=levels.split(',');if(edir_locations){if(document.getElementById("where")){document.getElementById("where").value="";}
if(document.getElementById("locations_default_where")){if(document.getElementById("locations_default_where").value){document.getElementById("where").value=document.getElementById("locations_default_where").value;}}
for(i=0;i<edir_locations.length;i++){if($("#location_"+edir_locations[i]+" option:selected").val()>0){fillFieldWhere($("#location_"+edir_locations[i]+" option:selected").text());}}}}
function clearLocations(levels,has_default,last_default){var edir_locations=levels.split(',');var first_to_show=0;document.getElementById("where").value="";for(i=0;i<edir_locations.length;i++){if(i>first_to_show){$('#div_location_'+edir_locations[i]).css('display','none');}else{$('#div_location_'+edir_locations[i]).css('display','');$("#location_"+edir_locations[i]).val(0);}
if(has_default){if(edir_locations[i]==last_default){first_to_show=i+1;}}}
$('#locations_clear').css('display','none');}

/* File: /scripts/loadtheme.js */

function containerReload(){var Content;if($.browser.msie&&$.browser.version==6){try{xmlhttp=new XMLHttpRequest();}
catch(ee){try{xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");}
catch(e){try{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
catch(E){xmlhttp=false;}}}
try{Content=document.getElementById('LocationbaseAdvancedSearch').innerHTML;document.getElementById('LocationbaseAdvancedSearch').innerHTML="";document.getElementById('LocationbaseAdvancedSearch').innerHTML=Content;}catch(e){Content=document.getElementById('formsLocation').innerHTML;document.getElementById('formsLocation').innerHTML="";document.getElementById('formsLocation').innerHTML=Content;}}}
function loadTheme(url,select,id,destiny,query){var url=url;var select=select;var id=id;switch(select){case'country_id':var fillSelect='state_id';var nextSelects='state_id,region_id,city_id,area_id';var prevSelects='country_id';break;case'state_id':var fillSelect='region_id';var nextSelects='region_id,city_id,area_id';var prevSelects='country_id,state_id';break;case'region_id':var fillSelect='city_id';var nextSelects='city_id,area_id';var prevSelects='country_id,state_id,region_id';break;case'city_id':var fillSelect='area_id';var nextSelects='area_id';var prevSelects='country_id,state_id,region_id,city_id';break;}
if(id){$('#div_country_id').css('display','none');$('#div_state_id').css('display','none');$('#div_region_id').css('display','none');$('#div_city_id').css('display','none');$('#div_area_id').css('display','none');$('#div_img_loading').css('display','');$.getJSON(url+'/settheme.php?theme='+id+"&destiny="+destiny+"&query="+query,function(res){prevs=prevSelects.split(',');if(res=='empty'){$('#div_img_loading').css('display','none');$.each(prevs,function(i,prev){$('#div_'+prev).css('display','');});$('#div_'+fillSelect).css('display','none');}else{var items=res.split(',');var id=0;var option=new Array();$.each(items,function(i,item){if(id>0)option[id]=item;id=item;});$('#'+fillSelect).empty();$('#'+fillSelect).addOption('',message);$('#'+fillSelect).addOption(option);$('#'+fillSelect+' option[value=]').attr('selected',true);$('#div_img_loading').css('display','none');$.each(prevs,function(i,prev){$('#div_'+prev).css('display','');});$('#div_'+fillSelect).css('display','');$('#'+fillSelect).focus();nexts=nextSelects.split(',');$.each(nexts,function(i,next){if(i>0){$('#'+next).empty();$('#'+next+' option[value=]').attr('selected',true);$('#div_'+next).css('display','none');}});}});}else{nexts=nextSelects.split(',');$.each(nexts,function(i,next){$('#'+next+' option[value=]').attr('selected',true);$('#div_'+next).css('display','none');});}
hideNewCity();containerReload();}
function showNewCity(toHide){$('#'+toHide+' option[value=]').attr('selected',true);$('#div_'+toHide).css('display','none');$('#addNewCity').css('display','');}
function hideNewCity(toShow){$('#'+toShow+' option[value=]').attr('selected',true);$('#div_'+toShow).css('display','');$('#addNewCity').css('display','none');}

/* File: /scripts/cookies.js */
<!--
function readCookie(name){var eq=name+"=";var ca=document.cookie.split(';');if(!ca.length)return null;for(var i=0;i<ca.length;i++){var c=ca[i];while(c.charAt(0)==' ')c=c.substring(1,c.length);if(c.indexOf(eq)==0)return unescape(c.substring(eq.length,c.length));}
return null;}
function includeInCookie(property_id,edir_path,type){if(!isNaN(property_id)){var name="bookmark"+type;var d=new Date();if(!edir_path)edir_path="/";d.setTime(d.getTime()+(15*24*60*60*1000));var expires='; expires='+d.toGMTString();var bookmark=readCookie("bookmark"+type);if(!bookmark)bookmark="'"+property_id+"'";else{if(bookmark.indexOf("'"+property_id+"'")==-1){bookmark=bookmark+","+"'"+property_id+"'";}}
document.cookie=name+'='+escape(bookmark)+expires+'; path='+edir_path;$('#confirmDiv').html("<p class=\"informationMessage\">"+showText(LANG_JS_FAVORITEADD)+"</p>");tb_show("","#TB_inline?width=400&height=110&inlineId=confirmDiv");}}
function removeFromCookie(property_id,edir_path,type){var name="bookmark"+type;var d=new Date();if(!edir_path)edir_path="/";d.setTime(d.getTime()+(15*24*60*60*1000));var expires='; expires='+d.toGMTString();if(isNaN(property_id)){if(property_id=="all"){var bookmark="";document.cookie=name+'='+escape(bookmark)+expires+'; path='+edir_path;}}else{var bookmark=readCookie("bookmark"+type);if(bookmark.length>0){if(bookmark.indexOf("'"+property_id+"'")>-1){finalvar=bookmark.indexOf("'"+property_id+"'")+property_id.length+3;var aux="";aux=bookmark.substr(0,bookmark.indexOf("'"+property_id+"'"));aux+=bookmark.substr(finalvar);bookmark=aux;}}
len=bookmark.length;len--;if(bookmark.lastIndexOf(",")==len){bookmark=bookmark.substr(0,len);}
document.cookie=name+'='+escape(bookmark)+expires+'; path='+edir_path;$('#confirmDiv').html("<p class=\"successMessage\">"+showText(LANG_JS_FAVORITEDEL)+"</p>");tb_show("","#TB_inline?width=300&height=90&inlineId=confirmDiv");}
setTimeout("window.location.reload();",2000);}

/* File: /scripts/jquery/jquery.selectbox.js */
;(function($){$.fn.addOption=function()
{var add=function(el,v,t,sO)
{var option=document.createElement("option");option.value=v,option.text=t;var o=el.options;var oL=o.length;if(!el.cache)
{el.cache={};for(var i=0;i<oL;i++)
{el.cache[o[i].value]=i;}}
if(typeof el.cache[v]=="undefined")el.cache[v]=oL;el.options[el.cache[v]]=option;if(sO)
{option.selected=true;}};var a=arguments;if(a.length==0)return this;var sO=true;var m=false;var items,v,t;if(typeof(a[0])=="object")
{m=true;items=a[0];}
if(a.length>=2)
{if(typeof(a[1])=="boolean")sO=a[1];else if(typeof(a[2])=="boolean")sO=a[2];if(!m)
{v=a[0];t=a[1];}}
this.each(function()
{if(this.nodeName.toLowerCase()!="select")return;if(m)
{for(var item in items)
{add(this,item,items[item],sO);}}
else
{add(this,v,t,sO);}});return this;};$.fn.ajaxAddOption=function(url,params,select,fn,args)
{if(typeof(url)!="string")return this;if(typeof(params)!="object")params={};if(typeof(select)!="boolean")select=true;this.each(function()
{var el=this;$.getJSON(url,params,function(r)
{$(el).addOption(r,select);if(typeof fn=="function")
{if(typeof args=="object")
{fn.apply(el,args);}
else
{fn.call(el);}}});});return this;};$.fn.removeOption=function()
{var a=arguments;if(a.length==0)return this;var ta=typeof(a[0]);var v,index;if(ta=="string"||ta=="object"||ta=="function")
{v=a[0];if(v.constructor==Array)
{var l=v.length;for(var i=0;i<l;i++)
{this.removeOption(v[i],a[1]);}
return this;}}
else if(ta=="number")index=a[0];else return this;this.each(function()
{if(this.nodeName.toLowerCase()!="select")return;if(this.cache)this.cache=null;var remove=false;var o=this.options;if(!!v)
{var oL=o.length;for(var i=oL-1;i>=0;i--)
{if(v.constructor==RegExp)
{if(o[i].value.match(v))
{remove=true;}}
else if(o[i].value==v)
{remove=true;}
if(remove&&a[1]===true)remove=o[i].selected;if(remove)
{o[i]=null;}
remove=false;}}
else
{if(a[1]===true)
{remove=o[index].selected;}
else
{remove=true;}
if(remove)
{this.remove(index);}}});return this;};$.fn.sortOptions=function(ascending)
{var sel=$(this).selectedValues();var a=typeof(ascending)=="undefined"?true:!!ascending;this.each(function()
{if(this.nodeName.toLowerCase()!="select")return;var o=this.options;var oL=o.length;var sA=[];for(var i=0;i<oL;i++)
{sA[i]={v:o[i].value,t:o[i].text}}
sA.sort(function(o1,o2)
{o1t=o1.t.toLowerCase(),o2t=o2.t.toLowerCase();if(o1t==o2t)return 0;if(a)
{return o1t<o2t?-1:1;}
else
{return o1t>o2t?-1:1;}});for(var i=0;i<oL;i++)
{o[i].text=sA[i].t;o[i].value=sA[i].v;}}).selectOptions(sel,true);return this;};$.fn.selectOptions=function(value,clear)
{var v=value;var vT=typeof(value);if(vT=="object"&&v.constructor==Array)
{var $this=this;$.each(v,function()
{$this.selectOptions(this,clear);});};var c=clear||false;if(vT!="string"&&vT!="function"&&vT!="object")return this;this.each(function()
{if(this.nodeName.toLowerCase()!="select")return this;var o=this.options;var oL=o.length;for(var i=0;i<oL;i++)
{if(v.constructor==RegExp)
{if(o[i].value.match(v))
{o[i].selected=true;}
else if(c)
{o[i].selected=false;}}
else
{if(o[i].value==v)
{o[i].selected=true;}
else if(c)
{o[i].selected=false;}}}});return this;};$.fn.copyOptions=function(to,which)
{var w=which||"selected";if($(to).size()==0)return this;this.each(function()
{if(this.nodeName.toLowerCase()!="select")return this;var o=this.options;var oL=o.length;for(var i=0;i<oL;i++)
{if(w=="all"||(w=="selected"&&o[i].selected))
{$(to).addOption(o[i].value,o[i].text);}}});return this;};$.fn.containsOption=function(value,fn)
{var found=false;var v=value;var vT=typeof(v);var fT=typeof(fn);if(vT!="string"&&vT!="function"&&vT!="object")return fT=="function"?this:found;this.each(function()
{if(this.nodeName.toLowerCase()!="select")return this;if(found&&fT!="function")return false;var o=this.options;var oL=o.length;for(var i=0;i<oL;i++)
{if(v.constructor==RegExp)
{if(o[i].value.match(v))
{found=true;if(fT=="function")fn.call(o[i],i);}}
else
{if(o[i].value==v)
{found=true;if(fT=="function")fn.call(o[i],i);}}}});return fT=="function"?this:found;};$.fn.selectedValues=function()
{var v=[];this.selectedOptions().each(function()
{v[v.length]=this.value;});return v;};$.fn.selectedTexts=function()
{var t=[];this.selectedOptions().each(function()
{t[t.length]=this.text;});return t;};$.fn.selectedOptions=function()
{return this.find("option:selected");};})(jQuery);

/* File: /scripts/float_layer.js */

document.onmousemove=captureMousePosition;var xMousePos=0;var yMousePos=0;function captureMousePosition(e){e=e||window.event;if(e.pageX||e.pageY){xMousePos=e.pageX;yMousePos=e.pageY;}else if(typeof(e.clientX)=='number'){xMousePos=event.clientX;yMousePos=event.clientY;}}
function enablePopupLayer(type,comment,listing_title,reply){var float_layer=document.getElementById("float_layer");var layer_reply='';float_layer.style.visibility='visible';if(type=='review'){float_layer.style.left=(xMousePos+20)+"px";float_layer.style.top=(yMousePos+10)+"px";if(reply){layer_reply='<br />'
+'<p><strong><?=system_showText(LANG_REPLYNOUN);?>: </strong></p>'
+'<p>'+reply+'</p>'
+'';}
float_layer.innerHTML=''
+'<h3>'+listing_title+'</h3>'
+'<p><strong><?=system_showText(LANG_REVIEW);?>: </strong></p>'
+'<p>'+comment+'</p>'
+layer_reply;}
else if(type=='langnav'){float_layer.style.left=(xMousePos-220)+"px";float_layer.style.top=(yMousePos+10)+"px";float_layer.innerHTML=$('#allLang').html();}}
function disablePopupLayer(keep){var float_layer=document.getElementById("float_layer");float_layer.style.visibility='hidden';if(!keep){float_layer.innerHTML='';}}

/* File: /scripts/jquery/twitter/twitter.js */

function twitterCallback2(twitters){var div_loading=TWITTER_DIV_LOADING;var div_twitters=TWITTER_DIV_TWITTERS;var statusHTML=[];for(var i=0;i<twitters.length;i++){var username=twitters[i].user.screen_name;var status=twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g,function(url){return'<a href="'+url+'">'+url+'</a>';}).replace(/\B@([_a-z0-9]+)/ig,function(reply){return reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';});statusHTML.push('<li><span>'+status+'</span> <a style="font-size:85%" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id_str+'">'+relative_time(twitters[i].created_at)+'</a></li>');}
$(div_loading).fadeOut(500,function(){$(div_twitters).append($(statusHTML.join('')).hide().fadeIn(500));});}
function relative_time(time_value){var values=time_value.split(" ");time_value=values[1]+" "+values[2]+", "+values[5]+" "+values[3];var parsed_date=Date.parse(time_value);var relative_to=(arguments.length>1)?arguments[1]:new Date();var delta=parseInt((relative_to.getTime()-parsed_date)/1000);delta=delta+(relative_to.getTimezoneOffset()*60);if(delta<60){return'less than a minute ago';}else if(delta<120){return'about a minute ago';}else if(delta<(60*60)){return(parseInt(delta/60)).toString()+' minutes ago';}else if(delta<(120*60)){return'about an hour ago';}else if(delta<(24*60*60)){return'about '+(parseInt(delta/3600)).toString()+' hours ago';}else if(delta<(48*60*60)){return'1 day ago';}else{return(parseInt(delta/86400)).toString()+' days ago';}}