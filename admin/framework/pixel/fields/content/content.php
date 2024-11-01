<?php
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Class Field content
 *
 * @since 	1.0
 * @since	1.4.9	2019-07-12	Now it has the attributes before and after
 * @since	1.6.33	2020-02-19	Now in the content you can execute a function via callback
 *
 */
if( ! class_exists( 'PF_Field_content' ) ) {
class PF_Field_content extends PF_classFields {

	public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
		parent::__construct( $field, $value, $unique, $where, $parent );
	}

	public function render() {
		echo $this->field_before();
		echo ! empty( $this->field['callback'] ) ? call_user_func($this->field['callback']) : $this->field['content'];
		echo $this->field_after();
	}

}
}