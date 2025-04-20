<?php

if(isset($_FILES['file']['name'])){

	/* Getting file name */
	$filename = $_FILES['file']['name'];

	/* Location */
	$location = "/var/www/html/upload/".$filename;
	$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
	$imageFileType = strtolower($imageFileType);

	/* Valid extensions */
	$valid_extensions = array("jpg","jpeg","png");

	$response = 0;
	/* Check file extension */
	if(in_array(strtolower($imageFileType), $valid_extensions)) {
	   	/* Upload file */
		if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
	    	$response = $location .' '. $_POST["port"];
		}
	}
	$cid ="1234";
    // post to api
	$strUrl = "http://localhost:59353/admin/uploadfilesilp.aspx";//?deposit_acc=". $_POST["port"]."&s_cid=12345"; // e.g. http://localhost/myuploader/upload.php // request URL

	$filedata = $_FILES['file']['tmp_name'];
	$filesize = $_FILES['file']['size'];
	//echo $strUrl;
	if ($filedata != '')
	{
		// echo $strUrl;
		// echo $response;
		// $headers = array("Content-Type:multipart/form-data");
		// $postfields = array("filedata" => "@$filedata", "filename" => $filename);// ,"s_cid" => $cid ,"deposit_acc" => $_POST["port"]);
		// $options = array(
		// 	CURLOPT_URL => $url,
		// 	CURLOPT_HEADER => true,
		// 	CURLOPT_POST => 1,
		// 	CURLOPT_HTTPHEADER => $headers,
		// 	CURLOPT_POSTFIELDS => $postfields,
		// 	CURLOPT_INFILESIZE => $filesize,
		// 	CURLOPT_RETURNTRANSFER => true
		// ); // cURL options
		// $ch = curl_init();
		// curl_setopt_array($ch, $options);
		// curl_exec($ch);
		// if(!curl_errno($ch))
		// {
		// 	$info = curl_getinfo($ch);
		// if ($info['http_code'] == 200)
		// 	$errmsg = "File uploaded successfully";
		// 	echo errmsg;
		// }
		// else
		// {
		// 	$errmsg = curl_error($ch);
		// }
		// curl_close($ch);
		$headers = [
			'Content-Type: multipart/form-data',
			'User-Agent: '.$_SERVER['HTTP_USER_AGENT'],
		];
		// $ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL,$strUrl );
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$fields = [
			'slip' => new CURLFile($location, 'image/'.$imageFileType ),
			"deposit_acc" => $_POST["port"], 
			"s_cid" => $cid
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $strUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close ($ch);
		echo $response;
		echo $result;
		exit;
	}
}

echo 0;