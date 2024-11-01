<?php 
global $MositeDirName;
?> 
<br>
<div class="nav-tab-wrapper">
	<button class="nav-tab tablinks" onclick="openTab(event, 'post_report_tab')" id="post_reports_tab">Post Report</button>
    <button class="nav-tab tablinks" onclick="openTab(event, 'post_report_premium_tab')" id="post_reports_preminum">Post Details</button>
</div>
<br>
<div class="tabcontent" id="post_report_tab">
	<div class="mo_wpns_divided_layout">
		<table style="width:100%;">
			<tr>
				<td>
					<?php 
					include_once $MositeDirName . 'controller'.DIRECTORY_SEPARATOR.'post_report.php'; 
					?>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="tabcontent" id="post_report_premium_tab">
	<div class="mo_wpns_divided_layout">
		<table style="width:100%;">
			<tr>
				<td>
					<?php include_once $MositeDirName . 'controller'.DIRECTORY_SEPARATOR.'post_report_premium.php'; ?>
				</td>
			</tr>
		</table>
	</div>
</div>

<script>
	document.getElementById("post_report_tab").style.display = "block";
	document.getElementById("post_report_premium_tab").style.display = "none";
	document.getElementById("post_reports_tab").className += " active";
	function openTab(evt, tabname){
		var i, tablinks, tabcontent;
		tabcontent = document.getElementsByClassName("tabcontent");
  			for (i = 0; i < tabcontent.length; i++) {
    		tabcontent[i].style.display = "none";
  		}
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}
		document.getElementById(tabname).style.display = "block";
		localStorage.setItem("tablast", tabname);
  		evt.currentTarget.className += " active";
	}
	var tab = localStorage.getItem("tablast");
	if(tab == "post_report_tab"){
		document.getElementById("post_reports_tab").click();
	}
	else if(tab == "post_report_premium_tab"){
		document.getElementById("post_reports_preminum").click();
	}
	else{
		document.getElementById("post_reports_tab").click();
	}
</script>