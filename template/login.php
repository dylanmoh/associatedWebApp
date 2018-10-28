<?php
/* Template Name: Login */ 
global $wpdb;
get_header();
if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']))
{
   	$result = $wpdb->get_results("SELECT * FROM Users WHERE username = '" . $_POST['username'] . "' AND password = '" . $_POST['password'] . "';" );
   	$url = get_site_url() . '?userId=' . $result[0]->userId;
   	$string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';
    echo $string;
} 
?>
<section class="login">
	<div class="login__icon">Food Show</div>
	<form class="login__form" method="post" action="<?php echo get_site_url() . '/login'; ?>">
		<input type="text" name="username" placeholder="USERNAME" class="form__username" />
		<input type="password" name="password" placeholder="PASSWORD" class="form__password" />
		<a class="login__forgot" href="#">Forgot username/password?</a>
		<button type="submit" class="form__submit-login" value="click" name="submit">LOGIN</button>
		<a href="<?php echo get_site_url() . '/register'; ?>" class="form__submit-request">NEW? REQUEST FOOD SHOW ACCESS</a>
	</form>
</section>
<?php get_footer(); ?>