<?php
include 'config.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json; charset=utf-8');

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}

if(count($_POST)>0){
	if($_POST['type']==1){
		$email = isset($_POST['email']) ? $_POST['email'] : die(json_encode(array("status"=>false,"message"=>"Email required")));
        
		$sql = "SELECT * FROM member WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
		if ($row) {
         
			echo json_encode(array("status"=>true,"message"=>$row));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==2){
		$sql = "SELECT count(*) AS Total FROM member";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
		if ($row) {
            echo json_encode(array("status"=>true,"message"=>$row));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==3){
		$sql = "SELECT count(*) AS Total FROM invitecode";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
		if ($row) {
            echo json_encode(array("status"=>true,"message"=>$row));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}
if(count($_POST)>0){
	if($_POST['type']==4){
		$sql = "SELECT * FROM member ORDER BY joined_at DESC LIMIT 5";
        $result = mysqli_query($conn, $sql);

        $resARR = array();

        while($row = mysqli_fetch_assoc($result)){
            $resARR[] = $row;
        }
		if ($resARR) {
            echo json_encode(array("status"=>true,"message"=>$resARR));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}
if(count($_POST)>0){
	if($_POST['type']==5){
		$UID = getToken(8);
		$sql = "INSERT INTO invitecode (uid) VALUES ('$UID')";
		if (mysqli_query($conn, $sql)) {
            echo json_encode(array("status"=>true,"message"=>$UID));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==6){
		$UID = getToken(8);
		$sql = "SELECT * FROM invitecode ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        $resARR = array();

        while($row = mysqli_fetch_assoc($result)){
            $resARR[] = $row;
        }
		if ($resARR) {
            echo json_encode(array("status"=>true,"message"=>$resARR));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==7){
		$sql = "SELECT * FROM member ORDER BY joined_at DESC";
        $result = mysqli_query($conn, $sql);
        $resARR = array();

        while($row = mysqli_fetch_assoc($result)){
            $resARR[] = $row;
        }
		if ($resARR) {
            echo json_encode(array("status"=>true,"message"=>$resARR));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==8){
		$infoData = isset($_POST['infoData']) ? $_POST['infoData'] : die(json_encode(array("status"=>false,"message"=>"infoData required")));
        
		$sql = "INSERT INTO `info` (`key`,`data`) VALUES ('infomation', '$infoData') ON DUPLICATE KEY UPDATE `data` = '$infoData';";

        $result = mysqli_query($conn, $sql);
     
		if ($result) {
            echo json_encode(array("status"=>true,"message"=>$result));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==9){

		$sql = "SELECT * FROM info WHERE `key` = 'infomation' ";

        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);

		if ($row) {
			// $row['data'] = json_decode($row['data']);
            echo json_encode(array("status"=>true,"message"=>$row));
		} 
		else {
			echo json_encode(array("status"=>false,"message"=>$row));
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==10){
		$sql = "SELECT * FROM prize WHERE is_deleted = 'F' ";

        $result = mysqli_query($conn, $sql);
		$resARR = array();

        while($row = mysqli_fetch_assoc($result)){
			$row['status'] = 'old';
            $resARR[] = $row;
        }
		if ($resARR) {
            echo json_encode(array("status"=>true,"message"=>$resARR));
		} 
		else {
			echo json_encode(array("status"=>false,"message"=>$resARR));
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==11){
		$email = isset($_POST['email']) ? $_POST['email'] : die(json_encode(array("status"=>false,"message"=>"email required")));

		$sql = "SELECT * FROM member WHERE `email` = '$email' ";

        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

		if ($row) {
            echo json_encode(array("status"=>true,"message"=>$row));
		} 
		else {
			echo json_encode(array("status"=>false,"message"=>$row));
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==12){
		$user = isset($_POST['user']) ? json_decode($_POST['user']) : die(json_encode(array("status"=>false,"message"=>"user required")));

		$sql = "INSERT INTO `member`
		(first_name, last_name, `role`, email, phone_no, extra_id)
		VALUES('$user->firstname', '$user->lastname', 'CUSTOMER', '$user->email', '$user->phone', '$user->winboxuid');";

        $result = mysqli_query($conn, $sql);

		if ($result) {
            echo json_encode(array("status"=>true,"message"=>'Register Successful'));
		} 
		else {
			echo json_encode(array("status"=>false,"message"=>'Register failed'));
		}
		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==13){
		$uid = isset($_POST['uid']) ? $_POST['uid'] : die(json_encode(array("status"=>false,"message"=>"uid required")));
		$email = isset($_POST['email']) ? $_POST['email'] : die(json_encode(array("status"=>false,"message"=>"email required")));

		$sql = "SELECT * FROM invitecode WHERE uid = '$uid' AND status = 'F' LIMIT 1";

        $result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);

		if($row){
			$sql = "SELECT id FROM prize WHERE is_deleted = 'F' ORDER BY chance * rand() DESC LIMIT 1;";
			$result = mysqli_query($conn, $sql);
			$row2 = mysqli_fetch_assoc($result);

			$Prize = $row2['id'];
			$sql = "UPDATE invitecode SET prizeId = '$Prize' ,email = '$email', status = 'T', update_at = now() WHERE uid = '$uid'";
			$result = mysqli_query($conn, $sql);

			if($result){
				echo json_encode(array("status"=>true,"message"=>$Prize));
			}else{
				echo json_encode(array("status"=>false,"message"=>'failed'));
			}

		}else{
			echo json_encode(array("status"=>false,"message"=>'failed'));
		}

		mysqli_close($conn);
	}
}

if(count($_POST)>0){
	if($_POST['type']==14){
		$prizeJson = isset($_POST['prizeJson']) ? json_decode($_POST['prizeJson']) : die(json_encode(array("status"=>false,"message"=>"prizeJson required")));

		foreach ($prizeJson as $value) {
			if($value->status == 'old'){
				$sql = "UPDATE prize SET name = '$value->name', `desc` ='$value->desc', img = '$value->img', chance = '$value->chance', is_deleted = '$value->is_deleted' WHERE id = '$value->id'";
			}else if($value->status == 'new'){
				$sql = "INSERT INTO prize (name,desc,img,chance) VALUES ('$value->name','$value->desc', '$value->img', '$value->chance') ";
			}
			$result = mysqli_query($conn, $sql);
		}


		if ($result) {
            echo json_encode(array("status"=>true,"message"=>'Succcesful'));
		} 
		else {
			// echo json_encode(array("status"=>false,"message"=>'Failed'));
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}


?>