<?php
namespace App\Http\Controllers\Api;
use App\Libraries\Providers;
use App\Traits\InteractsWithFacebookGraphApi;
use App\Http\Controllers\Controller;
class SocialAuthController extends Controller
{
  use InteractsWithFacebookGraphApi;
  
  /**
   * Login a user with social identity.
   * 
   * @param string $provider
   */
   public function login(string $provider)
   {
    $userAccessToken = 'ddasfasdhasjda';
     switch ($provider) {
        case Providers::FACEBOOK:
          return $this->initFacebookLoginFlow($userAccessToken);
        case Providers::GOOGLE:
          // return $this->initGoogleLoginFlow();
     }
   }
}