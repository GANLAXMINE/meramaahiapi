<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;
//fcm0
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use DateTime;

class ApiController extends \App\Http\Controllers\Controller
{

    /**
     * Create admin controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //        $this->middleware('auth');
        //        $roles = implode('|', Role::all()->pluck('name')->toArray());
        //        $this->middleware(['role:' . $roles, 'auth:admin']);
        //        dd($roles);
    }

    private function _headers()
    {
        return getallheaders();
    }

    protected function __allowedUsers()
    {
        $userRole = \App\Models\User::find($this->_headers()['user_id'])->getRoleNames()['0'];
        return \App\Models\User::role($userRole)->get()->pluck('id')->toArray();
    }

    public $successStatus = 200;
    public static $locale = '';
    //    public $requiredParams = ['device_id' => 'required', 'device_token' => 'required', 'device_type' => 'in:ios,android|required', 'client_id' => 'required', 'client_secret' => 'required'];
    //    public $requiredParams = ['device_id' => 'required', 'device_type' => 'in:ios,android|required', 'client_id' => 'required', 'client_secret' => 'required'];
    public $requiredParams = ['device_type' => 'required', 'device_token' => 'required'];
    protected static $_allowedURIwithoutAuth = ['api/login', 'api/customer/login', 'api/configuration/{type}', 'api/customer/verify-login', 'api/customer/registeration', 'api/customer/resend-otp', 'api/salon/register', 'api/salon/{id}', 'api/customer/register', 'api/customer/{id}'];

    public static function validateClientSecret()
    {
        $headers = getallheaders();
        if (!isset($headers['client_id']) || !isset($headers['client_secret'])) :
            return self::error(trans('api.ApiController.ClientId_and_Secret_not_found'), 422);
        endif;
        $response = self::validateClient($headers['client_id'], $headers['client_secret']);
        if ($response === false) :
            return self::error(trans('api.ApiController.ClientId_and_Secret_not_mismatched'), 409);
        endif;
        //        dd(Request::route()->uri());
        if (!in_array(Request::route()->uri(), self::$_allowedURIwithoutAuth)) :
            if (!isset($headers['user_id'])) :
                return self::error(trans('api.ApiController.UserId_required'), 422);
            else :
                $user = User::find($headers['user_id']);
                if ($user === null)
                    return self::error(trans('api.ApiController.User_not_found'), 401);
                //                dd($user->hasAnyRole('super admin'));
                if ($user->hasPermissionTo(Request::route()->uri()) === false) :
                    return self::error(trans('api.ApiController.not_authorized'), 403);
                endif;
            endif;
        endif;
        if (isset($headers['locale'])) :
            if (!in_array($headers['locale'], ['', 'kr', 'ar'])) :
                return self::error(trans('api.ApiController.use_valid_language'), 422);
            endif;
            self::$locale = $headers['locale'];
        endif;
        return false;
    }

    protected static function validateClient($client_id, $client_secret)
    {
        $check = \App\Models\OauthClients::where(["id" => $client_id, "secret" => $client_secret]);
        if ($check->exists())
            return true;
        else
            return false;
    }

    protected static function validateHeadersOnly($request, $formType = 'GET', $attributeValidate = [])
    {
        $headers = getallheaders();
        if ($request->method() != $formType) {
            return self::error(trans('api.ApiController.method_not_allowed'), 409);
        }
        if (isset($headers['client_id']) && isset($headers['client_secret'])) :
            $params['client_id'] = $headers['client_id'];
            $params['client_secret'] = $headers['client_secret'];
        endif;
        //        if (isset($headers['device_id']) && isset($headers['device_token']) && isset($headers['device_type'])):
        if (isset($headers['device_id']) && isset($headers['device_type'])) :
            $params['device_id'] = $headers['device_id'];
            //            $params['device_token'] = $headers['device_token'];
            $params['device_type'] = $headers['device_type'];
        endif;
        $validator = Validator::make($params, $attributeValidate);
        if ($validator->fails()) {
            $errors = [];
            $messages = $validator->getMessageBag();
            foreach ($messages->keys() as $key) {
                $errors[] = $messages->get($key)['0'];
            }
            return self::error($errors, 422, false);
        }
        return false;
    }

    public static function validateAttributes($request, $formType = 'GET', $attributeValidate = [], $attributes = [], $checkVariableCount = false, $customMessages = [])
    {
        $headers = getallheaders();
        if ($request->method() != $formType) {
            return self::error(trans('api.ApiController.method_not_allowed'), 409);
        }
        $params = [];
        if (isset($headers['client_id']) && isset($headers['client_secret'])) :
            $params['client_id'] = $headers['client_id'];
            $params['client_secret'] = $headers['client_secret'];
        endif;
        //        if (isset($headers['device_id']) && isset($headers['device_token']) && isset($headers['device_type'])):
        //        if (isset($headers['device_id']) && isset($headers['device_type'])):
        //            $params['device_id'] = $headers['device_id'];
        ////            $params['device_token'] = $headers['device_token'];
        //            $params['device_type'] = $headers['device_type'];
        //        endif;
        foreach ($attributes as $attribute) :
            $params[$attribute] = $request->$attribute;
        endforeach;
        if ($checkVariableCount === true) :
            if (count($attributes) != count($request->all())) :
                return self::error(trans('api.ApiController.fill_required_parameters'), 409);
            endif;
        //        else:
        //            if (count($request->all()) == 0):
        //                return self::error('Please select one of the paramter.', 409);
        //            endif;
        endif;
        //        dd($params);
        $validator = Validator::make($params, $attributeValidate, $customMessages);
        if ($validator->fails()) {
            //            $errors = [];
            $messages = $validator->getMessageBag();
            foreach ($messages->keys() as $k => $key) {
                //                $errors[$key] = $messages->get($key)['0'];
                $errors = $messages->get($key)['0'];
            }
            return self::error($errors, 422, false);
        }
        return false;
    }

    //    public static function error($message, $errorCode = 422, $messageIndex = false) {
    //
    ////        dd($message);
    ////        $message = (object) $message;
    ////        echo json_encode(['status' => false, 'code' => $errorCode, 'data' => (object) [], 'error' => $message], JSON_FORCE_OBJECT);
    ////        die();
    //        if (is_string($message))
    //            $return = ['status' => false, 'code' => $errorCode, 'data' => (object) [], 'error' => $message, 'errors' => null];
    //        else
    //            $return = ['status' => false, 'code' => $errorCode, 'data' => (object) [], 'error' => null, 'errors' => $message];
    //        return response()->json($return, $errorCode);
    ////        return response()->json(['status' => false, 'code' => $errorCode, 'data' => (object) [], 'error' => $message, 'errors' => null], $errorCode);
    //    }
    public static function error($message, $errorCode = 422, $messageIndex = false)
    {
        return response()->json(['status' => false, 'code' => $errorCode, 'data' => (object) [], 'error' => $message], $errorCode);
    }

    public static function success($data, $code = 200, $returnType = 'object')
    {
        //    print_r($data);die;
        if ($returnType == 'array')
            $data = (array) $data;
        elseif ($returnType == 'data')
            $data = $data;
        else
            $data = (object) $data;

        return response()->json(['status' => true, 'code' => $code, 'data' => $data], $code);
    }

    public static function successCreated($data, $code = 201)
    {
        if (!is_array($data))
            $data = ['message' => $data];
        return response()->json(['status' => true, 'code' => $code, 'data' => (object) $data], $code);
    }

    protected static function sendOTPUser(User $user)
    {
        $otp = mt_rand(1000, 9999);
        $user->otp = $otp;
        $user->save();
        return self::sendTextMessage('Your ' . config('app.name') . ' Verification code is ' . $otp, $user->phone);
    }

    public function generateOTP()
    {
        $otp = mt_rand(1000, 9999);
        return $otp;
    }

    public static function getPercentOfPrice($price, $percent)
    {
        return ($percent / 100) * $price;
    }

    protected static function sendOTP($number)
    {
        $otp = mt_rand(1000, 9999);
        self::sendTextMessage('Your ' . config('app.name') . ' Verification code is ' . $otp, $number);
        return $otp;
    }

    protected static function sendTextMessage($message, $to)
    {
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_TOKEN');
            $from = env('TWILIO_PHONE');
            $twilio = new Client($sid, $token);
            $return = $twilio->messages->create($to, ["body" => $message, "from" => $from]);
            return $return;
        } catch (\Twilio\Exceptions\TwilioException $ex) {
            // dd($ex);
            return true;
        }
    }

    public static function pushNotofication($data = [], $deviceToken)
    {
        // FCM
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);
        $notificationBuilder = new PayloadNotificationBuilder($data['title']);
        $notificationBuilder->setBody($data['body'])->setSound('default');
        if (isset($data['data']['app_badge']))
            $notificationBuilder->setBadge($data['data']['app_badge']);
        $dataBuilder = new PayloadDataBuilder();
        //        $dataBuilder->addData(['a_data' => 'my_data']);
        //        if (isset($data['data']))
        //            $notificationBuilder->setClickAction(json_encode($data['data']));
        //        if (isset($data['data']))
        //        $dataBuilder->addData(['messageInfo' => array_merge(['coldstart' => true, 'content-available' => '1', 'foreground' => true, 'priority' => 'high'], $data)]);
        //        else
        // $dataBuilder->addData(['messageInfo' => ['coldstart' => true, 'content-available' => '1', 'foreground' => true, 'priority' => 'high']]);
        //	if (isset($data['data']['target_id']))
        //	    $dataBuilder->addData(['target_id' => $data['data']['target_id']]);
        //	if (isset($data['data']['target_model']))
        //	    $dataBuilder->addData(['target_model' => $data['data']['target_model']]);
        //	if (isset($data['data']['data_type']))
        //	    $dataBuilder->addData(['data_type' => $data['data']['data_type']]);


        $url = "https://fcm.googleapis.com/fcm/send";
        // $token =['djIfQJUpSrCNttgosMU6D_:APA91bGYUCMMjNaYBznXJR-MuBZjuuYgBhmuI4aHnKXf4xUutsHA_3khURygyNIt9cpCLQ_22acudVaP5uDJqvsEEAotJcm9cRr3fQichUwA0MArIsu1pbDglHcCQDqst6W-q4_Pa6Gv'];
        $token = is_array($deviceToken) ? $deviceToken : [$deviceToken];
        $serverKey = config('app.FCM_SERVER_KEY');

        $dataToSend = array_merge(['priority' => 'high'], $data);
        // dd($dataToSend);
        // $arrayToSend = ['registration_ids' => $token, 'notification' => $dataToSend, ['notification' => ['title' => $data['title'], 'body' => $data['body']]]];

        // $arrayToSend = ['registration_ids' => $token, 'data' => $dataToSend, ['notification' => ['title' => $data['title'], 'body' => $data['body']]]];    

        $arrayToSend = [
            'registration_ids' => $token,
            'data' =>  isset($dataToSend['data']) ? $dataToSend['data'] : $dataToSend,
            // 'data' =>   $dataToSend,
            'notification' => [
                'title' => $data['title'],
                'body' => $data['body'],
                // 'badge' => $data['badge'],
                "priority" => "high",
                "sound" => "default"
            ],

            // 'badge'=>$data['badge']
        ];
        $headers = array();
        $headers[] = 'Authorization: key=' . $serverKey;
        $a = self::CURL_API('POST', $url, $arrayToSend, $headers, true);

        // foreach ($data['data'] as $key => $dataDetail) :
        //     //    dd($key,$dataDetail);
        //     $dataBuilder->addData([$key => $dataDetail]);
        // //        $dataDetail[$key];
        // //        $da[]=[$key => $dataDetail[$key]];
        // endforeach;
        // $option = $optionBuilder->build();
        // $notification = $notificationBuilder->build();
        // $data = $dataBuilder->build();

        //    $deviceToken = "dRyHOgfdDMA:APA91bFr-dj3_sDe3z7R3d30X12k6n4NnFWuyvbsh4xGRr-s0j2RfpKplfrc0rms5ZZ0aZu6taho3ZbGn_xvtSPdq0QBTcXTRjo94g2L5X5snSuJUW4yt-TfH5WRbEqYoKAktSkLPN5X";

        //    $deviceToken = "eIHIpJN5HEFyj0fiqi2R6X:APA91bFazHQdgUQU8OHB594W4dque3mqHLebv4l6AkGOJY-7Xpa3pf8hmuK7o3dhIvukHoYDZ_wJgS7eCGtiJBDGXgXn_agYUOii49ki7YGBoeVR1B7E7-NnktnhestzlnuZFMiOuQkc
        //    ";

        // dd($deviceToken);
        // $downstreamResponse = FCM::sendTo($deviceToken, $data);
        // dd($downstreamResponse);
        //    $downstreamResponse->numberFailure();
        // return $downstreamResponse->numberSuccess() == '1' ? true : false;
        return true;
        // } catch (\Exception $ex) {
        //     return true;
        // }
    }

    public static function pushNotoficationRaw($data = [], $deviceToken)
    {
        // dd($data);
        try {
            $url = "https://fcm.googleapis.com/fcm/send";
            // $token =['djIfQJUpSrCNttgosMU6D_:APA91bGYUCMMjNaYBznXJR-MuBZjuuYgBhmuI4aHnKXf4xUutsHA_3khURygyNIt9cpCLQ_22acudVaP5uDJqvsEEAotJcm9cRr3fQichUwA0MArIsu1pbDglHcCQDqst6W-q4_Pa6Gv'];
            $token = is_array($deviceToken) ? $deviceToken : [$deviceToken];
            $serverKey = config('app.FCM_SERVER_KEY');

            $dataToSend = array_merge(['priority' => 'high'], $data);
            // dd($dataToSend);
            // $arrayToSend = ['registration_ids' => $token, 'notification' => $dataToSend, ['notification' => ['title' => $data['title'], 'body' => $data['body']]]];

            // $arrayToSend = ['registration_ids' => $token, 'data' => $dataToSend, ['notification' => ['title' => $data['title'], 'body' => $data['body']]]];    

            $arrayToSend = [
                'registration_ids' => $token,
                'data' =>  isset($dataToSend['data']) ? $dataToSend['data'] : $dataToSend,
                // 'data' =>   $dataToSend,
                'notification' => [
                    'title' => $data['title'],
                    'body' => $data['body'],
                    // 'badge' => $data['badge'],
                    "priority" => "high",
                    "sound" => "default"
                ],

                // 'badge'=>$data['badge']
            ];
            $headers = array();
            $headers[] = 'Authorization: key=' . $serverKey;
            $a = self::CURL_API('POST', $url, $arrayToSend, $headers, true);
            //    dd($arrayToSend,$a);

            //            $json = json_encode($arrayToSend);
            //            $headers = array();
            //            $headers[] = 'Content-Type: application/json';
            //            $headers[] = 'Authorization: key=' . $serverKey;
            //            $ch = curl_init();
            //            curl_setopt($ch, CURLOPT_URL, $url);
            //            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            //            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            //            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            //            //Send the request
            //            $response = curl_exec($ch);
            ////            dd($ch);
            //            //Close request
            //            if ($response === FALSE) {
            ////                die('FCM Send Error: ' . curl_error($ch));
            //                return true;
            //            }
            //            curl_close($ch);
            return true;
        } catch (\Exception $ex) {
            return true;
        }
    }

    //    public function pushNotificationiOS($data, $devicetokens, $customData = null) {
    //        foreach ($devicetokens as $devicetoken):
    //            self::pushNotifyiOS($data, $devicetoken, $customData);
    //        endforeach;
    //        return true;
    //    }

    public static function pushNotificationiOSMultipleUsers($data = [], $userIds, $customData = null)
    {
        foreach ($userIds as $userId) :
            self::pushNotificationiOS($data, $userId, $customData);
        endforeach;
        return true;
    }

    public static function pushNotificationiOS($data = [], $userId, $customData = null)
    {
        foreach (\App\Models\UserDevice::whereUserId($userId)->get() as $userDevice) :
            self::pushNotifyiOS($data, $userDevice->token);
        endforeach;
        return true;
    }

    private static function emailSend($templateName, $subject, $userId, $customData = [])
    {
        try {

            $user = User::whereId($userId)->first();
            //send mail to user as a feedback    
            //        $dataM = ['subject' => 'Register Notification', 'name' => $request->name, 'to' => $request->email];
            //            $request = new Request;
            //            dd(request()->header('X-localization'));
            $userName = 'name_en';
            if (request()->header('X-localization') == 'zh')
                $userName = 'name_zh';
            if ($user->email != '') :
                if (filter_var($user->email, FILTER_VALIDATE_EMAIL) != false) :
                    $dataM = ['subject' => $subject, 'name' => $user->$userName, 'to' => $user->email];
                    if (count($customData) > 0)
                        $dataM += $customData;
                    //        dd($dataM,$templateName,$subject);
                    //ENDS      
                    dispatch(new \App\Jobs\BackgroundEMAIL($templateName, $dataM));
                endif;
            endif;
            return true;
        } catch (\Exception $ex) {
            return true;
        }
    }

    /**
     * 
     * @param array $data
     * @param int $userId
     * @param bool $saveNotification
     * @param array $emailTemplate if you want to send email send array ['template_name'=>'','subject'=>'','customData'=>'']
     * @return boolean
     */
    public static function pushNotifications($data = [], $userId, $saveNotification = true, $emailTemplate = false)
    {
        // dd($data);
        // dd('notification');
        if ($saveNotification)
            self::savePushNotification($data, $userId);
        if ($emailTemplate != false) :
            self::emailSend($emailTemplate['template_name'], $emailTemplate['subject'], $userId, $emailTemplate['customData']);
        endif;


        $tokensAndroid = [];
        foreach (\App\Models\UserDevice::whereIn('type', ['android', 'web'])->whereUserId($userId)->get() as $userDevice) :
            $tokensAndroid[] = $userDevice->token;
        endforeach;
        // dd($tokensAndroid);
        if (count($tokensAndroid) > 0)
            // dd($userId);
            self::pushNotoficationRaw($data, $tokensAndroid);


        $tokensiOS = [];
        foreach (\App\Models\UserDevice::whereIn('type', ['ios', 'web'])->whereUserId($userId)->get() as $userDevice) :
            $tokensiOS[] = $userDevice->token;
        endforeach;
        // dd($tokensiOS);

        if (count($tokensiOS) > 0)
            // dd($data);
            self::pushNotofication($data, $tokensiOS);

        return true;
    }
    public static function pushNotificationMultiple($data = [], $userIds, $saveNotification = true, $emailTemplate = false)
    {
        $tokens = [];
        $tokensAndroid = [];
        $tokensiOS = [];
        foreach ($userIds as $userId) :
            if ($saveNotification) {
                self::savePushNotification($data, $userId);
            }
            if ($emailTemplate != false) :
                self::emailSend($emailTemplate['template_name'], $emailTemplate['subject'], $userId, $emailTemplate['customData']);
            endif;
            if (User::whereId($userId)->where('is_notify', '1')->get()->isEmpty() === true)
                continue;
            //	    foreach (\App\Models\UserDevice::whereUserId($userId)->get() as $userDevice):
            //		$tokens[] = $userDevice->token;
            //	    endforeach;
            //            
            foreach (\App\Models\UserDevice::where('type', 'android')->whereUserId($userId)->get() as $userDevice) :
                $tokensAndroid[] = $userDevice->token;
            endforeach;
            foreach (\App\Models\UserDevice::where('type', 'ios')->whereUserId($userId)->get() as $userDevice) :
                $tokensiOS[] = $userDevice->token;
            endforeach;
        endforeach;
        if (count($tokensAndroid) > 0)
            self::pushNotoficationRaw($data, $tokensAndroid);
        if (count($tokensiOS) > 0)
            self::pushNotofication($data, $tokensiOS);
        // dd($tokens);
        //        if (count($tokens) > 0)
        //            self::pushNotofication($data, $tokens);
        //        return true;
    }
    public static $_AuthId = 0;

