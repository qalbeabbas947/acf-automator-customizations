<?php
/**
 * Plugin Name: Automator Sample Integration 123
 */
add_action( 'automator_add_integration', 'sample_integration_load_files' );

 function sample_integration_load_files() {
 
    // If this class doesn't exist, Uncanny Automator plugin needs to be updated.
    if ( ! class_exists( '\Uncanny_Automator\Integration' ) ) {
        return;
    }
 
    require_once 'helpers/helpers.php';
    $helpers = new Helpers();
 
    require_once 'sample-integration.php';
    new Sample_Integration( $helpers );
 
    require_once 'triggers/post-created-sample.php';
    new Post_Created_Sample_Trigger( $helpers );

    require_once 'actions/send-email-sample.php';
    new Send_Email_Sample();

    if ( class_exists( '\Uncanny_Automator_Pro\Action_Condition' ) ) {

        require_once 'conditions/user-email-contains-text.php';
        new User_Email_Contains_Text( $helpers );
    }
}