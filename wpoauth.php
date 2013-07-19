<?php
/**
 * Basic template class for setting up oAuth keys
 */
class WP_oAuth {
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
		add_options_page('OAuth Applications', 'OAuth Applications', 'edit_users', 'oauth-applications', 'base_applications_page');
	}

	public function base_applications_page(){}


	private function build_auth_url(){
		return add_query_arg(array(
			'response_type' = 'code',
			'client_id' = $this->client_id,
			'redirect_uri' = admin_url('options-general.php'),
		), $this->auth_url);
	}

	public function get_token(){

}