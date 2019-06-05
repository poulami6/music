

<?php
   /**
    * Template Name: Payment Process Page
    *
    * @package WordPress
    * @subpackage Twenty_Sixteen
    * @since Twenty Sixteen 1.0
    */
   get_header();
   
if(!is_user_logged_in()){
?>
<script language="javascript" type="text/javascript">
var url = '<?php echo home_url();?>';
document.location = url;
</script>
<?php
exit();
}

ob_start();
// For test payments we want to enable the sandbox mode. If you want to put live
// payments through then this setting needs changing to `false`.
$enableSandbox = true;

if( function_exists('fw_get_db_settings_option') ) {
  $enableSandbox = fw_get_db_settings_option( 'paypal_mode' ) == 'testing' ? true : false;
  $paypal_business_email = fw_get_db_settings_option( 'paypal_business_email' );
  $paypal_success_page_url = fw_get_db_settings_option( 'paypal_success_page_url' );
  $paypal_cancel_page_url = fw_get_db_settings_option( 'paypal_cancel_page_url' );
  $currency_code = fw_get_db_settings_option( 'paypal_currency' );
}

// PayPal settings. 
$paypalConfig = [
  'email' => $paypal_business_email,
  'return_url' => $paypal_success_page_url ? $paypal_success_page_url : site_url(),
  'cancel_url' => $paypal_cancel_page_url ? $paypal_cancel_page_url : site_url(),
  'notify_url' => esc_url(home_url( '/payment-processing/' )),
];

$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

$itemName = $_POST['item_name'];
$itemAmount = get_post_meta($_POST['item_number'], 'fw_option:plan_price', true);
$plan_validity = get_post_meta($_POST['item_number'], 'fw_option:plan_validity', true);
$monthly_download = get_post_meta($_POST['item_number'], 'fw_option:plan_monthly_downloads', true);
$monthly_upload = get_post_meta($_POST['item_number'], 'fw_option:plan_monthly_upload', true) ? get_post_meta($_POST['item_number'], 'fw_option:plan_monthly_upload', true) : 50;

// Include Functions
//require '../paypal/functions.php';

// Check if paypal request or response
if ( !isset($_POST["txn_id"]) ) {

  // Grab the post data so that we can set up the query string for PayPal.
  // Ideally we'd use a whitelist here to check nothing is being injected into
  // our post data.
  $data = [];
  foreach ($_POST as $key => $value) {
    $data[$key] = stripslashes($value);
  } 

  // Set the PayPal account.
  $data['business'] = $paypalConfig['email'];

  // Set the PayPal return addresses.
  $data['return'] = stripslashes($paypalConfig['return_url']);
  $data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
  $data['notify_url'] = stripslashes($paypalConfig['notify_url']);

  // Set the details about the product being purchased, including the amount
  // and currency so that these aren't overridden by the form data.
  $data['amount'] = $itemAmount;
  $data['currency_code'] = $currency_code;
  $data['item_name'] = $itemName;
  $data['item_number'] = $_POST['item_number'];

  $custom_arr = array('user_id' => $_POST['user_id'], 'plan_validity' => $plan_validity, 'ms_download' => $monthly_download, 'ms_upload' => $monthly_upload);
  $data['custom'] = json_encode($custom_arr);

  // Build the query string from the data.
  $queryString = http_build_query($data);

  // echo "<pre>";
  // print_r($data);
  // die();

  // Redirect to paypal IPN
  header('location:' . $paypalUrl . '?' . $queryString);
  exit();

} else {
  // Handle the PayPal response.
  // Assign posted variables to local data array.
  $custom_res = stripslashes($_POST['custom']);
  $custom_res1 = json_decode( $custom_res );
  
  $data = [
    'plan_name' => $_POST['item_name'],
    'plan_number' => $_POST['item_number'],
    'user_id' => $custom_res1->user_id,
    'plan_validity' => $custom_res1->plan_validity,
    'monthly_download' => $custom_res1->ms_download,
    'monthly_upload' => $custom_res1->ms_upload,
    'payment_status' => $_POST['payment_status'],
    'payment_amount' => $_POST['mc_gross'],
    'payment_currency' => $_POST['mc_currency'],
    'txn_id' => $_POST['txn_id'],
    'receiver_email' => $_POST['receiver_email'],
    'payer_email' => $_POST['payer_email'],
  ];

  // We need to verify the transaction comes from PayPal and check we've not
  // already processed the transaction before adding the payment to our
  // database.
  if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {
    if (addPayment($data) !== false) {
      /*Payment successfully added.*/
    }
  }
}
ob_end_clean();

?>



<?php get_footer();?>

