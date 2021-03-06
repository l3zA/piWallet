<?php
define("IN_WALLET", true);
include('common.php');

$mysqli = new Mysqli($db_host, $db_user, $db_pass, $db_name);
if (!empty($_SESSION['user_session'])) {
    if(empty($_SESSION['token'])) {
        $_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
    }
    $user_session = $_SESSION['user_session'];
    $admin = false;
    if (!empty($_SESSION['user_admin']) && $_SESSION['user_admin']==1) {
        $admin = true;
    }
    $error = array('type' => "none", 'message' => "");
    #$client = new Client($rpc_host, $rpc_port, $rpc_user, $rpc_pass);
	
	$coin = new Coin($mysqli);
	$coins = $coin->getCoins();
	
	if($_GET['t'] == "true" && $_GET['p'] != ""){
		$c = new Client('localhost', $_GET['p'], 'rpc', 'pass');
		$transactionList = $c->getTransactionList($user_session);
	}
	
    $admin_action = false;
    if ($admin && !empty($_GET['a'])) {
        $admin_action = $_GET['a'];
    }
    if (!$admin_action) {
		if (!empty($_POST['jsaction'])) {
            $json = array();
            switch ($_POST['jsaction']) {
                case "withdraw":
                $json['success'] = false;
				if (empty($_POST['address']) || empty($_POST['totalAmount']) || !is_numeric($_POST['totalAmount'])) {
                    $json['message'] = "You have to fill all the fields";
					$message = "You have to fill all the fields";
                }else{
					$withdraw_amount = (float)$_POST['totalAmount'];
					$withdraw_amount = $withdraw_amount - (float)$reserve;
				}
				
                if (!WITHDRAWALS_ENABLED) {
                    $json['message'] = "Withdrawals are temporarily disabled";
					$message = "Withdrawals are temporarily disabled";
                } elseif (empty($_POST['address']) || empty($_POST['totalAmount']) || !is_numeric($_POST['totalAmount'])) {
                    $json['message'] = "You have to fill all the fields";
					$message = "You have to fill all the fields";
                } elseif ($_POST['token'] != $_SESSION['token']) {
                    $json['message'] = "Tokens do not match";
                    $_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
                    $json['newtoken'] = $_SESSION['token'];
					$message = "Tokens do not match";
                } elseif ($withdraw_amount > $_POST['balance']) {
                    $json['message'] = "Withdrawal amount exceeds your wallet balance. Please note the wallet owner has set a reserve fee of $reserve $short.";
					$message = "Withdrawal amount exceeds your wallet balance. Please note the wallet owner has set a reserve fee of $reserve $short.";
				} else {
					$withdraw_coin = new Client('localhost', $_POST['port'], 'rpc', 'pass');
                    $withdraw_message = $withdraw_coin->withdraw($user_session, $_POST['address'], $withdraw_amount);
					var_dump($withdraw_message);
					echo '!admin';
					echo $withdraw_coin->getBalance($user_session);
                    $_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
                    $json['newtoken'] = $_SESSION['token'];
                    $json['success'] = true;
                    $json['message'] = "Withdrawal successful";
					$message = $withdraw_message;
					header("Location: index.php");
                }
                echo json_encode($json); exit;
                break;
                case "password":
                $user = new User($mysqli);
                $json['success'] = false;
                if (empty($_POST['oldpassword']) || empty($_POST['newpassword']) || empty($_POST['confirmpassword'])) {
                    $json['message'] = "You have to fill all the fields";
					$message = "You have to fill all the fields";
                } elseif ($_POST['token'] != $_SESSION['token']) {
                    $json['message'] = "Tokens do not match";
                    $_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
                    $json['newtoken'] = $_SESSION['token'];
					$message = "Tokens do not match";
                } else {
                    $_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
                    $json['newtoken'] = $_SESSION['token'];
                    $result = $user->updatePassword($user_session, $_POST['oldpassword'], $_POST['newpassword'], $_POST['confirmpassword']);
                    if ($result === true) {
                        $json['success'] = true;
                        $json['message'] = "Password updated successfully.";
						$message = "Password updated successfully.";
                    } else {
                        $json['message'] = $result;
						$message = $result;
                    }
                }
                echo json_encode($json); exit;
                break;
            }
        }
        if (!empty($_POST['action'])) {
            switch ($_POST['action']) {
                case "new_address":
                header("Location: index.php");
                break;
                case "withdraw":
				if (empty($_POST['address']) || empty($_POST['totalAmount']) || !is_numeric($_POST['totalAmount'])) {
                    $json['message'] = "You have to fill all the fields";
					$message = "You have to fill all the fields";
                }else{
					$withdraw_amount = (float)$_POST['totalAmount'];
					$withdraw_amount = $withdraw_amount - (float)$reserve;
				}
                if (!WITHDRAWALS_ENABLED) {
                    $error['type'] = "withdraw";
                    $error['message'] = "Withdrawals are temporarily disabled";
					$message = "Withdrawals are temporarily disabled";
                } elseif (empty($_POST['address']) || empty($_POST['totalAmount']) || !is_numeric($_POST['totalAmount'])) {
                    $error['type'] = "withdraw";
                    $error['message'] = "You have to fill all the fields";
					$message = "You have to fill all the fields";
                } elseif ($_POST['token'] != $_SESSION['token']) {
                    $error['type'] = "withdraw";
                    $error['message'] = "Tokens do not match";
                    $_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
					$message = "Tokens do not match";
                } elseif ($withdraw_amount > $_POST['balance']) {
                    $error['type'] = "withdraw";
                    $error['message'] = "Withdrawal amount exceeds your wallet balance";
					$message = "Withdrawal amount exceeds your wallet balance";
                } else {
					
					$withdraw_coin = new Client('localhost', $_POST['port'], 'rpc', 'pass');
					$withdraw_message = $withdraw_coin->withdraw($user_session, $_POST['address'], $withdraw_amount);
					var_dump($withdraw_message);
					echo '!admin';
					echo $withdraw_coin->getBalance($user_session);
					$_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
					$message = $withdraw_message;
                    header("Location: index.php");
                }
                break;
                case "password":
                $user = new User($mysqli);
                if (empty($_POST['oldpassword']) || empty($_POST['newpassword']) || empty($_POST['confirmpassword'])) {
                    $error['type'] = "password";
                    $error['message'] = "You have to fill all the fields";
                } elseif ($_POST['token'] != $_SESSION['token']) {
                    $error['type'] = "password";
                    $error['message'] = "Tokens do not match";
                    $_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
                } else {
                    $_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
                    $result = $user->updatePassword($user_session, $_POST['oldpassword'], $_POST['newpassword'], $_POST['confirmpassword']);
                    if ($result === true) {
                        header("Location: index.php");
                    } else {
                        $error['type'] = "password";
                        $error['message'] = $result;
                    }
                }
                break;
                case "logout":
                session_destroy();
                header("Location: index.php");
                break;
                case "support":
                $error['message'] = "Please contact support via email at $support";
                echo "Support Key: ";
                echo $_SESSION['user_supportpin'];
                break;
                case "authgen":
                $user = new User($mysqli);
                $secret = $user->createSecret();
                $gen=$user->enableauth();
                echo $gen;
                break;
                
                case "disauth":
                $user = new User($mysqli);
                $disauth=$user->disauth();
                echo $disauth;
                break;
            }
        }
        /*$addressList = $client->getAddressList($user_session);
        $transactionList = $client->getTransactionList($user_session);*/
        include("view/header.php");
        include("view/wallet.php");
        include("view/footer.php");
    } else {
        $user = new User($mysqli);
        switch ($admin_action) {
            case "info":
            if (!empty($_GET['i'])) {
                $info = $user->adminGetUserInfo($_GET['i']);
                if (!empty($info)) {
                    //$info['balance'] = $client->getBalance($info['username']);
                    if (!empty($_POST['jsaction'])) {
                        $json = array();
                        switch ($_POST['jsaction']) {
                            case "new_address":
							
                            header("Location: index.php");
                            break;
                            case "withdraw":
							if (empty($_POST['address']) || empty($_POST['totalAmount']) || !is_numeric($_POST['totalAmount'])) {
								$json['message'] = "You have to fill all the fields";
								$message = "You have to fill all the fields";
							}else{
								$withdraw_amount = (float)$_POST['totalAmount'];
								$withdraw_amount = $withdraw_amount - (float)$reserve;
							}
                            $json['success'] = false;
                            if (!WITHDRAWALS_ENABLED) {
                                $json['message'] = "Withdrawals are temporarily disabled";
								$message = "Withdrawals are temporarily disabled";
                            } elseif (empty($_POST['address']) || empty($_POST['totalAmount']) || !is_numeric($_POST['totalAmount'])) {
                                $json['message'] = "You have to fill all the fields";
								$message = "You have to fill all the fields";
                            } elseif ($withdraw_amount > $_POST['balance']) {
                                $json['message'] = "Withdrawal amount exceeds your wallet balance";
								$message = "Withdrawal amount exceeds your wallet balance";
                            } else {
								
								$withdraw_coin = new Client('localhost', $_POST['port'], 'rpc', 'pass');
								$withdraw_message = $withdraw_coin->withdraw($info['username'], $_POST['address'], $withdraw_amount);
								var_dump($withdraw_message);
								echo 'admin';
								echo $withdraw_coin->getBalance($info['username']);
								
								$_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
								
                                $json['success'] = true;
                                $json['message'] = "Withdrawal successful";
								$message = $withdraw_message;
                                header("Location: index.php");
                            }
                            echo json_encode($json); exit;
                            break;
                            case "password":
                            $json['success'] = false;
                            if ((is_numeric($_GET['i'])) && (!empty($_POST['password']))) {
                                $result = $user->adminUpdatePassword($_GET['i'], $_POST['password']);
                                if ($result === true) {
                                    $json['success'] = true;
                                    $json['message'] = "Password changed successfully.";
                                } else {
                                    $json['message'] = $result;
                                }
                            } else {
                                $json['message'] = "Something went wrong (at least one field is empty).";
                            }
                            echo json_encode($json); exit;
                            break;
                        }
                    }
                    if (!empty($_POST['action'])) {
                        switch ($_POST['action']) {
                            case "new_address":
                            $client->getnewaddress($info['username']);
                            header("Location: index.php?a=info&i=" . $info['id']);
                            break;
                            case "withdraw":
							if (empty($_POST['address']) || empty($_POST['totalAmount']) || !is_numeric($_POST['totalAmount'])) {
								$json['message'] = "You have to fill all the fields";
								$message = "You have to fill all the fields";
							}else{
								$withdraw_amount = (float)$_POST['totalAmount'];
								$withdraw_amount = $withdraw_amount - (float)$reserve;
							}
                            if (!WITHDRAWALS_ENABLED) {
                                $error['type'] = "withdraw";
                                $error['message'] = "Withdrawals are temporarily disabled";
								$message = "Withdrawals are temporarily disabled";
                            } elseif (empty($_POST['address']) || empty($_POST['totalAmount']) || !is_numeric($_POST['totalAmount'])) {
                                $error['type'] = "withdraw";
                                $error['message'] = "You have to fill all the fields";
								$message = "You have to fill all the fields";
                            } elseif ($withdraw_amount > $_POST['balance']) {
                                $error['type'] = "withdraw";
                                $error['message'] = "Withdrawal amount exceeds your wallet balance";
								$message = "Withdrawal amount exceeds your wallet balance";
                            } elseif ((float)$_POST['totalAmount'] - ((float)$_POST['$reserve'] - (float)$_POST['$amount']) != 0) {
								$json['message'] = "Withdrawal amount exceeds your wallet balance. Please note the wallet owner has set a reserve fee of $reserve $short.";
								$message = "Withdrawal amount exceeds your wallet balance. Please note the wallet owner has set a reserve fee of $reserve $short.";
							} else {
								$withdraw_coin = new Client('localhost', $_POST['port'], 'rpc', 'pass');
								$withdraw_message = $withdraw_coin->withdraw($info['username'], $_POST['address'], $withdraw_amount);
								var_dump($withdraw_message);
								echo 'admin';
								echo $withdraw_coin->getBalance($info['username']);
								$_SESSION['token'] = sha1('@s%a$l£t#'.rand(0,10000));
								$message = $withdraw_message;
                                #header("Location: index.php?a=info&i=" . $info['id']);
                            }
                            break;
                            case "password":
                            if ((is_numeric($_GET['i'])) && (!empty($_POST['password']))) {
                                $result = $user->adminUpdatePassword($_GET['i'], $_POST['password']);
                                if ($result === true) {
                                    $error['type'] = "password";
                                    $error['message'] = "Password changed successfully.";
                                    header("Location: index.php?a=info&i=" . $info['id']);
                                } else {
                                    $error['type'] = "password";
                                    $error['message'] = $result;
                                }
                            } else {
                                $error['type'] = "password";
                                $error['message'] = "Something went wrong (at least one field is empty).";
                            }
                            break;
                        }
                    }
                    unset($info['password']);
                }
            }
            include("view/header.php");
            include("view/admin_info.php");
            include("view/footer.php");
            break;
            default:
            if ((!empty($_GET['m'])) && (!empty($_GET['i']))) {
                switch ($_GET['m']) {
                    case "deadmin":
                    $user->adminDeprivilegeAccount($_GET['i']);
                    header("Location: index.php?a=home");
                    break;
                    case "admin":
                    $user->adminPrivilegeAccount($_GET['i']);
                    header("Location: index.php?a=home");
                    break;
                    case "unlock":
                    $user->adminUnlockAccount($_GET['i']);
                    header("Location: index.php?a=home");
                    break;
                    case "lock":
                    $user->adminLockAccount($_GET['i']);
                    header("Location: index.php?a=home");
                    break;
                    case "del":
                    $user->adminDeleteAccount($_GET['i']);
                    header("Location: index.php?a=home");
                    break;
					case "addcoin":
					$c = (object)[];
					$c->id = $_GET['id'];
					$c->fullName = $_GET['fullname'];
					$c->name = $_GET['name'];
					$c->port = $_GET['port'];
					$c->blockapiurl = $_GET['blockapiurl'];
					$msg['message'] = $coin->addCoin($c);
                    break;
                }
            }
            $userList = $user->adminGetUserList();
			$coins = $coin->getAllBalance();
            include("view/header.php");
            include("view/admin_home.php");
            include("view/footer.php");
            break;
        }
    }
} else {
    $error = array('type' => "none", 'message' => "");
    if (!empty($_POST['action'])) {
        $user = new User($mysqli);
        switch ($_POST['action']) {
            case "login":
            $result = $user->logIn($_POST['username'], $_POST['password'], $_POST['auth']);
            if (!is_array($result)) {
                $error['type'] = "login";
                $error['message'] = $result;
            } else {
                $_SESSION['user_session'] = $result['username'];
                $_SESSION['user_admin'] = $result['admin'];
                $_SESSION['user_supportpin'] = $result['supportpin'];
                $_SESSION['user_id'] = $result['id'];
                header("Location: index.php");
            }
            break;
            case "register":
            $result = $user->add($_POST['username'], $_POST['password'], $_POST['confirmPassword']);
            if ($result !== true) {
                $error['type'] = "register";
                $error['message'] = $result;
            } else {
                $username   = $mysqli->real_escape_string(   strip_tags(          $_POST['username']   ));
                $_SESSION['user_session'] = $username;
                $_SESSION['user_supportpin'] = "Please relogin for Support Key";
                    header("Location: index.php");
            }
            break;
        }
    }
    include("view/header.php");
    include("view/home.php");
    include("view/footer.php");
}
$mysqli->close();
?>
