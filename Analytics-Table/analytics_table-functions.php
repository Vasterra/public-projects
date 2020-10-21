<?php
include dirname(__FILE__). '/includes/class-dashboard.php';

function add_plugin_role(){
    $result = add_role( 'Digistore24_manager', 'Manager Digistore24',
    array(
        'read'  => true,
        'manage_options' => true
    ));

    create_tutorials_table();
    create_students_table();
    create_managers_table();
}

function remove_plugin_role(){
    remove_role( 'Digistore24_manager' );
}

function create_tutorials_table() {
    global $wpdb;
    // задаем название таблицы
    $table_name = $wpdb->get_blog_prefix() . 'tg_tutorial_videos';
    // проверяем есть ли в базе таблица с таким же именем, если нет - создаем.
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        // устанавливаем кодировку
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
        // подключаем файл нужный для работы с bd
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        // запрос на создание
        $sql = "CREATE TABLE {$table_name} (
        id int(11) unsigned NOT NULL auto_increment,
        name varchar(255) NOT NULL default '',
        date_time DATETIME,
        url varchar(255) NOT NULL default '',
        PRIMARY KEY  (id)
        ) {$charset_collate};";
        // Создать таблицу.
        dbDelta($sql);
    }
}

function create_students_table() {
    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'tg_students_ids';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $sql = "CREATE TABLE {$table_name} (
        id int(11) unsigned NOT NULL auto_increment,
        student_id int(11) NOT NULL,
        manager_id int(11) NOT NULL,
        PRIMARY KEY  (id)
        ) {$charset_collate};";
        dbDelta($sql);
    }
}

function create_managers_table() {
    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'tg_managers_info';
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        $sql = "CREATE TABLE {$table_name} (
        id int(11) unsigned NOT NULL auto_increment,
        manager_id int(11) NOT NULL,
        order_id varchar(255) NOT NULL,
        license_key varchar(255) NOT NULL,
        PRIMARY KEY  (id)
        ) {$charset_collate};";
        dbDelta($sql);
    }
}


function read_tg_tutorial_videos_table() {
    global $wpdb;
    $newtable = $wpdb->get_results( "SELECT name, url FROM ". $wpdb->get_blog_prefix() . "tg_tutorial_videos" );?>
    <div class="tutorials-wrap">
        <?php foreach ($newtable as $item) {?>
            <div class="tutorials-wrap__item">                
                <div class="tutorials-wrap__img"></div>
                <p class="tutorials-wrap__head"><?php echo $item->name;?></p>
            </div>
            <div class="tutorials-wrap__vimeo">
                <iframe id="www_<?php echo $item->url;?>" class="vimeo-frame" src="https://player.vimeo.com/video/<?php echo $item->url;?>?&title=1&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <p><?php echo $item->url;?></p>                
            </div>
        <?php }?>
    </div>
<?php }

function order_id_function() {
    global $wpdb;

    if(isset($_POST['order_id']) && isset($_POST['license_key'])) {
        define( 'YOUR_API_KEY', get_option('apy_key')['input'] );
        require_once __DIR__.'/digistore/ds24_api.php';
        try
        {
            $api = DigistoreApi::connect( YOUR_API_KEY );

            $list = $api->validateLicenseKey($_POST['order_id'], $_POST['license_key']);
            $api->disconnect();
            if($list->is_license_valid == 'Y') {


                $table_name = $wpdb->prefix . 'tg_managers_info';

                $table_name_arg = array(
                    'id'            => null,
                    'manager_id'    => get_current_user_id(),
                    'order_id'      => $_POST['order_id'],
                    'license_key'   => $_POST['license_key']
                );
                $items = $wpdb->get_results( 'SELECT * FROM '. $wpdb->prefix .'tg_managers_info WHERE order_id='. $_POST['order_id']);
                
                if($items != false) $wpdb->insert( $table_name, $table_name_arg );
                else echo "Already exists!";
            }
        }
        catch (DigistoreApiException $e)
        {
            echo "Undefined orderID or license key";
        }

    }
    $data = $wpdb->get_results( 'SELECT * FROM '. $wpdb->prefix .'tg_managers_info WHERE manager_id='. get_current_user_id()); ?>

    <table class="wp-list-table widefat fixed striped users">
        <tr>
            <th>Order ID</th>
            <th>License key</th>
        </tr>
        <?php foreach($data as $row):?>
            <tr>
                <td><?=$row->order_id?></td>
                <td><?=$row->license_key?></td>
            </tr>
        <?php endforeach;?>

    </table>

<?php }