    private static function savePushNotification($data, $userId)
    {
        try {
            if (isset($data['data'])) {
                $data['message'] = json_encode($data['data']);
            }

            $data += [
                'target_id' => $userId,
                'created_by' => Auth::id() ?: self::$_AuthId,
            ];

            \App\Models\Notification::create($data);
            return true;
        } catch (\Exception $ex) {
            // Log or handle the exception
            return false;
        }
    }


    private static function pushNotifyiOS($data, $devicetoken, $customData = null)
    {
        //return true;
        $deviceToken = $devicetoken;
        $ctx = stream_context_create();
        // ck.pem is your certificate file
        stream_context_set_option($ctx, 'ssl', 'local_cert', public_path('apn/key.pem'));
        stream_context_set_option($ctx, 'ssl', 'passphrase', '');
        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.sandbox.push.apple.com:2195',
            $err,
            $errstr,
            60,
            STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT,
            $ctx
        );
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
        $body['aps'] = ['alert' => ['title' => $data['title'], 'body' => $data['body']], 'sound' => 'default'];
        if ($customData !== null)
            $body['extraPayLoad'] = ['custom' => $customData];
        // Encode the payload as JSON
        // dd($body);
        $payload = json_encode($body);
        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        //        pack("H*", "2133")
        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        // $this->saveNotification($data);
        fclose($fp);

