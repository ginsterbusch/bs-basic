<?php
/**
 * Theme class
 */
 
 

class bootstrapBasicTheme {
	var $strAssetsUri;
	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 * @type object
	 */
	protected static $instance = NULL;
	
	
	function __construct() {
		$this->init_theme();
		
		
		
	}
	
	function init_theme() {
		$this->strAssetsUri = get_template_directory_uri() . '/assets/';
		$this->strTimthumbURL = $this->strAssetsUri . 'tools/timthumb/timthumb.php';
		
		// original initial setup
		$this->bootstrapBasicSetup();
		
		// init scripts
		add_action('wp_enqueue_scripts', array( $this, 'register_js'), 5 ); // earlier registration, BEFORE later init
		add_action('wp_enqueue_scripts', array( $this, 'register_css'), 5 ); // earlier registration, BEFORE later init
		
		
		add_action('wp_enqueue_scripts', array( $this, 'init_css' ), 10 );
		add_action('wp_enqueue_scripts', array( $this, 'init_js' ), 10 );
		
		
		
		// register sidebars and widgets
		add_action('widgets_init', array( $this, 'bootstrapBasicWidgetsInit') );
	}
	
	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @since   04/05/2013
	 * @return  object of this class
	 */
	public static function get_instance() {

		NULL === self::$instance and self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Setup theme and register support wp features.
	 */
	function bootstrapBasicSetup() 
	{
		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * 
		 * copy from underscores theme
		 */
		load_theme_textdomain('bootstrap-basic', get_template_directory() . '/languages');
		
		// add theme support post and comment automatic feed links
		add_theme_support('automatic-feed-links');
		
		// enable support for post thumbnail or feature image on posts and pages
		add_theme_support('post-thumbnails');
		
		// add support menu
		register_nav_menus(array(
			'primary' => __('Primary Menu', 'bootstrap-basic'),
		));
		
		// add post formats support
		add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));
		
