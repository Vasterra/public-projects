<div class="wrap">
    <h2><?php _e( 'Add new user', 'qwerty' ); ?></h2>
    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-name">
                    <th scope="row">
                        <label for="name"><?php _e( 'User login', 'qwerty' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="tg_user_login" id="name" class="regular-text" placeholder="<?php echo esc_attr( '', 'qwerty' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-url">
                    <th scope="row">
                        <label for="url"><?php _e( 'User email', 'qwerty' ); ?></label>
                    </th>
                    <td>
                        <input type="email" name="tg_user_email" id="url" class="regular-text" placeholder="<?php echo esc_attr( '', 'qwerty' ); ?>" value="" required="required" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( 'user-new' ); ?>
        <?php submit_button( __( 'Add new user', 'qwerty' ), 'primary', 'submit_user' ); ?>
    </form>
</div>