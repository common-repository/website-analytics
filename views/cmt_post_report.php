<div style="width: 100%;">
<div class="mo_wpns_divided_layout">
		<div class="mo_wpns_setting_layout">

	    <div>
            <h2>Comments Report</h2>       
		<br>
		</div>
        <table id="cmt_reports" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">author</th>
                        <th style="text-align: center;">author email</th>
                        <th style="text-align: center;">comment content</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                   mosa_showcmtTransactions($commenttranscations);
                   ?>
            </tbody>
            </table>
        </div>
</div>
</div>

<script>
    jQuery(document).ready(function() {
    	
        jQuery("#cmt_reports").DataTable({
						"order": [[ 1, "desc" ]]
						});
    });
</script>
<?php
function mosa_showcmtTransactions($usertranscations)
    {   
         foreach($usertranscations as $usertranscation)
        {   
                echo "<tr><td>".esc_html($usertranscation->comment_author)."</td><td>".esc_html($usertranscation->comment_author_email)."</td><td>".esc_html($usertranscation->comment_content)."</td>";
                
        }
    }
?>