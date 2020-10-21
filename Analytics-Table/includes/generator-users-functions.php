<?php

/**
 * Get all manager`s users
 *
 * @param $args array
 *
 * @return array
 */
function usersManagement_get_all_users( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'users.ID',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'users-all';
    $items     = wp_cache_get( $cache_key, 'qwerty' );

    if ( false === $items ) {

         $items = $wpdb->get_results( '
            SELECT * FROM '. $wpdb->prefix .'users users 
            INNER JOIN '. $wpdb->prefix .'tg_students_ids tg_students_ids
            ON tg_students_ids.student_id=users.ID
            WHERE tg_students_ids.manager_id='. get_current_user_id() .' 
            ORDER BY '. $args['orderby'] .' ' .$args['order'] .' 
            LIMIT '. $args['offset'] .', ' .$args['number'] );

        wp_cache_set( $cache_key, $items, 'qwerty' );
    }

    return $items;
}

/**
 * Fetch all manager`s users from database
 *
 * @return array
 */
function usersManagement_get_users_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM '. $wpdb->prefix .'users users 
            JOIN '. $wpdb->prefix .'tg_students_ids tg_students_ids
            ON tg_students_ids.student_id=users.ID
            WHERE tg_students_ids.manager_id='. get_current_user_id());
}

/**
 * Fetch a single user from database
 *
 * @param int   $id
 *
 * @return array
 */
function usersManagement_get_user( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'users WHERE ID = %d', $id ) );
}

function usersManagement_delete_user( $id = 0 ) {
    global $wpdb;

    wp_delete_user($id);
    $wpdb->delete ( $wpdb->prefix.'tg_user_mapping',  array("user_id" => $id));
    return $wpdb->get_row( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'tg_students_ids WHERE student_id = %d', $id ) );;
}

function usersManagement_insert_user( $args = array(), $courses = array() ) {

    global $wpdb;

    $defaults = array(
        'ID'         => null,
        'user_login' => '',
        'user_email' => '',
        'user_pass' => '',
        'role' => 'tg_student'
    );

    $args       = wp_parse_args( $args, $defaults );

    // some basic validation
    if ( empty( $args['user_login'] ) ) {
        return new WP_Error( 'no-user_login', __( 'No Login provided.', 'qwerty' ) );
    }
    if ( empty( $args['user_email'] ) ) {
        return new WP_Error( 'no-user_email', __( 'No Email provided.', 'qwerty' ) );
    }

    // remove row id to determine if new or update

    if(isset($args['id'])) {
        $row_id = (int) $args['id'];
        unset( $args['id'] );        
    } else $row_id = false;

    if ( ! $row_id ) {

        // insert a new

        $user_id = wp_insert_user( $args ) ;
        $headers = 'From: My Name <lms@'. $_SERVER['HTTP_HOST'] .'>' . "\r\n";
        $mess = '<p><b>Your login:</b> '. $args['user_login'].'</p>';
        $mess .= '<p><b>Your password:</b> '. $args['user_pass']. '</p>';

        wp_mail($args['user_email'], 'Your login and email to course', $mess, $headers);

        // возврат
        if( ! is_wp_error( $user_id ) ) {

            $table_name = $wpdb->prefix . 'tg_students_ids';
            $table_name_arg = array(
                'id'            => null,
                'student_id'    => $user_id,
                'manager_id'    => get_current_user_id()
            );
            $wpdb->insert( $table_name, $table_name_arg );

            if(!empty($courses)):
            $table_name2 = $wpdb->prefix . 'tg_user_mapping';

            foreach ($courses as $course){
                $table_name_arg2 = array(
                    'm_id'            => null,
                    'c_id'    => $course->c_id,
                    'user_id'    => $user_id,
                    'added_on'    => date('yy-m-d h:i:s'),
                    'm_status'    => 'Active'
                );
                $wpdb->insert( $table_name2, $table_name_arg2 );
            }
            endif;

            return true;
        } else {
            return $user_id->get_error_message();
        } 


    } else {

        // do update method here

        $args['ID'] = $row_id;
        $user_id = wp_update_user($args);

    }

    return false;
}

function usersManagement_delete_bulk_user( $args = array() ) {
    global $wpdb;

    $str = implode(', ', $args);

    $wpdb->query( "DELETE FROM ". $wpdb->prefix ."users WHERE ID IN(". $str .") ");
    $wpdb->query( "DELETE FROM ". $wpdb->prefix ."tg_students_ids WHERE student_id IN(". $str .") ");

    return true;
}