		// add support custom background
		add_theme_support(
			'custom-background', 
			apply_filters(
				'bootstrap_basic_custom_background_args', 
				array(
					'default-color' => 'ffffff', 
					'default-image' => ''
				)
			)
		);
	}// bootstrapBasicSetup



	/**
	 * Register widget areas
	 */
	function bootstrapBasicWidgetsInit() 
	{
		register_sidebar(array(
			'name'          => __('Header right', 'bootstrap-basic'),
			'id'            => 'header-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));
		
		register_sidebar(array(
			'name'          => __('Navigation bar right', 'bootstrap-basic'),
			'id'            => 'navbar-right',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		));
		
		register_sidebar(array(
			'name'          => __('Sidebar left', 'bootstrap-basic'),
			'id'            => 'sidebar-left',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));
		
		register_sidebar(array(
			'name'          => __('Sidebar right', 'bootstrap-basic'),
			'id'            => 'sidebar-right',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));
		
		register_sidebar(array(
			'name'          => __('Footer left', 'bootstrap-basic'),
			'id'            => 'footer-left',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));
		
		register_sidebar(array(
			'name'          => __('Footer middle', 'bootstrap-basic'),
			'id'            => 'footer-middle',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));
		
		register_sidebar(array(
			'name'          => __('Footer right', 'bootstrap-basic'),
			'id'            => 'footer-right',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		));
	}// bootstrapBasicWidgetsInit



	/**
	 * Enqueue scripts & styles
	 */
	function register_js() {
		/**
		 * @see http://wordpress.org/support/topic/wp_register_style-conditional-comments
		 */
		
		//wp_register_script( 'html5-shiv-script', $this->strAssetsUri . '/js/vendor/html5shiv.min.js'
		
		$strAssetsUri = get_template_directory_uri() . '/assets';
		
		wp_register_script( 'headjs-core-css3', $strAssetsUri . '/js/vendor/head.core.css3.min.js' ); // solves all troubles .. combines modernizt with html5shiv with js-based media queries and a fuckload of other helpers ;)
		
		wp_register_script( 'bootstrap-script', $strAssetsUri . '/js/vendor/bootstrap.min.js', array('jquery', 'headjs-core-css3') );
		
		wp_register_script( 'smartmenus', $strAssetsUri . '/js/vendor/smartmenus/jquery.smartmenus.min.js', array('jquery', 'bootstrap-script') );
		wp_register_script( 'smartmenus-bootstrap', $strAssetsUri .  '/js/vendor/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.min.js', array('smartmenus') );
		
		wp_register_script( 'smartmenus-bootstrap-unminified', $strAssetsUri .  '/js/vendor/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.js', array('smartmenus') );
		
	}
	
	
	function init_js() {
		$strAssetsUri = get_template_directory_uri() . '/assets';
		//wp_enqueue_script('headjs-core-css3' ); // solves all troubles .. combines modernizt with html5shiv with js-based media queries and a fuckload of other helpers ;)
		

		//wp_enqueue_script('jquery');
		
		wp_enqueue_script('main-script', get_stylesheet_directory_uri() . '/assets/js/main.js', array('bootstrap-script') );
		
	}

		/**
		 * Add a font to the Google Font loading queue
		 * 
		 * @param string $font_name		The font name.
		 * @param string $sizes			Eg. 400, 600, 700-italic. Optional. Defaults to 400.
		 */

		function add_google_font( $strFont = '', $arrSizes = array() ) {
			if( !empty( $strFont ) ) {
				$strFontParam = str_replace(' ', '+', trim($strFont));
				if( !empty( $arrSizes ) ) {
					$strFontParam .= ':';
					
					foreach( $arrSizes as $iCount => $strFontSize ) {
						if( $iCount > 0 ) {
							$strFontParam .= ',';
						}
						
						$strFontParam .= str_replace('-', '', $strFontSize);
					}
				}
				
				// automatically overwrites already set up fonts of the same name ... for now		
				$this->arrGoogleFonts[$strFont] = $strFontParam;
				
			}
		}

		function init_google_fonts() {
			if( isset($this->arrGoogleFonts) && is_array( $this->arrGoogleFonts) ) {
				wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=' .  implode('|', $this->arrGoogleFonts ) );
			}
		}
		
	function register_css() {
		$strAssetsUri = get_template_directory_uri() . '/assets';
		$strBaseCSSURL = $strAssetsUri . '/css/bootstrap.min.css';	
		
		/**
		 * Option: Replace base bootstrap CSS file with one provided in the child theme directory, to enable themeing (eg. using Bootstrap themes from bootswatch.com)
		 */
		if( file_exists( get_stylesheet_directory() . '/assets/css/bootstrap.min.css' ) ) {
			$strBaseCSSURL = get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css';
		}
		
		wp_register_style( 'bootstrap-style', $strBaseCSSURL );
		
		
		
		wp_register_style( 'smartmenus-bootstrap-style', $strAssetsUri . '/js/vendor/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.css', array('bootstrap-style') );
		
	}
	
	/**
	 * Check whether a custom version of the given file name + path is set up or not. If it is, return the custom path, else the regular one.
	 * 
	 */

	function get_custom_childtheme_url( $strFile = '' ) {
		$return = '';
		
		if( !empty( $strFile ) ) {
			$return = get_template_directory_uri() . $strFile;
		
			if( is_child_theme() && file_exists( get_stylesheet_directory() . $strFile ) ) {
				$return = get_stylesheet_directory_uri() . $strFile;
			}
		}
		
		return $return;
	}

	function init_css() {
		$strAssetsUri = get_template_directory_uri() . '/assets';
		
		// properly enqueue google fonts
		$this->init_google_fonts();		
		
		wp_enqueue_style('bootstrap-theme-style', $this->get_custom_childtheme_url( '/assets/css/bootstrap-theme.min.css' ), array('google-fonts', 'bootstrap-style') );
		
		wp_enqueue_style('fontawesome-style', $strAssetsUri . '/css/font-awesome.min.css');
		
		wp_enqueue_style('main-style', $this->get_custom_childtheme_url( '/assets/css/main.css' ), array('bootstrap-style') );
		
		
		wp_enqueue_style('bootstrap-basic-style', ( get_template_directory_uri() != get_stylesheet_directory_uri() ? get_template_directory_uri() . '/style.css' : get_stylesheet_uri() ), array('main-style') );
	}
	
	
	public static function get_sidebar_count( $arrSidebars = array() ) {
		$return = false;
		
		if( !empty( $arrSidebars ) ) {
			$iCount = 0;
			foreach( $arrSidebars as $strSidebarID ) {
				if( is_active_sidebar( $strSidebarID ) ) {
					$iCount++;
				}
			}
			$return = $iCount;
		}
		
		return $return;
	}
	
	/**
	 * Original call
	 */ 
	/*
	function bootstrapBasicEnqueueScripts() {
		
		$strAssetsUri = get_template_directory_uri() . '/assets/';
		
		//__debug( $strAssetsUri, 'assets_uri' );
		
		wp_enqueue_style('bootstrap-basic-style', get_stylesheet_uri());
		
		wp_enqueue_style('bootstrap-style', $strAssetsUri . '/css/bootstrap.min.css');
		wp_enqueue_style('bootstrap-theme-style', $strAssetsUri . '/css/bootstrap-theme.min.css', array('bootstrap-style') );
		wp_enqueue_style('fontawesome-style', $strAssetsUri . '/css/font-awesome.min.css');
		wp_enqueue_style('main-style', $strAssetsUri . '/css/main.css', array('bootstrap-style') );
		
		wp_enqueue_script('modernizr-script', $strAssetsUri . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js');
		wp_enqueue_script('html5-shiv-script', $strAssetsUri . '/js/vendor/html5shiv.js');
		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrap-script', $strAssetsUri . '/js/vendor/bootstrap.min.js', array('jquery'));
		wp_enqueue_script('main-script', $strAssetsUri . '/js/main.js', array('bootstrap-script') );
	}// bootstrapBasicEnqueueScripts
	*/
}
