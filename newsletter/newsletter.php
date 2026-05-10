<?php
/*
 * Plugin Name: Newsletter.php
 * Description: A newsletter plugin with customized trending posts, post cards, email signup, and a post poll.
 * Version: 1.0
 * Author: Omorinsola Olumoh
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* -------- Assets -------- */

function nl_assets() {
    wp_enqueue_style(
        'nl-style',
        plugin_dir_url( __FILE__ ) . 'css/style.css',
        array(),
        '1.0'
    );

    wp_enqueue_script(
        'nl-script',
        plugin_dir_url( __FILE__ ) . 'js/script.js',
        array(),
        '1.0',
        true
    );

    wp_localize_script( 'nl-script', 'nl_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'nl_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'nl_assets' );

/* -------- Header -------- */

function newsletter_header() {
    ob_start();
    ?>
    <header>
        <h1 class="header">CrimeStories</h1>
        <nav class="site-nav">
            <a href="<?php echo esc_url( home_url() ); ?>">Home</a>
            <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a>
            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a>
        </nav>
    </header>
    <?php
    return ob_get_clean();
}
add_shortcode( 'newsletter_header', 'newsletter_header' );


/* ------- Trending Post -------- */

function nl_trending_posts() {
    $query = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => 5,
        'orderby'        => 'comment_count',
        'order'          => 'DESC',
    ) );

    ob_start();

    if ( $query->have_posts() ) {
        echo '<h2 class="newsletter-trending-title">Trending Posts</h2>';
        echo '<div class="newsletter-trending-post-grid">';

        while ( $query->have_posts() ) {
            $query->the_post();

            echo '<article class="newsletter-trending-card">';

            if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'medium' );
            }

            echo '<div class="newsletter-trending-card-post">';
            echo '<h3 class="newsletter-trending-card-post-h3">' . esc_html( get_the_title() ) . '</h3>';
            echo '<p class="newsletter-trending-card-post-p">' . esc_html( get_the_date() . ', By ' . get_the_author() ) . '</p>';
            echo '<p class="newsletter-trending-card-post-excerpt">' . esc_html( wp_trim_words( get_the_excerpt(), 50 ) ) . '</p>';
            echo '<a class="newsletter-trending-card-readmore" href="' . esc_url( get_permalink() ) . '">Read More</a>';
            echo '</div>';

            echo '</article>';
        }

        echo '</div>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'trending_posts', 'nl_trending_posts' );

/* ------- Post Grid -------- */

function nl_posts_grid() {
    $query = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => 6,
    ) );

    ob_start();

    if ( $query->have_posts() ) {
        echo '<section class="site-post-grid">';

        while ( $query->have_posts() ) {
            $query->the_post();

            echo '<article class="site-post-card">';

            if ( has_post_thumbnail() ) {
                the_post_thumbnail( 'medium' );
            }

            echo '<h3>' . esc_html( get_the_title() ) . '</h3>';
            echo '<p>' . esc_html( wp_trim_words( get_the_excerpt(), 40 ) ) . '</p>';
            echo '<a class="newsletter-trending-card-readmore" href="' . esc_url( get_permalink() ) . '">Read More</a>';

            echo '</article>';
        }

        echo '</section>';
    }

    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'posts_grid', 'nl_posts_grid' );


/* ------- Save Email ( AJAX)-------- */

function nl_save_email() {
    if ( ! isset( $_POST['nl_nonce'] ) || ! wp_verify_nonce( $_POST['nl_nonce'], 'nl_email_nonce' ) ) {
        wp_send_json_error( 'Invalid request' );
    }

    if ( ! isset( $_POST['email'] ) || empty( $_POST['email'] ) ) {
        wp_send_json_error( 'No email provided' );
    }

    $email = sanitize_email( wp_unslash( $_POST['email'] ) );

    if ( ! is_email( $email ) ) {
        wp_send_json_error( 'Invalid email' );
    }

    $subscribers = get_option( 'nl_subscribers', array() );

    if ( in_array( $email, $subscribers, true ) ) {
        wp_send_json_error( 'Already subscribed' );
    }

    $subscribers[] = $email;
    update_option( 'nl_subscribers', $subscribers );

    wp_send_json_success( 'Subscribed successfully' );
}
add_action( 'wp_ajax_nl_save_email',        'nl_save_email' );
add_action( 'wp_ajax_nopriv_nl_save_email', 'nl_save_email' );


/* ------- Save Vote ( Ajax) -------- */

function nl_save_vote() {
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'nl_nonce' ) ) {
        wp_send_json_error( 'Invalid request' );
    }

    $allowed = array( 'good', 'average', 'bad' );
    $vote    = isset( $_POST['vote'] ) ? sanitize_text_field( wp_unslash( $_POST['vote'] ) ) : '';

    if ( ! in_array( $vote, $allowed, true ) ) {
        wp_send_json_error( 'Invalid vote' );
    }

    $votes          = get_option( 'nl_poll_votes', array( 'good' => 0, 'average' => 0, 'bad' => 0 ) );
    $votes[ $vote ] = ( isset( $votes[ $vote ] ) ? intval( $votes[ $vote ] ) : 0 ) + 1;
    update_option( 'nl_poll_votes', $votes );

    wp_send_json_success( $votes );
}
add_action( 'wp_ajax_nl_save_vote',        'nl_save_vote' );
add_action( 'wp_ajax_nopriv_nl_save_vote', 'nl_save_vote' );


