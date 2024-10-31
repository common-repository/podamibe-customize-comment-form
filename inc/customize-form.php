<?php

defined( 'ABSPATH' ) or die( "No script kiddies please!" );


/**
 *
 * Default comment form includes name, email, URL and pccf_phone
 * Default comment form elements are hidden when user is logged in
 *
 */
add_filter('comment_form_default_fields','pccf_custom_fields');
function pccf_custom_fields($fields) {
	$pccf_setting_options   = get_option('pccf_setting_options');
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	$fields[ 'author' ] = '<p class="comment-form-author">'.
		'<label for="author">' . esc_html__( 'Name *', PCCF_TEXT_DOMAIN ) . '</label>'.
		( $req ? '<span class="required"></span>' : '' ).
		'<input id="author" name="author" type="text" value="'. esc_attr( $commenter['comment_author'] ) . 
		'" size="30" tabindex="1"' . $aria_req . ' /></p>';
	
	$fields[ 'email' ] = '<p class="comment-form-email">'.
		'<label for="email">' . esc_html__( 'Email *', PCCF_TEXT_DOMAIN ) . '</label>'.
		( $req ? '<span class="required"></span>' : '' ).
		'<input id="email" name="email" type="text" value="'. esc_attr( $commenter['comment_author_email'] ) . 
		'" size="30"  tabindex="2"' . $aria_req . ' /></p>';
				
	$fields[ 'url' ] = '<p class="comment-form-url">'.
		'<label for="url">' . esc_html__( 'Website', PCCF_TEXT_DOMAIN ) . '</label>'.
		'<input id="url" name="url" type="text" value="'. esc_attr( $commenter['comment_author_url'] ) . 
		'" size="30"  tabindex="3" /></p>';

	return $fields;
}

/**
 * Change the textarea to editor of wordpress
 */
function pccf_chnage_comment_textarea() {
	ob_start();
	wp_editor( '', 'comment', array(
	    'textarea_rows' => 15,
	    'teeny' => true,
	    'quicktags' => false,
	    'media_buttons' => false
	  ) );
	$comment_field = ob_get_contents();
	ob_end_clean();
    return $comment_field;
}
$pccf_setting_options   = get_option('pccf_setting_options');
if( $pccf_setting_options['pccf_editor'] == '1' ){
	add_filter( 'comment_form_field_comment', 'pccf_chnage_comment_textarea' );
}


/**
 * Add fields after default fields above the comment box, always visible
 */
add_action( 'comment_form_logged_in_after', 'pccf_additional_fields' );
add_action( 'comment_form_after_fields', 'pccf_additional_fields' );

function pccf_additional_fields () {
	$pccf_setting_options   = get_option('pccf_setting_options');
	if( $pccf_setting_options['pccf_title'] == '1' ){
		echo '<p class="comment-form-pccf-title">'.
		'<label for="pccf_title">' . esc_html__( 'Comment title ', PCCF_TEXT_DOMAIN ) . '</label>'.
		'<input id="pccf_title" name="pccf_title" type="text" size="30"  tabindex="5" /></p>';
	}

	if( $pccf_setting_options['pccf_phone'] == '1' ){
		echo '<p class="comment-form-pccf-pccf_phone">'.
		'<label for="pccf_phone">' . esc_html__( 'Phone ', PCCF_TEXT_DOMAIN ) . '</label>'.
		'<input id="pccf_phone" name="pccf_phone" type="text" size="30"  tabindex="5" /></p>';
	}

	if( $pccf_setting_options['pccf_country'] == '1' ){
		echo '<p class="comment-form-pccf-pccf_country">'.
		'<label for="pccf_country">' . esc_html__( 'Country ', PCCF_TEXT_DOMAIN ) . '</label>'.
		'<input id="pccf_country" name="pccf_country" type="text" size="30"  tabindex="5" /></p>';
	}

	if( $pccf_setting_options['pccf_rating'] == '1' ){
		echo '<p class="comment-form-pccf-rating">'.
		'<label for="pccf_rating">'. esc_html__('Rating ', PCCF_TEXT_DOMAIN) . '<span class="required">*</span></label>';
		for( $i=1; $i <= 5; $i++ ){
			echo '<img src="'.PCCF_URI.'assets/images/'.$i.'star.gif"/> <input type="radio" name="pccf_rating" id="pccf_rating" value="'.$i.'"/>';
		}
	}
}

 
/**
 * Save the comment meta data along with comment
 */
