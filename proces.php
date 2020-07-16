<?php
include_once 'database.php';
function encrypt_3des($clear_text, $key) {
        $encrypt_text = openssl_encrypt($clear_text, "DES-EDE3", $key, OPENSSL_RAW_DATA, "");
        $data = base64_encode($encrypt_text);

        return $data;
    }

    function decrypt_3des($data, $key) {
        $encrypt_text = base64_decode($data);
        $clear_text = openssl_decrypt($encrypt_text, "DES-EDE3", $key, OPENSSL_RAW_DATA, "");

        return $clear_text;
    }
    $key = md5(microtime().rand());
if(isset($_POST['save']))
{	 
	 $first_name = $_POST['first_name'];
	 $last_name = $_POST['last_name'];
	 $username = $_POST['username'];
	 $phoneno = $_POST['phoneno'];
	 $email = $_POST['email'];
	 $address = $_POST['address'];
	 $cardname = $_POST['cardname'];
	 $card_no = $_POST['card_no'];
	 $exp_date = $_POST['exp_date'];
	 $cvv = $_POST['cvv'];

	 //encrypting account details using 3des 
	 $card_no_encrypt = encrypt_3des($card_no, $key);
	 $exp_date_encrypt = encrypt_3des($exp_date, $key);
	 $cvv_encrypt = encrypt_3des($cvv, $key);

	 $sql = "INSERT INTO payment (firstName,username,phoneno,email,address,cardname,card_no,exp_date,cvv)
	 VALUES ('$first_name','$username','$phoneno','$email','$address','$cardname','$card_no_encrypt','$exp_date_encrypt','$cvv_encrypt')";

	 //decrypting account details using 3des
	 $card_no_decrypt = decrypt_3des($card_no_encrypt, $key);
	 $exp_date_decrypt = decrypt_3des($exp_date_encrypt, $key);
	 $cvv_decrypt = decrypt_3des($cvv_encrypt, $key);
	 if (mysqli_query($conn, $sql)) {
		echo "
			
			<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' integrity='sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh' crossorigin='anonymous'>
			<body>

				<div class='card text-center'>
				<div class='card-header'>
					<h1>Account Details</h1>
				</div>
				<div class='card-body'>
					<h4 class='card-title'>Card Details</h4>
					<p class='card-text'>	
					<div class='form-group row'>
						<label for='example-text-input' class='col-2 col-form-label'><h4 style='text-align:center'>Card name :</h4></label>
						<div class='col-10'>
							<input class='form-control' type='text' value='".$cardname."' id='example-text-input'>
						</div>
					</div>
					<h4 class='card-title'>After encrypting</h4>
					<div class='form-group row'>
						<label for='example-text-input' class='col-2 col-form-label'><h4 style='text-align:center'>Card name :</h4></label>
						<div class='col-10'>
							<input class='form-control' type='text' value='".$cardname."' id='example-text-input'>
						</div>
					</div>
					<div class='form-group row'>
						<label for='example-text-input' class='col-2 col-form-label'><h4 style='text-align:center'>Card no :</h4></label>
						<div class='col-10'>
							<input class='form-control' type='text' value='".$card_no_encrypt."' id='example-text-input'>
						</div>
					</div>
					<div class='form-group row'>
						<label for='example-text-input' class='col-2 col-form-label'><h4 style='text-align:center'>Exp date :</h4></label>
						<div class='col-10'>
							<input class='form-control' type='text' value='".$exp_date_encrypt."' id='example-text-input'>
						</div>
					</div>
					<div class='form-group row'>
						<label for='example-text-input' class='col-2 col-form-label'><h4 style='text-align:center'>Cvv no :</h4></label>
						<div class='col-10'>
							<input class='form-control' type='text' value='".$cvv_encrypt."' id='example-text-input'>
						</div>
					</div>
					<h4 class='card-title'>After decrypting</h4>
					
					<div class='form-group row'>
						<label for='example-text-input' class='col-2 col-form-label'><h4 style='text-align:center'>Card no :</h4></label>
						<div class='col-10'>
							<input class='form-control' type='text' value='".$card_no_decrypt."' id='example-text-input'>
						</div>
					</div>
					<div class='form-group row'>
						<label for='example-text-input' class='col-2 col-form-label'><h4 style='text-align:center'>Exp date :</h4></label>
						<div class='col-10'>
							<input class='form-control' type='text' value='".$exp_date_decrypt."' id='example-text-input'>
						</div>
					</div>
					<div class='form-group row'>
						<label for='example-text-input' class='col-2 col-form-label'><h4 style='text-align:center'>Cvv no :</h4></label>
						<div class='col-10'>
							<input class='form-control' type='text' value='".$cvv_decrypt."' id='example-text-input'>
						</div>
					</div>
			
					<a href='index.html' class='btn btn-primary'>HomePage</a>
				</div>
				<div class='card-footer text-muted'>
					2 days ago
				</div>
				</div>
							
			</body>
			";



			
			
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($conn);
	 }
	 echo '<script>alert("Payment Successful")</script>'; 
	 mysqli_close($conn);
}
//echo $data."\n";
//echo decrypt_3des($data, $key)."\n";
?>