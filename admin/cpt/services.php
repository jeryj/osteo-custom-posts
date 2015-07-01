<?php //Services Custom Post Type
add_action( 'init', 'register_cpt_services' );
//CPT for Services
function register_cpt_services() {

    $labels = array(
        'name' => _x( 'Services', 'services' ),
        'singular_name' => _x( 'Service', 'services' ),
        'add_new' => _x( 'Add New', 'services' ),
        'add_new_item' => _x( 'Add New Service', 'services' ),
        'edit_item' => _x( 'Edit Service', 'services' ),
        'new_item' => _x( 'New Service', 'services' ),
        'view_item' => _x( 'View Service', 'services' ),
        'search_items' => _x( 'Search Services', 'services' ),
        'not_found' => _x( 'No Services found', 'services' ),
        'not_found_in_trash' => _x( 'No Services found in Trash', 'services' ),
        'parent_item_colon' => _x( 'Parent Services:', 'services' ),
        'menu_name' => _x( 'Services', 'services' ),
    );

    $args = array(
        'labels' => $labels,
        'menu_icon' => 'dashicons-tag',
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions', 'page-attributes' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'register_meta_box_cb' => 'add_services_metaboxes',
    );

    register_post_type( 'services', $args );
}

// Create Service Type
function create_service_type_taxonomies() {
    register_taxonomy(
        'service_type',
        'services',
        array(
            'labels' => array(
                'name' => 'Service Types',
                'add_new_item' => 'Add New Service Type',
                'new_item_name' => "New Service Type"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'sort' => true
        )
    );
}
add_action( 'init', 'create_service_type_taxonomies', 0 );

// Creates the categories we need for the Property Type
function create_service_types() {
    wp_insert_category(
        array('cat_name' => 'Writing Services', 'category_nicename' => 'writing-services', 'taxonomy' => 'service_type')
    );

    wp_insert_category(
        array('cat_name' => 'Consulting', 'category_nicename' => 'consulting', 'taxonomy' => 'service_type')
    );

}
add_action('admin_init', 'create_service_types');


// Register the Services Metaboxes
function add_services_metaboxes() {
    add_meta_box('service_details', 'Service Details', 'service_details', 'services', 'normal', 'high');
    add_meta_box('service_process', 'Our Process', 'service_process', 'services', 'normal', 'high');
}

function service_details() {
    metaField('_needsBeforeStart', array('type' => 'editor', 'title' => 'What we need to get started') );
}

function service_process() {
    $ourProcess['fields'] = array(
                            array(
                                'title' => 'Title',
                                'dataname' => 'title',
                                'required' => true, // This doesn't "really" require it
                            ),
                            array(
                                'type' => 'textarea',
                                'title' => 'Description',
                                'dataname' => 'description',
                            ),
                        );


    metaItems('_ourProcess', $ourProcess);
}

function save_services_meta($post_id, $post) {
        // Exits script if autosave, if nonces don't match, or if revision
    if(metaSaveSetup($post_id) !== true){
        return;
    }

    // all the items
    metaSave('_needsBeforeStart');

    // Save the details
        // Required Fields
        $ourProcess['required'] = array('title');
        // save it
        metaSave('_ourProcess', $ourProcess);

}
add_action('save_post_services', 'save_services_meta', 1, 2); // save the custom fields

?>
