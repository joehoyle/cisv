<?php

class WP_Wufoo_Integration_Control {
	
	public $model;
	public $view;

	public function __construct()
	{
		$this->model = new WP_Wufoo_Integration_Model; 
		$this->view = new WP_Wufoo_Integration_View; 
		$this->view->model = &$this->model;
		add_action('admin_init', array(&$this->view, 'event_admin_init'));
		add_action('init', array(&$this->model, 'event_init'));
		add_action('widgets_init', array(&$this, 'event_widgets_init'));
		add_shortcode('wufoo-form', array(&$this->view, 'shortcode_wufoo_form'));
		
		if ( is_admin() ) {
			add_action('admin_head', array(&$this->view, 'event_admin_head'));
			add_action('wp_ajax_wufoo-integration-json', array(&$this, 'wp_ajax_wufoo_integration_json'));

			add_filter('mce_external_plugins', array(&$this, 'filter_mce_external_plugins'));
			add_filter('mce_buttons', array(&$this, 'filter_mce_buttons') );
		}
	}

	public function event_widgets_init()
	{
		// register_widget('Wufoo_Integration_Widget'); 
	}

	public function filter_mce_buttons( $buttons = array() )
	{
		$buttons[] = 'WufooIntegration';
		return $buttons;
	}

	public function filter_mce_external_plugins( $plugins = array() )
	{
		$plugins['WufooIntegration'] = $this->view->client_dir_url . 'js/wufoo-tinymce-plugin.js';
		return $plugins;
	}

	public function handle_json_request( $request = null, $print = true )
	{
		if ( empty( $request->method ) ) {
			return;	
		}

		$id = isset( $request->id ) ? (string) $request->id : null;

		switch( $request->method ) :
			case 'wufoointegration.getDialog' :
				$api = $this->model->get_api();
				$account = $this->model->get_account();
				if ( empty( $api ) || empty( $account ) ) {
					$request->method = 'wufoointegration.getAPIForm';
					return $this->handle_json_request( $request, $print );
				} else {
					$request->method = 'wufoointegration.getFormsList';
					return $this->handle_json_request( $request, $print );
				}
			break;
			
			case 'wufoointegration.getAPIForm' :
				$api = $this->model->get_api();
				$account = $this->model->get_account();
				$result = array(	
					'buttons' => array(
						array(
							'class' => 'cancel',
							'value' => esc_js( __('Cancel', 'wufoo-integration') ),
						),
						array(
							'class' => 'save-data',
							'value' => esc_js( __('Save', 'wufoo-integration') ),
						),
					),
					'message' => $this->view->get_api_form( $account, $api ),
				);
			break;

			case 'wufoointegration.getFormsList' :
				$message = $this->view->get_forms_dropdown();

				if ( is_wp_error( $message ) ) {
					$error = new WP_Error(
						$message->get_error_code(),
						sprintf(
							__('<p>Oops!  We tried to get your forms but got the following error message instead:</p><p>%s</p>', 'wufoo-integration'),
							$message->get_error_message()
						)
					);
					
					if ( $print ) :
						echo $this->view->get_json_error(
							$error,
							$id,
							array(
								'buttons' => array(
									array(
										'class' => 'ok',
										'value' => esc_js( __('OK', 'wufoo-integration') ),
									),
									array(
										'class' => 'edit-data',
										'value' => esc_js( __('Edit Account Info', 'wufoo-integration') ),
									),
								)
							)
						);
						exit;
					endif;
					return $error;
				}
				
				$result = array(	
					'buttons' => array(
						array(
							'class' => 'cancel',
							'value' => esc_js( __('Close', 'wufoo-integration') ),
						),
						array(
							'class' => 'edit-data',
							'value' => esc_js( __('Edit Account Info', 'wufoo-integration') ),
						),
						array(
							'class' => 'insert-form',
							'value' => esc_js( __('Insert Form', 'wufoo-integration') ),
						),
					),
					'message' => $message,
				);
			break;

			case 'wufoointegration.saveData' :
				if ( isset( $request->params ) && isset( $request->params->data ) ) {
					$saved = $this->model->save_data( $request->params->data );
					if ( $saved ) {
						$result = array(
							'buttons' => array(
								array(
									'class' => 'cancel',
									'value' => esc_js( __('Close', 'wufoo-integration') ),
								),
								array(
									'class' => 'retreive-forms',
									'value' => esc_js( __('Retrieve Forms', 'wufoo-integration') ),
								),
							),
							'message' => __('Your connection information has been saved!', 'wufoo-integration')
						);
					}
				}
			break;
		endswitch;

		if ( $print && ! empty( $result ) ) :
			echo $this->view->get_json_result(
				$result,
				$id
			);
			exit;
		endif;

		return $result;
	}

