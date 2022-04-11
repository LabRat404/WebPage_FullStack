<?php
include_once('auth.php');

function fetch_DB()
{
    $db = new PDO('sqlite:/var/www/cart.db');
    // enable foreign key support
    $db->query('PRAGMA foreign_keys = ON;');

    // FETCH_ASSOC:
    // Specifies that the fetch method shall return each row as an
    // array indexed by column name as returned in the corresponding
    // result set. If the result set contains multiple columns with
    // the same name, PDO::FETCH_ASSOC returns only a single value
    // per column name.
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $db;
}

function ierg4210_login()
{
    if (empty($_POST['email']) || empty($_POST['password'])
    || !preg_match("/^[\w=+\-\/\.]*@[\w\-]+(\.[\w\-]+)*(\.[\w]{2,6})$/", $_POST['email'])
    || !preg_match("/^[\w@#$%\^\&\*\-]+$/", $_POST["password"])) 
    {
        throw new Exception('Wrong inputed email or password');
    }
    global $db;
    $db = fetch_DB();
    $email = $_POST['email'];
    $pw = $_POST['password'];
    $q = $db->prepare('SELECT * FROM account WHERE email = ?');
    $q->bindParam(1, $email);
    $q->execute();
    
    if ($r = $q->fetch()) {
        //if successful fetch
        $admin_flag = $r["ADMIN_FLAG"];
        $password = $r["HASHED_PASSWORD"];
        $salt = $r["SALT"];
        $hashed_password = hash_hmac('sha256', $pw, $salt);
   
        if ($password == $hashed_password) {
            //if correct pw
            $exp = time() + 3600 * 12;
            $token = array(
                'em'=>$r['EMAIL'],
                'exp'=>$exp,
                'admin' => $r['ADMIN_FLAG'],
                'k'=>hash_hmac('sha256', $exp.$r['HASHED_PASSWORD'], $r['SALT'])
               
            );
            setcookie('auth', json_encode($token), $exp, '','', true, true);
            $_SESSION['auth'] = $token;
            session_regenerate_id();
            if($admin_flag == 1){
                $_SESSION['login'] = true;
                header('Location: index.php', true, 302);
                exit();
            } else {
                $_SESSION['login'] = true;
                header('Location: index.php', true, 302);
                exit();
            }
        } else {
            //if not correct pw
            header('Location: login.php', true, 302);
            echo "<script language=\"JavaScript\">\n";
echo "alert('Username or Password was incorrect!');\n";
echo "</script>";
            exit();
           
        }
        //Check if the hash of the password equals the one saved in database //If yes, create authentication information in cookies and session //program code on next slide
    } else {
        //if not successful fetch
        header('Content-Type: text/html; charset=utf-8');
        echo' 2';
        echo '
        <head>
            
            <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
            <title>Login Page</title>
            <!-- Bootstrap icons-->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
            <!-- Core theme CSS (includes Bootstrap)-->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
            <link href="../css/styles.css" rel="stylesheet" />
        </head>
        <body style="background-color:bisque;">
            <div class="page-wrap d-flex flex-row align-items-center">
                <div class="container h-100">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <div class="mb-4 lead">Wrong email or password entered!</div>
                            <a href="../login.php" class="btn btn-secondary">Back to Login page</a>
                            <a href="../index.php" class="btn btn-primary">Visit the shop via Guest</a>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        ';
        exit();
    }


    // if($login_success){
    // //redirect to admin page
    // header('Location: admin.php', true, 302);
    // exit();
    // }else{
    //     throw new Exception('Wrong Credentials');
    //}

}


function ierg4210_logout()
{

     //clear cookie and session
     setcookie('auth', '', time() - 3600 * 12, '/');
     session_destroy();
     //redirect to login page after logout
     header('Location: index.php', true, 302);
     exit();

}


function ierg4210_changepw()
{
    global $db;
    $db = fetch_DB();
    $old_pwd = $_POST['password'];
    $email = $_POST['email'];
    htmlspecialchars($old_pwd);
    htmlspecialchars($email);
    // htmlspecialchars($email);
    $q=$db->prepare('SELECT * FROM account WHERE email = (?);'); 
    $q->bindParam(1, $email);
    $q->execute();
    $r=$q->fetch();
    $old_db_password = $r["HASHED_PASSWORD"];
    $old_salt = $r["SALT"];
    $admin_flag = $r["ADMIN_FLAG"];
    $db_email = $r["EMAIL"];
    $old_hashed_password = hash_hmac('sha256', $old_pwd, $old_salt);

    if ($email != $db_email || $old_hashed_password != $old_db_password) {
        //prompt alert

        header('Content-Type: text/html; charset=utf-8');
        echo '
        <head>
            <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
            <title>Login Page</title>
            <!-- Bootstrap icons-->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
            <!-- Core theme CSS (includes Bootstrap)-->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
            <link href="../css/styles.css" rel="stylesheet" />
        </head>
        <body style="background-color:bisque;">
            <div class="page-wrap d-flex flex-row align-items-center">
                <div class="container h-100 pt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <div class="mb-4 lead">email or password not found!</div>
                            <a href="../changepw.php" class="btn btn-secondary">Back to Reset page</a>
                            <a href="../index.php" class="btn btn-primary">Visit the shop via Guest</a>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        ';
        exit();
    }
    else {
        $new_password = $_POST['new_password'];
        htmlspecialchars($new_password);
        $new_salt = mt_rand();
        $new_hashed_password = hash_hmac('sha256', $new_password, $new_salt);
        $q=$db->prepare('UPDATE account SET hashed_password = (?), salt = (?) WHERE (email) = (?);'); 
        $q->bindParam(1, $new_hashed_password);
        $q->bindParam(2, $new_salt);
        $q->bindParam(3, $email);
        if ($q->execute()) {
            if (isset($_COOKIE['auth'])) {
                unset($_COOKIE['auth']);
                setcookie('auth', '', time() - 3600 * 12, '/'); // empty value and old timestamp
            }
            header('Location: index.php', true, 302);
            exit();
        }
    }
}


function csrf_getNonce($action) {
    $nonce = mt_rand() . mt_rand();
    if(!isset($_SESSION['csrf_nonce']))
        $_SESSION['csrf_nonce'] = array();
    $_SESSION['csrf_nonce'][$action] = $nonce;
    return $nonce;
}

function csrf_verifyNonce($action, $receivedNonce) {
    if(isset($receivedNonce) && $_SESSION['csrf_nonce'][$action] == $receivedNonce) {
        if($_SESSION['auth'] == null)
            unset($_SESSION['csrf_nonce'][$action]);
        return true;
    }
    throw new Exception('csrf-attack!!');
}

?>