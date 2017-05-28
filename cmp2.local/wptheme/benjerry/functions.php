<?php

/* LINK NAAR STYLESHEETS EN SCRIPTS */
function add_theme_scripts() {
  wp_enqueue_style( 'materialize', get_template_directory_uri() . '/materialize/materialize.css',  array(), '1.1', 'all' );
  wp_enqueue_style( 'materialize', get_template_directory_uri() . '/materialize/materialize.min.css',  array(), '1.1', 'all' );
  wp_enqueue_style( 'style', get_stylesheet_uri() );

  wp_enqueue_script( 'script', get_template_directory_uri() . '/js/jquery-3.2.1.js', array ( 'jquery' ), 1.1, true);
  wp_enqueue_script( 'materialize-js', get_template_directory_uri() . '/js/materialize.js', array( 'jquery' ), 1.1, true );
  wp_enqueue_script( 'materialize-js', get_template_directory_uri() . '/js/materialize.min.js', array( 'jquery' ), 1.1, true );
  wp_enqueue_script( 'mainjs', get_template_directory_uri() . '/js/init.js', array(), 1.1, true );

}

add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


/* Zorgen dat features images in custom post types gezet kunnen worden */
add_theme_support('post-thumbnails');

/* Add secondary thumbnail (featured image) in posts */
$thumb = new MultiPostThumbnails(array(
'label' => 'Open potje',
'id' => 'open-image',
'post_type' => 'smaken'
)
);

/* Add secondary thumbnail (featured image) in posts */
$thumb = new MultiPostThumbnails(array(
'label' => 'Voedingswaardetabel',
'id' => 'secondary-image',
'post_type' => 'smaken',

)
);



function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Homepage posts';
    $submenu['edit.php'][5][0] = 'Homepage posts';
    $submenu['edit.php'][10][0] = 'voeg Homepage post toe';
    $submenu['edit.php'][16][0] = 'Homepage posts Tags';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Homepage posts';
    $labels->singular_name = 'Homepage posts';
    $labels->add_new = 'Voeg Homepage posts toe';
    $labels->add_new_item = 'Voeg Homepage posts toe';
    $labels->edit_item = 'Wijzig Homepage posts';
    $labels->new_item = 'Homepage posts';
    $labels->view_item = 'Bekijk Homepage posts';
    $labels->search_items = 'Zoek Homepage posts';
    $labels->not_found = 'No Homepage posts found';
    $labels->not_found_in_trash = 'No Homepage posts found in Trash';
    $labels->all_items = 'All Homepage posts';
    $labels->menu_name = 'Homepage posts';
    $labels->name_admin_bar = 'Homepage posts';
}
 
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );




//METABOX AANMAKEN VOOR LINKS OP HOMEPAGE
    function post_link_box(){
        add_meta_box( 'post_link_box', 'Link', 'post_link_box_content', 'post', 'normal', 'high');
    }
    //AANMAKEN DE MOMENT METABOXES WORDEN GEMAAKT
    add_action('add_meta_boxes', 'post_link_box' );
    //FUNCTIE VOOR DE INHOUD VAN DE METABOX
    function post_link_box_content($post){
        // Als er een post wordt aangepast, haal de post_meta op uit de databank, VUL DIE IN
        $Link   = get_post_meta( $post->ID, 'Link', true );
        //CONTROLE ALS DE AANVRAAG KOMT VAN DIT SCHERM - SAVE POST KAN VAN EEN ANDERE PAGINA KOMEN
            wp_nonce_field(plugin_basename(__FILE__), 'post_link_box_content_nonce' );
        //WERKELIJKE INHOUD - GEBRUIK ECHO
        echo '<label for="Link">Zin voor verwijzing naar pagina<label><br>';
        echo "<textarea rows='4' cols='100' id='Link' name='Link'>{$Link}</textarea>";
    }
    //DATA VAN METABOX OPSLAAN
    function Link_box_post_save($post_id){
        //CONTROLE ALS DE AANVRAAG KOMT VAN DIT SCHERM - SAVE POST KAN VAN EEN ANDERE PAGINA KOMEN
        if ( !wp_verify_nonce( $_POST['post_link_box_content_nonce'], plugin_basename(__FILE__) )) {
            return $post_id;
        }
        // Verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
        // to do anything
            if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
            return $post_id;
        // Check permissions to edit pages and/or post
            if ( 'page' == $_POST['post_type'] ||  'post' == $_POST['post_type']) {
            if ( !current_user_can( 'edit_page', $post_id ) || !current_user_can( 'edit_post', $post_id ))
            return $post_id;
        } 
        // OK, we're authenticated: we need to find and save the data
        //HAAL DATA UIT HET FORMULIER
        $afk = $_POST['Link'];
        // save data in INVISIBLE custom field (note the "_" prefixing the custom fields' name
        update_post_meta($post_id, 'Link', $afk); 
        }
    //WANNEER WE DE POST OPLSAAN GAAN WE DE METADATA OPSLAAN, INDIEN DE METADATA BESTAAT
    if(isset($_POST['Link'])){
        add_action('save_post', 'Link_box_post_save');
}



