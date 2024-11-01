<?php
global $MositeDirName;
?>
<br>
<div class="nav-tab-wrapper">
	<button class="nav-tab tablinks" onclick="openTab(event, 'guest_user')" id="guest_sec">Guest User</button>
    <button class="nav-tab tablinks" onclick="openTab(event, 'current_guest_user')" id="live_guest">Live Users</button>
</div>
<br>
<div class="tabcontent" id="guest_user">
	<div class="mo_wpns_divided_layout">
		<table style="width:100%;">
			<tr>
				<td>
					<?php 
					include_once $MositeDirName . 'controller'.DIRECTORY_SEPARATOR.'user_login_status.php'; 
					?>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="tabcontent" id="current_guest_user">
	<div class="mo_wpns_divided_layout">
		<table style="width:100%;">
			<tr>
				<td>
					<?php include_once $MositeDirName . 'controller'.DIRECTORY_SEPARATOR.'user_login_status_premium.php'; ?>
				</td>
			</tr>
		</table>
	</div>
</div>

<script>
	document.getElementById("guest_user").style.display = "block";
	document.getElementById("current_guest_user").style.display = "none";
	document.getElementById("guest_sec").className += " active";
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
	if(tab == "guest_user"){
		document.getElementById("guest_sec").click();
	}
	else if(tab == "current_guest_user"){
		document.getElementById("live_guest").click();
	}
	else{
		document.getElementById("guest_sec").click();
	}
</script>