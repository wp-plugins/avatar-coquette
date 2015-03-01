<?php
/*
Plugin Name: Avatar Coquette
Plugin URI:
Description: avatar,Change avatar sad wordpress by other coquette
Tags: Change avatar Wordpress, Change my avatar in wordpress, avartar custom in wordpress, comment change avartar plugin, custom avatar wordpress, plugin comments, wordpress new avatar, wordpress plugin,seo,comments,addon comments, avatar comments,avatar wp,avatar comment
Version: 2.1
Author: iLen
Author URI:
*/
if ( !class_exists('avatar_coquette') ) {
require_once 'assets/functions/options.php';
class avatar_coquette extends avatar_coquette_make{

    public $parameter       = array();
    public $options         = array();
    public $components      = array();


    var $letter_by_number = array();

    function __construct(){

        parent::__construct(); // configuration general



        if( is_admin() ){
            
            add_action( 'admin_enqueue_scripts', array( &$this,'script_and_style_admin' ) );

            add_action( 'show_user_profile', array( &$this,'additional_user_fields_avatar' ) );
            add_action( 'edit_user_profile', array( &$this,'additional_user_fields_avatar' ) );

            add_action( 'personal_options_update', array( &$this,'save_additional_user_meta_avatar' ) );
            add_action( 'edit_user_profile_update', array( &$this,'save_additional_user_meta_avatar' ) );

        }elseif( ! is_admin() ) {

            global $option_avatar_coquette;

            self::get_letter_by_number();

            $option_avatar_coquette = get_option( $this->parameter['name_option']."_options" ) ;
            if( $option_avatar_coquette[$this->parameter['name_option'].'_enabled'] ){
                add_action( 'wp_enqueue_scripts', array( &$this,'script_and_style_front' ) );
                add_filter('get_avatar',array($this,'get_coquette_avatar'),10,4);
            }

        }



    }
 
    function script_and_style_admin(){
        //var_dump( get_current_screen()->id );
        if( isset($_GET["page"]) && $_GET["page"] == $this->parameter["name_option"] || get_current_screen()->id == "profile" ){
            // Enqueue Scripts
            if(function_exists( 'wp_enqueue_media' )){
                wp_enqueue_media();
            }else{
                wp_enqueue_script('media-upload'); // else put this
                wp_enqueue_script('media-models');
            }
            wp_enqueue_script( 'admin-avatar-coquette-js', plugins_url('/assets/js/avatar-coquette.js',__FILE__), array( 'jquery' ), '1.0', true );
            wp_enqueue_style( 'admin-avatar-coquette-css', plugins_url('/assets/css/avatar-coquette.css',__FILE__),'all',$this->parameter['version']);

        }
    }

    function script_and_style_front(){
        wp_enqueue_style( 'front-avatar-coquette-css', plugins_url('/assets/css/front.css',__FILE__),'all',$this->parameter['version']);
    }
 


    function validate_gravatar($email) {
        // Craft a potential url and test its headers
        $hash = md5(strtolower(trim($email)));
        $uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
        $headers = @get_headers($uri);
        if (!preg_match("|200|", $headers[0])) {
            $has_valid_avatar = FALSE;
        } else {
            $has_valid_avatar = TRUE;
        }
        return $has_valid_avatar;
    }


    function get_coquette_avatar($avatar , $id_or_email , $size = '90'  , $default , $alt = false){

        global $option_avatar_coquette,$post;
        $active_change_avatar = false;

        if( !  $default = $option_avatar_coquette[$this->parameter['name_option'].'_avatar_default'] )
            $default = plugins_url()."/avatar-coquette/assets/images/default.png";

        if(is_string($id_or_email)){
            // email user
            /*if( self::validate_gravatar( $id_or_email ) ){
                $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower($id_or_email)) . "?d=" . urlencode($default) . "&s=" . $size;
            }else{
                $grav_url = $default;
                $active_change_avatar = true;
            }*/

            $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower($id_or_email)) . "?d=" . urlencode($default) . "&s=" . $size;

        }elseif( is_numeric($id_or_email) ){
            // id user 
            $grav_url = $default;
            $active_change_avatar = true;

        }elseif( is_object( $id_or_email ) ) {


            /*if( $id_or_email->comment_author_email && self::validate_gravatar( $id_or_email->comment_author_email ) ){
                $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower( $id_or_email->comment_author_email )) . "?d=" . urlencode($default) . "&s=" . $size;
            }else*/
            if( $option_avatar_coquette[$this->parameter['name_option'].'_set_avatar'] !=3 ){
                $letter = null;

                if( $id_or_email->user_id == $post->post_author && $attachment_url = esc_url( get_the_author_meta( 'user_meta_image', $post->post_author ) ) ){

                    $grav_url = $attachment_url;

                }else{

                    if( $option_avatar_coquette[$this->parameter['name_option'].'_criteria'] == 1 ){
                        $letter = strtolower($id_or_email->comment_author[0]);
                    }elseif(  $option_avatar_coquette[$this->parameter['name_option'].'_criteria'] == 2 ){
                        $letter = strtolower(substr($id_or_email->comment_author, -1) );
                    }

                    $number_avatar = null;
                    if(  $number_avatar = $this->letter_by_number[ $letter ] ){
                        $grav_url = plugins_url()."/avatar-coquette/assets/images/".$option_avatar_coquette[$this->parameter['name_option'].'_set_avatar']."/$number_avatar.png";
                    }else{
                        $grav_url = $default;
                    }
                    $active_change_avatar = true;

                }

            }elseif( $option_avatar_coquette[$this->parameter['name_option'].'_set_avatar'] ==3 ){
                $grav_url = $default;
                $active_change_avatar = true;
            }


        }else{

            $grav_url = $default;

        }

        $span = "";
        //if( $active_change_avatar && $option_avatar_coquette[$this->parameter['name_option'].'_enabled_text'] )
            //$span = "<span style='position:absolute;top:0;left:0;'><a href='".$option_avatar_coquette[$this->parameter['name_option'].'_link_change_avatar']."' target='_blank'>".$option_avatar_coquette[$this->parameter['name_option'].'_text_change_avatar']."</a></span>";
        //$avatar = "<div style='height:{$size}px;width:{$size}px;oveflow:hidden;position:relative'>$span<img src='$grav_url' width='$size' height='$size' alt='$alt' class='avatar avatar-{$size} photo' /></div>";
        $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower( $id_or_email->comment_author_email )) . "?d=" . urlencode( $grav_url ) . "&s=" . $size;
        $avatar = "<img src='$grav_url' width='$size' height='$size' alt='$alt' class='avatar avatar-{$size} photo' />";

        return $avatar;
    }

    function get_letter_by_number(){
        $azRange = range('a', 'z');
        $array_avatar = array();
        $i=1;
        foreach ($azRange as $letter)
        {
            $array_avatar[$letter] = $i;
            $i++;
        }

        $this->letter_by_number = $array_avatar;
    }


    /**
     * Adds additional user fields
     * more info: http://justintadlock.com/archives/2009/09/10/adding-and-using-custom-user-profile-fields
     * url: http://s2webpress.com/add-image-uploader-to-profile-admin-page-wordpress/
     */
     
    function additional_user_fields_avatar( $user ) { ?>
     
        <h3><?php _e( 'Additional User Image (Avatar Coquette)', '' ); ?></h3>
     
        <table class="form-table avatar-coquette-table">
     
            <tr>
                <th><label for="user_meta_image"><?php _e( 'A special image for each user', '' ); ?></label></th>
                <td>
                    <!-- Outputs the image after save -->
                    <img src="<?php echo esc_url( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" style="width:150px;clear:both"> 
                    <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                    <input type="text" name="user_meta_image" id="user_meta_image" value="<?php echo esc_url_raw( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" class="regular-text" style='float:left; margin-right:5px;' />
                    <!-- Outputs the save button -->
                    <input type='button' class="additional-user-image button-primary" value="<?php _e( 'Upload Image', '' ); ?>" id="uploadimage" style='float:left'/><br />
                    <span class="description" style='display:block;clear:both'><?php _e( 'Upload an additional image for your user profile.', '' ); ?></span>
                </td>
            </tr>
     
        </table><!-- end form-table -->
    <?php } // additional_user_fields
     
    /**
    * Saves additional user fields to the database
    */
    function save_additional_user_meta_avatar( $user_id ) {
     
        // only saves if the current user can edit user profiles
        if ( !current_user_can( 'edit_user', $user_id ) )
            return false;
     
        update_usermeta( $user_id, 'user_meta_image', $_POST['user_meta_image'] );
    }
     





} // end class
} // end if

global $IF_CONFIG;
unset($IF_CONFIG);
$IF_CONFIG = null;
$IF_CONFIG = new avatar_coquette;
require_once "assets/ilenframework/core.php";
?>