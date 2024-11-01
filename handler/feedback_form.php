<?php
global $MositeDirName;
class MoSite_Feedback_Handler
{
    function __construct()
    { 
        add_action('admin_init', array($this, 'mosa_feedback_actions'));
    }

function mosa_feedback_actions()
{
    global $moWpnsUtility, $MositeDirName;
    if (current_user_can('manage_options') && isset($_POST['option'])) {
       switch (sanitize_text_field(wp_unslash($_REQUEST['option']))) {
        case 'mo_site_skip_feedback':  
            $this->mosa_handle_feedback($_POST);
            break;
        case "mo_wpns_feedback":                    
            $this->mosa_handle_feedback($_POST);
            break;
        
        }
    }
}

function mosa_handle_feedback($postdata)
{
    if(sanitize_text_field(wp_unslash($postdata['option']))==='mo_wpns_feedback'){
        $nonce = sanitize_text_field(wp_unslash($postdata['mo_site_nonce']));
        if ( ! wp_verify_nonce( $nonce, 'mo-site-feedback-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        }
       }else if(sanitize_text_field(wp_unslash($postdata['option']))==='mo_site_skip_feedback'){
         $nonce = sanitize_text_field(wp_unslash($postdata['mo_site_skip_nonce']));
        if ( ! wp_verify_nonce( $nonce, 'mo-site-skip-nonce' ) ){
          do_action('mo_site_show_message',Mosite_Messages::showMessage('NONCE_ERROR'),'ERROR');
          return;
        }
       } 

    $user = wp_get_current_user();
    $feedback_option = sanitize_text_field(wp_unslash($_POST['option']));
    $message ='[version : '. MO_SITE_ANALYTICS_VERSION .']'; 
    $message .= 'Plugin Deactivated';
    $deactivate_reason_message = array_key_exists('wpns_query_feedback', $_POST) ? htmlspecialchars(sanitize_text_field($_POST['wpns_query_feedback'])) : false;


    $reply_required = '';
    if (isset($_POST['get_reply']))
        $reply_required = sanitize_text_field(wp_unslash($_POST['get_reply']));
    if (empty($reply_required)) {
        $reply_required = "don't reply";
        $message .= '<b style="color:red";> &nbsp; [Reply :' . $reply_required . ']</b>';
    } else {
        $reply_required = "yes";
        $message .= '[Reply :' . $reply_required . ']';
    }


    $message .= ', Feedback : ' . $deactivate_reason_message . '';

  
    if (isset($_POST['rate'])){
        $rate_value = sanitize_text_field(wp_unslash($_POST['rate']));
        $message .= ', [Rating :' . $rate_value . ']';
   }
   else{
      $message .= ', [Rating :]';
   }

  if(isset($_POST['query_mail']))
   {
   $email = sanitize_email($_POST['query_mail']);
   }
   else
    $email='';
   

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = get_site_option('mo2f_email');
        if (empty($email))
            $email = $user->user_email;
    }
    $phone = get_site_option('mo_wpns_admin_phone');
    $feedback_reasons = new Mosite_URL();
   
    if (!is_null($feedback_reasons)) {
        if (!$this->mosa_is_curl_installed()) {
            deactivate_plugins(dirname(dirname(__FILE__ ))."\\miniorange-site-activity-setting.php");
            wp_redirect('plugins.php');
        } else {
            $submited = json_decode($feedback_reasons->mosa_send_email_alert($email, $phone, $message, $feedback_option), true);
            if (json_last_error() == JSON_ERROR_NONE) {
                if (is_array($submited) && array_key_exists('status', $submited) && $submited['status'] == 'ERROR') {
                    do_action('mo_site_show_message',$submited['message'],'ERROR');

                } else {
                    if ($submited == false) {
                        do_action('mo_site_show_message','Error while submitting the query.','ERROR');
                    }
                }
            }

            deactivate_plugins(dirname(dirname(__FILE__ ))."\\miniorange-site-activity-setting.php");
            do_action('mo_site_show_message','Thank you for the feedback.','SUCCESS');

        }
    }
}

public static function mosa_is_curl_installed()
{
    if  (in_array  ('curl', get_loaded_extensions()))
        return 1;
    else 
        return 0;
}


}new MoSite_Feedback_Handler();
