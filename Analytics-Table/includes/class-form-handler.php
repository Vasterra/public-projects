<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the video new and edit form
     *
     * @return void
     */
    public function handle_form() {

// VIDEOS MANAGE

        if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'video_delete' ) vimeo_delete_video($_GET['id']);


        if ( ! isset( $_POST['submit_video'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'video-new' ) ) {
            die( __( 'Are you cheating?', 'qwerty' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'qwerty' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=tgvideos' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $url = isset( $_POST['url'] ) ? sanitize_text_field( $_POST['url'] ) : '';

        // some basic validation
        if ( ! $name ) {
            $errors[] = __( 'Error: Title is required', 'qwerty' );
        }

        if ( ! $url ) {
            $errors[] = __( 'Error: Video src is required', 'qwerty' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => urlencode($first_error) ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'name' => $name,
            'url' => $url,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = video_insert_video( $fields );

        } else {

            $fields['id'] = $field_id;

            $insert_id = video_insert_video( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg(
                array( 'error' => urlencode($insert_id->get_error_message()) ),
                $page_url
            );
        } else {
            $redirect_to = add_query_arg(
                array( 'success' => urlencode(__( 'Succesfully saved!', 'qwerty' )) ),
                $page_url
            );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}