<?php
defined( 'ABSPATH' ) || exit;
get_header();
$category = get_queried_object();
$articles = new WP_Query( array(
	'cat' => (int) $category->term_id,
	'posts_per_page' => 9,
	'paged' => max( 1, get_query_var( 'paged' ) ),
	'ignore_sticky_posts' => true,
) );
?>
<main id="main-content" class="door404-hub">
	<section class="door404-hero"><div class="door404-shell door404-hero__grid">
		<div><p class="door404-eyebrow">DOOR 404 · NOVI SAD</p><h1>Saveti i ideje za nezaboravnu avanturu</h1>
		<p class="door404-hero__lead">Kratki i korisni vodiči za prvi escape room, izbor igre, rođendane i team building. Bez spojlera — samo ono što vam pomaže da izaberete pravu avanturu.</p>
		<div class="door404-actions"><a class="door404-button door404-button--primary" href="<?php echo esc_url( home_url( '/rezervacija/' ) ); ?>">Rezervišite termin</a><a class="door404-button door404-button--ghost" href="#najnovije">Pročitajte vodiče</a></div></div>
		<div class="door404-hero__art" aria-hidden="true"><span class="door404-hero__number">404</span><span class="door404-hero__line">OTKLJUČAJTE<br>NOVU PRIČU</span></div>
	</div></section>

	<section class="door404-section"><div class="door404-shell"><p class="door404-kicker">OD IDEJE DO REZERVACIJE</p><h2>Sve što treba da znate pre igre</h2>
		<p class="door404-section__lead">Pronađite odgovore na najčešća pitanja, ideje za posebne prilike i savete koji će vašoj ekipi pomoći da izvuče maksimum iz iskustva u Door 404.</p>
		<div class="door404-topics">
			<a class="door404-topic" href="<?php echo esc_url( home_url( '/sta-je-escape-room-vodic-za-pocetnike/' ) ); ?>"><span>01</span><h3>Prvi escape room</h3><p>Kako igra izgleda, šta da očekujete i kako da se pripremite.</p><b>Pročitajte vodič →</b></a>
			<a class="door404-topic" href="<?php echo esc_url( home_url( '/proslava-rodjendana/' ) ); ?>"><span>02</span><h3>Rođendani</h3><p>Originalna proslava puna izazova, smeha i zajedničkih uspomena.</p><b>Pogledajte ponudu →</b></a>
			<a class="door404-topic" href="<?php echo esc_url( home_url( '/team-building-novi-sad/' ) ); ?>"><span>03</span><h3>Team building</h3><p>Test komunikacije, saradnje i snalažljivosti vaše ekipe.</p><b>Organizujte događaj →</b></a>
			<a class="door404-topic" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span>04</span><h3>Izbor avanture</h3><p>Upoznajte naše priče i pronađite izazov za svoju ekipu.</p><b>Pogledajte igre →</b></a>
		</div>
	</div></section>

	<section id="najnovije" class="door404-section door404-latest"><div class="door404-shell">
		<div class="door404-section__head"><div><p class="door404-kicker">SAVETI BEZ SPOJLERA</p><h2>Najnoviji vodiči</h2></div><p>Korisni tekstovi za bolji izbor i još bolje iskustvo.</p></div>
		<?php if ( $articles->have_posts() ) : ?><div class="door404-articles"><?php while ( $articles->have_posts() ) : $articles->the_post(); ?>
		<article <?php post_class( 'door404-article' ); ?>><div class="door404-article__meta"><span><?php echo esc_html( get_the_date( 'd.m.Y.' ) ); ?></span><span><?php echo esc_html( door404_reading_time( get_the_content() ) ); ?></span></div><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p><a class="door404-article__link" href="<?php the_permalink(); ?>">Pročitajte tekst →</a></article>
		<?php endwhile; ?></div><?php echo wp_kses_post( paginate_links( array( 'total' => $articles->max_num_pages, 'current' => max( 1, get_query_var( 'paged' ) ) ) ) ); ?>
		<?php else : ?><p class="door404-empty">Novi vodiči stižu uskoro.</p><?php endif; wp_reset_postdata(); ?>
	</div></section>

	<section class="door404-cta"><div class="door404-shell door404-cta__inner"><div><p class="door404-kicker">SPREMNI ZA IZAZOV?</p><h2>Najbolje priče se ne čitaju. One se dožive.</h2></div><a class="door404-button door404-button--light" href="<?php echo esc_url( home_url( '/rezervacija/' ) ); ?>">Izaberite termin</a></div></section>
</main>
<?php get_footer(); ?>
