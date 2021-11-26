<?php

// include __DIR__.'./Facebook/autoload.php';

// class login_FB {

//     function login_FB() {
        
//         // Call Facebook API
//         $fb = new Facebook\Facebook([
//         'app_id' => APP_ID,
//         'app_secret' => APP_SECRET,
//         'default_graph_version' => API_VERSION,
//         ]);

        
//         if(!session_id()){
//             session_start();
//         }
        
        
//         // Call Facebook API
//         $fb = new Facebook\Facebook([
//          'app_id' => APP_ID,
//          'app_secret' => APP_SECRET,
//          'default_graph_version' => API_VERSION,
//         ]);
        
        
//         // Get redirect login helper
//         $fb_helper = $fb->getRedirectLoginHelper();
        
        
//         // Try to get access token
//         try {
//             if(isset($_SESSION['facebook_access_token']))
//                 {$accessToken = $_SESSION['facebook_access_token'];}
//             else
//                 {$accessToken = $fb_helper->getAccessToken();}
//         } catch(Facebook\Exceptions\FacebookResponseException $e) {
//              echo 'Facebook API Error: ' . $e->getMessage();
//               exit;
//         } catch(Facebook\Exceptions\FacebookSDKException $e) {
//             echo 'Facebook SDK Error: ' . $e->getMessage();
//               exit;
//         }

//         $permissions = ['email']; //optional

//         if (isset($accessToken))
//         {
//             if (!isset($_SESSION['facebook_access_token'])) 
//             {
//                 //get short-lived access token
//                 $_SESSION['facebook_access_token'] = (string) $accessToken;
                
//                 //OAuth 2.0 client handler
//                 $oAuth2Client = $fb->getOAuth2Client();
                
//                 //Exchanges a short-lived access token for a long-lived one
//                 $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
//                 $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                
//                 //setting default access token to be used in script
//                 $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
//             } 
//             else 
//             {
//                 $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
//             }
            
            
//             //redirect the user to the index page if it has $_GET['code']
//             if (isset($_GET['code'])) 
//             {
                
//             }
            
//             try {
//                 $fb_response = $fb->get('/me?fields=name,first_name,last_name,email',$accessToken->getValue());
//                 // $fb_response_picture = $fb->get('/me/picture?redirect=false&height=200',$accessToken->getValue());
                
//                 $fb_user = $fb_response->getGraphUser();
//                 // $picture = $fb_response_picture->getGraphUser();

//                 print_r($fb_user); exit;
                
//             } catch(Facebook\Exceptions\FacebookResponseException $e) {
//                 echo 'Facebook API Error: ' . $e->getMessage();
//                 session_destroy();
//                 // redirecting user back to app login page
//                 header("Location: ./");
//                 exit;
//             } catch(Facebook\Exceptions\FacebookSDKException $e) {
//                 echo 'Facebook SDK Error: ' . $e->getMessage();
//                 exit;
//             }
//         } 
//         else
//         {	
//             // replace your website URL same as added in the developers.Facebook.com/apps e.g. if you used http instead of https and you used
//             $fb_login_url = $fb_helper->getLoginUrl("http://localhost/PRO1014/sign/",$permissions);
//         }
//         $data = array(
//             "fb_login_url" => $fb_login_url,
//             // "fb_user" => $fb_user
//         );
//         return $data;
//     }
// }
?>