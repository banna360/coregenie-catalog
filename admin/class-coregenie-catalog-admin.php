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

		 if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
 

	}

	/**
     * Meta box initialization.
     */
    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }
 
    /**
     * Adds the meta box.
     */
    public function add_metabox() {
        add_meta_box(
            'my-meta-box',
            __( 'Catalog Deails', 'coregenie-catalog' ),
            array( $this, 'render_metabox' ),
            'post',
            'advanced',
            'default'
        );
 
    }
 
    /**
     * Renders the meta box.
     */
    public function render_metabox( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
    }
 
    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';
 
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

public function Catalog_post_type_register() {

    $labels = array(
        'name'                  => _x( 'Product Catalogs', 'Post type general name', 'coregenie-catalog' ),
        'singular_name'         => _x( 'Catalog', 'Post type singular name', 'coregenie-catalog' ),
        'menu_name'             => _x( 'Product Catalogs', 'Admin Menu text', 'coregenie-catalog' ),
        'name_admin_bar'        => _x( 'Catalog', 'Add New on Toolbar', 'coregenie-catalog' ),
        'add_new'               => __( 'Add New', 'coregenie-catalog' ),
        'add_new_item'          => __( 'Add New Catalog', 'coregenie-catalog' ),
        'new_item'              => __( 'New Catalog', 'coregenie-catalog' ),
        'edit_item'             => __( 'Edit Catalog', 'coregenie-catalog' ),
        'view_item'             => __( 'View Catalog', 'coregenie-catalog' ),
        'all_items'             => __( 'All Catalogs', 'coregenie-catalog' ),
        'search_items'          => __( 'Search Catalogs', 'coregenie-catalog' ),
        'parent_item_colon'     => __( 'Parent Catalogs:', 'coregenie-catalog' ),
        'not_found'             => __( 'No Catalogs found.', 'coregenie-catalog' ),
        'not_found_in_trash'    => __( 'No Catalogs found in Trash.', 'coregenie-catalog' ),
        'featured_image'        => _x( 'Catalog Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'coregenie-catalog' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'coregenie-catalog' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'coregenie-catalog' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'coregenie-catalog' ),
        'archives'              => _x( 'Catalog archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'coregenie-catalog' ),
        'insert_into_item'      => _x( 'Insert into Catalog', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'coregenie-catalog' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Catalog', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'coregenie-catalog' ),
        'filter_items_list'     => _x( 'Filter Catalogs list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'coregenie-catalog' ),
        'items_list_navigation' => _x( 'Catalogs list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'coregenie-catalog' ),
        'items_list'            => _x( 'Catalogs list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'coregenie-catalog' ),
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
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt',),
    );

    register_post_type( 'cg-catalogs', $args );
}
}