	public function wp_ajax_wufoo_integration_json()
	{
		$request = $_POST['json-rpc-request'];
		if ( get_magic_quotes_gpc() ) {
			$request = stripslashes( $request );
		}
		$decoded = json_decode( $request );	

		if ( null !== $decoded ) {
			$this->handle_json_request( $decoded );
		}
	}
}

class WP_Wufoo_Integration_Model {
	
	protected $_allowed_data;

	public function __construct()
	{
		$this->_allowed_data = array(
			'wufoo-integration-api' => array(
				'get' => array(&$this, 'get_api'),
				'set' => array(&$this, 'set_api'),
				'cap' => 'manage_options',
			),
			'wufoo-integration-account' => array( 
				'get' => array(&$this, 'get_account'),
				'set' => array(&$this, 'set_account'),
				'cap' => 'manage_options',
			),
		);
	}

	public function event_init()
	{
		register_post_type('wufoo-form', array(
			'label' => __('Wufoo Form', 'wufoo-integration'),
			'singular_label' => __('Wufoo Form', 'wufoo-integration'),
			'public' => false,
			'show_ui' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => false,
			'query_var' => false,
		));
	}

	public function save_data( $data = null )
	{
		$values = get_object_vars( $data );
		$saved = false;
		if ( 
			isset( $values['wufoo-integration-nonce'] ) && 
			wp_verify_nonce( $values['wufoo-integration-nonce'], 'wufoo-integration-nonce' ) 
		) {
			foreach( $this->_allowed_data as $key => $data_meta ) {
				if ( 
					isset( $values[ $key ] ) &&
					current_user_can( $data_meta[ 'cap' ] )
				) {
					call_user_func( $data_meta['set'], $values[ $key ] );
					$saved = true;
				}
			}
		}

		return $saved;
	}

	public function get_account()
	{
		$account = get_option('wufoo-integration-account-name');
		if ( empty( $account ) ) {
			return false;
		} else {
			return $account;
		}
	}

	public function set_account( $value = '' )
	{
		return update_option('wufoo-integration-account-name', $value );
	}

	public function get_api()
	{
		$api = get_option('wufoo-integration-api-key');
		if ( empty( $api ) ) {
			return false;
		} else {
			return $api;
		}
	}

	public function set_api( $value = '' )
	{
		return update_option('wufoo-integration-api-key', $value );
	}

	public function get_form( $hash = '', $type = 'simple' )
	{
		$account = $this->get_account();
		$api = $this->get_api();
		
		if ( empty( $account ) || empty( $api ) ) {
			return false;
		}

		
	}

	public function get_forms( $account = '', $api = '' )
	{
		if ( empty( $account ) || empty( $api ) ) {
			return array();
		}
	
		$response = wp_remote_get(
			$this->_get_forms_url( $account ),
			array(
				'headers' => $this->_get_auth_header( $api )
			)
		);
		
		$form_data = array();
		if ( is_wp_error( $response ) ) {
			return $response;
		} elseif ( ! empty( $response['body'] ) ) {
			$dom = new DOMDocument;
			try {
				$dom->loadXML( $response['body'] );	
				foreach( $dom->getElementsByTagname('Form') as $form ) {
					$hash = $form->getElementsByTagname('Hash') && $form->getElementsByTagname('Hash')->item(0) ? $form->getElementsByTagname('Hash')->item(0)->nodeValue : '';
					$name = $form->getElementsByTagname('Name') && $form->getElementsByTagname('Name')->item(0) ? $form->getElementsByTagname('Name')->item(0)->nodeValue : '';

					if ( ! empty( $hash ) ) {
						$form_data[ $hash ] = empty( $name ) ? sprintf(
							__('Form: %s', 'wufoo-integration'),
							$hash
						) : $name ;
					}
				}
			} catch( Exception $e ) {

			}
		}

		return $form_data;
	}

	protected function _get_auth_header( $api = '' )
	{
		$header = array(
			'Authorization' => 'Basic ' . base64_encode($api . ':footastic'),
		);

		return $header;
	}
	
