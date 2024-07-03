<?php

class ac_automator_email_action extends \Uncanny_Automator\Recipe\Action {
 
    protected function setup_action() {
 
        // Define the Actions's info
        $this->set_integration( 'ACF_USERS_INTEGRATIONS1' );
        $this->set_action_code( 'SEND_EMAIL_SAMPLE' );
        $this->set_action_meta( 'EMAIL_TO' );

        // Define the Action's sentence
        $this->set_sentence( sprintf( esc_attr__( 'Send an email to {{email address:%1$s}} from Sample Integration', 'automator-sample' ), $this->get_action_meta() ) );
        $this->set_readable_sentence( esc_attr__( 'Send an {{email}} from Sample Integration', 'automator-sample' ) );
        
    }

    protected function process_action( $user_id, $action_data, $recipe_id, $args, $parsed ) {
        error_log('ac_automator_email_action process_action setup_action');
        $action_meta = $action_data['meta'];
 
        // Get the field values
        $to = sanitize_email( Automator()->parse->text( $action_meta['EMAIL_TO'], $recipe_id, $user_id, $args ) );
        $from = sanitize_email( Automator()->parse->text( $action_meta['EMAIL_FROM'], $recipe_id, $user_id, $args ) );
        $subject = sanitize_text_field( Automator()->parse->text( $action_meta['EMAIL_SUBJECT'], $recipe_id, $user_id, $args ) );
        $body = wp_filter_post_kses( stripslashes( ( Automator()->parse->text( $action_meta['EMAIL_BODY'], $recipe_id, $user_id, $args ) ) ) );

        //Set email headers
        $headers = array( 
            'Content-Type: text/html; charset=utf-8',
            'From: ' . get_bloginfo('name') . ' <' . $from . '>',
            'Reply-To: ' . get_bloginfo('name') . ' <' . $from . '>',
         );
         error_log('ac_automator_email_action process_action');
        // Send the email. Returns true or false
        $status = wp_mail( $to, $subject, $body, $headers ); 
 
        // Convert true or false into string error
        $status_string = $status ? __( 'Email was sent', 'automator-sample' ) : __( 'Email was not sent', 'automator-sample' );
 
        // Populate the custom token value
        $this->hydrate_tokens( 
            array( 
                'STATUS' => $status_string
                ) 
        );
 
        // Handle errors
        if ( ! $status ) {
 
            $this->add_log_error( $status_string );
 
            return false; // Return false if error ocurred during the action completion
        }
 
        // Always return true if everything was okay
        return true;
    }
}