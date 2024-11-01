<?php
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.0
/**
 *
 * Class field background
 *
 * @since   1.0     2019-03-05  Release
 * @since   1.6     2019-12-02  The fields were wrapped in blocks
 * @since   1.6.33  2020-02-19  - BLEND_MODE & Auto Attributes added
 *                              - Aggregate Default value
 *                              - Show and hide fields dynamically
 *
 */
if( ! class_exists( 'PF_Field_background' ) ) {
class PF_Field_background extends PF_classFields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
        parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

        $args = wp_parse_args( $this->field, array(
            'background_color'              => true,
            'background_image'              => true,
            'background_position'           => true,
            'background_repeat'             => true,
            'background_attachment'         => true,
            'background_size'               => true,
            'background_origin'             => false,
            'background_clip'               => false,
            'background_blend_mode'         => false,
            'background_gradient'           => false,
            'background_gradient_color'     => true,
            'background_gradient_direction' => true,
            'background_image_preview'      => true,
            'background_auto_attributes'    => false,
            'background_image_library'      => 'image',
            'background_image_placeholder'  => esc_html__( 'No background selected', 'pf' ),
        ) );

        $default_values = array(
            'background-color'              => '',
            'background-image'              => '',
            'background-position'           => '',
            'background-repeat'             => '',
            'background-attachment'         => '',
            'background-size'               => '',
            'background-origin'             => '',
            'background-clip'               => '',
            'background-blend-mode'         => '',
            'background-gradient-color'     => '',
            'background-gradient-direction' => '',
        );

        $default_values = ( ! empty( $this->field['default'] ) ) ? wp_parse_args( $this->field['default'], $default_values ) : $default_values;

        $this->value = wp_parse_args( $this->value, $default_values );

        echo $this->field_before();

        echo '<div class="pf--blocks">';

        // Background Color
        if( ! empty( $args['background_color'] ) ) {

            echo '<div class="pf--block pf--color">';
            echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="pf--title">From</div>' : '';

            PF::field( array(
                'id'      => 'background-color',
                'type'    => 'color',
                'default' => $default_values['background-color'],
            ), $this->value['background-color'], $this->field_name(), 'field/background' );

            echo '</div>';

        }

        // Background Gradient Color
        if( ! empty( $args['background_gradient_color'] ) && ! empty( $args['background_gradient'] ) ) {

            echo '<div class="pf--block pf--bggradient">';
            echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="pf--title">To</div>' : '';

            PF::field( array(
            'id'      => 'background-gradient-color',
            'type'    => 'color',
            'default' => $default_values['background-gradient-color'],
            ), $this->value['background-gradient-color'], $this->field_name(), 'field/background' );

            echo '</div>';

        }

        // Background Gradient Direction
        if( ! empty( $args['background_gradient_direction'] ) && ! empty( $args['background_gradient'] ) ) {

            echo '<div class="pf--block pf--gradient">';
            echo ( ! empty( $args['background_gradient'] ) ) ? '<div class="pf--title">Direction</div>' : '';

            PF::field( array(
            'id'          => 'background-gradient-direction',
            'type'        => 'select',
            'options'     => array(
                ''          => 'Gradient Direction',
                'to bottom' => '&#8659; top to bottom',
                'to right'  => '&#8658; left to right',
                '135deg'    => '&#8664; corner top to right',
                '-135deg'   => '&#8665; corner top to left',
            ),
            ), $this->value['background-gradient-direction'], $this->field_name(), 'field/background' );

            echo '</div>';

        }

        echo '</div>';

        // echo '<div class="clear"></div>';

        // Background Image
        if( ! empty( $args['background_image'] ) ) {

            echo '<div class="pf--blockk pf--background-image">';

            PF::field( array(
            'id'          => 'background-image',
            'type'        => 'media',
            'class'       => 'pf-assign-field-background',
            'library'     => $args['background_image_library'],
            'preview'     => $args['background_image_preview'],
            'placeholder' => $args['background_image_placeholder'],
            'attributes'  => array( 'data-depend-id' => $this->field['id'] ),
            ), $this->value['background-image'], $this->field_name(), 'field/background' );

            echo '</div>';

        }

        $auto_class   = ( ! empty( $args['background_auto_attributes'] ) ) ? ' pf--auto-attributes' : '';
        $hidden_class = ( ! empty( $args['background_auto_attributes'] ) && empty( $this->value['background-image']['url'] ) ) ? ' pf--attributes-hidden' : '';

        echo '<div class="pf--background-attributes'. $auto_class . $hidden_class .'">';

        // Background Position
        if( ! empty( $args['background_position'] ) ) {

            PF::field( array(
            'id'              => 'background-position',
            'type'            => 'select',
            'options'         => array(
                ''              => esc_html__('Background Position','pf'),
                'left top'      => esc_html__('Left Top','pf'),
                'left center'   => esc_html__('Left Center','pf'),
                'left bottom'   => esc_html__('Left Bottom','pf'),
                'center top'    => esc_html__('Center Top','pf'),
                'center center' => esc_html__('Center Center','pf'),
                'center bottom' => esc_html__('Center Bottom','pf'),
                'right top'     => esc_html__('Right Top','pf'),
                'right center'  => esc_html__('Right Center','pf'),
                'right bottom'  => esc_html__('Right Bottom','pf'),
            ),
            ), $this->value['background-position'], $this->field_name(), 'field/background' );

        }

        // Background Repeat
        if( ! empty( $args['background_repeat'] ) ) {

            PF::field( array(
            'id'          => 'background-repeat',
            'type'        => 'select',
            'options'     => array(
                ''          => esc_html__('Background Repeat','pf'),
                'repeat'    => esc_html__('Repeat','pf'),
                'no-repeat' => esc_html__('No Repeat','pf'),
                'repeat-x'  => esc_html__('Repeat Horizontally','pf'),
                'repeat-y'  => esc_html__('Repeat Vertically','pf'),
            ),
            ), $this->value['background-repeat'], $this->field_name(), 'field/background' );


        }

        // Background Attachment
        if( ! empty( $args['background_attachment'] ) ) {

            PF::field( array(
            'id'       => 'background-attachment',
            'type'     => 'select',
            'options'  => array(
                ''       => esc_html__('Background Attachment', 'pf'),
                'scroll' => esc_html__('Scroll', 'pf'),
                'fixed'  => esc_html__('Fixed', 'pf'),
            ),
            ), $this->value['background-attachment'], $this->field_name(), 'field/background' );

        }

        // Background Size
        if( ! empty( $args['background_size'] ) ) {

            PF::field( array(
            'id'        => 'background-size',
            'type'      => 'select',
            'options'   => array(
                ''        => esc_html__('Background Size', 'pf'),
                'cover'   => esc_html__('Cover', 'pf'),
                'contain' => esc_html__('Contain', 'pf'),
            ),
            ), $this->value['background-size'], $this->field_name(), 'field/background' );

        }

        // Background Origin
        if( ! empty( $args['background_origin'] ) ) {

            PF::field( array(
            'id'            => 'background-origin',
            'type'          => 'select',
            'options'       => array(
                ''            => esc_html__('Background Origin', 'pf'),
                'padding-box' => esc_html__('Padding Box', 'pf'),
                'border-box'  => esc_html__('Border Box', 'pf'),
                'content-box' => esc_html__('Content Box', 'pf'),
            ),
            ), $this->value['background-origin'], $this->field_name(), 'field/background' );

        }

        // Background Clip
        if( ! empty( $args['background_clip'] ) ) {

            PF::field( array(
            'id'            => 'background-clip',
            'type'          => 'select',
            'options'       => array(
                ''            => esc_html__('Background Clip', 'pf'),
                'border-box'  => esc_html__('Border Box', 'pf'),
                'padding-box' => esc_html__('Padding Box', 'pf'),
                'content-box' => esc_html__('Content Box', 'pf'),
            ),
            ), $this->value['background-clip'], $this->field_name(), 'field/background' );

        }

        // Background Blend Mode
        if( ! empty( $args['background_blend_mode'] ) ) {

            PF::field( array(
                'id'            => 'background-blend-mode',
                'type'          => 'select',
                'options'       => array(
                    ''            => esc_html__('Background Blend Mode', 'pf'),
                    'normal'      => esc_html__('Normal', 'pf'),
                    'multiply'    => esc_html__('Multiply', 'pf'),
                    'screen'      => esc_html__('Screen', 'pf'),
                    'overlay'     => esc_html__('Overlay', 'pf'),
                    'darken'      => esc_html__('Darken', 'pf'),
                    'lighten'     => esc_html__('Lighten', 'pf'),
                    'color-dodge' => esc_html__('Color Dodge', 'pf'),
                    'saturation'  => esc_html__('Saturation', 'pf'),
                    'color'       => esc_html__('Color', 'pf'),
                    'luminosity'  => esc_html__('Luminosity', 'pf'),
                ),
            ), $this->value['background-blend-mode'], $this->field_name(), 'field/background' );

        }

        echo '</div>';

        echo $this->field_after();

    }

    public function output() {

        $output    = '';
        $bg_image  = array();
        $important = ( ! empty( $this->field['output_important'] ) ) ? '!important' : '';
        $element   = ( is_array( $this->field['output'] ) ) ? join( ',', $this->field['output'] ) : $this->field['output'];

        // Background image and gradient
        $background_color        = ( ! empty( $this->value['background-color']              ) ) ? $this->value['background-color']              : '';
        $background_gd_color     = ( ! empty( $this->value['background-gradient-color']     ) ) ? $this->value['background-gradient-color']     : '';
        $background_gd_direction = ( ! empty( $this->value['background-gradient-direction'] ) ) ? $this->value['background-gradient-direction'] : '';
        $background_image        = ( ! empty( $this->value['background-image']['url']       ) ) ? $this->value['background-image']['url']       : '';


        if( $background_color && $background_gd_color ) {
            $gd_direction   = ( $background_gd_direction ) ? $background_gd_direction .',' : '';
            $bg_image[] = 'linear-gradient('. $gd_direction . $background_color .','. $background_gd_color .')';
        }

        if( $background_image ) {
            $bg_image[] = 'url('. $background_image .')';
        }

        if( ! empty( $bg_image ) ) {
            $output .= 'background-image:'. implode( ',', $bg_image ) . $important .';';
        }

        // Common background properties
        $properties = array( 'color', 'position', 'repeat', 'attachment', 'size', 'origin', 'clip', 'blend-mode' );

        foreach( $properties as $property ) {
            $property = 'background-'. $property;
            if( ! empty( $this->value[$property] ) ) {
                $output .= $property .':'. $this->value[$property] . $important .';';
            }
        }

        if( $output ) {
            $output = $element .'{'. $output .'}';
        }

        $this->parent->output_css .= $output;

        return $output;

    }

}
}
