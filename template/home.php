<?php
/* Template Name: Home */ 
if (empty($_GET["userId"]))
{
  if ( wp_redirect(get_site_url() . '/login') ) {
  	exit;
  }
} 
global $wpdb;
get_header();
if($_GET["userId"])
{
	$userId = $_GET["userId"];
   	$result = $wpdb->get_results("SELECT * FROM Profiles WHERE userId = '" . $_GET['userId'] . "';" );
   	$firstName = $result[0]->firstName;
   	$lastName = $result[0]->lastName;
   	$imageLink = $result[0]->imageLink;
   	$company = $result[0]->company;
   	$jobPosition = $result[0]->jobPosition;
   	$phone = $result[0]->phone;
   	$email = $result[0]->email;
   	$conferenceId = $result[0]->conferenceId;
   	$result = $wpdb->get_results("SELECT * FROM Conferences WHERE conferenceId = '" . $conferenceId . "';" );
   	$conferenceTitle = $result[0]->title;
}
if(isset($_POST['submit']))
{
	$updateItems = array();
	if (!empty($_POST['firstName'])) {
		$updateItems['firstName'] = $_POST['firstName'];
	}
	if (!empty($_POST['lastName'])) {
		$updateItems['lastName'] = $_POST['lastName'];
	}
	if ($_FILES['profilePic']['size'] != 0) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		$attachment_id = media_handle_upload( 'profilePic' );
		$updateItems['imageLink'] = $attachment_id;
	}
	if (!empty($_POST['company'])) {
		$updateItems['company'] = $_POST['company'];
	}
	if (!empty($_POST['jobPosition'])) {
		$updateItems['jobPosition'] = $_POST['jobPosition'];
	}
	if (!empty($_POST['phone'])) {
		$updateItems['phone'] = $_POST['phone'];
	}
	if (!empty($_POST['email'])) {
		$updateItems['email'] = $_POST['email'];
	}
	$wpdb->update(
		'Profiles',
		$updateItems,
		array( 'userId' => $userId )
	);
	$result = $wpdb->get_results("SELECT * FROM Profiles WHERE userId = '" . $_GET['userId'] . "';" );
   	$firstName = $result[0]->firstName;
   	$lastName = $result[0]->lastName;
   	$imageLink = $result[0]->imageLink;
   	$company = $result[0]->company;
   	$jobPosition = $result[0]->jobPosition;
   	$phone = $result[0]->phone;
   	$email = $result[0]->email;
   	$conferenceId = $result[0]->conferenceId;
   	$result = $wpdb->get_results("SELECT * FROM Conferences WHERE conferenceId = '" . $conferenceId . "';" );
   	$conferenceTitle = $result[0]->title;
} 
if(isset($_POST['delete']))
{	
	$wpdb->delete('Users', array('userId' => $userId));
	$wpdb->delete('Profiles', array('userId' => $userId));
	$url = get_site_url() . '/login';
   	$string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';
    echo $string;
}
include('phpqrcode/qrlib.php'); 
QRcode::png(get_site_url() . '/print/?userId=' . $userId, 'wp-content/themes/associatedApp/qrcodes/' . $userId . 'QR.png', QR_ECLEVEL_L, 4);
?>
<div id="QR-code" style="text-align: center; padding-top: 30px">
	<img style="width: 100%; max-width: 500px; margin: auto; margin-bottom: 30px;" src="wp-content/themes/associatedApp/qrcodes/<?php echo $userId; ?>QR.png" />
	<button id="print-button-back" onclick="printBackOption()">Back</button>
</div>
<div id="main-content" class="main-wrap">
	<h1>Welcome to <?php echo $conferenceTitle; ?></h1>
	<h2>My Profile</h2>
	<ul id="display-info">
		<li>Profile Picture:</li>
		<li><?php echo wp_get_attachment_image($imageLink); ?></li>
		<li>First Name: <?php echo $firstName; ?></li>
		<li>Last Name: <?php echo $lastName; ?></li>
		<li>Company: <?php echo $company; ?></li>
		<li>Job Position: <?php echo $jobPosition; ?></li>
		<li>Phone Number: <?php echo $phone; ?></li>
		<li>Email: <?php echo $email; ?></li>
	</ul>
	<ul id="edit-info">
		<div class="form-info" style="width: 20%; float: left;">
		<p>Image:</p>
		<p>First Name:</p>
		<p>Last Name:</p>
		<p>Company:</p>
		<p>Job Position:</p>
		<p>Phone Number:</p>
		<p>Email:</p>
		</div>
		<form style="width: 80%; float: left;" method="post" action="<?php echo get_site_url() . '/?userId=' . $_GET["userId"]; ?>" enctype="multipart/form-data">
			<input type="file" name="profilePic" />
			<input type="text" name="firstName" />
			<input type="text" name="lastName" />
			<input type="text" name="company" />
			<input type="text" name="jobPosition" />
			<input type="text" name="phone" />
			<input type="text" name="email" />
			<button id="update" type="submit" value="Upload" name="submit">Update</button>
			<button id="update" type="submit" value="click" name="delete">Delete All</button>
		</form>
	</ul>
	<button id="edit-button" onclick="editOption()">Edit</button>
	<button id="display-button" onclick="displayOption()">Cancel</button>
	<button id="print-button" onclick="printOption()">Print QR code</button>
</div>
<script type="text/javascript">
	var displayInfo = document.getElementById("display-info");
	var editInfo = document.getElementById("edit-info");
	var displayButton = document.getElementById("display-button");
	var editButton = document.getElementById("edit-button");
	var updateButton = document.getElementById("update");
	var printScreen = document.getElementById("QR-code");
	var mainContent = document.getElementById("main-content");

	editInfo.style.display = "none";
	displayButton.style.display = "none";
	updateButton.style.display = "none";
	printScreen.style.display = "none";
	function editOption() {
		displayInfo.style.display = "none";
		editInfo.style.display = "block";
		editButton.style.display = "none";
		displayButton.style.display = "block";
		updateButton.style.display = "block";
	}
	function displayOption() {
		displayInfo.style.display = "block";
		editInfo.style.display = "none";
		editButton.style.display = "block";
		displayButton.style.display = "none";
		updateButton.style.display = "none";
	}
	function printOption() {
		printScreen.style.display = "grid";
		mainContent.style.display = "none";
	}
	function printBackOption() {
		printScreen.style.display = "none";
		mainContent.style.display = "block";
	}
</script>
<?php get_footer(); ?>