	/**
	 * https://{subdomain}.wufoo.com/api/v3/forms.{xml|json}
	 */
	protected function _get_forms_url( $account = '' )
	{
		$url = sprintf(
			'https://%1$s.wufoo.com/api/v3/forms.xml',
			urlencode( $account )
		);

		return $url;
	}
}

class WP_Wufoo_Integration_View {

	public $client_dir_url;
	public $model;
	
	public function __construct()
	{
		$this->client_dir_url = plugin_dir_url( dirname( __FILE__ ) ) . 'client-files/';
	}

	public function event_admin_head()
	{
		?>
		<script type="text/javascript">
		// <![CDATA[
		if ( 'undefined' != typeof wufooWPadmin ) {
			wufooWPadmin.setOKText('<?php echo esc_js( __('OK', 'wufoo-integration') ); ?>');
			wufooWPadmin.setCloseLinkText('<?php echo esc_js( __('Close', 'wufoo-integration') ); ?>');
			wufooWPadmin.setEditorButtonText('<?php echo esc_js( __('Wufoo Form', 'wufoo-integration') ); ?>');
			wufooWPadmin.setupInit();
		}
		//]]>
		</script>
		<?php
	}

	public function event_admin_init()
	{
		wp_enqueue_script(
			'wufoo-integration-admin-js',
			$this->client_dir_url . 'js/wufoo-admin.js',
			null,
			'1.0'
		);
		
		wp_enqueue_style(
			'wufoo-integration-admin-css',
			$this->client_dir_url . 'css/wufoo-admin.css',
			null,
			'1.0'
		);
	}

	public function get_simple_form( $user = '', $hash = '' )
	{
		ob_start();
		?>
		<script type="text/javascript">var host = (("https:" == document.location.protocol) ? "https://secure." : "http://");document.write(unescape("%3Cscript src='" + host + "wufoo.com/scripts/embed/form.js' type='text/javascript'%3E%3C/script%3E"));</script>

		<script type="text/javascript">
		(function() {
			var myForm = new WufooForm();
			myForm.initialize({
				'userName':'<?php echo $user; ?>', 
				'formHash':'<?php echo esc_js( $hash ); ?>', 
				'autoResize':true});
			myForm.display();
		})();
		</script>
		<?php
		
		return ob_get_clean();
	}

	public function shortcode_wufoo_form( $attributes = array() )
	{
		if ( isset( $attributes['id'] ) ) {
			$type = isset( $attributes['type'] ) ? $attributes['type'] : '';
/*
			$data = $this->model->get_form( $attributes['id'], $type );

			if ( 'simple' == $attributes['type'] ) {
			*/
				$user = $this->model->get_account();
				return $this->get_simple_form( $user, $attributes['id'] );
				/*
			} else {

			}
			*/
		}
	}



	public function get_api_form( $account = '', $api = false )
	{
		$message = '';

		ob_start();
		?>
		<input type="hidden" name="wufoo-integration-nonce" id="wufoo-integration-nonce" value="<?php echo esc_attr( wp_create_nonce('wufoo-integration-nonce') ); ?>" />

		<h3><?php _e('Wufoo Account Subdomain', 'wufoo-integration'); ?></h3>
		<p><?php
			_e('Log into Wufoo, and visit the "Account" tab. Enter the gold, underlined subdomain (http://<span class="example-url">thistext</span>.wufoo.com).', 'wufoo-integration-account');	
		?></p>
		<p id="wufoo-email-incorrect" class="wufoo-email-incorrect wufoo-email-incorrect-inactive">
			<?php _e('Hmm.  That looks a lot like an email address, which won\'t work.  You need to enter your Wufoo subdomain, like <span class="example-url">thistext</span> in the example above.', 'wufoo-integration'); ?>
		</p>
		<input class="wufoo-integration-input" name="wufoo-integration-account" id="wufoo-integration-account" value="<?php echo esc_attr( $account ); ?>" />
		
		<h3><?php _e('Wufoo API Key', 'wufoo-integration'); ?></h3>
		<?php 

		if ( empty( $api ) ) :
		/*
			echo '<p>' . sprintf(
				__('It looks like you\'re missing a <a href="%1$s" target="_blank">Wufoo API key</a>.  You can click <a href="%1$s" target="_blank">here</a> to get one from your Wufoo account.', 'wufoo-integration'),
				'http://wufoo.com/'
			) . '</p>';
			*/
			
			echo '<p>' . __('Find your API key under the &ldquo;Forms&rdquo; tab by clicking &ldquo;Code&rdquo; from the options under one of your forms then &ldquo;API Information&rdquo; button near the top right corner.', 'wufoo-integration') . '</p>';
		endif;
		?>
		<input class="wufoo-integration-input" name="wufoo-integration-api" id="wufoo-integration-api" value="<?php echo esc_attr( $api ); ?>" />
		<?php
		
		$message .= "\n" . ob_get_clean() . "\n";

		return $message;
	}