// CUSTOM POST TYPES



    //CUSTOM POSTTYPE waarden AANMAKEN
    function add_my_custom_posttype_waarden(){
    //LABELS DIFINIËREN
        $labels = array(
            'add_new' => 'Voeg nieuwe waarde toe',
            'add_new_item' => 'Voeg nieuwe waarde toe',
            'name' => 'waarden',
            'singular_name' => 'waarden',
        );
    //ARGUMENTEN DIFINIËREN
        $args = array(
            'labels' => $labels, // de array labels van hier boven linken aan het argument labels
            'Description' => 'waarden van Ben & Jerry',
            'public' => true,
            'menu_position' => 6,
            'menu_icon' => 'dashicons-layout', //Een icoon kiezen
            'supports' => array('title', 'editor', 'thumbnail'), 
        'has_archive' => true, //Maak een archief aan (opsomming van alle elementen), anders gaan we archive-waarden.php nooit kunnen aanspreken.
        'show_in_nav_menus'   => TRUE,
        
        );
        register_post_type( 'waarden', $args ); 
    }
    add_action( 'init', 'add_my_custom_posttype_waarden' );





    //CUSTOM POSTTYPE SMAKEN AANMAKEN
    function add_my_custom_posttype_smaken(){
    //LABELS DIFINIËREN
        $labels = array(
            'add_new' => 'Voeg nieuwe smaak toe',
            'add_new_item' => 'Voeg nieuwe smaak toe',
            'name' => 'Smaken',
            'singular_name' => 'Smaak',
        );
    //ARGUMENTEN DIFINIËREN
        $args = array(
            'labels' => $labels, // de array labels van hier boven linken aan het argument labels
            'Description' => 'Lactosevrije smaken van B & J',
            'public' => true,
            'menu_position' => 4,
            'menu_icon' => 'dashicons-carrot', //Een icoon kiezen
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'), 
        'has_archive' => true, //Maak een archief aan (opsomming van alle elementen), anders gaan we archive-waarden.php nooit kunnen aanspreken.
        'show_in_nav_menus'   => TRUE,
        );
        register_post_type( 'smaken', $args ); 
    }
    add_action( 'init', 'add_my_custom_posttype_smaken' );

//limiet recepten blog
function set_posts_per_page_for_recepten_cpt( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'recepten' ) ) {
    $query->set( 'posts_per_page', '5' );
  }
}
add_action( 'pre_get_posts', 'set_posts_per_page_for_recepten_cpt' );

    //METABOX AANMAKEN INGRDIENTEN
            function smaken_ingr_box(){
                add_meta_box( 'smaken_ingr_box', 'Ingredienten', 'smaken_ingr_box_content', 'smaken', 'normal', 'high');
            }
            //AANMAKEN DE MOMENT METABOXES WORDEN GEMAAKT
            add_action('add_meta_boxes', 'smaken_ingr_box' );
            //FUNCTIE VOOR DE INHOUD VAN DE METABOX
            function smaken_ingr_box_content($post){
                // Als er een post wordt aangepast, haal de post_meta op uit de databank, VUL DIE IN
                $ingredienten   = get_post_meta( $post->ID, 'ingredienten', true );
                //CONTROLE ALS DE AANVRAAG KOMT VAN DIT SCHERM - SAVE POST KAN VAN EEN ANDERE PAGINA KOMEN
                    wp_nonce_field(plugin_basename(__FILE__), 'smaken_ingr_box_content_nonce' );
                //WERKELIJKE INHOUD - GEBRUIK ECHO
                echo '<label for="ingredienten">ingredienten <label><br>';
                echo "<textarea rows='4' cols='100' id='ingredienten' name='ingredienten'>{$ingredienten}</textarea>";
            }
            //DATA VAN METABOX OPSLAAN
            function ingredienten_box_smaken_save($post_id){
                //CONTROLE ALS DE AANVRAAG KOMT VAN DIT SCHERM - SAVE POST KAN VAN EEN ANDERE PAGINA KOMEN
                if ( !wp_verify_nonce( $_POST['smaken_ingr_box_content_nonce'], plugin_basename(__FILE__) )) {
                    return $post_id;
                }
                // Verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
                // to do anything
                    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
                    return $post_id;
                // Check permissions to edit pages and/or posts
                    if ( 'page' == $_POST['post_type'] ||  'post' == $_POST['post_type']) {
                    if ( !current_user_can( 'edit_page', $post_id ) || !current_user_can( 'edit_post', $post_id ))
                    return $post_id;
                } 
                // OK, we're authenticated: we need to find and save the data
                //HAAL DATA UIT HET FORMULIER
                $afk = $_POST['ingredienten'];
                // save data in INVISIBLE custom field (note the "_" prefixing the custom fields' name
                update_post_meta($post_id, 'ingredienten', $afk); 
                }
            //WANNEER WE DE POST OPLSAAN GAAN WE DE METADATA OPSLAAN, INDIEN DE METADATA BESTAAT
            if(isset($_POST['ingredienten'])){
                add_action('save_post', 'ingredienten_box_smaken_save');
            };




