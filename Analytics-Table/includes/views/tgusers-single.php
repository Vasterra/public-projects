<div class="wrap">
    <h2><?php _e( 'Add new field', 'qwerty' ); ?></h2>

    <?php $item = vimeo_get_video( $id ); ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-name">
                    <th scope="row">
                        <label for="name"><?php _e( 'Title', 'qwerty' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" placeholder="<?php echo esc_attr( '', 'qwerty' ); ?>" value="<?php echo esc_attr( $item->name ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-url">
                    <th scope="row">
                        <label for="url"><?php _e( 'Video src', 'qwerty' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="url" id="url" class="regular-text" placeholder="<?php echo esc_attr( '', 'qwerty' ); ?>" value="<?php echo esc_attr( $item->url ); ?>" required="required" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->id; ?>">

        <?php wp_nonce_field( 'video-new' ); ?>
        <?php submit_button( __( 'Update video', 'qwerty' ), 'primary', 'submit_video' ); ?>

    </form>
</div>