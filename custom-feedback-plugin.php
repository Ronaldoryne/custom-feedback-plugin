<?php
/*
Plugin Name: Custom Feedback Plugin
Description: Adds a unique feedback form with custom CSS and JS.
Version: 1.0
Author: Your Name
*/

// Enqueue CSS
function cfp_enqueue_styles() {
    wp_enqueue_style(
        'cfp-style',
        plugin_dir_url(__FILE__) . 'css/feedback-style.css',
        array(),
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'cfp_enqueue_styles');

// Enqueue JS
function cfp_enqueue_scripts() {
    wp_enqueue_script(
        'cfp-script',
        plugin_dir_url(__FILE__) . 'js/feedback-script.js',
        array('jquery'),
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'cfp_enqueue_scripts');

// Shortcode for feedback form
function cfp_feedback_form_shortcode() {
    $form = '
    <div class="cfp-form-wrapper">
        <form class="cfp-feedback-form" method="post">
            <label>Full Name *</label>
            <input type="text" name="cfp_name" required>

            <label>Email *</label>
            <input type="email" name="cfp_email" required>

            <label>Street Address</label>
            <input type="text" name="cfp_street">

            <label>Address Line 2</label>
            <input type="text" name="cfp_address2">

            <label>City</label>
            <input type="text" name="cfp_city">

            <label>Postal Code</label>
            <input type="text" name="cfp_zip">

            <label>Post Title</label>
            <input type="text" name="cfp_post_title">

            <label>Post Content</label>
            <textarea name="cfp_post_body"></textarea>

            <input type="submit" name="cfp_submit" value="Send Feedback">
        </form>
    </div>';

    // Handle form submission
    if ( isset($_POST['cfp_submit']) ) {
        $title = sanitize_text_field($_POST['cfp_post_title']) ?: 'Feedback from ' . sanitize_text_field($_POST['cfp_name']);
        $content = sanitize_textarea_field($_POST['cfp_post_body']);

        wp_insert_post(array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'pending',
            'post_type'    => 'post'
        ));

        $form .= '<p class="cfp-success-message">Thank you! Your feedback has been received.</p>';
    }

    return $form;
}
add_shortcode('cfp_feedback_form', 'cfp_feedback_form_shortcode');
