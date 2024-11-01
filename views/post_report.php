<div style="width: 100%;">
<div>
		<div class="mo_wpns_setting_layout">

	    <div>

                    <h2>
                        Posts Report
                    </h2>
    
		</div>
        <table id="post_reports" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;">Post Author</th>
                        <th style="text-align: center;">Post Title</th>
                        <th style="text-align: center;">Post Status</th>
                        <th style="text-align: center;">Post Type</th>
                        <th style="text-align: center;">Publish Date</th>
                        <th style="text-align: center;">Comment Count</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                   mosa_showpostTransactions($posttranscations);
                 
                   ?>
            </tbody>
            </table>
        </div>
</div>
</div>

<script>
    jQuery(document).ready(function() {
        jQuery("#post_reports").DataTable({
            "order": [[ 1, "desc" ]]
        });
    });
</script>
<?php
function mosa_showpostTransactions($usertranscations)
    {   
         foreach($usertranscations as $usertranscation)
        {   
            $user=get_user_by('id', $usertranscation->post_author);
                echo "<tr><td>".esc_html($user->user_login)."</td><td>".esc_html($usertranscation->post_title)."</td><td>".esc_html($usertranscation->post_status)."</td><td>".esc_html($usertranscation->post_type)."</td><td>".esc_html($usertranscation->post_date)."</td><td>".esc_html($usertranscation->comment_count)."</td>";
                
        }
    }
?>