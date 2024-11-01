<div style="width: 100%;">
<div class="mo_wpns_divided_layout">
	<div class="mo_wpns_setting_layout">
	<div>
		<form name="f" method="post" action="" id="manualblockipform" >
		<input type="hidden" name="option" value="mo_wpns_manual_clear_page_count" />
        <?php echo'<input type="hidden" name="mo_site_page_count_nonce" value="'.esc_html(wp_create_nonce('mo-site-page-count-nonce')).'"/>';?>
		<table>
            <tr>
                <td style="width: 100%">
                    <h2>
                        Most Visited Page
                    </h2>
                </td>
		        <td>
                    <input type="submit" class="button button-primary button-large" value="Clear Reports" />
                </td>
            </tr>
        </table>
		<br>
	</form>
		</div>
        <table id="page_count_reports" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">Visited Page</th>
                        <th style="text-align: center;">Page Count ↓</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                        mosa_showpage_count_Transactions($page_count_transcations);
                   ?>
            </tbody>
            </table>
        </div>
</div>
</div>

<script>
    jQuery(document).ready(function() {
        jQuery("#page_count_reports").DataTable({
            "order": [[ 1, "desc" ]]
        });
    });
</script>
<?php
function mosa_showpage_count_Transactions($usertranscations)
    {   
         foreach($usertranscations as $usertranscation)
        {   
               echo "<tr><td style='text-align:left;'>".esc_html($usertranscation->visited_page)."</td><td>".esc_html($usertranscation->visited_page_count)."</td>";
                
        }
    }
?>