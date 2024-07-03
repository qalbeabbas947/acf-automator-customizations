<?php
/** 
 * Plugin Name: ACF Automator Integration
 * Version: 1.0
 * Description: 
 * Author: LDninjas.com
 * Author URI: LDninjas.com
 * Plugin URI: LDninjas.com
 * Text Domain: acf-automator-integration
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class ACF_AUTOMATOR_INTEGRATION
 */
class ACF_AUTOMATOR_INTEGRATION {

    const VERSION = '1.0';

    /**
     * @var self
     */
    private static $instance = null;

    /**
     * @since 1.0
     * @return $this
     */
    public static function instance() {

        if ( is_null( self::$instance ) && ! ( self::$instance instanceof ACF_AUTOMATOR_INTEGRATION ) ) {
            self::$instance = new self;

            self::$instance->setup_constants();
            self::$instance->includes();
            self::$instance->hooks();
            
        } 

        return self::$instance;
    }

    /**
     * defining constants for plugin
     */
    public function setup_constants() {

        /**
         * Directory
         */
        define( 'AAI_DIR', plugin_dir_path ( __FILE__ ) );
        define( 'AAI_DIR_FILE', AAI_DIR . basename ( __FILE__ ) );
        define( 'AAI_INCLUDES_DIR', trailingslashit ( AAI_DIR . 'includes' ) );
        define( 'AAI_TEMPLATES_DIR', trailingslashit ( AAI_DIR . 'templates' ) );
        define( 'AAI_BASE_DIR', plugin_basename(__FILE__));

        /**
         * URLs
         */
        define( 'AAI_URL', trailingslashit ( plugins_url ( '', __FILE__ ) ) );
        define( 'AAI_ASSETS_URL', trailingslashit ( AAI_URL . 'assets/' ) );

        /**
         * Text Domain
         */
        define( 'AAI_TEXT_DOMAIN', 'learndash-customize-shared-lesson' );
    }

    /**
     * Plugin requiered files
     */
    public function includes() {

        require_once AAI_INCLUDES_DIR.'acf-users-integration.php';
        require_once AAI_INCLUDES_DIR.'acf-users-tokens.php';
        require_once AAI_INCLUDES_DIR.'acf-users-action.php';

        
    }

    /**
     * Plugin Hooks
     */
    public function hooks() {

        add_action( 'automator_add_integration', [ $this, 'integration_load_files' ],9999 );
    }

    function integration_load_files() {
        // If this class doesn't exist, Uncanny Automator plugin needs to be updated.
        if ( ! class_exists( '\Uncanny_Automator\Integration' ) ) {
            return;
        }
    
        new ACF_USERS_Integration();
        new ac_automator_email_action();
    }
    
    /**
     * Plugin Hooks
     */
    function acf_automator_email_list() {
        ini_set('display_errors', 'On');
        error_reporting(E_ALL);

        $post_id = sanitize_text_field($_REQUEST['post_id']);
        $user_id = sanitize_text_field($_REQUEST['user_id']);

        $user_info = get_userdata($user_id);
        if( $user_info ) {
            
            $user_email = $user_info->user_email;
            $to_field = get_post_meta( $post_id, 'EMAILTO', true );

            if( strstr($to_field, $user_email) ){
                echo json_encode(['status'=>'user_exists', 'to'=>$to_field, 'message'=> __( 'User already exists in to field.', 'acf-automator-integration' )]);    
            } else {
                update_post_meta( $post_id, 'EMAILTO', $to_field . ','.$user_email );
                echo json_encode(['status'=>'done', 'to'=>$to_field, 'message'=> __( 'User is added in the to list.', 'acf-automator-integration' )]); 
            }  

        } else {
            echo json_encode(['status'=>'user_not_found', 'message'=> __( 'User does not exists', 'acf-automator-integration' )]);
        }
        
        exit;
    }
}

/**
 * Display admin notifications if dependency not found.
 */
function aai_ready() {
    if( !is_admin() ) {
        return;
    }

    if( ! class_exists( 'ACF' ) ) {
        deactivate_plugins ( plugin_basename ( __FILE__ ), true );
        $class = 'notice is-dismissible error';
        $message = __( 'ACF Automator Integration add-on requires ACF and Automator plugin is to be activated', 'acf-automator-integration' );
        printf ( '<div id="message" class="%s"> <p>%s</p></div>', $class, $message );
    }
}

/**
 * @return bool
 */
function AAI() {
    
    if ( ! class_exists( 'ACF' ) ) {
        add_action( 'admin_notices', 'aai_ready' );
        return false;
    }
    
    copy( __DIR__.'/includes/emails-send-emails.php', __DIR__.'/../uncanny-automator/src/integrations/emails/actions/emails-send-emails.php' );
    
    return ACF_AUTOMATOR_INTEGRATION::instance();
}
add_action( 'plugins_loaded', 'AAI' );
