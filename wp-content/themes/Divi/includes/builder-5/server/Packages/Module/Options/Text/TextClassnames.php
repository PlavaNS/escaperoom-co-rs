<?php
/**
 * Module: TextClassnames class.
 *
 * @package Divi
 * @since ??
 */

namespace ET\Builder\Packages\Module\Options\Text;

use ET\Builder\Framework\Breakpoint\Breakpoint;
use ET\Builder\Packages\ModuleUtils\ModuleUtils;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

/**
 * TextClassnames class.
 *
 * @since ??
 */
class TextClassnames {

	/**
	 * Get the text alignment classnames.
	 *
	 * This function generates classnames for aligning text based on the provided attributes.
	 *
	 * This function is equivalent of JS function:
	 * {@link /api/js/divi-module/functions/GetAlignmentClassnames getAlignmentClassnames} in
	 * `@divi/module` package.
	 *
	 * @since ??
	 *
	 * @param array $attr The text group attributes.
	 *
	 * @return string The generated classnames for text alignment.
	 *
	 * @example:
	 * ```php
	 * $attr = [
	 *     'text' => [
	 *         'breakpoint1' => [
	 *             'value' => [
	 *                 'orientation' => 'center'
	 *             ]
	 *         ],
	 *         'breakpoint2' => [
	 *             'value' => [
	 *                 'orientation' => 'right'
	 *             ]
	 *         ]
	 *     ]
	 * ];
	 *
	 * $classnames = self::get_alignment_classnames( $attr );
	 * // Returns: "et_pb_text_align_center et_pb_text_align_right-breakpoint2"
	 * ```
	 */
	public static function get_alignment_classnames( array $attr ): string {
		$classnames        = [];
		$valid_orientation = [ 'left', 'center', 'right', 'justify' ];
		$attr_text         = is_array( $attr ) && isset( $attr['text'] ) ? $attr['text'] : [];

		foreach ( $attr_text as $breakpoint => $attr_values ) {
			if ( ! isset( $attr_values['value']['orientation'] ) || ! in_array( $attr_values['value']['orientation'], $valid_orientation, true ) ) {
				continue;
			}

			$orientation = 'justify' === $attr_values['value']['orientation'] ? 'justified' : $attr_values['value']['orientation'];
			$suffix      = 'desktop' === $breakpoint ? '' : '-' . $breakpoint;

			$classnames[] = 'et_pb_text_align_' . $orientation . $suffix;
		}

		return implode( ' ', $classnames );
	}

	/**
	 * Get background layout classnames.
	 *
	 * This function retrieves the classnames for the background layout of a text group.
	 *
	 * This function is equivalent of JS function:
	 * {@link /api/js/divi-module/functions/GetBackgroundLayoutClassnames getBackgroundLayoutClassnames} in
	 * `@divi/module` package.
	 *
	 * @since ??
	 *
	 * @param array $attr          The text group attributes.
	 * @param bool  $skip_desktop  Optional. Whether to skip adding the desktop breakpoint classname. Default `false`.
	 * @param bool  $is_text_color Optional. Whether to render the text color classname. Default `false`.
	 *
	 * @return string The generated classnames separated by a space.
	 *
	 * @example:
	 * ```php
	 * self::get_background_layout_classnames( $attr );
	 * ```
	 *
	 * @example:
	 * ```php
	 * $attr = [
	 *     'text' => [
	 *         'desktop' => [
	 *             'value' => [
	 *                 'color' => 'dark',
	 *             ],
	 *         ],
	 *         'tablet' => [
	 *             'hover' => [
	 *                 'color' => 'light',
	 *             ],
	 *         ],
	 *     ],
	 * ];
	 *
	 * self::get_background_layout_classnames( $attr, true, true );
	 * ```
	 */
	public static function get_background_layout_classnames( array $attr, bool $skip_desktop = false, bool $is_text_color = false ): string {
		$classnames          = [];
		$valid_colors        = [ 'dark', 'light' ];
		$attr_text           = is_array( $attr ) && isset( $attr['text'] ) ? $attr['text'] : [];

		if ( empty( $attr_text ) ) {
			return '';
		}

		$base_breakpoint     = Breakpoint::get_base_breakpoint_name();
		$enabled_breakpoints = Breakpoint::get_enabled_breakpoint_names();
		$output_breakpoints  = array_values(
			array_filter(
				Breakpoint::get_style_breakpoint_order(),
				static function ( $breakpoint ) use ( $enabled_breakpoints ) {
					return in_array( $breakpoint, $enabled_breakpoints, true );
				}
			)
		);
		$base_value          = array_key_exists( 'value', $attr_text[ $base_breakpoint ] ?? [] )
			? $attr_text[ $base_breakpoint ]['value']
			: ModuleUtils::use_attr_value(
				[
					'attr'       => $attr_text,
					'breakpoint' => $base_breakpoint,
					'state'      => 'value',
					'mode'       => 'getOrInheritClosest',
				]
			);
		$base_color          = $base_value['color'] ?? null;
		$add_classnames      = static function ( array &$result, string $color, string $breakpoint, string $attr_state ) use ( $skip_desktop, $is_text_color ) {
			$breakpoint_suffix = 'desktop' === $breakpoint ? '' : '_' . $breakpoint;
			$state_suffix      = 'value' === $attr_state ? '' : '_' . $attr_state;

			if ( ! $skip_desktop || 'desktop' !== $breakpoint ) {
				$result[] = 'et_pb_bg_layout_' . $color . $breakpoint_suffix . $state_suffix;
			}

			if ( $is_text_color && 'light' === $color ) {
				$result[] = 'et_pb_text_color_dark' . $breakpoint_suffix . $state_suffix;
			}
		};

		foreach ( $output_breakpoints as $breakpoint ) {
			$has_explicit_value   = array_key_exists( 'value', $attr_text[ $breakpoint ] ?? [] );
			$explicit_value       = $has_explicit_value ? $attr_text[ $breakpoint ]['value'] : null;
			$explicit_value_color = $explicit_value['color'] ?? null;
			$inherited_value      = $has_explicit_value
				? $explicit_value
				: ModuleUtils::use_attr_value(
					[
						'attr'       => $attr_text,
						'breakpoint' => $breakpoint,
						'state'      => 'value',
						'mode'       => 'getOrInheritClosest',
					]
				);
			$inherited_color      = $inherited_value['color'] ?? null;
			$should_render_value  = 'desktop' !== $breakpoint
				&& in_array( $inherited_color, $valid_colors, true )
				&& $inherited_color !== $base_color;

			if ( in_array( $explicit_value_color, $valid_colors, true ) || $should_render_value ) {
				$add_classnames(
					$classnames,
					in_array( $explicit_value_color, $valid_colors, true ) ? $explicit_value_color : $inherited_color,
					$breakpoint,
					'value'
				);
			}

			foreach ( $attr_text[ $breakpoint ] ?? [] as $attr_state => $values ) {
				if ( 'value' === $attr_state || ! isset( $values['color'] ) || ! in_array( $values['color'], $valid_colors, true ) ) {
					continue;
				}

				$add_classnames( $classnames, $values['color'], $breakpoint, $attr_state );
			}
		}

		return implode( ' ', $classnames );
	}

