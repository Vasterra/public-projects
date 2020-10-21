<div class="wrap">
    <h2><?php _e( 'Edit user', 'qwerty' ); ?></h2>

    <?php 
        $item = usersManagement_get_user( $id );
    ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-name">
                    <th scope="row">
                        <label for="name"><?php _e( 'User login', 'qwerty' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="tg_user_login" id="name" class="regular-text" placeholder="<?php echo esc_attr( '', 'qwerty' ); ?>" value="<?php echo esc_attr( $item->user_login ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-user_email">
                    <th scope="row">
                        <label for="user_email"><?php _e( 'User email', 'qwerty' ); ?></label>
                    </th>
                    <td>
                        <input type="email" name="tg_user_email" id="user_email" class="regular-text" placeholder="<?php echo esc_attr( '', 'qwerty' ); ?>" value="<?php echo esc_attr( $item->user_email ); ?>" required="required" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->ID; ?>">

        <?php wp_nonce_field( 'user-new' ); ?>
        <?php submit_button( __( 'Update user', 'qwerty' ), 'primary', 'submit_user' ); ?>

    </form>
</div>