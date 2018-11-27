<?php
/* Template Name: Print */ 
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
?>
<div id="print-content" class="print-wrap">
	<div id="print-info">
		<div class="profile-pic"><?php echo wp_get_attachment_image($imageLink, [300,300]); ?></div>
		<div class="profile-info">
			<h1 class="print-name"><?php echo $firstName . " " . $lastName; ?></h1>
			<h2 class="print-company"><?php echo $company; ?></h2>
			<h3 class="print-position"><?php echo $jobPosition; ?></h3>
			<h4 class="print-email"><?php echo $email; ?></h4>
			<h4 class="print-phone"><?php echo $phone; ?></h4>
		</div>
	</div>
</div>
<script type="text/javascript">
	
</script>
<?php get_footer(); ?>