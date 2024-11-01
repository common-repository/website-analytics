<?php
global $MositeDirName;
?>
<br>
<div class="nav-tab-wrapper">
	<button class="nav-tab tablinks" onclick="openTab(event, 'logged_in_user')" id="login_sec">Logged In User</button>
    <button class="nav-tab tablinks" onclick="openTab(event, 'current_logged_in_user')" id="live_user">Live Users</button>
</div>
<br>
<div class="tabcontent" id="logged_in_user">
	<div class="mo_wpns_divided_layout">
		<table style="width:100%;">
			<tr>
				<td>
					<?php 
					include_once $MositeDirName . 'controller'.DIRECTORY_SEPARATOR.'page_report.php'; 
					?>
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="tabcontent" id="current_logged_in_user">
	<div class="mo_wpns_divided_layout">
		<table style="width:100%;">
			<tr>
				<td>
					<?php include_once $MositeDirName . 'controller'.DIRECTORY_SEPARATOR.'page_report_premium.php'; ?>
				</td>
			</tr>
		</table>
	</div>
</div>

<script>
	document.getElementById("logged_in_user").style.display = "block";
	document.getElementById("current_logged_in_user").style.display = "none";
	document.getElementById("login_sec").className += " active";
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
	if(tab == "logged_in_user"){
		document.getElementById("login_sec").click();
	}
	else if(tab == "current_logged_in_user"){
		document.getElementById("live_user").click();
	}
	else{
		document.getElementById("login_sec").click();
	}
</script>