<?php

namespace App\Http\Controllers\API;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Validator;
use App\Models\User as MyModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\UserLocation;
use App\Models\UserQuestion;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends ApiController
{
    protected $cloudinary;
    protected $config;

    public function __construct()
    {
        $this->config = Configuration::instance([
            'cloud' => [
                'cloud_name' => 'duhbl1twp',
                'api_key'    => '714827248171872',
                'api_secret' => 'rtU9vRyIrcrKSvNAzroMWtBWOjo'
            ]
        ]);
        $this->cloudinary = new Cloudinary($this->config);
    }
    public function userLocation(Request $request)
    {

        $rules = ['latitude' => 'required', 'longitude' => 'required'];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {
            $userExit = UserLocation::where('user_id', Auth::id())->count();
            if ($userExit == '0') {

                $input = $request->only(array_keys($rules));
                $input['user_id'] = Auth::id();
                UserLocation::create($input);
                return parent::successCreated(['message' => 'User Location Added Successfully']);
            }
            return parent::error('User Location Allready Added');
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    public function userRegister(Request $request)
    {
        $rules =
            [
                'first_name'       => 'required',
                'last_name'        => 'required',
                'profile_image'    => 'nullable',
                'email'            => 'required|email',
                'password'         => 'required|min:8',
                'confirm_password' => 'required|min:8|same:password',
                'gender'           => 'required',
                'dob'              => '',
                'address'          => '',
                'latitude'         => '',
                'longitude'        => '',
                'is_verify'        =>''
            ];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        $user = \App\Models\User::where('email', '=', $request->email)->first();
        try {
            $input = $request->all();
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageUpload = $this->cloudinary->uploadApi()->upload($image->getRealPath(), [
                    'folder' => 'uploads/images',
                    'resource_type' => 'image',
                ]);
                $input['profile_image'] = $imageUpload['secure_url'];
            }
            $input['password'] = Hash::make($request->password);

            if ($user) {
                if ($user->email && $user->is_verify == 1)
                    return parent::error('email already exist');
                elseif ($user->email && $user->is_verify == 0)
                    $user->fill($input);
            } else {
                $user = \App\Models\User::create($input);
            }
            $user->save();
            return parent::successCreated(['message' => 'Account Created successfully', 'user_id' => $user]);
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    public function sentOtp(Request $request)
    {
        $rules = [
            'otp' => 'required',
            'user_id' => '',
            'device_token' => '',
            'device_type' => '',
        ];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);

        if ($validateAttributes) {
            return $validateAttributes;
        }

        $userID = \App\Models\User::where('otp', '=', $request->otp)->where('id', $request->user_id)->first();

        try {
            if ($userID) {
                $token = $userID->createToken('netscape')->accessToken;
                parent::addUserDeviceData($userID, $request);
                \App\Models\User::where('id', $userID->id)->update(['is_verify' => "1", 'otp' => null]);
                $userLanguage = $userID->language ?? 'en';
                $messageType = 'user_login';
                $message = Message::getLocalizedMessage($messageType, $userLanguage);
                return parent::success([
                    'message' =>  $message,
                    'id' => $userID->id,
                    'token' => $token,
                    'user' => $userID->id
                ]);
            } else {
                return parent::error('The OTP you entered is invalid. Please enter the correct otp');
            }
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    public function resentOtp(Request $request)
    {
        // dd('cus');
        $rules = ['email' => 'required'];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {
            $user = \App\Models\User::where('email', $request->email)->first();
            // dd($user);
            $otp = rand(1231, 7879);

            if ($user) {
                if ($user->email && $user->is_verify == 1)
                    return parent::error('email already verified');
                elseif ($user->email && $user->is_verify == 0)
                    $dataM = ['subject' => 'Reset Your Password', 'to' => $request->email, 'otp' => $otp];
                Mail::send('emails.notify', $dataM, function ($message) use ($dataM) {
                    $message->to($dataM['to']);
                    $message->subject($dataM['subject']);
                });
            }
            \App\Models\User::where('email', $request->email)->update(['otp' => $otp]);

            return parent::successCreated(['message' => 'Otp send to your email , please verify.', 'user_id' => $user->id, 'otp' => $otp]);
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function CustomerLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'device_type' => 'required',
            'device_token' => 'required',
            'latitude' => '',
            'longitude' => '',
        ];

        if (!isset($request->email)) {
            $rules += ['email' => 'email|required'];
        }

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);

        if ($validateAttributes) {
            return $validateAttributes;
        }

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_verify' => "1"])) {
                $user = Auth::user();
                // dd($user);

                // Check if the user exists in your custom model
                if (MyModel::where('email', $request->email)->first() == null) {
                    return parent::error('User Not Exist');
                }

                $token = Auth::user()->createToken('netscape')->accessToken;
                parent::addUserDeviceData(Auth::user(), $request);

                MyModel::where('id', Auth::id())->update([
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
                return parent::success([
                    'message' => "Login Successfully",
                    'id' => Auth::id(),
                    'token' => $token,
                    'user' => Auth::user(),
                ]);
            } else {
                return parent::error("Email and password does not match");
            }
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }


    public function forgotPasswordVerify(Request $request)
    {
        $rules = [
            'password_otp' => 'required',
            'device_token' => 'required',
            'device_type'  => 'required',
            'user_id'      => '',
        ];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);

        if ($validateAttributes) {
            return $validateAttributes;
        }
        try {
            $user = MyModel::where('password_otp', $request->password_otp)->where('id', $request->user_id)->first();
            if (!$user) {
                return parent::error('Wrong OTP');
            }
            if ($user->is_verify == 1) {
                $token = $user->createToken('netscape')->accessToken;
                parent::addUserDeviceData($user, $request);
                $user->update(['password_otp' => null]);
                return parent::success([
                    'message' => 'Login Successfully',
                    'id' => $user->id,
                    'token' => $token,
                    'user' => $user
                ]);
            } else {
                return parent::error('User not verified');
            }
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function logout(Request $request)
    {
        // Define any rules for validation (if necessary)
        $rules = [
            'device_token' => 'required|string',
            'device_type' => 'required|string'
        ];
        $rules = array_merge($this->requiredParams, $rules);

        // Validate the request attributes
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);

        if ($validateAttributes) {
            return $validateAttributes;
        }

        try {
            // Delete the user device entry
            \App\Models\UserDevice::where('token', $request->device_token)
                ->where('type', $request->device_type)
                ->where('user_id', Auth::id())
                ->delete();

            // Revoke the OAuth access token
            DB::table('oauth_access_tokens')
                ->where('user_id', Auth::id())
                // ->where('id', $request->device_token)
                ->delete();

            return parent::success(['message' => "Logout successfully"]);
        } catch (\Exception $ex) {
            Log::error('logout: ' . $ex->getMessage());
            return parent::error('Failed to logout. Please try again.');
        }
    }

    public function resetPassword(Request $request)
    {
        $rules = ['type' => 'required|in:email,phone', $request['type'] => 'required|exists:users,' . $request['type'], 'password' => 'required', 'confirm_password' => 'required|same:password'];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {
            $user = MyModel::where($request->type, $request[$request['type']])->first();
            // if (Hash::check($request->old_password, $user->password)) :
            $user->password = Hash::make($request->password);
            $user->save();
            return parent::success(['message' => 'Password Changed Successfully']);
            // else :
            //     return parent::error('Use valid old password');
            // endif;
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function changePassword(Request $request)
    {
        $rules = ['password' => 'required', 'confirm_password' => 'required|same:password'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {
            // dd(Auth::id());
            if (MyModel::where('id', Auth::id())->first() != null) :
                $model = MyModel::find(Auth::id());
                $model->password = Hash::make($request->password);
                $model->save();
                return parent::success(['message' => 'Password Changed Successfully']);
            else :
                return parent::error('Something Went Wrong');
            endif;
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    public function userRegisterORLoginUsingGoogle(Request $request)
    {
        // Define validation rules
        $rules = [
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'email' => 'required|email',
            'google_id' => 'required',
            'profile_image' => 'nullable|url', // Adding image URL validation
            'latitude' => 'nullable',
            'longitude' => 'nullable'
        ];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) {
            return $validateAttributes;
        }

        try {
            // Extract first_name and last_name from email if not provided
            if (empty($request->first_name) || empty($request->last_name)) {
                $emailParts = explode("@", $request->email);
                $nameParts = explode(".", $emailParts[0]);

                if (count($nameParts) == 1) {
                    $first_name = ucfirst($nameParts[0]);
                    $last_name = '';
                } else {
                    $first_name = ucfirst($nameParts[0]);
                    $last_name = ucfirst($nameParts[1]);
                }

                $first_name = $request->first_name ?? $first_name;
                $last_name = $request->last_name ?? $last_name;
            } else {
                $first_name = $request->first_name;
                $last_name = $request->last_name;
            }

            // Set a default name
            $name = $first_name ? $first_name . ' ' . $last_name : explode("@", $request->email)[0];

            // Check if email exists
            $user = MyModel::where('email', $request->email)->first();

            if ($user) {
                // Email exists, update google_id and other fields
                $user->update([
                    'google_id' => $request->google_id,
                    'is_verify' => "1",
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'first_name' => $first_name,
                    'last_name' => $last_name
                ]);

                if ($user->social_type === null) {
                    return parent::error("User is not valid");
                }

                $token = $user->createToken('netscape')->accessToken;
                parent::addUserDeviceData($user, $request);
                return parent::success(['message' => 'Login Successful With Updated Email', 'social_login' => true, 'token' => $token, 'user' => $user]);
            } else {
                // google_id does not exist, create new user
                $input = $request->all();

                // Upload image to Cloudinary if URL is provided
                if (isset($request->image)) {
                    $imageUpload = $this->cloudinary->uploadApi()->upload($request->image, [
                        'folder' => 'uploads/images',
                        'resource_type' => 'image',
                    ]);
                    $input['profile_image'] = $imageUpload['secure_url'];
                }

                $input['social_type'] = 'Google';
                $input['is_verify'] = '1';
                $input['first_name'] = $first_name;
                $input['last_name'] = $last_name;
                $user = MyModel::create($input);

                // Create user token for authorization
                $token = $user->createToken('netscape')->accessToken;

                // Add user device details for Firebase
                parent::addUserDeviceData($user, $request);
                return parent::successCreated(['status' => $request->status, 'message' => "Account Created Successfully", 'social_login' => false, 'token' => $token, 'user' => $user]);
            }
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function userRegisterORLoginUsingApple(Request $request)
    {
        $rules = ['name' => '', 'email' => '', 'apple_id' => '', 'latitude' => '', 'longitude' => ''];
        $rules = array_merge($this->requiredParams, $rules);
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {
            $modelEmailCount = 0;
            if ($request->email != null) :
                $modelEmail = MyModel::where('email', $request->email);
                $modelEmailCount = $modelEmail->count();
            endif;
            if (isset($request->name)) {
                if ($request->name != null) {
                    $name = $request->name;
                }
            } else {
                $name = explode("@", $request->email)[0];
            }
            $model = MyModel::where('apple_id', $request->apple_id);
            if ($modelEmailCount != 0) {
                $modelEmailId = $modelEmail->first()->id;
                $user = MyModel::where('id', $modelEmailId)->update(['apple_id' => $request->apple_id, 'is_verify' => "1", 'latitude' => $request->latitude, 'longitude' => $request->longitude, 'name' => $name]);
                $user = MyModel::find($modelEmailId);
                if ($user->social_type == null) {
                    $userLanguage = $user->language ?? 'en';
                    $messageType = 'social_type_null';
                    $message = Message::getLocalizedMessage($messageType, $userLanguage);
                    return parent::error($message);
                }
                if ($user->is_block_by_admin == 1) {
                    $userLanguage = $user->language ?? 'en';
                    $messageType = 'is_block_by_admin';
                    $message = Message::getLocalizedMessage($messageType, $userLanguage);
                    return parent::error(['message' => $message]);
                }

                $token = $user->createToken('netscape')->accessToken;
                parent::addUserDeviceData($user, $request);
                if ($user->is_deactivate == 1) {
                    $user->update(['is_deactivate' => "0"]);
                }
                if ($user->first_time_login == 0) {
                    MyModel::where('id', $user->id)->update(['first_time_login' => "1"]);
                }

                return parent::success(['message' => 'Login Successful With Updated Email', 'social_login' => true, 'token' => $token, 'user' => $user]);
            } elseif ($model->count() == 0) {
                $input = $request->all();
                $input['social_type'] = 'Apple';
                $input['is_verify'] = '1';
                $input['name'] = $name;
                $user = MyModel::create($input);

                // create user token for authorization
                $token = $user->createToken('netscape')->accessToken;
                parent::addUserDeviceData($user, $request);

                return parent::successCreated(['status' => $request->status, 'message' => 'Account Created Successfully', 'social_login' => false, 'token' => $token, 'user' => $user]);
            } else {
                $user = $model;
                if ($user->social_type == null) {
                    $userLanguage = $user->language ?? 'en';
                    $messageType = 'social_type_null';
                    $message = Message::getLocalizedMessage($messageType, $userLanguage);
                    return parent::error($message);
                }
                $token = $user->createToken('netscape')->accessToken;
                parent::addUserDeviceData($user, $request);
                $userLanguage = $user->language ?? 'en';
                $messageType = 'user_login';
                $message = Message::getLocalizedMessage($messageType, $userLanguage);
                return parent::success(['message' => $message, 'social_login' => true, 'token' => $token, 'user' => $user]);
            }
        } catch (\Exception $ex) {
            // Log the exception for debugging purposes
            Log::error('Server Error: ' . $ex->getMessage());
            // Return an error response to the user
            return parent::error([
                'message' => 'No email found.Please try other login method.'
            ],);
        }
    }
    public function deleteAccount(Request $request)
    {
        try {
            $user = \App\Models\User::find(Auth::id());

            if (!$user) {
                return parent::error('User not found');
            }

            \App\Models\BlockUser::where('blocked_by', Auth::id())->delete();
            Notification::whereRaw('JSON_UNQUOTE(JSON_EXTRACT(message, "$.created_by")) = ?', [Auth::id()])->delete();

            $user->delete();
          return parent::success(['message' => "SUCCESS"]);
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function forgotPassword(Request $request, Factory $view)
    {
        try {
            $rules = ['email' => 'required|exists:users,email'];
            $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), true);
            if ($validateAttributes) :
                return $validateAttributes;
            endif;
            $email_id =  \App\Models\User::where('email', $request->email)->first();
            if ($email_id->is_verify == 1) {
                $email_id->update(['password_otp' => rand(1231, 7879)]);
                $dataM = ['subject' => 'Reset Your Password', 'to' => $request->email, 'otp' => $email_id->password_otp];

                //this is for sending email to user 
                // Mail::send('emails.forgetPassword', $dataM, function ($message) use ($dataM) {
                //     $message->to($dataM['to']);
                //     $message->subject($dataM['subject']);
                // });
                // $userLanguage = $email_id->language ?? 'en';
                // $messageType = 'forgot_password';
                // $message = Message::getLocalizedMessage($messageType, $userLanguage);
                return parent::successCreated(['message' => "OTP Sent Successfully", 'user_id' => $email_id->id, 'otp' => $email_id->password_otp]);
            } else {
                $userLanguage = $email_id->language ?? 'en';
                $messageType = 'wrong_email';
                $message = Message::getLocalizedMessage($messageType, $userLanguage);
                return parent::error($message);
            }
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
}
