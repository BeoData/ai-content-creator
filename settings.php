<?php

add_action('admin_menu', 'ai_post_creator_settings_page');

function ai_post_creator_settings_page() {
    add_options_page(
        'AI Post Creator Settings',       // Page title
        'AI Post Creator',                // Menu title
        'manage_options',                 // Capability required
        'ai-post-creator-settings',       // Menu slug
        'ai_post_creator_settings_content' // Callback function
    );
}


function ai_post_creator_settings_content() {
    ?>
    <div class="wrap">
        <h2>AI Post Creator Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('ai_post_creator_options');
            do_settings_sections('ai-post-creator-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


add_action('admin_init', 'ai_post_creator_register_settings');

function ai_post_creator_register_settings() {
    register_setting('ai_post_creator_options', 'ai_option_ai_api_key');
    register_setting('ai_post_creator_options', 'ai_option_ai_language');

    add_settings_section(
        'ai_settings_section',           // ID of the section
        'General Settings',              // Title of the section
        '',                              // Callback function for the section description (can be left empty)
        'ai-post-creator-settings'       // Page on which to display the section
    );

    add_settings_field(
        'ai_option_ai_api_key',                // ID of the settings field
        'OpenAI API Key',              // Label for the settings field
        'ai_option_display_callback',    // Callback function to display the field
        'ai-post-creator-settings',      // Page on which to display the field
        'ai_settings_section'            // Section in which to place the field
    );



    add_settings_field(
        'ai_option_ai_language',          // ID of the settings field
        'OpenAI Language',                // Label for the settings field
        'ai_language_display_callback',   // Callback function to display the field
        'ai-post-creator-settings',       // Page on which to display the field
        'ai_settings_section'             // Section in which to place the field
    );

    add_settings_field(
    'ai_option_ai_model',                  // ID of the settings field
    'OpenAI Model',                        // Label for the settings field
    'ai_model_display_callback',           // Callback function to display the field
    'ai-post-creator-settings',            // Page on which to display the field
    'ai_settings_section'                  // Section in which to place the field
);


}

function ai_option_display_callback() {
    $option_value = get_option('ai_option_ai_api_key', ''); // Retrieve the option's value from the database
    echo '<input type="text" name="ai_option_ai_api_key" class="regular-text code" value="' . esc_attr($option_value) . '">';
	echo'<br>';
	echo'<br>';
	echo' <a href="https://help.openai.com/en/articles/4936850-where-do-i-find-my-secret-api-key" target="_blank"> Where do I find my Secret API Key?</a>';
}

function ai_language_display_callback() {
    $option_value = get_option('ai_option_ai_language', ''); 
    echo '<input type="text" name="ai_option_ai_language" class="regular-text code" value="' . esc_attr($option_value) . '">';
    echo '<p class="description">Unesite željeni jezik. Na primer: English, Serbian, Spanish...</p>';
}

register_setting('ai_post_creator_options', 'ai_option_ai_model');

function ai_model_display_callback() {
    $selected_value = get_option('ai_option_ai_model', '');
    
    $ai_models = array(
        'davinci' => 'Davinci',
        'curie' => 'Curie',
        'babbage' => 'Babbage',
        'ada' => 'Ada'
        // Add more models here as needed
    );
    
    echo '<select name="ai_option_ai_model" class="regular-text">';
    foreach ($ai_models as $key => $value) {
        $selected = ($selected_value == $key) ? 'selected' : '';
        echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($value) . '</option>';
    }
    echo '</select>';
    echo '<p class="description">Select the desired AI model.</p>';
}
