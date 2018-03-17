<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * ------------- DO NOT UPLOAD THIS FILE TO LIVE SERVER ---------------------
 *
 * Implements code completion for CodeIgniter in PHPStorm.
 * PHPStorm indexes all class constructs, so if this file is in the project it will be loaded.
 *
 * These property values were borrowed from another project.
 * Visit : https://github.com/topdown/phpStorm-CC-Helpers
 *
 * This version is just an upgraded one working with CodeIgniter 3.
 *
 * PHP version 5
 *
 * LICENSE: GPL http://www.gnu.org/copyleft/gpl.html
 *
 * Created 11/12/15, 01:48 PM
 *
 * @category
 * @package    CodeIgniter CI_PHPStorm.php
 * @author     Nicolas Goudry
 * @copyright  2015 Nicolas Goudry
 * @license    GPL http://www.gnu.org/copyleft/gpl.html
 * @version    2015.11.12
 */

/**
 * @description Completion in controllers
 ***************** CORE COMPONENTS *****************
 * @property CI_Benchmark        $benchmark            This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
 * @property CI_Config           $config               This class contains functions that enable config files to be managed
 * @property CI_Controller       $controller           This class object is the super class that every library in CodeIgniter will be assigned to.
 * @property CI_Exceptions       $exceptions           Exceptions Class
 * @property CI_Hooks            $hooks                Provides a mechanism to extend the base system without hacking.
 * @property CI_Input            $input                Pre-processes global input data for security
 * @property CI_Lang             $lang                 Language Class
 * @property CI_Loader           $load                 Loads framework components.
 * @property CI_Log              $log                  Logging Class
 * @property CI_Model            $model                Model Class
 * @property CI_Output           $output               Responsible for sending final output to the browser.
 * @property CI_Router           $router               Parses URIs and determines routing
 * @property CI_Security         $security             Security Class
 * @property CI_URI              $uri                  Parses URIs and determines routing
 * @property CI_Utf8             $utf8                 Provides support for UTF-8 environments
 ***************** DATABASE COMPONENTS *****************
 * @property CI_DB_forge         $dbforge              Database Forge Class
 * @property CI_DB_query_builder $db                   This is the platform-independent base Query Builder implementation class.
 * @property CI_DB_utility       $dbutil               Database Utility Class
 ***************** CORE LIBRARIES *****************
 * @property CI_Cache            $cache                CodeIgniter Caching Class
 * @property CI_Session          $session              CodeIgniter Session Class
 * @property CI_Calendar         $calendar             This class enables the creation of calendars
 * @property CI_Cart             $cart                 Shopping Cart Class
 * @property CI_Driver_Library   $driver               This class enables you to create "Driver" libraries that add runtime ability to extend the capabilities of a class via additional driver objects
 * @property CI_Email            $email                Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encryption       $encryption           Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions.
 * @property CI_Form_validation  $form_validation      Form Validation Class
 * @property CI_FTP              $ftp                  FTP Class
 * @property CI_Image_lib        $image_lib            Image Manipulation class
 * @property CI_Migration        $migration            All migrations should implement this, forces up() and down() and gives access to the CI super-global.
 * @property CI_Pagination       $pagination           Pagination Class
 * @property CI_Parser           $parser               Parser Class
 * @property CI_Profiler         $profiler             This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
 * @property CI_Table            $table                Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback        $trackback            Trackback Sending/Receiving Class
 * @property CI_Typography       $typography           Typography Class
 * @property CI_Unit_test        $unit                 Simple testing class
 * @property CI_Upload           $upload               File Uploading Class
 * @property CI_User_agent       $agent                Identifies the platform, browser, robot, or mobile device of the browsing agent
 * @property CI_Xmlrpc           $xmlrpc               XML-RPC request handler class
 * @property CI_Xmlrpcs          $xmlrpcs              XML-RPC server class
 * @property CI_Zip              $zip                  Zip Compression Class
 ***************** DEPRECATED LIBRARIES *****************
 * @property CI_Jquery           $jquery               Jquery Class
 * @property CI_Encrypt          $encrypt              Provides two-way keyed encoding using Mcrypt
 * @property CI_Javascript       $javascript           Javascript Class
 ***************** YOUR LIBRARIES *****************
 * @property Ad_serv                  $ad_serv
 * @property Api_lib                  $api_lib
 * @property Article_serv             $article_serv
 * @property Auto_emotion_serv        $auto_emotion_serv
 * @property Board_serv               $board_serv
 * @property Channel_serv             $channel_serv
 * @property Chat_serv                $chat_serv
 * @property Chat_stats_serv          $chat_stats_serv
 * @property Event_serv               $event_serv
 * @property Follow_serv              $follow_serv
 * @property Format                   $format
 * @property Gateway_client_lib       $gateway_client_lib
 * @property Lottery_serv             $lottery_serv
 * @property Message_serv             $message_serv
 * @property MY_Form_validation       $my_form_validation
 * @property Notify_serv              $notify_serv
 * @property Push_notification_serv   $push_notification_serv
 * @property Reply_serv               $reply_serv
 * @property REST_Controller          $rest_controller
 * @property S3                       $s3
 * @property Section_serv             $section_serv
 * @property Sql_lib                  $sql_lib
 * @property Status_error_code        $status_error_code
 * @property Tag_serv                 $tag_serv
 * @property Time_serv                $time_serv
 * @property User_article_record_serv $user_article_record_serv
 * @property User_article_serv        $user_article_serv
 * @property User_emotion_serv        $user_emotion_serv
 * @property User_lottery_serv        $user_lottery_serv
 * @property User_record_serv         $user_record_serv
 * @property User_serv                $user_serv
 * @property Validator_lib            $validator_lib
 * @property Vote_serv                $vote_serv
 * @property Vote_pk_serv             $vote_pk_serv
 * @property Campaign_serv            $campaign_serv
 * @property Campaign_history_serv    $campaign_history_serv
 * @property Hook_serv                $hook_serv
 * @property Mission_serv             $mission_serv
 ***************** YOUR MODELS *****************
 * @property Ad_boards_model            $ad_boards_model
 * @property Adjs_model                 $adjs_model
 * @property Ads_model                  $ads_model
 * @property Animals_model              $animals_model
 * @property Articles_model             $articles_model
 * @property Auto_emotions_model        $auto_emotions_model
 * @property Boards_model               $boards_model
 * @property Chat_block_messages_model  $chat_block_messages_model
 * @property Chat_block_user_logs_model $chat_block_user_logs_model
 * @property Chat_block_users_model     $chat_block_users_model
 * @property Chat_channel_members_model $chat_channel_members_model
 * @property Chat_channels_model        $chat_channels_model
 * @property Chat_messages_model        $chat_messages_model
 * @property Chat_user_logs_model       $chat_user_logs_model
 * @property Close_marquees_model       $close_marquees_model
 * @property Events_model               $events_model
 * @property Event_users_model          $event_users_model
 * @property Favorites_model            $favorites_model
 * @property Follows_model              $follows_model
 * @property Lotteries_model            $lotteries_model
 * @property Marketing_articles_model   $marketing_articles_model
 * @property Model_base                 $model_base
 * @property Notifies_model             $notifies_model
 * @property Notify_logs_model          $notify_logs_model
 * @property Replies_model              $replies_model
 * @property Sections_model             $sections_model
 * @property User_article_records_model $user_article_records_model
 * @property User_boards_model          $user_boards_model
 * @property User_emotions_model        $user_emotions_model
 * @property User_lotteries_model       $user_lotteries_model
 * @property User_records_model         $user_records_model
 * @property User_reports_model         $user_reports_model
 * @property Users_model                $users_model
 * @property User_votes_model           $user_votes_model
 * @property Vote_options_model         $vote_options_model
 * @property Votes_model                $votes_model
 * @property Vote_pks_model             $vote_pks_model
 * @property Vote_pk_logs_model         $vote_pk_logs_model
 * @property Campaigns_model            $campaigns_model
 * @property Campaign_groups_model      $campaign_groups_model
 * @property Campaign_matches_model     $campaign_matches_model
 * @property Campaign_popups_model      $campaign_popups_model
 * @property Campaign_evaluations_model $campaign_evaluations_model
 * @property Campaign_evaluation_results_model $campaign_evaluation_results_model
 * @property Campaign_event_logs_model  $campaign_event_logs_model
 * @property Campaign_notifies_model    $campaign_notifies_model
 * @property Mission_instances_model        $mission_instances_model
 * @property Mission_instance_records_model $mission_instance_records_model
 */