add_action( 'comment_post', 'pccf_save_comment_meta_data' );
function pccf_save_comment_meta_data( $comment_id ) {

	if ( ( isset( $_POST['pccf_phone'] ) ) && ( $_POST['pccf_phone'] != '') )
	$pccf_phone = wp_filter_nohtml_kses($_POST['pccf_phone']);
	add_comment_meta( $comment_id, 'pccf_phone', $pccf_phone );

	if ( ( isset( $_POST['pccf_country'] ) ) && ( $_POST['pccf_country'] != '') )
	$pccf_country = wp_filter_nohtml_kses($_POST['pccf_country']);
	add_comment_meta( $comment_id, 'pccf_country', $pccf_country );

	if ( ( isset( $_POST['pccf_title'] ) ) && ( $_POST['pccf_title'] != '') )
	$pccf_title = wp_filter_nohtml_kses($_POST['pccf_title']);
	add_comment_meta( $comment_id, 'pccf_title', $pccf_title );

	if ( ( isset( $_POST['pccf_rating'] ) ) && ( $_POST['pccf_rating'] != '') )
	$pccf_rating = wp_filter_nohtml_kses($_POST['pccf_rating']);
	add_comment_meta( $comment_id, 'pccf_rating', $pccf_rating );

}


/**
 * Add an edit option in comment edit screen   
 */
add_action( 'add_meta_boxes_comment', 'pccf_extend_comment_add_meta_box' );
function pccf_extend_comment_add_meta_box() {
    add_meta_box( 'pccf_title', esc_html__( 'Comment extra fields', PCCF_TEXT_DOMAIN ), 'pccf_extend_comment_meta_box', 'comment', 'normal', 'high' );
}
 
