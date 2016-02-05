<?php
/**
 * Plugin Name: Mi first wordpress plugin
 * Plugin URI: https://github.com/franjmartin21/my-first-wp-plugin
 * Description: This is just the exercise of my first plugin
 * Version: 1.0
 * Author: Francisco Martin
 * License GPLv2
 */

// Call function when plugin is activated
register_activation_hook(__FILE__, 'halloween_store_install');

function halloween_store_install(){
    //setup default option values
    $hween_options_arr = array(
        'currency_sign' => '$'
    );

    //save our default option values
    update_option( 'halloween_options', $hween_options_arr);
}

//Action hook to initialize the plugin
add_action( 'init', 'halloween_store_init');

//Initialize the halloween Store
function halloween_store_init(){

    //register the products custome post type
    $labels = array(
        'name'               => __( 'Products', 'halloween-plugin' ),
        'singular_name'      => __( 'Product', 'halloween-plugin' ),
        'add_new'            => __( 'Add New', 'halloween-plugin' ),
        'add_new_item'       => __( 'Add New Product', 'halloween-plugin' ),
        'edit_item'          => __( 'Edit Product', 'halloween-plugin' ),
        'new_item'           => __( 'New Product', 'halloween-plugin' ),
        'all_items'          => __( 'All Products', 'halloween-plugin' ),
        'view_item'          => __( 'View Product', 'halloween-plugin' ),
        'search_items'       => __( 'Search Products', 'halloween-plugin' ),
        'not_found'          => __( 'No products found', 'halloween-plugin' ),
        'not_found_in_trash' => __( 'No products found in Trash', 'halloween-plugin' ),
        'menu_name'          => __( 'Products', 'halloween-plugin' )

    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => true,
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => null,
        'supports'              => array ('title', 'editor', 'thumbnail', 'excerpt')
    );

    register_post_type('halloween-products', $args);
}

// Action hook to add the post products menu item
add_action('admin_menu', 'halloween_store_menu');

//create the Halloween Masks sub-menu
function halloween_store_menu() {

    add_options_page( __( 'Halloween Store Settings Page', 'halloween-plugin' ), __( 'Halloween Store Settings', 'halloween-plugin' ), 'manage_options', 'halloween-store-settings', 'halloween_store_settings_page' );

}

//build the plugin settings page
function halloween_store_settings_page() {

    //load the plugin options array
    $hween_options_arr = get_option( 'halloween_options' );

    //set the option array values to variables
    $hs_inventory = ( ! empty( $hween_options_arr['show_inventory'] ) ) ? $hween_options_arr['show_inventory'] : '';
    $hs_currency_sign = $hween_options_arr['currency_sign'];
    ?>
    <div class="wrap">
        <h2><?php _e( 'Halloween Store Options', 'halloween-plugin' ) ?></h2>

        <form method="post" action="options.php">
            <?php settings_fields( 'halloween-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e( 'Show Product Inventory', 'halloween-plugin' ) ?></th>
                    <td><input type="checkbox" name="halloween_options[show_inventory]" <?php echo checked( $hs_inventory, 'on' ); ?> /></td>
                </tr>

                <tr valign="top">
                    <th scope="row"><?php _e( 'Currency Sign', 'halloween-plugin' ) ?></th>
                    <td><input type="text" name="halloween_options[currency_sign]" value="<?php echo esc_attr( $hs_currency_sign ); ?>" size="1" maxlength="1" /></td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'halloween-plugin' ); ?>" />
            </p>

        </form>
    </div>
    <?php
}

// Action hook to register the plugin option settings
//add_action( 'admin_init', 'halloween_store_register_settings' );


