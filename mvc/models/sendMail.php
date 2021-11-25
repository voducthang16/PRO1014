<?php 
include "PHPMailer-master/src/PHPMailer.php";
include "PHPMailer-master/src/Exception.php";
include "PHPMailer-master/src/OAuth.php";
include "PHPMailer-master/src/POP3.php";
include "PHPMailer-master/src/SMTP.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
    
class sendMail {
    public function sendMailerForgotPass($email,$code){
        $nFrom = 'Admin';
        $mFrom = 'thangvd.rm2@gmail.com';  // enter email 
        $mPass = 'VoDucThang123@';       // enter password
        $mail             = new PHPMailer();
        $mail->IsSMTP(); 
        $mail->CharSet   = "utf-8";
        $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;                    // enable SMTP authentication
        $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
        $mail->Host       = "smtp.gmail.com";        
        $mail->Port       = 465;
        $mail->Username   = $mFrom;  // GMAIL username
        $mail->Password   = $mPass;               // GMAIL password
        $mail->SetFrom($mFrom, $nFrom);
        $mail->Subject    = "Mã xác thực email";
        $mail->MsgHTML("Mã xác thực của bạn là: ".$code);
        $address = $email;
        $mail->AddAddress($address, "hi");
        $mail->AddReplyTo('nguyennhieu1507', 'nguyennhieu');
        if(!$mail->Send()) {
            return 0;
        } else {
            return 1;
        }
    }
}
?>