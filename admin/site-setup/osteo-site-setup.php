<?php
/**
* Step 1: Create link to the menu page.
*/
add_action('admin_menu', 'ew_create_menu');
function ew_create_menu() {
    //create new top-level menu
    add_menu_page('Site Setup', 'Site Setup', 'manage_options', 'osteo_site_setup', 'osteo_site_setup_page', 'dashicons-megaphone', 50);
}


/**
* Step 2: Create settings fields.
*/
add_action( 'admin_init', 'osteo_site_settings_data' );
function osteo_site_settings_data() {

    // About
    register_setting( 'osteo_site_settings', 'mission_statement' );
    // Contact Form
    register_setting( 'osteo_site_settings', 'contact_form' );
    register_setting( 'osteo_site_settings', 'show_contact_in_footer' );
    // Social Media
    register_setting( 'osteo_site_settings', 'social_facebook' );
    register_setting( 'osteo_site_settings', 'social_twitter' );
    register_setting( 'osteo_site_settings', 'social_googleplus' );
    register_setting( 'osteo_site_settings', 'social_linkedin' );
    // Address
    register_setting( 'osteo_site_settings', 'address_line_1' );
    register_setting( 'osteo_site_settings', 'address_line_2' );
    register_setting( 'osteo_site_settings', 'city_st_zip' );
    register_setting( 'osteo_site_settings', 'phone_number' );
    register_setting( 'osteo_site_settings', 'contact_email' );
    // Look & Feel
    register_setting( 'osteo_site_settings', 'blog_archive_style');
}

/**
* Step 3: Create the markup for the options page
*/
function osteo_site_setup_page() { ?>

<div class="wrap site-setup osteo-meta-styles">

    <form method="post" action="options.php">

        <?php if(isset( $_GET['settings-updated'])) { ?>
        <div class="updated">
            <p>Settings updated successfully</p>
        </div>
        <?php } ?>


        <h2>Site Setup</h2>

        <?php
        // check if gravity forms is installed
        if(is_plugin_active('gravityforms/gravityforms.php')) : ?>
            <div class="well">
                <h3>Forms</h3>
                <?php metaOption('contact_form', array('title'=>'Contact Form', 'description'=>'Gravity Forms Form ID'));?>
                <?php metaOption('show_contact_in_footer',
                                array(
                                        'type'=>'checkbox',
                                        'options'=>array(
                                                        array('value'=>true, 'description'=>'Show Contact Form in Footer'),
                                                    ),
                                    )
                            );?>
            </div>
        <?endif;?>

        <div class="well">
            <h3>About</h3>
            <?php metaOption('mission_statement', array('title'=>'Mission Statement', 'type'=>'editor', 'style'=>array('textarea_rows'=>5) ) );?>
        </div>

        <div class="well">
            <h3>Social Media</h3>

            <?php
                metaOption('social_facebook', array('title'=>'Facebook'));
                metaOption('social_twitter', array('title'=>'Twitter'));
                metaOption('social_googleplus', array('title'=>'Google Plus'));
                metaOption('social_linkedin', array('title'=>'LinkedIn'));
            ?>
        </div>

        <div class="well">
            <h3>Address &amp; Phone</h3>
            <?php
                metaOption('address_line_1', array('title' => 'Address Line 1'));
                metaOption('address_line_2', array('title' => 'Address Line 2'));
                metaOption('city_st_zip', array('title' => 'City, ST Zip'));
                metaOption('phone_number', array('title' => 'Phone Number'));
                metaOption('contact_email', array('title' => 'Contact Email'));
                // FIND OUT HOW TO GET GOOGLE MAP IN HRRRRR
            ?>

        </div>

        <div class="well">
            <h3>Look &amp; Feel</h3>
            <?php
                metaOption('blog_archive_style', array(
                                                    'title' => 'Blog Archive Style',
                                                    'type'=>'dropdown',
                                                    'options'=>array(
                                                                    array('value'=>'full', 'description'=>'Full Width'),
                                                                    array('value'=>'tile', 'description'=>'Tiles'),
                                                                    ),
                                                    )
                );
            ?>

        </div>
        <?php settings_fields( 'osteo_site_settings' ); ?>
        <?php do_settings_sections( 'osteo_site_settings' ); ?>
        <?php submit_button(); ?>
    </form>
</div>
<?php
}