	/**
	 * Get the color classnames for a text option group.
	 * Generate set of text color classnames for each attribute breakpoint and state.
	 *
	 * This function retrieves the color classnames for a given text option group.
	 * It iterates through the available breakpoints and uses the value mapping array to determine the corresponding color classnames.
	 * It then sanitizes the classnames and returns them as an array if they exist.
	 *
	 * @since ??
	 *
	 * @param array $text_option_group_attrs The attributes of the text option group.
	 *
	 * @return array The color classnames for the text option group.
	 *
	 * @example:
	 * ```php
	 *     $text_option_group_attrs = [
	 *         'desktop' => [
	 *             'value' => [
	 *                 'color' => 'light',
	 *             ],
	 *         ],
	 *         'tablet' => [
	 *             'value' => [
	 *                 'color' => 'dark',
	 *             ],
	 *         ],
	 *     ];
	 *     $color_classnames = self::get_color_classnames( $text_option_group_attrs );
	 *     // Returns ['et_pb_text_color_dark', 'et_pb_text_color_light_tablet']
	 * ```
	 *
	 * @example:
	 * ```php
	 *     $text_option_group_attrs = [
	 *         'desktop' => [
	 *             'value' => [
	 *                 'color' => 'invalid',
	 *             ],
	 *         ],
	 *         'tablet' => [
	 *             'value' => [
	 *                 'color' => 'dark',
	 *             ],
	 *         ],
	 *     ];
	 *     $color_classnames = self::get_color_classnames( $text_option_group_attrs );
	 *     // Returns ['et_pb_text_color_dark']
	 * ```
	 */
	public static function get_color_classnames( array $text_option_group_attrs ): array {
		$classnames = [];

		$breakpoints = Breakpoint::get_enabled_breakpoint_names();

		$value_mapping = [
			'light' => 'dark',
			'dark'  => 'light',
		];

		foreach ( $breakpoints as $breakpoint ) {
			$suffix     = 'desktop' === $breakpoint ? '' : '_' . $breakpoint;
			$text_color = $text_option_group_attrs[ $breakpoint ]['value']['color'] ?? null;

			if ( ! $text_color || ! isset( $value_mapping[ $text_color ] ) ) {
				continue;
			}

			$classnames[] = sprintf( 'et_pb_text_color_%1$s%2$s', $value_mapping[ $text_color ], $suffix );
		}

		if ( $classnames ) {
			return array_map( 'sanitize_html_class', $classnames );
		}

		return $classnames;
	}

	/**
	 * Get the classnames for text options.
	 *
	 * This function is used to retrieve the classnames for text options based on the given attributes and settings.
	 *
	 * This function is equivalent of JS function:
	 * {@link /api/js/divi-module/functions/TextOptionsClassnames textOptionsClassnames} in
	 * `@divi/module` package.
	 *
	 * @since ??
	 *
	 * @param array $attr      The attributes for the text options.
	 * @param array $settings  Optional. The settings for the text options. Default `[]`.
	 *
	 * @return string          The classnames for the text options.
	 *
	 * @example:
	 * ```php
	 * $attr = array(
	 *   'color' => true,
	 *   'orientation' => true,
	 * );
	 *
	 * $settings = array(
	 *   'color' => false,
	 *   'orientation' => true,
	 * );
	 *
	 * $class_names = self::text_options_classnames( $attr, $settings );
	 * ```
	 */
	public static function text_options_classnames( array $attr, array $settings = [] ): string {
		$settings_color       = isset( $settings['color'] ) ? $settings['color'] : true;
		$settings_orientation = isset( $settings['orientation'] ) ? $settings['orientation'] : true;
		$class_names_array    = [];

		if ( $settings_color ) {
			$background_layout_classnames = self::get_background_layout_classnames( $attr );

			if ( $background_layout_classnames ) {
				$class_names_array[] = $background_layout_classnames;
			}
		}

		if ( $settings_orientation ) {
			$alignment_classnames = self::get_alignment_classnames( $attr );

			if ( $alignment_classnames ) {
				$class_names_array[] = $alignment_classnames;
			}
		}

		return implode( ' ', $class_names_array );
	}
}
