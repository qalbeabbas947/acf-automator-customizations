<?php
use Uncanny_Automator\Tokens\Token;

class ac_automator_email_token extends Token {

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