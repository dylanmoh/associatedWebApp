<?php
/* Template Name: Register */ 
global $wpdb;
get_header();
if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']))
{
   $result = $wpdb->get_results("SELECT * FROM Users WHERE username = '" . $_POST['username'] . "';" );
   if (sizeof($result) == 0) {
	   	$wpdb->insert('Users', array(
	    'username' => $_POST['username'],
	    'password' => $_POST['password'],
	    'email' => $_POST['email'],
		));
		$result = $wpdb->get_results("SELECT * FROM Users WHERE username = '" . $_POST['username'] . "';" );
		$wpdb->insert('Profiles', array(
	    'firstName' => $_POST['firstName'],
	    'lastName' => $_POST['lastName'],
	    'company' => $_POST['company'],
	    'jobPosition' => $_POST['jobPosition'],
	    'phone' => $_POST['phone'],
	    'email' => $_POST['email'],
	    'userId' => $result[0]->userId,
	    'conferenceId' => 1,
		));
   }
} 
?>
<section class="login">
	<div class="login__icon">Food Show</div>
	<form class="login__form" method="post" action="<?php echo get_site_url() . '/register'; ?>">
		<input type="text" name="username" placeholder="USERNAME" class="form__username" />
		<input type="password" name="password" placeholder="PASSWORD" class="form__password" />
		<input type="text" name="firstName" placeholder="FIRST NAME" class="form__username" />
		<input type="text" name="lastName" placeholder="LAST NAME" class="form__username" />
		<input type="text" name="company" placeholder="COMPANY" class="form__username" />
		<input type="text" name="jobPosition" placeholder="JOB POSITION" class="form__username" />
		<input type="text" name="phone" placeholder="PHONE" class="form__username" />
		<input type="text" name="email" placeholder="EMAIL" class="form__username" />
		<button type="submit" class="form__submit-login" value="click" name="submit">REGISTER</button>
		<a href="<?php echo get_site_url() . '/login'; ?>" class="form__submit-request">ALREADY HAVE AN ACCOUNT? LOGIN</a>
	</form>
</section>
<?php get_footer(); ?>