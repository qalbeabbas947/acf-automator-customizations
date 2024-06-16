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
		new ac_automator_email_token('abbas@gmail.com');
        new ac_automator_email_token('asad@gmail.com');
        new ac_automator_email_token('farooq@gmail.com');
	}
}