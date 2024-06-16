<?php
 
class Post_Created_Sample_Trigger extends \Uncanny_Automator\Recipe\Trigger {
 
    protected function setup_trigger() {
 
        // Define the Trigger's info
        $this->set_integration( 'SAMPLE_INTEGRATION' );
        $this->set_trigger_code( 'POST_CREATED_SAMPLE' ); 
        $this->set_trigger_meta( 'POST_TYPE' );
 
        // Trigger sentence
        $this->set_sentence( sprintf( esc_attr__( '{{A post type:%1$s}} is created sample trigger', 'automator-sample' ), 'POST_TYPE' ) );
        $this->set_readable_sentence( esc_attr__( '{{A post type}} is created sample trigger', 'automator-sample' ) );
 
        // Trigger wp hook
        $this->add_action( 'wp_after_insert_post', 90, 4 );
    }

    public function options() {
 
        $post_types_dropdown = array(
            'input_type'      => 'select',
            'option_code'     => 'POST_TYPE',
            'label'           => __( 'Post type', 'automator-sample' ),
            'required'        => true,
            'options'         => aget_post_types(), // Load the options from the helpers file
            'placeholder'     => __( 'Please select a post type', 'automator-sample' ),
        );
 
        return array(
                $post_types_dropdown
            );
    }   

    public function validate( $trigger, $hook_args ) {
 
        // Make sure the trigger has some value selected in the options
        if ( ! isset( $trigger['meta']['POST_TYPE'] ) ) {
            //Something is wrong, the trigger doesn't have the required option value.
            return false;
        }
 
        // Get the dropdown value
        $selected_post_type = $trigger['meta']['POST_TYPE'];
 
        // Parse the args from the wp_after_insert_post hook
        list( $post_id, $post, $update, $post_before ) = $hook_args;
 
        // If the post type selected in the trigger options doesn't match the post type being inserted, bail.
        if (  '-1' != $selected_post_type && $selected_post_type !== $post->post_type ) {
            return false;
        }
 
        // Make sure the post is being published and not updated or drafted
        if ( ! $this->helpers->post_is_being_published( $post, $post_before ) ) {
            return false;
        }
 
        // If all conditions were met, return true
        return true;
    }

    public function define_tokens( $trigger, $tokens ) {
 
        $tokens[] = array(
            'tokenId'         => 'POST_TITLE',
            'tokenName'       => __( 'Post Title1', 'automator-sample' ),
            'tokenType'       => 'text',
        );
 
        $tokens[] = array(
            'tokenId'         => 'POST_URL',
            'tokenName'       => __( 'Post URL1', 'automator-sample' ),
            'tokenType'       => 'text',
        );
 
        return $tokens;
    }

    public function hydrate_tokens( $trigger, $hook_args ) {
 
        list( $post_id, $post ) = $hook_args;
 
        $token_values = array(
            'POST_TYPE' => $post->post_type,
            'POST_TITLE' => $post->post_title,
            'POST_URL' => get_permalink( $post->ID )
        ); 
 
        return $token_values;
    }
}