<?php 
	require_once("../include/incl.header.php");

	include_once('../businessLogic/managed11.php');
	include_once('../businessLogic/managed11Data.php');
	include_once('../businessLogic/utilFunctions.php');
	
	//Call API to get the access token needed for the REST API calls
	$access_token =buildAndProcessGetAccessToken();
	$_SESSION['access_token'] = $access_token;


	$mamReqArray = json_decode($mamRequestData, true);
	$newSellerEmailAddress = generateEmailAddress();
	$mamReqArray['owner_info']['email'] = $newSellerEmailAddress; //update the email address with a random generated value
	$mamRequestJson = json_encode($mamReqArray);
	$action_url = buildAndProcessMAM($_SESSION['access_token'], $mamRequestJson);

?>
		
		<script>
		
			// Load the default state of the Overview icons for this page
			$(document).ready(function() {					
				
				overviewHighlight("#icon-isu"); // ISU				
				overviewDefault("#icon-checkout"); // Checkout
				overviewGrayout("#icon-disburse"); // Disburse
				overviewGrayout("#icon-refund"); // Refund
				overviewDefault("#icon-reports"); // Reports
				
			});		
		</script>

		<div class="container-fluid">
		
			<div class="row">

				<!-- --------- UPPER LEFT --------- -->			
				<div class="col-sm-6">

					<div class="divBorder" style="min-height: 470px;">

                        <h3> MAM Setup: Your merchant’s Experience </h3>

						<br/>
						<h4> PayPal Payments</h4>
						<!--Script to get the mini-browser or in-context flow for the MAM Setup experience-->
						<!--Display Success message for MAM Setup completion-->
                        						<h4  style="margin-top: 25px;color:#62BD97 ">Setup Complete</h4>
                        						<br/>
                                                						<br/>
                                                						<br/>

                                                						Your MAM Account has been created and PayerID ID: <b><?php print_r($action_url);?></b>. 
                                                						<br/><br/>


					</div>
				</div>

				
				<!-- ---------  UPPER RIGHT: Overview icons section --------- -->
				<div class="col-sm-6">
					<div class="divBorder" style="min-height: 470px;">

						<?php require_once("../include/incl.overview.php"); ?>
						
					</div>
				</div>   

				
				<!-- ---------  BOTTOM: Readme --------- -->
				<div class="col-xs-12">
					<a id="readme"></a>
					<div class="divBorder">
					 	<?php include("../include/incl.readme.php"); ?>
					</div>
				</div>  
				

			</div> <!-- row -->

		</div> <!-- container-fluid -->

<?php require_once("../include/incl.footer.php"); ?>
