<?php
    class sign extends controller {
        public $sign;
        public $phpMailer;

        function __construct() {
            $this->sign = $this->model('signModels');
            $this->phpMailer = $this->model('sendMail');
        }

        function show() {
            if (isset($_POST["si-username"])) {
                $username = $_POST["si-username"];
                $password = $_POST["si-password"];
                $check = $this->sign->checkLogin($username, $password);
                if ($check == 0) {
                    echo '<script>alert("TK KHONG CHINH XAC.");</script>';
                } else {
                    $_SESSION["member-login"] = "true";
                    $_SESSION["member-username"] = $username;
                    echo '<script>alert("DANG NHAP THANH CONG");</script>';
                    header("Location:".BASE_URL);
                }
                header("Refresh: 0");
            }

            $this -> view("index", [
                "page" => "sign",
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
                echo 'Tao tk thanh cong';
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
                    echo 'đã update password thành công';
                } else {
                    echo 'bạn cần nhập code chính xác trước khi bị khoá';
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
                if ($result == 1) {

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
                                alert("password không trùng nhau");
                                return;
                            }        
                            if (code == "" || password == "" || email == "") {
                                alert("bạn còn 2 lần nhập trước khi bị khoá tài khoản !!");
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
                                        if (data == "đã update password thành công") {
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
?>