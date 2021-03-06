<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WC Predictive Search Global Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WC_Predictive_Search_Global_Settings extends WC_Predictive_Search_Admin_UI
{

	/**
	 * @var string
	 */
	private $parent_tab = 'global-settings';

	/**
	 * @var array
	 */
	private $subtab_data;

	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = '';

	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wc_predictive_search_global_settings';

	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;

	/**
	 * @var array
	 */
	public $form_fields = array();

	/**
	 * @var array
	 */
	public $form_messages = array();

	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {

		$this->init_form_fields();
		$this->subtab_init();

		$this->form_messages = array(
				'success_message'	=> __( 'Global Settings successfully saved.', 'woops' ),
				'error_message'		=> __( 'Error: Global Settings can not save.', 'woops' ),
				'reset_message'		=> __( 'Global Settings successfully reseted.', 'woops' ),
			);

		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );

		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );

		add_action( $this->plugin_name . '_settings_' . 'predictive_search_searchbox_text' . '_start', array( $this, 'predictive_search_searchbox_text' ) );
		add_action( $this->plugin_name . '_settings_' . 'predictive_search_synch_data' . '_start', array( $this, 'predictive_search_synch_data' ) );

		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'after_save_settings' ) );
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
	}

	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {

		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );

	}

	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wc_predictive_search_admin_interface;

		$wc_predictive_search_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}

	/*-----------------------------------------------------------------------------------*/
	/* after_save_settings()
	/* Process when clean on deletion option is un selected */
	/*-----------------------------------------------------------------------------------*/
	public function after_save_settings() {
		if ( ( isset( $_POST['bt_save_settings'] ) || isset( $_POST['bt_reset_settings'] ) ) && get_option( 'woocommerce_search_lite_clean_on_deletion' ) == 'no' )  {
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[WOOPS_NAME]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		}
		if ( isset( $_REQUEST['woocommerce_search_box_text']) ) {
			update_option('woocommerce_search_box_text',  $_REQUEST['woocommerce_search_box_text'] );
		}
		if ( isset( $_POST['predicitve-search-synch-wp-data'] ) ) {
			@set_time_limit(86400);
			@ini_set("memory_limit","1000M");

			global $wc_ps_synch;
			$wc_ps_synch->synch_full_database();

			echo '<div class="updated"><p>' . __( '<strong>SUCCESS</strong>! Your Predictive Search Database has been successfully updated.', 'woops' ) . '</p></div>';
		}

		if ( isset( $_POST['bt_save_settings'] ) ) {
			flush_rewrite_rules();
		} elseif ( 1 == get_option( 'wc_predictive_search_just_confirm', 0 ) ) {
			delete_option( 'wc_predictive_search_just_confirm' );
			flush_rewrite_rules();
		}
	}

	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wc_predictive_search_admin_interface;

		$wc_predictive_search_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}

	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array (
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {

		$subtab_data = array(
			'name'				=> 'global-settings',
			'label'				=> __( 'Settings', 'woops' ),
			'callback_function'	=> 'wc_predictive_search_global_settings_form',
		);

		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;

	}

	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {

		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();

		return $subtabs_array;
	}

	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wc_predictive_search_admin_interface;

		$output = '';
		$output .= $wc_predictive_search_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );

		return $output;
	}

	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {

  		// Define settings
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(

     		array(
            	'name' 		=> __( 'Search Results No-Cache', 'woops' ),
            	'desc'		=> __( 'While testing different setting and the results in search box dropdown you need to switch ON Results No-Cache On. Search box dropdown results are cached in local store for frontend users for faster delivery on repeat searches. Be sure to turn this OFF when you are finished testing.', 'woops' ),
                'type' 		=> 'heading',
           	),
			array(
				'name' 		=> __( 'Results No-Cache', 'woops' ),
				'id' 		=> 'woocommerce_search_is_debug',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woops' ),
				'unchecked_label' 	=> __( 'OFF', 'woops' ),
			),

			array(
            	'name' 		=> __( 'Global Search Box Text', 'woops' ),
                'type' 		=> 'heading',
				'id'		=> 'predictive_search_searchbox_text',
           	),

      		array(
            	'name' 		=> __('Search Page Configuration', 'woops'),
                'type' 		=> 'heading',
                'desc' 		=> ( class_exists('SitePress') ) ? __('Predictive Search has detected the WPML plugin. On install a search page was auto created for each language in use. Please use the WPML String Translations plugin to make translation for plugin text for each page. If adding another language after installing Predictive Search you have to manually create a search page for it.', 'woops') : __('A search results page needs to be selected so that WooCommerce Predictive Search knows where to show search results. This page should have been created upon installation of the plugin, if not you need to create it.', 'woops'),
           	),
			array(
				'name' 		=> __( 'Search Page', 'woops' ),
				'desc' 		=> __('Page contents:', 'woops').' [woocommerce_search]',
				'id' 		=> 'woocommerce_search_page_id',
				'type' 		=> 'single_select_page',
			),

			array(
            	'name' 		=> __( 'Special Characters', 'woops' ),
				'desc'		=> __( 'Select any special characters that are used on this site. Selecting a character will mean that results will be returned when user search input includes or excludes the special character. <strong>IMPORTANT!</strong> Do not turn this feature on unless needed. If ON - only select actual characters used in Product Titles, SKU, Category Names etc - each special character selected creates 1 extra query per search object, per product, post or page.', 'woops' ),
                'type' 		=> 'heading',
           	),
			array(
				'name' 		=> __( 'Special Character Function', 'woops' ),
				'class'		=> 'woocommerce_search_remove_special_character',
				'id' 		=> 'woocommerce_search_remove_special_character',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woops' ),
				'unchecked_label' 	=> __( 'OFF', 'woops' ),
			),

			array(
                'type' 		=> 'heading',
				'class'		=> 'woocommerce_search_remove_special_character_container',
           	),
           	array(
				'name' 		=> __( 'Character Syntax', 'woops' ),
				'id' 		=> 'woocommerce_search_replace_special_character',
				'type' 		=> 'onoff_radio',
				'default'	=> 'remove',
				'onoff_options' => array(
					array(
						'val' 				=> 'ignore',
						'text' 				=> __( 'IGNORE. ON to ignore or skip over special characters in the string.', 'woops' ),
						'checked_label'		=> __( 'ON', 'woops' ),
						'unchecked_label' 	=> __( 'OFF', 'woops' ),
					),
					array(
						'val' 				=> 'remove',
						'text' 				=> __( 'REMOVE. ON to remove or see special characters as a space.', 'woops' ).' <span class="description">('.__( 'recommended', 'woops' ).')</span>' ,
						'checked_label'		=> __( 'ON', 'woops' ),
						'unchecked_label' 	=> __( 'OFF', 'woops' ),
					),
					array(
						'val' 				=> 'both',
						'text' 				=> __( 'BOTH. On to use ignore and remove for special characters.', 'woops' ),
						'checked_label'		=> __( 'ON', 'woops' ),
						'unchecked_label' 	=> __( 'OFF', 'woops' ),
					),
				),
			),

			array(
				'name' 		=> __( "Select Characters", 'woops' ),
				'id' 		=> 'woocommerce_search_special_characters',
				'type' 		=> 'multiselect',
				'css'		=> 'width:600px; min-height:80px;',
				'options'	=> WC_Predictive_Search_Functions::special_characters_list(),
			),

			array(
            	'name' 		=> __( 'Manual Database Sync', 'woops' ),
            	'desc'		=> __( 'Predictive Search database is auto updated whenever a product or post is published or updated. Please run a Manual database sync if you upload products by csv or feel that Predictive Search results are showing old data.  Will sync the Predictive Search database with your current WooCommerce and WordPress databases', 'woops' ),
            	'id'		=> 'predictive_search_synch_data',
                'type' 		=> 'heading',
           	),

			array(
				'name' 		=> __( 'House Keeping', 'woops' ).' :',
				'type' 		=> 'heading',
			),
			array(
				'name' 		=> __( 'Clean up on Deletion', 'woops' ),
				'desc' 		=> __( 'On deletion (not deactivate) the plugin it will completely remove all of its code and tables it has created, leaving no trace it was ever here. If upgrading to the Pro Version this is <span class="description">not recommended</span>', 'woops' ),
				'id' 		=> 'woocommerce_search_lite_clean_on_deletion',
				'default'	=> 'no',
				'type' 		=> 'onoff_checkbox',
				'separate_option'	=> true,
				'checked_value'		=> 'yes',
				'unchecked_value'	=> 'no',
				'checked_label'		=> __( 'ON', 'woops' ),
				'unchecked_label' 	=> __( 'OFF', 'woops' ),
			),

        ));
	}

	function predictive_search_searchbox_text() {
		if ( class_exists('SitePress') ) {
			$woocommerce_search_box_text = get_option('woocommerce_search_box_text', array() );
			if ( !is_array( $woocommerce_search_box_text) ) $woocommerce_search_box_text = array();

			global $sitepress;
			$active_languages = $sitepress->get_active_languages();
			if ( is_array($active_languages)  && count($active_languages) > 0 ) {
	?>
    		<tr valign="top" class="">
				<td class="forminp" colspan="2">
                <?php _e("Enter the translated search box text for each language for WPML to show it correct on the front end.", 'woops'); ?>
				</td>
			</tr>
    <?php
				foreach ( $active_languages as $language ) {
	?>
    		<tr valign="top" class="">
				<th class="titledesc" scope="row"><label for="woocommerce_search_box_text_<?php echo $language['code']; ?>"><?php _e('Text to Show', 'woops');?> (<?php echo $language['display_name']; ?>)</label></th>
				<td class="forminp">
                	<input type="text" class="" value="<?php if (isset($woocommerce_search_box_text[$language['code']]) ) esc_attr_e( stripslashes( $woocommerce_search_box_text[$language['code']] ) ); ?>" style="min-width:300px;" id="woocommerce_search_box_text_<?php echo $language['code']; ?>" name="woocommerce_search_box_text[<?php echo $language['code']; ?>]" /> <span class="description"><?php _e('&lt;empty&gt; shows nothing', 'woops'); ?></span>
				</td>
			</tr>
    <?php
				}
			}

		} else {
			$woocommerce_search_box_text = get_option('woocommerce_search_box_text', '' );
			if ( is_array( $woocommerce_search_box_text) ) $woocommerce_search_box_text = '';
	?>
            <tr valign="top" class="">
				<th class="titledesc" scope="row"><label for="woocommerce_search_box_text"><?php _e('Text to Show', 'woops');?></label></th>
				<td class="forminp">
                	<input type="text" class="" value="<?php esc_attr_e( stripslashes( $woocommerce_search_box_text ) ); ?>" style="min-width:300px;" id="woocommerce_search_box_text" name="woocommerce_search_box_text" /> <span class="description"><?php _e('&lt;empty&gt; shows nothing', 'woops'); ?></span>
				</td>
			</tr>
    <?php }
	}

	public function predictive_search_synch_data() {
		global $wc_ps_posts_data;
	?>
		<tr valign="top" class="">
			<th class="titledesc" scope="row"><label><?php _e('Sync Search Data', 'woops');?></label></th>
			<td class="forminp">
				<input type="submit" class="button button-primary" name="predicitve-search-synch-wp-data" value="<?php _e('Sync Now', 'woops');?>" /><br />
				<p>
					<span class="a3-ps-synched-title"><?php _e('You have synced', 'woops');?>:</span>
					<span class="a3-ps-synched-products">
						<?php
						$total_products = $wc_ps_posts_data->get_total_items_synched('product');
						if ( $total_products > 0 ) {
							echo sprintf( _n( '%s Product', '%s Products', $total_products, 'woops' ), number_format( $total_products ) );
						} else {
							echo sprintf( __( '%s Product', 'woops' ), $total_products );
						}
						?>
					</span>-
					<span class="a3-ps-synched-posts">
						<?php
						$total_posts = $wc_ps_posts_data->get_total_items_synched('post');
						if ( $total_posts > 0 ) {
							echo sprintf( _n( '%s Post', '%s Posts', $total_posts, 'woops' ), number_format( $total_posts ) );
						} else {
							echo sprintf( __( '%s Post', 'woops' ), $total_posts );
						}
						?>
					</span>-
					<span class="a3-ps-synched-pages">
						<?php
						$total_pages = $wc_ps_posts_data->get_total_items_synched('page');
						if ( $total_pages > 0 ) {
							echo sprintf( _n( '%s Page', '%s Pages', $total_pages, 'woops' ), number_format( $total_pages ) );
						} else {
							echo sprintf( __( '%s Page', 'woops' ), $total_pages );
						}
						?>
					</span>
				</p>
			</td>
		</tr>
	<?php
	}

	public function include_script() {
	?>
	<style type="text/css">
		.a3-ps-synched-products {
			color: #96587d;
		}
		.a3-ps-synched-posts {
			color: #7ad03a;
		}
		.a3-ps-synched-pages {
			color: #0073aa;
		}
	</style>
<script>
(function($) {

	$(document).ready(function() {

		if ( $("input.woocommerce_search_focus_enable:checked").val() == 'yes') {
			$('.woocommerce_search_focus_plugin_container').css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		} else {
			$('.woocommerce_search_focus_plugin_container').css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		}

		if ( $("input.woocommerce_search_remove_special_character:checked").val() == 'yes') {
			$('.woocommerce_search_remove_special_character_container').css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		} else {
			$('.woocommerce_search_remove_special_character_container').css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		}

		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.woocommerce_search_focus_enable', function( event, value, status ) {
			$('.woocommerce_search_focus_plugin_container').hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
			if ( status == 'true' ) {
				$(".woocommerce_search_focus_plugin_container").slideDown();
			} else {
				$(".woocommerce_search_focus_plugin_container").slideUp();
			}
		});

		$(document).on( "a3rev-ui-onoff_checkbox-switch", '.woocommerce_search_remove_special_character', function( event, value, status ) {
			$('.woocommerce_search_remove_special_character_container').hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
			if ( status == 'true' ) {
				$(".woocommerce_search_remove_special_character_container").slideDown();
			} else {
				$(".woocommerce_search_remove_special_character_container").slideUp();
			}
		});

	});

})(jQuery);
</script>
    <?php
	}
}

global $wc_predictive_search_global_settings;
$wc_predictive_search_global_settings = new WC_Predictive_Search_Global_Settings();

/**
 * wc_predictive_search_global_settings_form()
 * Define the callback function to show subtab content
 */
function wc_predictive_search_global_settings_form() {
	global $wc_predictive_search_global_settings;
	$wc_predictive_search_global_settings->settings_form();
}

?>
