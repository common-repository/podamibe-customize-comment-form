<?php

defined( 'ABSPATH' ) or die( "No script kiddies please!" );

if ( !class_exists( 'PCCF_Class' ) ) {

  	class PCCF_Class {

  		/* Declare the required variables */
  		private static $_instance = null;

  		/* Function of constructor */
  		private function __construct(){
			  
  			$this->pccf_load_hooks();
        	$this->pccf_include_files();
			  $this->pccf_load_backend_scripts();
			  add_filter("plugin_row_meta", array($this, 'get_extra_meta_links'), 10, 4);
			  
  		}

  		/* Function to get instance */
  		public static function _get_instance(){
  			if(is_null(self::$_instance)){
  				self::$_instance = new self;
  			}
  			return self::$_instance;
  		}


  		/* Function to include required files */
  		private function pccf_include_files(){
  			include_once( PCCF_PATH . 'customize-form.php');
  		}

  		/* Function to load required wordpress hooks */
  		private function pccf_load_hooks(){
  			add_action('admin_menu', array($this,'pccf_menu_page') );
		add_filter('plugin_action_links', array($this, 'pccf_add_action_links') );
		
  		}

      /* Function to add settings menu */
      public function pccf_add_action_links( $links ) {
        $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=podamibe-customize-cform') ) .'">'.esc_html__('Settings', PCCF_TEXT_DOMAIN).'</a>';
        return $links;
      }

  		/* Function to enqueue required scripts for backend */
  		private function pccf_load_backend_scripts(){
  			add_action( 'admin_enqueue_scripts', array($this,'pccf_enqueue_backend_scripts') );
  		}

  		/* Function to add menu page */
  		public function pccf_menu_page() {
  			add_submenu_page(
          'options-general.php',
  				esc_html__( 'Customize Comment Form', PCCF_TEXT_DOMAIN ),
  				esc_html__( 'Customize Comment Form', PCCF_TEXT_DOMAIN ),
  				'manage_options',
  				'podamibe-customize-cform',
  				array( $this,'pccf_menu_page_callback' )
  			);
  		}

  		/* Enqueue for pac_load_backend_scripts */
  		public function pccf_enqueue_backend_scripts(){
  		  wp_enqueue_style( 'pccf-admin-style', PCCF_URI. 'assets/pccf-admin.css', true, PCCF_TEXT_DOMAIN );
  			wp_enqueue_script( 'pccf-admin-script', PCCF_URI. 'assets/pccf-admin.js', array( 'jquery'), true ,PCCF_TEXT_DOMAIN );
  		}


  		/* Callback function to add page */
  		public function pccf_menu_page_callback(){ ?>

  		<div class="pccf-main-wrapper">
  			<div class="pccf-main-title">
  				<?php esc_html_e('Podamibe Customize Comment Form', PCCF_TEXT_DOMAIN); ?>
  			</div>
  			<ul class="tabs">
  				<li class="tab-link" data-tab="tab-1">
  					<?php esc_html_e("Form Settings", PCCF_TEXT_DOMAIN); ?>
  				</li>
  				<li class="tab-link" data-tab="tab-2">
  					<?php esc_html_e("Plugin Info", PCCF_TEXT_DOMAIN); ?>
  				</li>
  			</ul>
  			<div id="tab-1" class="tab-content">
  				<?php include_once( PCCF_PATH . 'class-pccf-setting.php'); ?>
  			</div>
  			<div id="tab-2" class="tab-content">
  				<?php include_once( PCCF_PATH . 'class-pccf-info.php'); ?>
  			</div>  			
  		</div>

		  <?php }
		  


		/**
		 * Adds extra links to the plugin activation page
		 */
		public function get_extra_meta_links($meta, $file, $data, $status) {

			$meta[] = "<a href='http://shop.podamibenepal.com/forums/forum/support/' target='_blank'>" . __('Support', 'pn-sfwarea') . "</a>";
			$meta[] = "<a href='http://shop.podamibenepal.com/downloads/podamibe-customize-comment-form/' target='_blank'>" . __('Documentation  ', 'pn-sfwarea') . "</a>";
			$meta[] = "<a href='https://wordpress.org/support/plugin/podamibe-customize-comment-form/reviews#new-post' target='_blank' title='" . __('Leave a review', 'pn-sfwarea') . "'><i class='ml-stars'><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg><svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg></i></a>";
		
			return $meta;
		}


  	} // pccf class ends here

	PCCF_Class::_get_instance();

} // pccf class check ends here