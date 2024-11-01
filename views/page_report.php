<?php
$page_report_nonce = wp_create_nonce('mo-site-page-report-nonce');
?>
<div style="width: 100%;">
		<div class="mo_wpns_setting_layout">
	<div>
		<form name="f" method="post" action="" id="manualblockipform" >
		<input type="hidden" name="option" value="mosa_page_report_manual_clear" />
        <?php echo'<input type="hidden" name="mo_site_page_report_nonce" value="'.esc_html($page_report_nonce).'"/>';?>
		<table>
            <tr>
                <td style="width: 100%">
                    <h2>
                        Login Transactions Report
                    </h2>
                </td>
		        <td>
                    <input type="submit" class="button button-primary button-large" value="Clear Login Reports" />
                </td>
            </tr>
        </table>
		<br>
	</form>
		</div>
        <table id="login_reports" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">IP Address</th>
                        <th style="text-align: center;">Username</th>
                        <th style="text-align: center;">Visited Page</th>
                        <th style="text-align: center;">Site Referel</th>
                        <th style="text-align: center;">Time Spent on Page</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                
                   mosa_showLoginTransactions($logintranscations);
                   ?>
            </tbody>
            </table>
        </div>
</div>


<script>
    jQuery(document).ready(function() {
        jQuery("#login_reports").DataTable({
            "order": [[ 1, "desc" ]]
        });
    });
</script>
<?php
function mosa_showLoginTransactions($usertranscations)
    {   
         foreach($usertranscations as $usertranscation)
        {   
                echo "<tr><td>".esc_html($usertranscation->ip)."</td><td>".esc_html($usertranscation->username)."</td><td style='text-align:left;'>".esc_html($usertranscation->visited_page)."</td><td style='text-align:left;'>".esc_html($usertranscation->site_referel)."</td><td style='color:red; font-weight:700;'>[PREMIUM]</td>";
                
        }
    }
?>