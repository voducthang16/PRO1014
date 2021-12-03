<?php
    class sign extends controller {
        public $sign;
        public $phpMailer;

        function __construct() {
            $this->sign = $this->model('signModels');
            $this->phpMailer = $this->model('sendMail');
        }

        function loginFB() {
            if (isset($_GET['code'])) {
                $secret = APP_SECRET;
                $client_id = APP_ID;
                $redirect_url = BASE_URL . "sign/loginFB";
                $code = $_GET['code'];
                $facebook_access_token_url = GET_FB_TOKEN."?client_id=$client_id&redirect_uri=".REDIRECT__FB."&client_secret=$secret&code=$code";
                $call = curl_init();
                curl_setopt($call, CURLOPT_URL, $facebook_access_token_url);
                curl_setopt($call, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($call, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($call);
                $response = json_decode($response);
                $response = $response->access_token;
                curl_close($call);
    
                $url_get_info_user = FB_TOKEN.$response;
                $call = curl_init();
                curl_setopt($call, CURLOPT_URL, $url_get_info_user);
                curl_setopt($call, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($call, CURLOPT_SSL_VERIFYPEER, false);
                $user_info = curl_exec($call);
                curl_close($call);

                $user_info = json_decode($user_info);
                $count = $this->sign->checkUsername($user_info->id);
                if($count == 0) {
                    $this->sign->createFbGg($user_info->id,$user_info->name);
                }
                $_SESSION["member-login"] = "true";
                $_SESSION["member-username"] = $user_info->id;
                header("Location:".BASE_URL);
            }
        }

        function loginGoogle() {

            if (isset($_GET['code'])) {
                $secret = APP_SECRET_GOOGLE;
                $client_id = APP_ID_GOOGLE;
                $redirect_url = BASE_URL . "sign/loginGoogle";
                $code = $_GET['code'];

                $url = TOKEN_GG;
                $data = array('code' => $code, 'client_id' => $client_id, 'client_secret' => $secret, 'redirect_uri' => $redirect_url, 'grant_type' => 'authorization_code');
                $data_string = http_build_query($data);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                $response = json_decode($response);
                $token = $response->access_token;
                curl_close($ch);
                
                $url_get_info_user = URL."=$token";
                $call = curl_init();
                curl_setopt($call, CURLOPT_URL, $url_get_info_user);
                curl_setopt($call, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($call, CURLOPT_RETURNTRANSFER, 1);
    
                $user_info = curl_exec($call);
                curl_close($call);
                var_dump($user_info);

                $user_info = json_decode($user_info);
                $count = $this->sign->checkUsername($user_info->id);
                if($count == 0) {
                    $this->sign->createFbGg($user_info->id,$user_info->name);
                }
                $_SESSION["member-login"] = "true";
                $_SESSION["member-username"] = $user_info->id;
                header("Location:".BASE_URL);
            }
        }

        function show() {

            $FACEBOOK = APP_LINK__FB.'?client_id='.APP_ID.'&redirect_uri='.REDIRECT__FB.'&scope='.TYPE__;
            $GOOGLE = APP_LINK__GG.'?response_type=code&client_id='.APP_ID_GOOGLE.'&redirect_uri='.REDIRECT_URI.'&scope='.SCOPE_DEFAULT;

            if (isset($_POST["si-username"])) {
                $username = $_POST["si-username"];
                $password = $_POST["si-password"];
                $check = $this->sign->checkLogin($username, $password);
                if ($check == 0) {
                    echo '<script>alert("Tài khoản hoặc mật khẩu không chính xác.");</script>';
                } else {
                    $_SESSION["member-login"] = "true";
                    $_SESSION["member-username"] = $username;
                    echo '<script>alert("Đăng nhập thành công!");</script>';
                    header("Location:".BASE_URL);
                }
                header("Refresh: 0");
            }

            $this -> view("index", [
                "page" => "sign",
                "FACEBOOK" => $FACEBOOK,
                "GOOGLE" => $GOOGLE
            ]);
        }

        function signUp() {
            if (isset($_POST["username"])) {
                $username = $_POST["username"];
                $email = $_POST["email"];
                $name = $_POST["name"];
                $password = $_POST["password"];

                $this->sign->createAccount($username, $email, $name, $password);
                $_SESSION["member-login"] = "true";
                $_SESSION["member-username"] = $username;
                echo 'Tạo tài khoản thành công!';
            }
        }

        function forgotpassword() {
            $this -> view("index", [
                "page" => "forgotpassword",
            ]);
        }

        function GetPassword() {
            if(isset($_POST['code'])){
                $code = $_POST['code'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $result = $this->sign->checkCode($email, $code);
                if ($result == 1) {
                    $this->sign->updatePassword($password,$email,$code);
                    $codeNew = md5(random_int(0,9999));
                    $codeNew = substr($codeNew,0,8);
                    $this->sign->updateCode($email, $codeNew);
                    echo 'Đã Update password thành công!';
                } else {
                    echo 'Bạn cần nhập code xác minh chính xác để đổi mật khẩu';
                }
            }
        }

        function checkEmailForgotPassword(){
            if(isset($_POST['email'])){

                $email = $_POST['email'];
                $output = '';
                $action = false;
                $mailer = false;
                $result = $this->sign->checkEmail($email);
                $data = array();
                if ($result === 1) {
                    $code = md5(random_int(0,9999));
                    $code = substr($code,0,8);
                    $this->sign->updateCode($email, $code);
                    $action = true;
                    $output .= '
                    <div class="form-group">
                        <label for="email">Your email</label>
                        <input class="form-control email-forgot" type="email" name="email" id="email" value="'.$email.'" disabled readonly required>
                    </div>
                    <div class="form-group">
                        <label for="email">Enter the code We send to your Email</label>
                        <input class="form-control input-value-code-password" type="text" name="email" id="email" placeholder="Code ....." required>
                    </div>
                    <div class="form-group">
                        <label for="email">Enter new Password</label>
                        <input class="form-control input-value-new-password" type="password" name="email" id="email" placeholder="New password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Re-enter new Password</label>
                        <input class="form-control input-value-re-new-password" type="password" name="email" id="email" placeholder="Re-new password" required>
                    </div>
                    <div style="text-align: left" class="form-group">
                        <div class="btn btn-primary btn-submit-codePw">Get new password</div>
                    </div>
                    <script>
                        $(".btn-submit-codePw").click(function(e){
                            e.preventDefault();
                            const email = $(".email-forgot").val();
                            const code = $(".input-value-code-password").val();
                            const password = $(".input-value-new-password").val();
                            const rePassword = $(".input-value-re-new-password").val();
                    
                            if (rePassword != password) {
                                alert("Password không trùng nhau");
                                return;
                            }        
                            if (code == "" || password == "" || email == "") {
                                alert("Bạn còn 2 lần nhập trước khi bị khoá tài khoản !!");
                            } else {
                                $.ajax({
                                    url:"sign/GetPassword",
                                    method:"POST",
                                    data: {
                                        "email": email,
                                        "code": code,
                                        "password": password
                                    },
                                    success:function(data) {
                                        alert(data);
                                        if (data == "Đã Update password thành công!") {
                                            location.reload();
                                        }
                                    }
                                })
                            }
                        })
                    </script>
                    ';
                    
                    $send = $this->phpMailer->sendMailerForgotPass($email,$code);
                    if($send == 1){
                        $mailer = true;
                        $data = array (
                            'action' => $action,
                            'mailer' => $mailer,
                            'output' => $output
                        );
                    }
                } else {
                    $data = array(
                        'action' => $action,
                        'mailer' => $mailer
                    );
                } 
                echo json_encode($data);
            }
        }

        function checkExistAttribute() {
            $attribute = $_POST['attribute'];
            $column = $_POST['column'];
            $check = $this ->sign-> checkExistAttribute($column, $attribute);
            echo $check;
        }
    }
