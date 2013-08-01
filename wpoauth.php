<?php
/**
 * Basic template class for setting up oAuth keys
 */
class WPOAuth {
	protected $option_name;
	protected $auth_url;
	protected $key;
	protected $secret;

	/**
	 * Setep connection information, and individual instance information like option names.
	 *
	 * @param string $url         OAuth authorization url
	 * @param string $key         OAuth application key
	 * @param string $secret      OAuth application secret key
	 * @param string $option_name Option name for auth tokens to be stored under
	 */
	public function __construct($url, $key, $secret, $option_name = 'wp_oauth_token'){
		$this->auth_url = $url;
		$this->key = $key;
		$this->secret = $secret;
		$this->option_name = $option_name;
		add_action('admin_menu', array($this, 'add_oauth_menu'));
		add_action('admin_init', array($this, 'get_token'));
	}

	/**
	 * Setup OAuth page that each instance of the class adds it's request for credentials to
	 */
	public function add_oauth_menu(){
		add_options_page('OAuth Applications', 'OAuth Applications', 'edit_users', 'wpoauth-applications', array( $this, 'base_applications_page' ) );
	}

	/**
	 * Output main applications page where keys can be added for each application
	 * that is instantiated.
	 * @return void
	 */
	public function base_applications_page(){
		?>
		<div class="wrap">
			<h2>WP OAuth Applications</h2>
			<form method="post" action="<?php echo admin_url( 'options.php' ); ?>">
				<?php settings_fields('wpoauth-applications'); ?>
				<?php do_settings_sections('wpoauth-applications'); ?>
			</form>
		</div>
		<?php
	}

	public function register_settings_section(){

	}

	/**
	 * Build the auth url to be added to the auth button.
	 *
	 * @return string Auth url for the service
	 */
	private function build_auth_url(){
		return add_query_arg(array(
			'response_type' => 'code',
			'client_id' => $this->client_id,
			'redirect_uri' => admin_url('options-general.php'),
		), $this->auth_url);
	}

	public function get_token(){}

}