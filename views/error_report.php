<div style="width: 100%;">
<div class="mo_wpns_divided_layout">
		<div class="mo_wpns_setting_layout">
	<div>
		<form name="f" method="post" action="" id="manualblockipform" >
		<input type="hidden" name="option" value="mosa_error_manual_clear" />
        <?php echo'<input type="hidden" name="mo_site_error_nonce" value="'.esc_html(wp_create_nonce('mo-site-error-nonce')).'"/>';?>

		<table>
            <tr>
                <td style="width: 100%">
                    <h2>
                        Error Transactions Report
                    </h2>
                </td>
		        <td>
                    <input type="submit" class="button button-primary button-large" value="Clear Error Reports" />
                </td>
            </tr>
        </table>
		<br>
	</form>
		</div>
        <table id="error_reports" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">Ip Address</th>
                        <th style="text-align: center;">Username</th>
                        <th style="text-align: center;">URL</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                   mosa_showerrorTransactions($errortranscations);
                   ?>
            </tbody>
            </table>
        </div>
</div>
</div>

<script>
    jQuery(document).ready(function() {
        jQuery("#error_reports").DataTable({
            "order": [[ 1, "desc" ]]
        });
    });
</script>
<?php
function mosa_showerrorTransactions($usertranscations)
    {   
         foreach($usertranscations as $usertranscation)
        {   
               echo "<tr><td>".esc_html($usertranscation->ip)."</td><td>".esc_html($usertranscation->username)."</td><td style='text-align:left;'>".esc_html($usertranscation->visited_page)."</td>";
                
        }
    }
?>