<?php

class ac_automator_email_action extends \Uncanny_Automator\Recipe\Action {
 
    protected function setup_action() {
 
        // Define the Actions's info
        $this->set_integration( 'ACF_USERS_INTEGRATIONS' );
        $this->set_action_code( 'SEND_EMAIL_SAMPLE' );
        $this->set_action_meta( 'EMAIL_TO' );
 
        // Define the Action's sentence
        $this->set_sentence( sprintf( esc_attr__( 'Send an email to {{email address:%1$s}} from Sample Integration', 'automator-sample' ), $this->get_action_meta() ) );
        $this->set_readable_sentence( esc_attr__( 'Send an {{email}} from Sample Integration', 'automator-sample' ) );
        
    }
	
	public function define_tokens() {
		return array(
			'STATUS' => array(
				'name' => __( 'Send status', 'automator-sample' ),
				'type' => 'text',
			),
		);
	}
	public function options() {
		
        return array(
            Automator()->helpers->recipe->field->text(
                array(
                    'option_code' => 'EMAIL_FROM',
                    'label'       => 'From',
                    'description' => 'Sample description',
                    'placeholder' => 'Enter from email',
                    'input_type'  => 'email',
                    'default'     => 'john@doe.com',
                )
            ),
            Automator()->helpers->recipe->field->text(
                array(
                    'option_code' => 'EMAIL_TO',
                    'label'       => 'To1',
                    'input_type'  => 'email',
                )
            ),
            Automator()->helpers->recipe->field->text(
                array(
                    'option_code' => 'EMAIL_SUBJECT',
                    'label'       => 'Subject2',
                    'input_type'  => 'text',
                )
            ),
            Automator()->helpers->recipe->field->text(
                array(
                    'option_code' => 'EMAIL_BODY',
                    'label'       => 'Body3',
                    'input_type'  => 'textarea',
                )
            ),
        );

		
    }
}