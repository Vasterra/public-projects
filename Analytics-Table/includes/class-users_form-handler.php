<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Users_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        $this->handle_form();
    }

    /**
     * Handle the user new and edit form
     *
     * @return void
     */
    public function handle_form() {
        global $wpdb;

        if( isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete' ) usersManagement_delete_user($_GET['id']);

        if(isset($_POST['action2']) && $_POST['action2'] == 'delete' && isset($_POST['id'])) usersManagement_delete_bulk_user($_POST['id']);


        if ( ! isset( $_POST['submit_user'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'user-new' ) ) {
            die( __( 'Are you cheating?', 'qwerty' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'qwerty' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=manage_users_slug' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $user_login = isset( $_POST['tg_user_login'] ) ? sanitize_text_field( $_POST['tg_user_login'] ) : '';
        $user_email = isset( $_POST['tg_user_email'] ) ? sanitize_text_field( $_POST['tg_user_email'] ) : '';

        // some basic validation
        if ( ! $user_login ) {
            $errors[] = __( 'Error: Login is required', 'qwerty' );
        }

        if ( ! $user_email ) {
            $errors[] = __( 'Error: Email src is required', 'qwerty' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => urlencode($first_error) ), $page_url );

            echo("<script>location.href = '". $redirect_to ."'</script>");
            // wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'user_login' => $user_login,
            'user_email' => $user_email,
            'user_pass' => wp_generate_password(),
            'role' => 'tg_student'
        );
        $courses = $wpdb->get_results('SELECT c_id FROM '. $wpdb->prefix .'tg_user_mapping WHERE user_id='. get_current_user_id() );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = usersManagement_insert_user( $fields, $courses );

        } else {

            $fields['id'] = $field_id;
            $insert_id = usersManagement_insert_user( $fields );
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

        echo("<script>location.href = '". $redirect_to ."'</script>");
        // wp_safe_redirect( $redirect_to );
        exit;
    }
}
new Users_Form_Handler();