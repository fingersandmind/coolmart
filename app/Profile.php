<?php

namespace App;

use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use UploadTrait;
    protected $fillable = ['user_id', 'phone', 'title', 'about', 'twitter', 'facebook', 'instagram', 'avatar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateDetails($request)
    {
        $img_arr = [];

        if($request->has('image'))
        {
            $file = $request->file('image');
            $filename = str_random(5).'_'.time();
            $folder = 'uploads/users/';
            $imageFilepath = $folder.'image/'.$filename.'.'.$file->getClientOriginalExtension();
            $avatarFilepath = $folder.'optional/'.$filename.'.'.$file->getClientOriginalExtension();

            $this->uploadImage($this,$file,$folder,'public', $filename, $avatarFilepath);

            array_push($img_arr, ['image' => $imageFilepath]);
            array_push($img_arr, ['avatar' => $avatarFilepath]);
        }

        $this->update(array_merge($request->except('_token', 'action', 'image'),
            $img_arr[1] ?? []
            )
        );
        $this->user->image()->updateOrCreate(
            ['imageable_id' => $this->user->id],
            $img_arr[0] ?? []
        );
    }
}
