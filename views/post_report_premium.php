


<div style="width: 100%;">
<div>
		<div class="mo_wpns_setting_layout">

	<div>

		<form name="f" method="post" action="" id="" >
		<input type="hidden" name="option" value="" />
		<table>
            <tr>
                <td style="width: 100%">
                    <h2>
                        Live Tracking <span style="color: red;">[ Premium ]</span>
                    </h2>
                </td>
		        
            </tr>
        </table>
		<br>
	</form>
		</div>
        <table id="post_reports_premium" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">Post Author</th>
                        <th style="text-align: center;">Post Title</th>
                        <th style="text-align: center;">Total visites</th>
                        <th style="text-align: center;">Comment Count</th>
                    </tr>
                </thead>
                <tbody>
            </tbody>
            </table>
        </div>
</div>
</div>


<script>
    jQuery(document).ready(function() {
        jQuery("#post_reports_premium").DataTable({
            "order": [[ 1, "desc" ]]
        });
    });
</script>
