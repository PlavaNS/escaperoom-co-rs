<?php
/**
 * Plugin Name: Door 404 Site Tools
 * Description: Small, site-specific SEO and content improvements for escaperoom.co.rs.
 * Version: 0.2.0
 * Author: Door 404
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add useful introductory content to the Saveti i ideje archive.
 *
 * The archive currently has no visible H1 or category introduction. Keeping this
 * in a small site plugin makes the change independent from Divi updates.
 *
 * @param WP_Query $query Current WordPress query.
 */
function door404_render_saveti_i_ideje_hub( $query ) {
	static $rendered = false;

	if (
		$rendered ||
		is_admin() ||
		! $query->is_main_query() ||
		! is_category( 'saveti-i-ideje' )
	) {
		return;
	}

	$rendered = true;
	?>
	<section class="door404-content-hub" aria-labelledby="door404-content-hub-title">
		<h1 id="door404-content-hub-title">Saveti i ideje za escape room avanturu</h1>
		<p class="door404-content-hub__lead">
			Praktični vodiči za izbor igre, pripremu ekipe i organizaciju nezaboravnog izlaska u Novom Sadu.
			Ovde možete saznati kako escape room funkcioniše, koju avanturu da izaberete i kako da organizujete
			rođendan ili team building u Door 404.
		</p>

		<nav class="door404-content-hub__links" aria-label="Najtraženije teme">
			<a href="<?php echo esc_url( home_url( '/njeno-visocanstvo/' ) ); ?>">Njeno Visočanstvo</a>
			<a href="<?php echo esc_url( home_url( '/selektor/' ) ); ?>">Selektor</a>
			<a href="<?php echo esc_url( home_url( '/kutija-izgubljenih-legendi/' ) ); ?>">Kutija izgubljenih legendi</a>
			<a href="<?php echo esc_url( home_url( '/potraga-za-blagom/' ) ); ?>">Potraga za blagom</a>
			<a href="<?php echo esc_url( home_url( '/proslava-rodjendana/' ) ); ?>">Proslava rođendana</a>
			<a href="<?php echo esc_url( home_url( '/team-building/' ) ); ?>">Team building</a>
		</nav>

		<p class="door404-content-hub__cta">
			<a href="<?php echo esc_url( home_url( '/rezervacija/' ) ); ?>">Rezervišite termin</a>
		</p>
	</section>
	<?php
}
add_action( 'loop_start', 'door404_render_saveti_i_ideje_hub' );

/**
 * Add narrowly scoped styling for the category introduction.
 */
function door404_print_content_hub_styles() {
	if ( ! is_category( 'saveti-i-ideje' ) ) {
		return;
	}
	?>
	<style id="door404-content-hub-css">
		.door404-content-hub{max-width:1080px;margin:0 auto 36px;padding:32px 24px;background:#f7f7f7;border-top:5px solid #006d7d}
		.door404-content-hub h1{margin:0 0 16px;color:#111;font-size:clamp(30px,5vw,48px);line-height:1.12}
		.door404-content-hub__lead{max-width:820px;margin:0 0 22px;font-size:18px;line-height:1.7}
		.door404-content-hub__links{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:22px}
		.door404-content-hub__links a{display:inline-block;padding:9px 13px;background:#fff;border:1px solid #d5d5d5;color:#005c6a;text-decoration:none}
		.door404-content-hub__links a:hover,.door404-content-hub__links a:focus{border-color:#006d7d;text-decoration:underline}
		.door404-content-hub__cta{margin:0}
		.door404-content-hub__cta a{display:inline-block;padding:12px 18px;background:#006d7d;color:#fff;font-weight:700;text-decoration:none}
		.door404-content-hub__cta a:hover,.door404-content-hub__cta a:focus{background:#004c57}
	</style>
	<?php
}
add_action( 'wp_head', 'door404_print_content_hub_styles', 30 );

/**
 * Remove the obsolete seven-player price restored by an older backup.
 *
 * The match is deliberately limited to the birthday page and the exact price
 * row, so unrelated prices and page markup are left untouched.
 *
 * @param string $content Rendered page content.
 * @return string
 */
function door404_remove_obsolete_seven_player_price( $content ) {
	if ( ! is_page( 'proslava-rodjendana' ) || false === stripos( $content, '7.500' ) ) {
		return $content;
	}

	$pattern = '~<p[^>]*>\s*<strong[^>]*>\s*7\s*</strong>\s*IGRAČA\s*-\s*<strong[^>]*>\s*7(?:\.|\s)500\s*</strong>\s*<strong[^>]*>\s*RSD\s*</strong>\s*</p>~iu';

	return preg_replace( $pattern, '', $content );
}
add_filter( 'the_content', 'door404_remove_obsolete_seven_player_price', 20 );
