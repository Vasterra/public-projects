<?php

/**
 * Admin Menu
 */
class Users_students_menu {

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function __construct() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/tgusers-edit.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/tgusers-edit.php';
                break;

            case 'delete':
                $template = dirname( __FILE__ ) . '/views/tgusers-list.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/tgusers-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/tgusers-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}