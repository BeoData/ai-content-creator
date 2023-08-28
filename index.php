<?php
/*
Plugin Name: Ai Post Creator 
Plugin URI: https://www.beodata.rs
Description: A plugin to Create AI post.
Version: 1.0
Author: Dejan Simic
Author URI: https://www.beodata.rs
License: GPL2
*/

include_once plugin_dir_path(__FILE__) . 'settings.php';
require 'vendor/autoload.php';

add_action('admin_enqueue_scripts', 'enqueue_admin_assets');

function enqueue_admin_assets() {
    wp_enqueue_script('ai-post-creator-js', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery', 'thickbox'), '1.0.0', true);
    wp_enqueue_style('thickbox');
}

add_action('admin_footer-edit.php', 'add_create_ai_post_button');

function add_create_ai_post_button() {
    global $post_type;
    if ($post_type == 'post') {
        echo '<script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery(".wrap h1").after("<a href=\'#TB_inline?width=500&height=250&inlineId=ai_post_popup\' class=\'page-title-action thickbox\'>Kreiraj AI Post</a>");
                });
              </script>';
    }
}

add_action('load-edit.php', 'handle_ai_post_creation');

function handle_ai_post_creation() {
    if (!isset($_GET['create_ai_post']) || !isset($_GET['ai_post_title'])) {
        return;
    }

    $api_key = get_option('ai_option_ai_api_key', '');
    $post_title = sanitize_text_field($_GET['ai_post_title']);
    $post_content = generate_ai_content($post_title, $api_key);
    
   


    if (!$post_content) {
        show_admin_error('There was a problem generating content from the AI.');
        return;
    }

    $post_id = wp_insert_post(array(
        'post_title'    => $post_title,
        'post_content'  => $post_content,
        'post_status'   => 'publish',
        'post_type'     => 'post'
    ));

    if (!$post_id) {
        show_admin_error('There was a problem creating the AI post.');
        return;
    }

    wp_redirect(admin_url('post.php?action=edit&post=' . $post_id));
    exit;
}

function generate_ai_content($title, $api_key) {

 $language = get_option('ai_option_ai_language', '');
 


    $client = OpenAI::client($api_key);
    try {
        $result = $client->completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => 'Generate an SEO-optimized HTML content based on this topic: ' . $title . '. is very important that content is in language: ' . $language  ,
 
            'max_tokens' => 1024,
            'temperature' => 0.8 
        ]);
        file_put_contents(plugin_dir_path(__FILE__) . 'error_log.txt', print_r($result, true));
        return $result['choices'][0]['text'] ?? '';
    } catch (Exception $e) {
        file_put_contents(plugin_dir_path(__FILE__) . 'error_log.txt', $e->getMessage());
        return false;
    }
}


function show_admin_error($message) {
    add_action('admin_notices', function() use ($message) {
        echo '<div class="notice notice-error is-dismissible"><p>' . esc_html($message) . '</p></div>';
    });
}

add_action('admin_footer-edit.php', 'add_thickbox_modal');

function add_thickbox_modal() {
    global $post_type;
    if ($post_type == 'post') {
        include_once plugin_dir_path(__FILE__) . 'templates/ai_post_popup.php';
    }
}