//CUSTOM POSTTYPE RECEPTEN AANMAKEN
    function add_my_custom_posttype_recepten(){
    //LABELS DIFINIËREN
        $labels = array(
            'add_new' => 'Voeg nieuw recept toe',
            'add_new_item' => 'Voeg nieuw recept toe',
            'name' => 'Recepten',
            'singular_name' => 'recept',
        );
    //ARGUMENTEN DIFINIËREN
        $args = array(
            'labels' => $labels, // de array labels van hier boven linken aan het argument labels
            'Description' => 'Lactosevrije recepten van B & J',
            'public' => true,
            'menu_position' => 4,
            'menu_icon' => 'dashicons-book-alt', //Een icoon kiezen
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'comments'), 
            'has_archive' => true, //Maak een archief aan (opsomming van alle elementen), anders gaan we archive-recepten.php nooit kunnen aanspreken.
            'show_in_nav_menus'   => TRUE,

                );

        register_post_type( 'recepten', $args ); 
        
    }
    add_action( 'init', 'add_my_custom_posttype_recepten' );


//COMMENTS 
    // Als aanmelden noodzakelijk is...
    if ( post_password_required() ) {
        return;
    }

    if ( have_comments() ) :
        //Is er commentaar aan wezig... dan doen we het volgende...
    ?>
        <h2>
            <?php get_the_title(); ?>
        </h2>
        <?php the_comments_navigation(); ?>

        <ol>
            <?php
            wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 42,
                
            ) );
            ?>
        </ol>
        

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php
    // Als het niet is toegestaan om commentaar te geven, dan tonen we een kleine boodschap...
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php _e( 'Niet mogelijk om commentaar te geven.', 'mytheme' ); ?></p>
    <?php endif; ?>

    <?php
    comment_form( array(
        'title_reply_before' => '<h5>',
        'title_reply_after'  => '</h5>',
    ) );

    function alter_comments_defaults( $defaults ) {
        global $post;

            $defaults = array(
            
                'title_reply'          => '<a name="add-a-comment"></a>' . __( 'Voeg een reactie toe', 'text-domain' ) . ' ',
                'cancel_reply_link'    => __( 'cancel#a#comment', 'text-domain' ),
                'label_submit'         => __( 'Voeg reactie toe', 'text-domain' ),
                'comment_notes_before'	=> '<p class="comment-notes">' . __( 'text#before#comment#box', 'text-domain' ) . '</p>',
            
                
            );

            return $defaults;
    }
    add_filter( 'comment_form_defaults', 'alter_comments_defaults' );



//MENU LOCATIONS
function register_menu_locations() {
 register_nav_menus(
array(
       'primary-menu' => __( 'Primary Menu' ),
      'footer-menu' => __( 'Footer Menu' )     )
    );
 }
 add_action( 'init', 'register_menu_locations' );


//SIDEBAR LOCATIONS
function register_sidebar_locations() {
    /* Register the 'primary' sidebar. */
    register_sidebar(
        array(
            'id'            => 'social-sidebar',
            'name'          => __( 'Social Media Sidebar' ),
            'description'   => __( 'socialmedia sidebar.' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
    /* Repeat register_sidebar() code for additional sidebars. */
        register_sidebar(
        array(
            'id'            => 'pagina-sidebar',
            'name'          => __( 'Pagina Sidebar' ),
            'description'   => __( 'menu sidebar.' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        )
    );

}
add_action( 'widgets_init', 'register_sidebar_locations' );


// CUSTOM LOGO LOGIN
    function my_login_logo() { ?>
        <style type="text/css">
            #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri();?>/images/BJVEGAN.png);
            height:100px;
            width:320px;
            background-size: 320px 100px;
            background-repeat: no-repeat;
            padding-bottom: 30px;
            }
        </style>
    <?php }
    add_action( 'login_enqueue_scripts', 'my_login_logo' );
