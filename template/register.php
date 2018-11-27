<?php
/* Template Name: Register */ 
global $wpdb;
get_header();
$shows = $wpdb->get_results("SELECT * FROM Conferences;" );
if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']) && $_POST['show'] != -1)
{
   $result = $wpdb->get_results("SELECT * FROM Users WHERE username = '" . $_POST['username'] . "';" );
   if (sizeof($result) == 0) {
	   	$wpdb->insert('Users', array(
	    'username' => $_POST['username'],
	    'password' => $_POST['password'],
	    'email' => (isset($_POST['email']) ? $_POST['email'] : ""),
		));
		$result = $wpdb->get_results("SELECT * FROM Users WHERE username = '" . $_POST['username'] . "';" );
		$wpdb->insert('Profiles', array(
	    'firstName' => "",
	    'lastName' => "",
	    'imageLink' => "",
	    'company' => "",
	    'jobPosition' => "",
	    'phone' => "",
	    'email' => (isset($_POST['email']) ? $_POST['email'] : ""),
	    'userId' => $result[0]->userId,
	    'conferenceId' => $_POST['show'],
		));
		$url = get_site_url() . '?userId=' . $result[0]->userId;
	   	$string = '<script type="text/javascript">';
	    $string .= 'window.location = "' . $url . '"';
	    $string .= '</script>';
	    echo $string;
   }
   echo '<h1>The following username has already been selected</h1>';
} 
else if (isset($_POST['submit']) && (isset($_POST['username']) || isset($_POST['password']) || $_POST['show'] != -1))
{
	echo '<h1>One of the following fields was not filled out correctly</h1>';
}
?>
<section class="login">
	<div class="login__icon">Food Show</div>
	<form class="login__form" method="post" action="<?php echo get_site_url() . '/register'; ?>">
		<input type="text" name="username" placeholder="USERNAME" class="form__username" />
		<input type="password" name="password" placeholder="PASSWORD" class="form__password" />
		<input type="text" name="email" placeholder="EMAIL" class="form__username" />
		<select name="show">
			<option value="-1">Select Show</option>
			<?php foreach ($shows as $show) {
				echo '<option value="' . $show->conferenceId . '">' . $show->title . '</option>';
			} ?>
		</select>
		<button type="submit" class="form__submit-login" value="click" name="submit">REGISTER</button>
		<a href="<?php echo get_site_url() . '/login'; ?>" class="form__submit-request">ALREADY HAVE AN ACCOUNT? LOGIN</a>
	</form>
</section>
<?php get_footer(); ?>