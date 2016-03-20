<?php
//Copyright: Byke

?>

<div class="adminArea">
<form id="smtForm" action="post">
<h2><span class="icon-list"></span> [[=admin:sect:Articles]]<span class="adminSANew"><a href='[[::siteURL]]/[[::linkPrefixAdmin]]/articles/new/[[::linkConj]]CSRFCode=[[::newCSRFCode]]'><span class="icon-plus2"></span> [[=admin:btn:NewArticle]]</a> <a href='##' onclick="shBatch();"><span class="icon-wrench"></span> [[=admin:btn:Batch]]</a></span></h2> 
<div id="adminSAB"><a href='##' onclick="shSelAll();">[[=admin:btn:SelectAll]]</a> &nbsp; <a href='##' onclick="shDeSelAll();">[[=admin:btn:DeSelectAll]]</a> &nbsp; <a href='##' onclick="shDel();">[[=admin:btn:Delete]]</a> &nbsp; <a href='##' onclick="shDraft();">[[=admin:btn:MoveDraft]]</a></div>
<p>
<ul id="artList">
[[::loop, adminarticlelist]]<li class="adminSingleArticle adminSAL" title="[[=admin:msg:Select]]" data-aid="[[::aID]]"><a href="[[::siteURL]]/[[::linkPrefixArticle]]/[[::aID]]/" title="[[=admin:msg:Open]]"><span class="icon-export"></span></a> <span class="adminSAT" data-aid="[[::aID]]" title="[[=admin:msg:Modify]]">[[::aTitle]]</span> <span class="adminSADate">[[::aTime]]</span> </li>
[[::/loop]]
</ul>
</p>
<br/>
<div id="adminSAPage">[[::pagination]]</div>



<h2><span class="icon-archive"></span> [[=admin:sect:Categories]]<span class="adminSANew"><a href='##' onclick='$("#adminSCInputNew").toggle()'><span class="icon-plus2"></span> [[=admin:btn:NewCate]]</a> <a href='##' onclick="saveCategoryChanges('[[::siteURL]]/[[::linkPrefixAdmin]]/articles/savecategories/');"><span class="icon-disk"></span> [[=admin:btn:Save]]</a></span></h2>
<p><ul class="adminCateList" id="adminCateList">
[[::loop, admincatelist]]<li class="adminSingleArticle adminSCL" data-cid="[[::aCateURLName]]" id="adminSCL-[[::aCateURLName]]"><a href="##" title="[[=admin:msg:Up]]" class="adminSCLUp" data-cid="[[::aCateURLName]]"><span class="icon-arrow-up3"></span></a> <a href="##" title="[[=admin:msg:Down]]" class="adminSCLDown" data-cid="[[::aCateURLName]]"><span class="icon-arrow-down4"></span></a> <span id="adminSCLine-[[::aCateURLName]]" class="adminSCLine" data-cid="[[::aCateURLName]]">[[::aCateDispName]]</span><span class="adminSCLModify" id="adminSCM-[[::aCateURLName]]"><input type="text" class="inputLine inputLarge" value="[[::aCateDispName]]" id="adminSCInput-[[::aCateURLName]]"> <br/><a href="##" onclick='$("#adminSCM-[[::aCateURLName]]").fadeToggle();$("#adminSCL-[[::aCateURLName]]").remove();'><span class="icon-cross3"></span> [[=admin:msg:Remove]]</a> &nbsp; <a href="##" onclick='$("#adminSCM-[[::aCateURLName]]").fadeToggle();$("#adminSCLine-[[::aCateURLName]]").html($("#adminSCInput-[[::aCateURLName]]").val());$("#adminSCLine-[[::aCateURLName]]").toggle();'><span class="icon-arrow-up4"></span> [[=admin:msg:Close]]</a></span></li>
[[::/loop]]
</ul>
<span id="adminSCInputNew">

<input type="text" class="inputLine inputSmall" value="" placeholder="[[=admin:msg:NewCate]]"  id="adminSCInputNewItemName" /> <input type="text" class="inputLine inputSmall" value="" placeholder="ID"  id="adminSCInputNewItemID" />

<a href='##' onclick="addCategory('[[::siteURL]]/[[::linkPrefixAdmin]]/articles/validatecategory/');"><span class="icon-disk"></span> [[=admin:btn:Add]]</a><br/> </span>
<span class="adminExplain">[[=admin:msg:Categories]]</span></p>
<p class="adminCommand">
<p id="adminPromptError"></p><p id="adminPromptSuccess"></p>
</p>
[[::ext_adminArticles]]

<p><br/></p>
<h2><span class="icon-suitcase"></span> [[=admin:item:TrashBin]]</h2> 
<p>
<ul id="draftList">
[[::loop, admindraftlist]]<li class="adminSingleArticle adminSAL" data-aid="[[::aID]]"><a href="#"><span class="icon-popup"></span></a> <span class="adminSAT" data-aid="[[::aID]]" title="[[=admin:msg:Modify]]">[[::aTitle]]</span> <span class="adminSADate">[[::aTime]]</span> </li>
[[::/loop]]
</ul>
</p>

<p><br/></p>
<h2><span class="icon-newspaper2"></span> [[=admin:sect:Pages]]<span class="adminSANew"><a href='[[::siteURL]]/[[::linkPrefixAdmin]]/articles/newpage/[[::linkConj]]CSRFCode=[[::newCSRFCode]]'><span class="icon-plus2"></span> [[=admin:btn:NewPage]]</a></span></h2> 
<p>
<ul id="spList">
[[::loop, adminsinglepagelist]]<li class="adminSingleArticle adminSAL" data-aid="[[::aID]]"><a href="[[::siteURL]]/[[::linkPrefixPage]]/[[::aID]]/" title="[[=admin:msg:Open]]"><span class="icon-export"></span></a> <span class="adminSAT" data-aid="[[::aID]]" title="[[=admin:msg:Modify]]">[[::aTitle]]</span> <span class="adminSADate">[[::aTime]]</span> </li>
[[::/loop]]
</ul>
</p>


