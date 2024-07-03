<?php
use Uncanny_Automator\Tokens\Token;
class ACF_USERS_Integration extends \Uncanny_Automator\Integration {
     
    protected function setup() {
        $this->set_integration( 'ACF_USERS_INTEGRATIONS' );
        $this->set_name( 'ACF USERS' );
        $this->set_icon_url( plugin_dir_url( __FILE__ ) . 'img/sample-icon.svg' );
    }

    /**
	 * load
	 *
	 * @return void
	 */
	protected function load() {
        $resposible_email = get_option( 'options_responsible_individual_-_email' );
        if( $resposible_email ) {
            new ac_automator_email_token( 'Responsible/Nominated Individual', $resposible_email );   
        }

        $person_in_charge_email = get_option( 'options_person_in_charge_of_finance_-_email' );
        if( $person_in_charge_email ) {
            new ac_automator_email_token( 'Person in charge of Finance', $person_in_charge_email );   
        }

        $register_manager_email = get_option( 'options_registered_manager_-_email' );
        if( $register_manager_email ) {
            new ac_automator_email_token( 'Registered Manager', $register_manager_email );   
        }

	}
}