function pccf_extend_comment_meta_box ( $comment ) {
    $pccf_phone     = get_comment_meta( $comment->comment_ID, 'pccf_phone', true );
    $pccf_title     = get_comment_meta( $comment->comment_ID, 'pccf_title', true );
    $pccf_rating    = get_comment_meta( $comment->comment_ID, 'pccf_rating', true );
    $pccf_country   = get_comment_meta( $comment->comment_ID, 'pccf_country', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?>
    <p>
        <label for="pccf_title"><?php esc_html_e( 'Comment pccf_title', PCCF_TEXT_DOMAIN ); ?></label>
        <input type="text" name="pccf_title" value="<?php echo esc_attr( $pccf_title ); ?>" class="widefat" />
    </p>
    <p>
    <p>
        <label for="pccf_phone"><?php esc_html_e( 'Phone', PCCF_TEXT_DOMAIN ); ?></label>
        <input type="text" name="pccf_phone" value="<?php echo esc_attr( $pccf_phone ); ?>" class="widefat" />
    </p>
    
        <label for="pccf_country"><?php esc_html_e( 'Country', PCCF_TEXT_DOMAIN ); ?></label>
        <input type="text" name="pccf_country" value="<?php echo esc_attr( $pccf_country ); ?>" class="widefat" />
    </p>
    <p>
        <label for="pccf_rating"><?php esc_html_e( 'Rating : ', PCCF_TEXT_DOMAIN ); ?></label>
			<span class="commentpccf_ratingbox">
			<?php for( $i=1; $i <= 5; $i++ ) {
				echo '<span class="commentpccf_rating"><input type="radio" name="pccf_rating" id="pccf_rating" value="'. $i .'"';
				if ( $pccf_rating == $i ) echo ' checked="checked"';
				echo ' /> <img src="'.PCCF_URI.'assets/images/'.$i.'star.gif"/></span> '; 
				}
			?>
			</span>
    </p>
    <?php
}


/**
 * Update comment meta data from comment edit screen 
 */
add_action( 'edit_comment', 'pccf_extend_comment_edit_metafields' );
function pccf_extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

    if ( ( isset( $_POST['pccf_title'] ) ) && ( $_POST['pccf_title'] != '') ):
	$pccf_title = wp_filter_nohtml_kses($_POST['pccf_title']);
	update_comment_meta( $comment_id, 'pccf_title', $pccf_title );
	else :
	delete_comment_meta( $comment_id, 'pccf_title');
	endif;
	
	if ( ( isset( $_POST['pccf_phone'] ) ) && ( $_POST['pccf_phone'] != '') ) : 
	$pccf_phone = wp_filter_nohtml_kses($_POST['pccf_phone']);
	update_comment_meta( $comment_id, 'pccf_phone', $pccf_phone );
	else :
	delete_comment_meta( $comment_id, 'pccf_phone');
	endif;

	if ( ( isset( $_POST['pccf_country'] ) ) && ( $_POST['pccf_country'] != '') ):
	$pccf_country = wp_filter_nohtml_kses($_POST['pccf_country']);
	update_comment_meta( $comment_id, 'pccf_country', $pccf_country );
	else :
	delete_comment_meta( $comment_id, 'pccf_country');
	endif;

	if ( ( isset( $_POST['pccf_rating'] ) ) && ( $_POST['pccf_rating'] != '') ):
	$pccf_rating = wp_filter_nohtml_kses($_POST['pccf_rating']);
	update_comment_meta( $comment_id, 'pccf_rating', $pccf_rating );
	else :
	delete_comment_meta( $comment_id, 'pccf_rating');
	endif;
	
}


/**
 * Add the comment meta (saved earlier) to the comment text
 * You can also output the comment meta values directly in comments template 
 */
add_filter( 'comment_text', 'pccf_modify_comment');
function pccf_modify_comment( $text ){

	$plugin_url_path = PCCF_URI;

	if( $commentpccf_title = get_comment_meta( get_comment_ID(), 'pccf_title', true ) ) {
		$commentpccf_title = '<strong>'.esc_html__('Comment title : ', PCCF_TEXT_DOMAIN).'</strong> ' . esc_attr( $commentpccf_title ).'<br/>';
		$text = $commentpccf_title . $text.'<br/>';
	} 

	if( $commentpccf_phone = get_comment_meta( get_comment_ID(), 'pccf_phone', true ) ) {
		$commentpccf_phone = '<strong>'.esc_html__('Phone : ', PCCF_TEXT_DOMAIN).'</strong> ' . esc_attr( $commentpccf_phone ).'<br/>';
		$text = $commentpccf_phone . $text.'<br/>';
	}

	if( $commentpccf_country = get_comment_meta( get_comment_ID(), 'pccf_country', true ) ) {
		$commentpccf_country = '<strong>'.esc_html__('Country : ', PCCF_TEXT_DOMAIN).'</strong> ' . esc_attr( $commentpccf_country ) . '<br/> ';
		$text = $commentpccf_country . $text.'<br/>';
	} 

	if( $commentpccf_rating = get_comment_meta( get_comment_ID(), 'pccf_rating', true ) ) {
		$commentpccf_rating = '<strong>'.esc_html__('Rating : ', PCCF_TEXT_DOMAIN).'</strong> <img src="'. $plugin_url_path .
		'assets/images/'. $commentpccf_rating . 'star.gif"/>';
		$text = $text . $commentpccf_rating.'<br/>';
		return $text;		
	} else {
		return $text;		
	}	 
}

