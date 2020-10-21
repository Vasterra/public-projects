<?php

/**
 * Admin Menu
 */
class Vimeo_videos_menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu **/
        add_menu_page( __( 'Adding videos&fields', 'qwerty' ), __( 'Adding videos&fields', 'qwerty' ), 'manage_options', 'tgvideos', array( $this, 'plugin_videos_page' ), 'dashicons-groups', null );

        add_submenu_page( 'tgvideos', __( 'Adding vimeo videos', 'qwerty' ), __( 'Adding vimeo videos', 'qwerty' ), 'manage_options', 'tgvideos', array( $this, 'plugin_videos_page' ) );
        // add_submenu_page( 'tgvideos', __( 'Adding new fields', 'qwerty' ), __( 'Adding new fields', 'qwerty' ), 'manage_options', 'tgfields', array( $this, 'plugin_fields_page' ) );

    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_videos_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/tgvideos-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/tgvideos-edit.php';
                break;

            case 'video_delete':
                $template = dirname( __FILE__ ) . '/views/tgvideos-list.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/tgvideos-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/tgvideos-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }



    // public function plugin_fields_page() {
    //     $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
    //     $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

    //     switch ($action) {
    //         case 'view':

    //             $template = dirname( __FILE__ ) . '/views/tgfields-single.php';
    //             break;

    //         case 'edit':
    //             $template = dirname( __FILE__ ) . '/views/tgfields-edit.php';
    //             break;

    //         case 'delete':
    //             $template = dirname( __FILE__ ) . '/views/tgfields-list.php';
    //             break;

    //         case 'new':
    //             $template = dirname( __FILE__ ) . '/views/tgfields-new.php';
    //             break;

    //         default:
    //             $template = dirname( __FILE__ ) . '/views/tgfields-list.php';
    //             break;
    //     }

    //     if ( file_exists( $template ) ) {
    //         include $template;
    //     }
    // }
}