<?php

/**
 * Get all video
 *
 * @param $args array
 *
 * @return array
 */
function vimeo_get_all_video( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'video-all';
    $items     = wp_cache_get( $cache_key, 'qwerty' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'tg_tutorial_videos ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'qwerty' );
    }

    return $items;
}

/**
 * Fetch all video from database
 *
 * @return array
 */
function vimeo_get_video_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'tg_tutorial_videos' );
}

/**
 * Fetch a single video from database
 *
 * @param int   $id
 *
 * @return array
 */
function vimeo_get_video( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'tg_tutorial_videos WHERE id = %d', $id ) );
}

function vimeo_delete_video( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'tg_tutorial_videos WHERE id = %d', $id ) );
}

function video_insert_video( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'name' => '',
        'url' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'tg_tutorial_videos';

    // some basic validation
    if ( empty( $args['name'] ) ) {
        return new WP_Error( 'no-name', __( 'No Title provided.', 'qwerty' ) );
    }
    if ( empty( $args['url'] ) ) {
        return new WP_Error( 'no-url', __( 'No Video src provided.', 'qwerty' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {

        $args['date_time'] = current_time( 'mysql' );

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}