<script type="text/javascript">


$(".adminSAT").click(function(){
	var aID=$(this).data("aid");
	window.location="[[::siteURL]]/[[::linkPrefixAdmin]]/articles/modify/[[::linkConj]]aID="+aID+"&CSRFCode=[[::oldCSRFCode]]";
});
$("#artList .adminSAL").click(function(){
	$(this).toggleClass("adminSAChosen");
});
$("#admArticles").addClass("activeNav");

function shBatch() {
	$('#adminSAB').fadeToggle (500);
}
function shSelAll() {
	$("#artList .adminSAL").addClass("adminSAChosen");
}
function shDeSelAll() {
	$("#artList .adminSAL").removeClass("adminSAChosen");
}
function shDel() {
	if ($(".adminSAChosen").length>0) {
		if (confirm("[[=admin:msg:DeleteBatch]]")) {
			if (confirm("[[=admin:msg:DeleteBatch2]]")) {
				var aID=new Array();
				$(".adminSAChosen").each (function () {
					aID.push($(this).data("aid"));
				});
				var smtURL="[[::siteURL]]/[[::linkPrefixAdmin]]/articles/batchdel/[[::linkConj]]ajax=1&"+encodeURI("aID="+aID.join('<'))+"&CSRFCode=[[::oldCSRFCode]]";
				$.post(smtURL, null, function(data) {
					if (data.error==1) {
						alert (data.returnMsg);
					}
					else {
						window.location.reload();
					}
				}, "json");
			}
		}
	}
}
function shDraft() {
	if ($(".adminSAChosen").length>0) {
		var aID=new Array();
		$(".adminSAChosen").each (function () {
			aID.push($(this).data("aid"));
		});
		var smtURL="[[::siteURL]]/[[::linkPrefixAdmin]]/articles/batchdraft/[[::linkConj]]ajax=1&"+encodeURI("aID="+aID.join('<'))+"&CSRFCode=[[::oldCSRFCode]]";
		$.post(smtURL, null, function(data) {
			if (data.error==1) {
				alert (data.returnMsg);
			}
			else {
				window.location.reload();
			}
		}, "json");
	}
}
if ($("#draftList .adminSAL").length==0) {
	$("#draftList").html("<li class=\"adminSingleArticle adminSAL\">[[=admin:msg:EmptyTrashBin]]</li>");
}
if ($("#spList .adminSAL").length==0) {
	$("#spList").html("<li class=\"adminSingleArticle adminSAL\">[[=admin:msg:EmptySinglePage]]</li>");
}
function bindUpDown () {
	$('.adminSCLUp').click(function() {
		var cID="adminSCL-"+$(this).data("cid");
		if ($("#"+cID).prev().length>0)
		{
			$("#"+cID).prev().before($("#"+cID));
		}
	});

	$('.adminSCLDown').click(function() {
		var cID="adminSCL-"+$(this).data("cid");
		if ($("#"+cID).next().length>0)
		{
			$("#"+cID).next().after($("#"+cID));
		}
	});
	$('.adminSCLine').click(function() {
		var cID=$(this).data("cid");
		$("#"+"adminSCM-"+cID).fadeToggle();
		$("#"+"adminSCLine-"+cID).toggle();
	});
}
bindUpDown ();


$("#adminSCInputNew").hide();

function addCategory(smtURL) {
	if ($("#adminSCInputNewItemName").val()=='')
	{
		alert ("[[=admin:msg:ErrorCorrection]]");
		return false;
	}

	var newList=$("#adminSCInputNewItemID").val()+'='+$("#adminSCInputNewItemName").val();
	var nList=newList.split('=');
	var smtURL=smtURL+"[[::linkConj]]ajax=1&CSRFCode=[[::cateCSRFCode]]";	
	var sVal=encodeURI("smt[aCateURLName]="+nList[0]+"&smt[aCateDispName]="+nList[1]);
	$.post(smtURL, sVal, function(data) {
		if (data.error==1) {
			$("#adminPromptError").text (data.returnMsg);
			$("#adminPromptError").fadeIn(400).delay(1500).fadeOut(600);
		}
		else {
			$("#adminCateList").append(data.returnMsg);
			$( '.adminSCLUp').unbind("click");
			$( '.adminSCLDown').unbind("click");
			$( '.adminSCLine').unbind("click");
			bindUpDown ();
			$("#adminSCInputNewItem").val('');
			$("#adminSCInputNew").hide();
		}
	}, "json");
}

function saveCategoryChanges(smtURL) {
	$("#UI-loading").fadeIn(500);
	var finalList='';
	$('.adminSCL').each(function(){
		var cID=$(this).data("cid");
		finalList+=encodeURI("smt["+cID+"]="+$("#"+"adminSCLine-"+cID).html()+"&");
	});

	var smtURL=smtURL+"[[::linkConj]]ajax=1&CSRFCode=[[::cateCSRFCode]]";	

	$.post(smtURL, finalList, function(data) {
		$("#UI-loading").fadeOut(200);
		if (data.error==1) {
			$("#adminPromptError").text (data.returnMsg);
			$("#adminPromptError").fadeIn(400).delay(1500).fadeOut(600);
		}
		else {
			$("#adminPromptSuccess").text (data.returnMsg);
			$("#adminPromptSuccess").fadeIn(400).delay(1500).fadeOut(600);
		}
	}, "json");
}

</script>
</form>

</div>

[[::ext_adminArticlesEnding]]