        if (!$result)
            return trans('api_ApiController.Message_not_delivered') . PHP_EOL;
        else
            return trans('api_ApiController.Message_successfully_delivered') . PHP_EOL;
        //die();
    }

    protected static function __uploadImageBase64($baseEncodeImage, $path = null)
    {
        $image = $baseEncodeImage;  // your base64 encoded
        $fileExtension = 'png';
        if (strpos($image, 'png') !== false) :
            $image = str_replace('data:image/png;base64,', '', $image);
            $fileExtension = 'png';
        endif;
        if (strpos($image, 'jpeg') !== false) :
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $fileExtension = 'jpeg';
        endif;
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10) . '.' . $fileExtension;
        if ($path === null)
            $path = public_path('uploads');
        \File::put($path . '/' . $imageName, base64_decode($image));
        return $imageName;
    }

    public static function __uploadImage($image, $path = null)
    {
        if ($path === null)
            $path = public_path('uploads');
        $imageName = uniqid() . time() . '.' . $image->getClientOriginalExtension();
        $image->move($path, $imageName);
        //	$image->response()->file(storage_path($path));
        return $imageName;
    }

    public static function __uploadImageInCache($image, $path = null)
    {
        if ($path === null)
            $path = public_path('uploads');
        $imageName = rand(1000, 10000) . '_' . \Auth::id() . '.' . $image->getClientOriginalExtension();
        $image->move($path, $imageName);
        //	$image->response()->file(storage_path($path));
        return $imageName;
    }

    public static function __uploadVideo($image, $path = null, $savethumbnail = false)
    {

        if ($path === null)
            $path = public_path('uploads');
        $imageNamewithoutExtension = uniqid() . time();
        $imageName = $imageNamewithoutExtension . '.' . $image->getClientOriginalExtension();
        $image->move($path, $imageName);
        //        Thumbnail::getThumbnail(<VIDEO_SOURCE_DIRECTORY>,<THUMBNAIL_STORAGE_DIRECTORY>,<THUMBNAIL_NAME>);
        //        dd([$path . $imageName, $path . 'thumbnail/', $imageNamewithoutExtension . '.png']);
        if ($savethumbnail === true)
            \Lakshmaji\Thumbnail\Facade\Thumbnail::getThumbnail($path . $imageName, $path . 'thumbnail/', $imageNamewithoutExtension . '.png', 2);
        //        dd($Thumbnail);
        return $imageName;
    }

    public static function __uploadImageWithURL($url, $path = null)
    {
        //        if ($path === null)
        //            $path = public_path('uploads');
        //        $imageName = uniqid() . time() . '.' . $image->getClientOriginalExtension();
        //        $image->move($path, $imageName);
        //        return $imageName;
        //        $url = 'https://pay.google.com/about/static/images/social/og_image.jpg';
        //        $info = pathinfo($url);
        //        $arrContextOptions = array(
        //            "ssl" => array(
        //                "verify_peer" => false,
        //                "verify_peer_name" => false,
        //            ),
        //        );
        //        dd($url);
        $contents = file_get_contents($url, false, stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]));
        if ($path === null)
            $path = public_path('uploads');
        //        $file = '/tmp/' . $info['basename'];
        $imageName = uniqid() . time() . '.png';
        $returnName = $path . '/' . $imageName;
        file_put_contents($returnName, $contents);
        return $imageName;
    }

    public static function getDistanceByTable($lat, $lng, $distance, $tableName)
    {
        $latKey = 'latitude';
        $lngKey = 'longitude';
        $results = \DB::select(\DB::raw('SELECT id, ( 3959 * acos( cos( radians(' . $lat . ') ) * cos( radians( ' . $latKey . ' ) ) * cos( radians( ' . $lngKey . ' ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians(' . $latKey . ') ) ) ) AS distance FROM ' . $tableName . ' HAVING distance < ' . $distance . ' ORDER BY distance'));
        //        dd($results);
        return $results;
    }

    protected static function CURL_API($method, $url, $data, $httpHeaders = [], $contentTypejson = true, $curlOptionUserPWD = [])
    {
        $curl = curl_init();
        //    dd($data);
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) :
                    if ($contentTypejson)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                    else
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                endif;
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        if ($contentTypejson)
            $headers = array_merge(['Content-Type: application/json'], $httpHeaders);
        else
            $headers = array_merge(['Content-Type: application/x-www-form-urlencoded'], $httpHeaders);
        //        $headers = $httpHeaders;
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        if (count($curlOptionUserPWD) > 0)
            curl_setopt($curl, CURLOPT_USERPWD, $curlOptionUserPWD['0'] . ":" . $curlOptionUserPWD['1']);
        //dd($data);
        //dd($headers);
        // EXECUTE:
        $result = curl_exec($curl);
        // dd($result,$data['registration_ids']);    
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        //        dd($data, $headers, $result);
        return json_decode($result);
    }

    protected function registerUserQuickBlox($email, $name = null)
    {
        $response = self::getTokenQuickBlox();
        $data = self::CURL_API('POST', 'https://api.quickblox.com/users.json', ['user' => ['login' => $email, 'password' => $email, 'email' => $email, 'full_name' => $name]], ['QuickBlox-REST-API-Version: 0.1.0', 'QB-Token: ' . $response->session->token]);
        //        dd($data->user->id);

        return $data;
    }

    protected function addUserDeviceData(User $user, $request)
    {
        $existingDevice = UserDevice::where('user_id', $user->id)->first();

        if ($existingDevice) {
            // Update the existing device token
            $existingDevice->token = $request->device_token;
            $existingDevice->type = $request->device_type;
            $existingDevice->save();
        } else {
            
            // Create a new device entry
            $userDevice = new \App\Models\UserDevice;
            $userDevice->user_id = $user->id;
            $userDevice->type = $request->device_type;
            $userDevice->token = $request->device_token;
            $userDevice->save();
        }

        return true;
    }


    public static function isJSON($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}
