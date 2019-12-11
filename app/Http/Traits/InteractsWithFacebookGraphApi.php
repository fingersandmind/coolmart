<?php
namespace App\Traits;
use App\Models\SocialIdentity;
use GuzzleHttp\Client;
use Tymon\JWTAuth\Facades\JWTAuth;
trait InteractsWithFacebookGraphApi
{
  private $client;
  private $config;
  public function __construct()
  {
    $this->client = new Client([
      'base_uri' => 'https://graph.facebook.com'  
    ]);
    $this->config = config('services.facebook');
  }
  
  /**
   * Initialize Facebook login flow.
   * 
   * @param string $userAccessToken
   * 
   * @return string
   */
  public function initFacebookLoginFlow($userAccessToken)
  {
    $appAccessToken = $this->getAppAccessToken();
    $response = $this->verifyAccessToken($userAccessToken, $appAccessToken);
    $user = optional(SocialIdentity::whereProviderId($response->data->user_id)->first())->user;
    if (!$user) {
      return response()->json([
        'message' => 'There is no Facebook account associated with this user.',
      ], 401);
    }
    $accessToken = $user->createToken('authToken')->accessToken;
    return response()->json([
      'access_token' => $accessToken,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60,
    ]);
  }
    /**
     * Get app access token.
     *
     * @return string
     */
    public function getAppAccessToken()
    {
        $response = $this->client->get("/oauth/access_token?client_id={$this->config['client_id']}&client_secret={$this->config['client_secret']}&grant_type=client_credentials");
        $response = json_decode($response->getBody()->getContents());
        return $response->access_token;
    }
    
    /**
     * Verify an access token.
     *
     * @param string $accessToken
     * @param string $appAccessToken
     *
     * @return object
     */
    public function verifyAccessToken($accessToken, $appAccessToken)
    {
        $response = $this->client->get("/debug_token?input_token={$accessToken}&access_token={$appAccessToken}");
        return json_decode($response->getBody()->getContents());
    }
}