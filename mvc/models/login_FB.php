<?php

class login_FB {

    function login_FB() {

        require 'vendor/autoload.php';
        
        // Call Facebook API
        $fb = new \Facebook\Facebook([
            "app_id" => APP_ID,
            "app_secret" => APP_SECRET,
            "default_graph+version" => API_VERSION
        ]);
        
        // Get redirect login helper
        $helper = $fb->getRedirectLoginHelper();
        $login_url = $helper->getLoginUrl(FB_BASE_URL);
        
        try{
            $accessToken = $helper->getAccessToken();
            if(isset($accessToken)){
                $_SESSION['access_token'] = (string)$accessToken;
                try {
                    $fb->setDefaultAccessToken($_SESSION['access_token']);
                    $res = $fb->get('/me?locale=en_US&fields=id,name,email');
                    $res_picture = $fb->get('/me/picture?redirect=false&height=200',$accessToken->getValue());
                    $user_pic = $res_picture->getGraphUser();
                    $user = $res->getGraphUser();
                    $id = $user->getField('id');
                    $name = $user->getField('name');
                    $email = $user->getField('email');
                    $picture = $user_pic['url'];
                    $data = array(
                        'status' => 'loginSuccess',
                        'name' => $name,
                        'email' => $email,
                        'username' => $id,
                        'picture' => $picture
                    );
                    return $data;
                } catch (Exception $e) {
                    echo $e->getTraceAsString();
                }
            }
        } catch (Exception $e){
            echo $e->getTraceAsString();
        }
        $data = array(
            'status' => 'loginFailed',
            'fb_login_url' => $login_url
        );
        return $data;
    }
}

?>