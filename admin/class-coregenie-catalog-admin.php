<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://coregenie.com
 * @since      1.0.0
 *
 * @package    Coregenie_Catalog
 * @subpackage Coregenie_Catalog/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Coregenie_Catalog
 * @subpackage Coregenie_Catalog/admin
 * @author     Hasanul Banna <banna@coregenie.com>
 */
class Coregenie_Catalog_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Coregenie_Catalog_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Coregenie_Catalog_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/coregenie-Catalog-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Coregenie_Catalog_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Coregenie_Catalog_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/coregenie-Catalog-admin.js', array( 'jquery' ), $this->version, false );

	}

// Register Post Type

public function catalog_post_type_register() {

    $labels = array(
        'name'                  => _x( 'Product Catalogs', 'Post type general name', $this->plugin_name ),
        'singular_name'         => _x( 'Catalog', 'Post type singular name', $this->plugin_name ),
        'menu_name'             => _x( 'Product Catalogs', 'Admin Menu text', $this->plugin_name ),
        'name_admin_bar'        => _x( 'Catalog', 'Add New on Toolbar', $this->plugin_name ),
        'add_new'               => __( 'Add New', $this->plugin_name ),
        'add_new_item'          => __( 'Add New Catalog', $this->plugin_name ),
        'new_item'              => __( 'New Catalog', $this->plugin_name ),
        'edit_item'             => __( 'Edit Catalog', $this->plugin_name ),
        'view_item'             => __( 'View Catalog', $this->plugin_name ),
        'all_items'             => __( 'All Catalogs', $this->plugin_name ),
        'search_items'          => __( 'Search Catalogs', $this->plugin_name ),
        'parent_item_colon'     => __( 'Parent Catalogs:', $this->plugin_name ),
        'not_found'             => __( 'No Catalogs found.', $this->plugin_name ),
        'not_found_in_trash'    => __( 'No Catalogs found in Trash.', $this->plugin_name),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'catalogs' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'menu_icon'			 => 'dashicons-admin-page',
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor','thumbnail',),
    );

    register_post_type( 'cg-catalogs', $args );
}


	
    /**
     * Add the meta box to catalog post type.
     */
    public function add_metabox() {
        add_meta_box(
            'catalog-meta-box',
            __( 'Product Deails', $this->plugin_name ),
            array( $this, 'render_metabox' ),
            'cg-catalogs',
            'advanced',
            'high'
        );
 
    }
 
    /**
     * Renders the meta box.
     */
    public function render_metabox( $post ) {
        // Add nonce for security and authentication.
        global $post;
    	$meta = get_post_meta( $post->ID, 'catelog_product_fields', true );
    	
        wp_nonce_field( 'calatalog_custom_nonce_action', 'catelog_custom_nonce' );
        // Meta box html code

        	echo '<div class="product_meta_box">
		    <p class="meta-options product_meta_field">
		        <label for="product_id">Product ID</label>
		        <input id="product_id" type="text" name="catelog_product_fields[product_id]" value='.$meta['product_id'].'>
		    </p>
		    <p class="meta-options product_meta_field">
		        <label for="product_size">Product Size</label>
		        <input id="product_size" type="text" name="catelog_product_fields[product_size]" value='.$meta['product_size'].'>
		    </p>
		    <p class="meta-options product_meta_field">
		        <label for="product_weight">Product Weight</label>
		        <input id="product_weight" type="text" name="catelog_product_fields[product_weight]" value='.$meta['product_weight'].'>
		    </p>
		    <p class="meta-options product_meta_field">
		        <label for="product_price">Product Price</label>
		        <input id="product_price" type="text" name="catelog_product_fields[product_price]" value='.$meta['product_price'].'>
		    </p>
		</div>';
  
		
    }
 
    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_catalog_fields_meta( $post_id) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['catelog_custom_nonce'] ) ? $_POST['catelog_custom_nonce'] : '';
        $nonce_action = 'calatalog_custom_nonce_action';
 
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
 
        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
 
        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }
 
        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }

        $old = get_post_meta( $post_id, 'catelog_product_fields', true );
    	$new = $_POST['catelog_product_fields'];

    	if ( $new && $new !== $old ) {
    		update_post_meta( $post_id, 'catelog_product_fields', $new );
    	} elseif ( '' === $new && $old ) {
    		delete_post_meta( $post_id, 'catelog_product_fields', $old );
    	}

    }

    public function add_plugin_admin_menu() {

	add_submenu_page( 
            'edit.php?post_type=cg-catalogs', 'Catalog Settings', 'Catalog Settings', 'manage_options', $this->plugin_name, array($this, 'submenu_page_callback')
        );
}
	public function submenu_page_callback() {
        echo '<div class="wrap">';
        echo '<h2>Product Catalog Settings</h2>';
        echo '</div>';
        echo $this->plugin_name;
    }

}