class CI_Controller {
    public function __construct() {
    } // This default returns construct as set
}

/**
 ***************** CORE COMPONENTS *****************
 * @property CI_Benchmark        $benchmark            This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
 * @property CI_Config           $config               This class contains functions that enable config files to be managed
 * @property CI_Controller       $controller           This class object is the super class that every library in CodeIgniter will be assigned to.
 * @property CI_Exceptions       $exceptions           Exceptions Class
 * @property CI_Hooks            $hooks                Provides a mechanism to extend the base system without hacking.
 * @property CI_Input            $input                Pre-processes global input data for security
 * @property CI_Lang             $lang                 Language Class
 * @property CI_Loader           $load                 Loads framework components.
 * @property CI_Log              $log                  Logging Class
 * @property CI_Model            $model                Model Class
 * @property CI_Output           $output               Responsible for sending final output to the browser.
 * @property CI_Router           $router               Parses URIs and determines routing
 * @property CI_Security         $security             Security Class
 * @property CI_URI              $uri                  Parses URIs and determines routing
 * @property CI_Utf8             $utf8                 Provides support for UTF-8 environments
 ***************** DATABASE COMPONENTS *****************
 * @property CI_DB_forge         $dbforge              Database Forge Class
 * @property CI_DB_query_builder $db                   This is the platform-independent base Query Builder implementation class.
 * @property CI_DB_utility       $dbutil               Database Utility Class
 ***************** CORE LIBRARIES *****************
 * @property CI_Cache            $cache                CodeIgniter Caching Class
 * @property CI_Session          $session              CodeIgniter Session Class
 * @property CI_Calendar         $calendar             This class enables the creation of calendars
 * @property CI_Cart             $cart                 Shopping Cart Class
 * @property CI_Driver_Library   $driver               This class enables you to create "Driver" libraries that add runtime ability to extend the capabilities of a class via additional driver objects
 * @property CI_Email            $email                Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encryption       $encryption           Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions.
 * @property CI_Form_validation  $form_validation      Form Validation Class
 * @property CI_FTP              $ftp                  FTP Class
 * @property CI_Image_lib        $image_lib            Image Manipulation class
 * @property CI_Migration        $migration            All migrations should implement this, forces up() and down() and gives access to the CI super-global.
 * @property CI_Pagination       $pagination           Pagination Class
 * @property CI_Parser           $parser               Parser Class
 * @property CI_Profiler         $profiler             This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
 * @property CI_Table            $table                Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback        $trackback            Trackback Sending/Receiving Class
 * @property CI_Typography       $typography           Typography Class
 * @property CI_Unit_test        $unit                 Simple testing class
 * @property CI_Upload           $upload               File Uploading Class
 * @property CI_User_agent       $agent                Identifies the platform, browser, robot, or mobile device of the browsing agent
 * @property CI_Xmlrpc           $xmlrpc               XML-RPC request handler class
 * @property CI_Xmlrpcs          $xmlrpcs              XML-RPC server class
 * @property CI_Zip              $zip                  Zip Compression Class
 ***************** DEPRECATED LIBRARIES *****************
 * @property CI_Jquery           $jquery               Jquery Class
 * @property CI_Encrypt          $encrypt              Provides two-way keyed encoding using Mcrypt
 * @property CI_Javascript       $javascript           Javascript Class
 */
class CI_Model {
    public function __construct() {
    } // This default returns construct as set
}

/**
***************** DATABASE COMPONENTS *****************
 * @property CI_DB_forge         $dbforge              Database Forge Class
 * @property CI_DB_query_builder $db                   This is the platform-independent base Query Builder implementation class.
 * @property CI_DB_utility       $dbutil               Database Utility Class
 */
class CI_Migration {
    public function __construct() {
    } // This default returns construct as set
}

/* End of file PHPStorm_CI_CC.php */
