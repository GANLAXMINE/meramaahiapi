<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User as MyModel;
use Illuminate\Support\Facades\Log;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use App\Models\UserDetail;
use App\Models\UserImage;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected $config;
    protected $cloudinary;

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

    public function userDetails(Request $request)
    {
        // Validation rules for the fields used
        $rules = [
            'religion' => 'nullable|string',
            'community' => 'nullable|string',
            'relationship_status' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'education_course' => 'nullable|string',
            'education_college_name' => 'nullable|string',
            'education_college_place' => 'nullable|string',
            'working' => 'nullable|string',
            'job_role' => 'nullable|string',
            'company_name' => 'nullable|string',
            'workplace' => 'nullable|string',
            'passions.*' => 'nullable|string',
            'profile_for' => 'nullable|string',
            'about_me' => 'nullable|string',

        ];

        // Validate the request data against defined rules
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);

        // If validation fails, return the validation errors
        if ($validateAttributes) {
            return $validateAttributes;
        }

        try {
            $user_id = Auth::id();
            // dd($user_id);

            // Prepare data to be inserted or updated
            $value = [
                "religion" => $request->input('religion'),
                "community" => $request->input('community'),
                "relationship_status" => $request->input('relationship_status'),
                "country" => $request->input('country'),
                "state" => $request->input('state'),
                "city" => $request->input('city'),
                "education_course" => $request->input('education_course'),
                "education_college_name" => $request->input('education_college_name'),
                "education_college_place" => $request->input('education_college_place'),
                "working" => $request->input('working'),
                "job_role" => $request->input('job_role'),
                "company_name" => $request->input('company_name'),
                "workplace" => $request->input('workplace'),
                "profile_for" => $request->input('profile_for'),
                "about_me" => $request->input('about_me'),
                "user_id" => $user_id,
            ];
            $userDetail = UserDetail::updateOrCreate(
                ['user_id' => $user_id], // Search criteria
                $value // Data to update or insert
            );
            // Return success response
            return parent::success(['message' => 'User details updated successfully', 'userDetail' => $userDetail]);
        } catch (\Exception $ex) {
            dd($ex);
            // Log any errors that occur during the process
            Log::error('Error updating user details: ' . $ex->getMessage());

            // Return error response
            return parent::error('Failed to update user details. Please try again.');
        }
    }

    public function userProfile(Request $request)
    {
        try {
            $questionsCount = count(UserImage::where('user_id', auth()->id())->get());
            $model = MyModel::select(['id', 'first_name', 'last_name', 'email', 'gender', 'dob', 'profile_image'])
                ->with(['userDeatil', 'Images'])
                ->where('id', auth()->id());

            if ($questionsCount > 0) {
                $profileImage = UserImage::where('user_id', auth()->id())->first();

                if ($profileImage) {
                    $model = $model->addSelect(DB::raw("'" . $profileImage->image . "' AS profile"));
                    $model = $model->addSelect(DB::raw("'$profileImage->thumb_image' AS thumb_image"));
                } else {
                    // Set both profile and thumb_image to null
                    $model = $model->addSelect(DB::raw("null as profile, null as thumb_image"));
                }
            } else {
                // Handle the case where there are no user questions
                $model = $model->addSelect(DB::raw("'null' as profile, null as thumb_image"));
            }


            if ($model->first() != null) {
                return parent::success($model->first());
            } else {
                return parent::error('No Record Found');
            }
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }

    public function editProfile(Request $request)
    {
        try {
            $hasQuestions = false;
            $config = $this->config;
            $cloudinary = $this->cloudinary;

            // Update User model fields (first_name, last_name, email, gender, dob)
            $userData = [];
            if ($request->filled('first_name')) {
                $userData['first_name'] = $request->first_name;
            }
            if ($request->filled('last_name')) {
                $userData['last_name'] = $request->last_name;
            }
            if ($request->filled('email')) {
                $userData['email'] = $request->email;
            }
            if ($request->filled('gender')) {
                $userData['gender'] = $request->gender;
            }
            if ($request->filled('dob')) {
                $userData['dob'] = $request->dob;
            }
            if (!empty($userData)) {
                MyModel::where('id', Auth::id())->update($userData);
            }

            // Update UserDetail model fields
            $existingUserDetails = UserDetail::where('user_id', Auth::id())->first();
            $userDetailInput = [
                "religion" => $request->input('religion', $existingUserDetails->religion),
                "community" => $request->input('community', $existingUserDetails->community),
                "relationship_status" => $request->input('relationship_status', $existingUserDetails->relationship_status),
                "country" => $request->input('country', $existingUserDetails->country),
                "state" => $request->input('state', $existingUserDetails->state),
                "city" => $request->input('city', $existingUserDetails->city),
                "education_course" => $request->input('education_course', $existingUserDetails->education_course),
                "education_college_name" => $request->input('education_college_name', $existingUserDetails->education_college_name),
                "education_college_place" => $request->input('education_college_place', $existingUserDetails->education_college_place),
                "working" => $request->input('working', $existingUserDetails->working),
                "job_role" => $request->input('job_role', $existingUserDetails->job_role),
                "company_name" => $request->input('company_name', $existingUserDetails->company_name),
                "workplace" => $request->input('workplace', $existingUserDetails->workplace),
                "passions" => $request->input('passions', $existingUserDetails->passions),
                "profile_for" => $request->input('profile_for', $existingUserDetails->profile_for),
                "about_me" => $request->input('about_me', $existingUserDetails->about_me),
            ];
            UserDetail::where('user_id', Auth::id())->update($userDetailInput);

            // Handle image uploads if any
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $imageUpload = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                        'folder' => 'uploads/images',
                        'resource_type' => 'image',
                    ]);

                    $thumbImageUpload = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                        'folder' => 'uploads/thumb_images',
                        'transformation' => [
                            [
                                'width' => 800,
                                'height' => null,
                                'quality' => 'auto',
                                'format' => 'jpg',
                                'crop' => 'scale',
                            ]
                        ]
                    ]);

                    // Create or update UserImage record
                    $userImage = UserImage::updateOrCreate(
                        ['user_id' => Auth::id()],
                        ['image' => $imageUpload['secure_url'], 'thumb_image' => $thumbImageUpload['secure_url']]
                    );
                }
            }

            return parent::success(['message' => "Profile updated successfully"]);
        } catch (\Exception $ex) {
            Log::error('edit profile: ' . $ex->getMessage());
            return parent::error('Failed to update profile. Please try again.');
        }
    }

    public function editLatLong(Request $request)
    {
        $rules = ['latitude' => 'required', 'longitude' => 'required', 'address' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {

            if ($request->has('latitude') && !empty($request->latitude) && $request->has('longitude') && !empty($request->longitude) && $request->has('address') && !empty($request->address)) {
                $address = $request->address;

                // Remove the first comma if it exists at the start of the address
                if (substr($address, 0, 1) === ',') {
                    $address = substr($address, 1);
                }
                MyModel::where('id', Auth::id())->update(['latitude' => $request->latitude, 'longitude' => $request->longitude, 'address' => $address]);
                return parent::success(['message' => 'Location Updated Successfully']);
            }
            return parent::success("Can't Get Your Location");
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
    public function imageVerify(Request $request)
    {
        $rules = ['image' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);

        if ($validateAttributes) {
            return $validateAttributes;
        }

        try {
            $cloudinary = $this->cloudinary;

            $user = MyModel::find(Auth::id());
            if ($user->verification_status == '2') {
                return parent::success(['message' => 'Image Already Verified']);
            }

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');

                $imageUpload = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                    'folder' => 'uploads/users',
                    'resource_type' => 'image',
                ]);

                $user->verification_image = $imageUpload['secure_url'];
                $user->verification_status = '1';
                $user->save();
                return parent::success(['message' => ""]);
            } else {
                throw new \Exception("Image file is missing or invalid.");
            }
        } catch (\Exception $ex) {
            Log::error('image verify: ' . $ex->getMessage());
            return parent::error($ex->getMessage());
        }
    }

    public function imageUpload(Request $request)
    {
        $rules = [
            'image' => 'required|array',

        ];

        // Validate the request data against defined rules
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);

        // If validation fails, return the validation errors
        if ($validateAttributes) {
            return $validateAttributes;
        }

        try {
            $config = $this->config;
            $cloudinary = $this->cloudinary;
            $user = UserDetail::where('user_id', Auth::id())->first();

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    // Upload original image
                    $imageUpload = $cloudinary->uploadApi()->upload($image->getRealPath(), [
                        'folder' => 'uploads/images',
                        'resource_type' => 'image',
                    ]);

                    // Upload thumbnail image
                    $thumbImageUpload = $this->cloudinary->uploadApi()->upload($image->getRealPath(), [
                        'folder' => 'uploads/thumb_images',
                        'transformation' => [
                            [
                                'width' => 800,
                                'height' => null,
                                'quality' => 'auto',
                                'format' => 'jpg',
                                'crop' => 'scale',
                            ]
                        ]
                    ]);

                    // Save image details to database
                    $questionImage = new UserImage();
                    $questionImage->image = $imageUpload['secure_url'];
                    $questionImage->thumb_image = $thumbImageUpload['secure_url'];
                    $questionImage->user_detail_id = $user->id;
                    $questionImage->user_id = Auth::id();
                    $questionImage->save();
                }
            }

            return parent::success(['message' => "Images uploaded successfully"]);
        } catch (\Exception $ex) {
            Log::error('Image upload error: ' . $ex->getMessage());
            return parent::error('Failed to upload images. Please try again.');
        }
    }

    public function deleteProfileImage(Request $request)
    {
        $rules = ['image_id' => 'required'];
        $validateAttributes = parent::validateAttributes($request, 'POST', $rules, array_keys($rules), false);
        if ($validateAttributes) :
            return $validateAttributes;
        endif;
        try {

            UserImage::where('id', $request->image_id)->delete();
            return parent::success(['message' => ""]);
        } catch (\Exception $ex) {
            return parent::error($ex->getMessage());
        }
    }
}