/* ------- Email Signup Footer -------- */

function nl_email_signup() {
    ob_start();
    ?>
    <section class="newsletter-footer">
        <div class="newsletter-signup-footer-copy">
            <h2>Join Our Newsletter</h2>
            <p>Get the latest trending posts delivered to your inbox.</p>
        </div>
        <form method="post" id="newsletter-footer-form" class="newsletter-footer-form">
            <?php wp_nonce_field( 'nl_email_nonce', 'nl_nonce' ); ?>
            <input type="email" name="nl_email" placeholder="Enter your email" required>
            <button type="submit">Subscribe</button>
        </form>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode( 'email_signup', 'nl_email_signup' );


/* ------- Poll-------- */

function nl_poll() {
    if ( ! is_singular( 'post' ) ) {
        return '';
    }

    ob_start();
    ?>
    <div class="poll-wrapper">
        <h3>What do you think of this post?</h3>
        <form class="poll-wrapper-form" id="poll-wrapper-form">
            <label><input type="radio" name="vote" value="good"> Good</label>
            <label><input type="radio" name="vote" value="bad"> Bad</label>
            <button type="submit">Vote</button>
        </form>
        <div class="poll-results"></div>
    </div>
    <?php
    return ob_get_clean();
}

function nl_auto_insert_poll( $content ) {
    if ( ! is_singular( 'post' ) ) return $content;
    if ( is_admin() )              return $content;
    if ( ! in_the_loop() )         return $content;
    if ( ! is_main_query() )       return $content;

    remove_filter( 'the_content', 'nl_auto_insert_poll' );
    $poll = nl_poll();
    add_filter( 'the_content', 'nl_auto_insert_poll' );

    return $content . $poll;
}
add_filter( 'the_content', 'nl_auto_insert_poll' );

/* ------- Admin Menu -------- */

function nl_admin_menu() {
    add_menu_page(
        'Newsletter',
        'Newsletter',
        'manage_options',
        'nl-subscribers',
        'nl_render_admin_page',
        'dashicons-email',
        25
    );
}
add_action( 'admin_menu', 'nl_admin_menu' );

function nl_render_admin_page() {
    $subscribers = get_option( 'nl_subscribers', array() );
    $votes       = get_option( 'nl_poll_votes', array( 'good' => 0, 'bad' => 0 ) );

    $good    = intval( $votes['good']    ?? 0 );
    $bad     = intval( $votes['bad']     ?? 0 );
    $total   = $good + $average + $bad;

    echo '<div class="wrap">';

    /* ---- subscribers ---- */
    echo '<h1>Newsletter Subscribers</h1>';

    if ( empty( $subscribers ) ) {
        echo '<p>No subscribers yet.</p>';
    } else {
        echo '<p><strong>' . count( $subscribers ) . ' subscriber(s)</strong></p>';
        echo '<ul>';
        foreach ( $subscribers as $email ) {
            echo '<li>' . esc_html( $email ) . '</li>';
        }
        echo '</ul>';
    }

    /* ---- poll results ---- */
    echo '<hr style="margin: 30px 0;">';
    echo '<h2>Poll Results</h2>';

    if ( $total === 0 ) {
        echo '<p>No votes yet.</p>';
    } else {
        $pGood    = round( ( $good    / $total ) * 100 );
        $pBad     = round( ( $bad     / $total ) * 100 );

        echo '<p><strong>Total votes: ' . $total . '</strong></p>';
        echo '<table class="widefat" style="max-width:400px; margin-top:12px;">';
        echo '<thead><tr><th>Option</th><th>Votes</th><th>Percentage</th></tr></thead>';
        echo '<tbody>';
        echo '<tr><td>Good</td><td>'    . $good    . '</td><td>' . $pGood    . '%</td></tr>';
        echo '<tr><td>Bad</td><td>'     . $bad     . '</td><td>' . $pBad     . '%</td></tr>';
        echo '</tbody>';
        echo '</table>';

        /* reset button */
        if ( isset( $_POST['nl_reset_votes'] ) && check_admin_referer( 'nl_reset_votes_action' ) ) {
            update_option( 'nl_poll_votes', array( 'good' => 0, 'bad' => 0 ) );
            echo '<p style="color:green;">Votes reset successfully.</p>';
        }

        echo '<form method="post" style="margin-top:16px;">';
        wp_nonce_field( 'nl_reset_votes_action' );
        echo '<input type="hidden" name="nl_reset_votes" value="1">';
        echo '<button type="submit" class="button button-secondary">Reset Poll Votes</button>';
        echo '</form>';
    }

    echo '</div>';
}
