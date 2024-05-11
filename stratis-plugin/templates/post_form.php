<?php

?>
<form id="form__handler" method="post" action="">
    <?php wp_nonce_field('post_form_nonce', 'post_nonce'); ?>
    <div class="form-group">
        <label for="post_title stratis__plugin">Title:</label>
        <input type="text" class="form-control" id="post_title" name="post_title">
    </div>
    <div class="form-group">
        <label for="post_content stratis__plugin">Description:</label>
        <textarea class="form-control" id="post_content" name="post_content"></textarea>
    </div>
    <button type="submit" name="submit_post" class="btn btn-primary"><?php echo esc_html($submit_button_text); ?></button>
</form>