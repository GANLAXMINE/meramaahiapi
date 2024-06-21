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
                'longitude'        => ''
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
        $rules = [];
        $rules = array_merge($this->requiredParams, $rules);
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
                ->where('id', $request->device_token)
                ->delete();
            $userLanguage = Auth::user()->language ?? 'en';
            $messageType = 'logout_user';
            $message = Message::getLocalizedMessage($messageType, $userLanguage);

            return parent::success(['message' => $message]);
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
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

    public function customerUpdate(Request $request)
    {
        $rules = ['first_name' => '', 'last_name' => ''];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {
            if (DB::table('role_user')->where('user_id', Auth::id())->value('role_id') != 1) {
                return parent::error('Sorry You Are At Wrong Place');
            }
            $input = $request->all();
            $user = MyModel::findOrFail(Auth::id());
            if ($request->has('profile_image') && !empty($request->profile_image)) {
                $file = $request->profile_image;
                $ext = strtolower($file->getClientOriginalExtension());
                $profile_image = parent::__uploadImage($file, public_path(MyModel::$_imagePublicPath), true);
                $input['profile_image'] = $profile_image;
            }
            $user->fill($input);
            $user->save();
            return parent::successCreated(['message' => 'Updated Successfully', 'user' => MyModel::findOrFail(Auth::id())]);
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }


    public function getcustomerProfile(Request $request)
    {

        try {
            if (DB::table('role_user')->where('user_id', Auth::id())->value('role_id') != 1) {
                return parent::error('Sorry You Are At Wrong Place');
            }
            // $user = MyModel::where('id',Auth::id())->first();
            // dd($user);
            return parent::success(['user' => Auth::user()]);
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function getConfigurationByColumn(Request $request, $column)
    {
        $rules = [];
        $validateAttributes = parent::validateAttributes($request, 'GET', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {
            if (!in_array($column, ['terms_and_conditions', 'privacy_policy', 'about_us', 'help_and_contact_us', 'cancellation_policy']))
                return parent::error('Please use valid column');
            $model = \App\Models\Configuration::first();
            $var = $column;
            return parent::success(['config' => $model->$var]);
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




    public function userRegisterORLoginUsingFb(Request $request)
    {
        $rules = ['first_name' => '', 'email' => 'required', 'fb_id' => 'required'];
        $rules = array_merge($this->requiredParams, $rules);
        //        dd($rules,$request->all());
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {

            $modelEmailCount = 0;
            if ($request->email != null) :
                //                $modelEmail = MyModel::where('email', $request->email)->whereNull('fb_id');
                $modelEmail = MyModel::where('email', $request->email);
                $modelEmailCount = $modelEmail->count();
            endif;
            //dd($request->email,$modelEmailCount);

            $model = MyModel::where('fb_id', $request->fb_id);
            //            dd($modelEmailCount);
            if ($modelEmailCount != 0) {
                $modelEmailId = $modelEmail->first()->id;
                $user = MyModel::where('id', $modelEmailId)->update(['fb_id' => $request->fb_id]);
                //            dd($modelEmail->first());
                $user = MyModel::find($modelEmailId);
                if ($user->social_type == null)
                    return parent::error('User Already Exists');

                $token = $user->createToken('netscape')->accessToken;
                parent::addUserDeviceData($user, $request);
                return parent::success(['message' => 'Login Successful With Updated Email', 'social_login' => true, 'token' => $token, 'user' => $user]);
            } elseif ($model->count() == 0) {
                $input = $request->all();
                $input['social_type'] = 'Facebook';
                $input['first_name'] = $request->first_name;
                $user = MyModel::create($input);

                // $user->assignRole(\App\Models\Role::where('id', 1)->first()->name);
                // create user token for authorization
                $token = $user->createToken('netscape')->accessToken;

                parent::addUserDeviceData($user, $request);

                return parent::successCreated(['status' => 200, 'message' => 'Account Created Successfully', 'social_login' => true,  'token' => $token, 'user' => $user]);
            } else {
                $user = MyModel::find($model->first()->id);

                if ($user->social_type == null)
                    return parent::error('User Already Exists');
                $token = $user->createToken('netscape')->accessToken;
                parent::addUserDeviceData($user, $request);
                return parent::success(['message' => trans('api_AuthController.Login_Successfully'), 'social_login' => true, 'token' => $token, 'user' => $user]);
            }
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
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
            \App\Models\BlockUser::where('blocked_user', Auth::id())->delete();
            \App\Models\UserQuestion::where('user_id', Auth::id())->delete();
            \App\Models\WhoViewedprofile::where('view_by', Auth::id())->delete();
            \App\Models\UserLike::where('like_by', Auth::id())->delete();
            \App\Models\UserBookmark::where('bookmark_by', Auth::id())->delete();
            \App\Models\UserDislike::where('dislike_by', Auth::id())->delete();
            \App\Models\WhoViewedprofile::where('view_user', Auth::id())->delete();
            \App\Models\UserLike::where('like_user', Auth::id())->delete();
            \App\Models\UserBookmark::where('bookmark_user', Auth::id())->delete();
            \App\Models\UserDislike::where('dislike_user', Auth::id())->delete();
            \App\Models\SurveyUserAnswer::where('receiver_id', Auth::id())->delete();
            \App\Models\SurveyUserQuestion::where('receiver_id', Auth::id())->delete();
            Notification::whereRaw('JSON_UNQUOTE(JSON_EXTRACT(message, "$.created_by")) = ?', [Auth::id()])->delete();

            $stripeCustomerId = $user->stripe_customer_id;

            if ($stripeCustomerId) {
                \Stripe\Stripe::setApiKey(config('app.stripe_sk_key'));

                try {
                    // Retrieve all subscriptions associated with the customer
                    $subscriptions = \Stripe\Subscription::all(['customer' => $stripeCustomerId]);

                    // Iterate over the retrieved subscriptions
                    foreach ($subscriptions->data as $subscription) {
                        // Retrieve the subscription object
                        $stripeSubscription = \Stripe\Subscription::retrieve($subscription->id);
                        // dump($stripeSubscription);

                        // Cancel and delete the subscription
                        $stripeSubscription->cancel(['invoice_now' => true]);
                        $stripeSubscription->delete();
                    }
                    // Send email notification for subscription cancellation
                    $subject = 'Your Subscription Has Been Cancelled';
                    // dd($subject);
                    Log::info('Subscription cancelled for user: ' . $user->email);

                    // Send email using Mail facade
                    Mail::send('emails.subscription_cancelled', ['user' => $user, 'subject' => $subject], function ($message) use ($user, $subject) {
                        $message->to($user->email)->subject($subject);
                        // Log success
                        Log::info('Email sent successfully to: ' . $user->email);
                    });
                    // dd($user->email);
                } catch (\Exception $e) {
                    // Handle any errors occurred during retrieval of subscriptions
                    Log::error('Error: ' . $e->getMessage());
                }
            }
            // dd('hello');
            // Delete the user
            $user->delete();
            $userLanguage = $user->language ?? 'en';
            $messageType = 'account_delete';
            $message = Message::getLocalizedMessage($messageType, $userLanguage);

            return parent::success(['message' => $message]);
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function deleteAccountUsingEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);

        if ($validateAttributes) {
            return $validateAttributes;
        }

        try {
            $user = \App\Models\User::where('email', $request->input('email'))->first();

            // Check if user exists and verify password
            if ($user && Hash::check($request->input('password'), $user->password)) {
                // Delete related data
                \App\Models\BlockUser::where('blocked_by', $user->id)->delete();
                \App\Models\BlockUser::where('blocked_user', $user->id)->delete();
                \App\Models\UserQuestion::where('user_id', $user->id)->delete();
                \App\Models\WhoViewedprofile::where('view_by', $user->id)->delete();
                \App\Models\UserLike::where('like_by', $user->id)->delete();
                \App\Models\UserBookmark::where('bookmark_by', $user->id)->delete();
                \App\Models\UserDislike::where('dislike_by', $user->id)->delete();
                \App\Models\WhoViewedprofile::where('view_user', $user->id)->delete();
                \App\Models\UserLike::where('like_user', $user->id)->delete();
                \App\Models\UserBookmark::where('bookmark_user', $user->id)->delete();
                \App\Models\UserDislike::where('dislike_user', $user->id)->delete();
                \App\Models\SurveyAnswer::where('receiver_id', $user->id)->delete();
                \App\Models\QuestionMessage::where('receiver_id', $user->id)->delete();
                \App\Models\Notification::whereRaw('JSON_UNQUOTE(JSON_EXTRACT(message, "$.target_id")) = ?', [$user->id])
                    ->orWhereRaw('JSON_UNQUOTE(JSON_EXTRACT(message, "$.created_by")) = ?', [$user->id])
                    ->delete();
                \App\Models\Notification::where('target_id', $user->id)->orWhere('created_by', $user->id)->delete();
                $user->userChats()->delete();

                // Delete the user
                $user->delete();

                return response()->json(['message' => 'Account Deleted Successfully'], 200);
            } else {
                // Password is incorrect or user not found
                return response()->json(['error' => 'Incorrect email or password'], 401);
            }
        } catch (\Exception $ex) {
            // Log the exception for debugging
            Log::error($ex);

            // Return a generic error message
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
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
