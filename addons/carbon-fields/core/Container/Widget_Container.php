<?php

namespace Carbon_Fields\Container;

/**
 * Widget container class
 */
class Widget_Container extends Container {

	/**
	 * Create a new widget
	 *
	 * @param string $id Unique ID of the widget
	 **/
	public function __construct( $id ) {
		// Reset the registered fields array, this is required so we can have fields with same names
		self::$registered_field_names = array();

		$this->id = $id;

		add_action( 'admin_footer', array( $this, 'admin_hook_scripts' ) );
		add_action( 'admin_footer', array( $this, 'admin_hook_styles' ) );
	}

	/**
	 * Perform instance initialization after calling setup()
	 **/
	public function init() {
		$this->_attach();
		$this->render();

		return $this;
	}

	/**
	 * Returns an array that holds the container data, suitable for JSON representation.
	 * This data will be available in the Underscore template and the Backbone Model.
	 *
	 * @param bool $load  Should the value be loaded from the database or use the value from the current instance.
	 * @return array
	 */
	public function to_json( $load ) {
		return parent::to_json( false );
	}

	/**
	 * Output the container markup
	 **/
	public function render() {
		include \Carbon_Fields\DIR . '/templates/Container/widget.php';
	}

	/**
	 * Perform checks whether the container should be attached during the current request
	 *
	 * @return bool True if the container is allowed to be attached
	 **/
	public function is_valid_attach() {
		$screen = get_current_screen();

		return $screen && $screen->id === 'widgets';
	}
}

