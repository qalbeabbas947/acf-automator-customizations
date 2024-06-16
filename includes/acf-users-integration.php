<?php
use Uncanny_Automator\Tokens\Token;
class ACF_USERS_Integration extends \Uncanny_Automator\Integration {
     
    protected function setup() {
        $this->set_integration( 'ACF_USERS_INTEGRATIONS' );
        $this->set_name( 'ACF USERS Integration' );
        $this->set_icon_url( plugin_dir_url( __FILE__ ) . 'img/sample-icon.svg' );
    }

    /**
	 * load
	 *
	 * @return void
	 */
	protected function load() {
		new Current_Date_Timestamp();
        new email_Recipe_Id('abbas@gmail.com');
        new email_Recipe_Id('asad@gmail.com');
        new email_Recipe_Id('farooq@gmail.com');
	}
}



class Current_Date_Timestamp extends Token {

	/**
	 * setup
	 *
	 * @return void
	 */
	public function setup() {
		$this->integration   = 'ACF_USERS_INTEGRATIONS';
		$this->id            = 'currentdate_unix_timestamp';
		$this->name          = esc_attr_x( 'currentdate_unix_timestamp', 'Token', 'uncanny-automator' );
		$this->requires_user = false;
		$this->type          = 'date';
		$this->cacheable     = true;
	}

	/**
	 * parse
	 *
	 * @param  mixed $replaceable
	 * @param  mixed $field_text
	 * @param  mixed $match
	 * @param  mixed $current_user
	 * @return string
	 */
	public function parse( $replaceable, $field_text, $match, $current_user ) {
		return strtotime( date_i18n( 'Y-m-d' ), current_time( 'timestamp' ) );
	}
}



/****************************Action********************/
class Send_Email_Sample extends \Uncanny_Automator\Recipe\Action {
 
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

////////////////////////////////////////////////////////


class email_Recipe_Id extends Token {

    private $instance_id;

    function __construct( $id ) {

        $this->instance_id = $id;
        parent::__construct();
    }
	/**
	 * setup
	 *
	 * @return void
	 */
	public function setup() {
		$this->integration = 'ACF_USERS_INTEGRATIONS';
		$this->id          = $this->instance_id;
		$this->name        = esc_attr_x( $this->instance_id, 'Token', 'uncanny-automator' );
		$this->cacheable     = false;
	}

	/**
	 * parse
	 *
	 * @param  mixed $replaceable
	 * @param  mixed $field_text
	 * @param  mixed $match
	 * @param  mixed $current_user
	 * @return int
	 */
	public function parse( $replaceable, $field_text, $match, $current_user ) {
		return $this->instance_id;
	}
}