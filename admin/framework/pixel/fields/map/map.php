<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
if( ! class_exists( 'PF_Field_map' ) ) {
/**
 *
 * Class Field map
 *
 * @since   1.6.33  2020-02-19  Release
 *
 */
class PF_Field_map extends PF_classFields {

    public $version = '1.5.1';
    public $cdn_url = 'https://cdn.jsdelivr.net/npm/leaflet@';

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
        parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

        $args = wp_parse_args( $this->field, array(
            'placeholder'    => esc_html__( 'Search your address...', 'pf' ),
            'latitude_text'  => esc_html__( 'Latitude', 'pf' ),
            'longitude_text' => esc_html__( 'Longitude', 'pf' ),
            'address_field'  => '',
            'height'         => '',
        ) );

        $value = wp_parse_args( $this->value, array(
            'address'        => '',
            'latitude'       => '20',
            'longitude'      => '0',
            'zoom'           => '2',
        ) );

        $default_settings = array(
            'center'          => array( $value['latitude'], $value['longitude'] ),
            'zoom'            => $value['zoom'],
            'scrollWheelZoom' => false,
        );

        $settings = ( ! empty( $this->field['settings'] ) ) ? $this->field['settings'] : array();
        $settings = wp_parse_args( $settings, $default_settings );
        $encoded  = htmlspecialchars( json_encode( $settings ) );

        $style_attr  = ( ! empty( $args['height'] ) ) ? ' style="min-height:'. $args['height'] .';"' : '';
        $placeholder = ( ! empty( $args['placeholder'] ) ) ? array( 'placeholder' => $args['placeholder'] ) : '';

        echo $this->field_before();

        if( empty( $args['address_field'] ) ) {
            echo '<div class="pf--map-search">';
            echo '<input type="text" name="'. $this->field_name('[address]') .'" value="'. $value['address'] .'"'. $this->field_attributes( $placeholder ) .' />';
            echo '</div>';
        } else {
            echo '<div class="pf--address-field" data-address-field="'. $args['address_field'] .'"></div>';
        }

        echo '<div class="pf--map-osm-wrap"><div class="pf--map-osm" data-map="'. $encoded .'"'. $style_attr .'></div></div>';

        echo '<div class="pf--map-inputs">';

        echo '<div class="pf--map-input">';
        echo '<label>'. $args['latitude_text'] .'</label>';
        echo '<input type="text" name="'. $this->field_name('[latitude]') .'" value="'. $value['latitude'] .'" class="pf--latitude" />';
        echo '</div>';

        echo '<div class="pf--map-input">';
        echo '<label>'. $args['longitude_text'] .'</label>';
        echo '<input type="text" name="'. $this->field_name('[longitude]') .'" value="'. $value['longitude'] .'" class="pf--longitude" />';
        echo '</div>';

        echo '</div>';

        echo '<input type="hidden" name="'. $this->field_name('[zoom]') .'" value="'. $value['zoom'] .'" class="pf--zoom" />';

        echo $this->field_after();

    }

    public function enqueue() {

        if( ! wp_script_is( 'pf-leaflet' ) ) {
            wp_enqueue_script( 'pf-leaflet', $this->cdn_url . $this->version .'/dist/leaflet.js', array( 'pf' ), $this->version, true );
        }

        if( ! wp_style_is( 'pf-leaflet' ) ) {
            wp_enqueue_style( 'pf-leaflet', $this->cdn_url . $this->version .'/dist/leaflet.css', array(), $this->version );
        }

        if( ! wp_script_is( 'jquery-ui-autocomplete' ) ) {
            wp_enqueue_script( 'jquery-ui-autocomplete' );
        }

    }

}
}