	public function get_forms_dropdown()
	{
		$message = '';
		$account = $this->model->get_account();
		$api = $this->model->get_api();
		if ( empty( $account ) || empty( $api ) ) {
			$message .= '<p>' . sprintf(
				__('You seem to be missing Wufoo account information. <a href="%1$s" class="edit-data">Click here</a> to update your data.'),
				'#'
			) . '</p>';
		}
		$forms = $this->model->get_forms( $account, $api );
		if ( is_wp_error( $forms ) ) {
			return $forms;
		}

		if ( empty( $forms ) ) {
			$message .= '<p>' . sprintf(
				__('You don\'t seem to have any forms. Go <a href="%1$s" target="_blank">create one</a>!'),
				'http://wufoo.com/'
			) . '</p>';
		} else {
			ob_start();
			?>
			<select name="wufoo-integration-form-list" id="wufoo-integration-form-list">
				<option value=""><?php _e('Select a form', 'wufoo-integration'); ?></option>
				<?php foreach( (array) $forms as $hash => $name ) : ?>
				<option value="<?php echo esc_attr( $hash ); ?>"><?php echo $name; ?></option>
				<?php endforeach; ?>
			</select>

			<ul class="wufoo-integration-insert-options">
				<li>
					<input type="radio" id="wufoo-integration-insert-simple" name="wufoo-integration-insert-type" value="simple" checked="checked" />
					<label><?php _e('Easy Insert', 'wufoo-integration'); ?></label>
				</li>
				<li>
					<input type="radio" class="disabled" id="wufoo-integration-insert-advanced" name="wufoo-integration-insert-type" value="advanced" disabled="disabled" />
					<label class="disabled"><?php _e('Advanced (Coming soon)', 'wufoo-integration'); ?></label>
				</li>
			</ul>
			<?php
			$message .= ob_get_clean();
		}

		return $message;
	}

	public function get_json_error( WP_Error $error, $id = null, $data = null )
	{
		$code = (int) $error->get_error_code();
		$message = $error->get_error_message();

		$error = array(
			'code' => $code,
			'message' => $message,
		);

		if ( ! empty( $data ) ) {
			$error['data'] = $data;
		}

		return json_encode( array(
			'jsonrpc' => '2.0',
			'error' => $error,
			'id' => $id,
		) );
	}

	public function get_json_result( $result = null, $id = null )
	{
		return json_encode( array(
			'jsonrpc' => '2.0',
			'result' => $result,
			'id' => $id,
		) );
	}
}

class Wufoo_Integration_Widget extends WP_Widget {

	public function Wufoo_Integration_Widget() {
		$widget_ops = array(
			'classname' => 'widget_wufoo_integration', 
			'description' => __( 'Add Wufoo forms to your sidebars!', 'wufoo-integration')
		);

		$this->WP_Widget('wufoo_integration', __('Wufoo Forms', 'wufoo-integration'), $widget_ops );
	}

	public function widget( $args, $instance ) {
		global $wp_wufoo_integration;

		extract($args);
		$title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;


		echo $after_widget;
	}

	public function form( $instance ) {
		global $wp_wufoo_integration;
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php _e('Title:'); ?> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>
		<?php
		$request = null;
		$request->id = '1234';
		$request->method = 'wufoointegration.getDialog';
		$data = $wp_wufoo_integration->handle_json_request( $request, false );

		if ( $data['message'] ) {
			echo $data['message'];
		}

		foreach( (array) $data['buttons'] as $button ) :
			?>
			<button class="<?php echo esc_attr( $button['class'] ); ?>"><?php echo $button['value']; ?></button>
			<?php
		endforeach;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}
}

function wp_wufoo_integration_load()
{
	global $wp_wufoo_integration;
	
	$wp_wufoo_integration = new WP_Wufoo_Integration_Control; 
}

add_action('plugins_loaded', 'wp_wufoo_integration_load');
