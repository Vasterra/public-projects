<?php
/*
Plugin Name: Analytics table
Plugin URI: http://wordpress.org
Description: Analytics Table
Author: Vasterra
Author URI: http://vasterra.com
*/
include dirname(__FILE__). '/analytics_table-functions.php';


//  Генерация админки добавления видео
add_action('init', function(){
        include dirname(__FILE__). '/includes/class-generator-menu.php';
        include dirname(__FILE__). '/includes/class-video-list-table.php';      
        include dirname(__FILE__). '/includes/generator-functions.php';
        include dirname(__FILE__). '/includes/class-form-handler.php';

        new Vimeo_videos_menu();

        wp_enqueue_script( 'myPluginScripts', plugins_url('assets/analytics_table.js', __FILE__) );
        wp_enqueue_script( 'vimeoPlayer', "https://player.vimeo.com/api/player.js" );
        wp_enqueue_style( 'myPluginStylesheetTutorials', plugins_url('assets/tutorials.css', __FILE__) );  
});



register_activation_hook(__FILE__, 'add_plugin_role');
register_deactivation_hook(__FILE__, 'remove_plugin_role');
add_action( 'plugins_loaded', '____action_main_function' );

add_action('admin_print_footer_scripts', 'manage_students_javascript', 99);
function manage_students_javascript() { ?>
    <script>
        jQuery(document).ready(function($) {

            $('.ctudent_access-check').on('change', function () {

                var data = {
                    action: 'student',
                    course_id: $(this).val(),
                    student_id: $(this).data('user')
                };

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                    success: function( data ) {
                        console.log( data );
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });
        });
    </script>
<?php }
if(isset($_POST['action'])) {
    add_action( 'wp_ajax_student', 'student_access_function' );

    function student_access_function() {
        global $wpdb;
        $student = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'tg_user_mapping WHERE c_id = %d AND user_id = %d', $_POST['course_id'], $_POST['student_id'] ) );
        if($student != false) {
            $status = $student->m_status == 'Active' ? 'Inactive' : 'Active';
            $wpdb->update( $wpdb->prefix . 'tg_user_mapping',
                array( 'm_status' => $status ),
                array( 'm_id' => $student->m_id )
            );
        }

        wp_die();
    }
}