function ____action_main_function() {

    // Проверка роли пользователя
    function is_user_role_in( $roles, $user = false ){
        if( ! $user )           $user = wp_get_current_user();
        if( is_numeric($user) ) $user = get_userdata( $user );

        if( empty($user->ID) )
            return false;

        foreach( (array) $roles as $role )
            if( isset($user->caps[ $role ]) || in_array($role, $user->roles) )
                return true;

        return false;
    }


    if( is_user_role_in(['Digistore24_manager']) || is_user_role_in(['administrator']) )  {


        /**
         * Создаем страницу настроек плагина
         */
        
        add_action('admin_menu', 'add_plugin_page');


        function add_plugin_page(){

            //  Скрываем лишние пункты меню для роли Digistore24_manager
            if( is_user_role_in(['Digistore24_manager'])) {

                wp_enqueue_style( 'myPluginStylesheet', plugins_url('assets/analytics_table.css', __FILE__) );                

                remove_menu_page( 'index.php' );
                remove_menu_page( 'edit.php' );
                remove_menu_page( 'upload.php' );
                remove_menu_page( 'edit.php?post_ENGINE=page' );
                remove_menu_page( 'edit-comments.php' );
                remove_menu_page( 'themes.php' );
                remove_menu_page( 'plugins.php' );
                remove_menu_page( 'users.php' );
                remove_menu_page( 'tools.php' );
                remove_menu_page( 'export-personal-data.php' ); 
                remove_menu_page( 'admin.php' );
                remove_menu_page( 'options-general.php' );


            }

            add_menu_page( 'Analytics Table settings', 'Analytics Table', 'manage_options', 'analyticsTable_slug', 'analyticsTable_options_page_output' );
            add_submenu_page( 'analyticsTable_slug', 'Tutorials Videos', 'Tutorials','manage_options', 'analyticsTableVideos_slug', 'analyticsTable_videos_page_output' );
            
            if( is_user_role_in(['administrator'])) {
                new Form_Handler();
                add_submenu_page( 'analyticsTable_slug', 'Dashboard', 'Dashboard','manage_options', 'analyticsTableDashboard_slug', 'analyticsTable_Dashboard_page_output' );
                add_submenu_page( 'analyticsTable_slug', 'API KEY', 'API KEY','manage_options', 'analyticsTableAPIKEY_slug', 'analyticsTable_APIKEY_page_output' );
            }

            if( is_user_role_in(['Digistore24_manager'])) {
                add_submenu_page( 'analyticsTable_slug', 'Dashboard', 'Dashboard','manage_options', 'analyticsTableDashboard_slug', 'analyticsTable_Dashboard_manager_page_output' );
                add_submenu_page('analyticsTable_slug', 'Manage users', 'Users', 'manage_options', 'manage_users_slug', 'add_users_manage_page');
            }
        }


        

//  OUTPUT MENUS PAGES

        function analyticsTable_options_page_output(){?>
            <div class="wrap">
                <h2><?php echo get_admin_page_title() ?></h2>
                <?php if( is_user_role_in(['Digistore24_manager'])):?>

                    <form method="post">
                        <table>                            
                        <tr>
                            <td><label> Input your orderID:</td>
                            <td><input type="text" name="order_id"></label></td>
                        </tr>
                        <tr>
                            <td><label> Input your license KEY:</td>
                            <td><input type="text" name="license_key"></label></td>
                        </tr>
                        </table>
                        <?php submit_button( __( 'Submit ID', 'qwerty' ), 'primary', 'submit_order_id' ); ?>
                    </form>
                    <?php order_id_function();?>

                <?php endif; ?>
            </div>
        <?php }

        //  Вывод админки с dashboard admin
        function analyticsTable_Dashboard_page_output(){
            $dsboard=new DashboardClass(0);
            $dsboard->ShowOutput();
        }

        //  Вывод админки с dashboard manager
        function analyticsTable_Dashboard_manager_page_output(){
            $dsboard=new DashboardClass(wp_get_current_user()->ID);
            $dsboard->ShowOutput();
        }

        function analyticsTable_APIKEY_page_output(){ ?>
            <div class="wrap">
                <h2><?php echo get_admin_page_title() ?></h2>
                <?php

                    define( 'YOUR_API_KEY', get_option('apy_key')['input'] );
                    require_once __DIR__.'/digistore/ds24_api.php';

                        try
                        {
                            $api = DigistoreApi::connect( YOUR_API_KEY );
                            $data = $api->ping();
                            $server_time = $data->server_time;
                            echo "Success: Server time is $server_time\n";
                            $api->disconnect();
                        }
                        catch (DigistoreApiException $e)
                        {
                            $error_message = $e->getMessage();
                            echo "Error: $error_message\n";
                        }

                ?>

                <form action="options.php" method="POST">                   
                    <?php
                        settings_fields( 'option_group' );     // скрытые защитные поля
                        do_settings_sections( 'analyticsTable_page' ); // секции с настройками (опциями). У нас она всего одна 'section_id'
                        submit_button();
                    ?>
                </form>
            </div>
            <?php
        }


        //  Вывод админки Video Tutorials
        function analyticsTable_videos_page_output(){ ?>
            <div class="tutorials-shadow"></div>
            <div class="wrap">
                <h2><?php echo get_admin_page_title() ?></h2>
                <?php read_tg_tutorial_videos_table(); ?>
            </div>
            <?php
        }

        //  Вывод админки Users management
        function add_users_manage_page(){
            include dirname(__FILE__). '/includes/class-usersGenerator-menu.php';
            include dirname(__FILE__). '/includes/class-users-list-table.php';
            include dirname(__FILE__). '/includes/generator-users-functions.php';
            include dirname(__FILE__). '/includes/class-users_form-handler.php';

            new Users_students_menu();            
        }


//   ADD SETTINGS

        /**
         * Регистрируем настройки.
         * Настройки будут храниться в массиве, а не одна настройка = одна опция.
         */
        add_action('admin_init', 'plugin_settings');
        function plugin_settings(){

            // параметры: $option_group, $option_name, $sanitize_callback
            register_setting( 'option_group', 'apy_key', 'sanitize_callback' );

            // параметры: $id, $title, $callback, $page
            add_settings_section( 'section_id', 'Main settings', '', 'analyticsTable_page' ); 

            // параметры: $id, $title, $callback, $page, $section, $args
            add_settings_field('analyticsTable_field1', 'API KEY', 'fill_analyticsTable_field1', 'analyticsTable_page', 'section_id' );
        }

        ## Заполняем API KEY
        function fill_analyticsTable_field1(){
            $val = get_option('apy_key');
            $val = $val ? $val['input'] : null;
            ?>
            <input type="text" name="apy_key[input]" value="<?php echo esc_attr( $val ) ?>" />
            <p><i>replace by your api key (any type) - see https://www.digistore24.com/vendor/settings/account_access/api</i></p>
            <?php
        }

        ## Очистка данных
        function sanitize_callback( $options ){ 
            // очищаем
            foreach( $options as $name => & $val ){
                if( $name == 'input' )
                    $val = strip_tags( $val );

                if( $name == 'checkbox' )
                    $val = intval( $val );
            }

            return $options;
        }
    }


}
