<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class Users_table_list extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'user',
            'plural'   => 'users',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e( 'no users found', 'qwerty' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {
        global $wpdb;
        $items = $wpdb->get_results('SELECT c_id FROM '. $wpdb->prefix .'tg_user_mapping WHERE user_id='. get_current_user_id() );

        $html = '';
        foreach ($items as $el) {
            $user_access = $wpdb->get_row('SELECT m_status FROM '. $wpdb->prefix .'tg_user_mapping WHERE user_id='. $item->ID. ' AND c_id='. $el->c_id );
            $checked = $user_access->m_status == 'Active' ? 'checked' : '';

            $html .= '<p><label><input type="checkbox" class="ctudent_access-check" name="course_id[]" value="'. $el->c_id .'" '. $checked .'> '. get_the_title($el->c_id) .'</label></p>';
        }


        switch ( $column_name ) {
            case 'user_login':
                return $item->user_login;

            case 'user_email':
                return $item->user_email;

            case 'courses':
                return $html;

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'user_login'    => __( 'Name', 'qwerty' ),
            'user_email'    => __( 'Email', 'qwerty' ),
            'courses'       =>  __('Courses', 'qwerty')
        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_user_login( $item ) {
        $actions           = array();
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=manage_users_slug&action=edit&id=' . $item->ID ), $item->ID, __( 'Edit this item', 'qwerty' ), __( 'Edit', 'qwerty' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=manage_users_slug&action=delete&id=' . $item->ID ), $item->ID, __( 'Delete this item', 'qwerty' ), __( 'Delete', 'qwerty' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=manage_users_slug&action=view&id=' . $item->ID ), $item->user_login, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'user_login' => array( 'user_login', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'delete'  => __( 'Delete Permanently', 'qwerty' ),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%d" />', $item->student_id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=sample-page' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items  = usersManagement_get_all_users( $args );

        $this->set_pagination_args( array(
            'total_items' => usersManagement_get_users_count(),
            'per_page'    => $per_page
        ) );
    }
}