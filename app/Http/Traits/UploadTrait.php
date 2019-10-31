<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use File;

trait UploadTrait
{
    public function checkImage($image,$model)
    {
        $exists = $model->exists(public_path($image));
        if($exists)
        {
            File::delete(public_path($image));
        }
    }

    public function resizeImage($image, $width, $height)
    {
        Image::make(public_path($image))->fit($width, $height)->save();
    }

    public function uploadLogo($model, UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $this->checkImage($model->logo, $model);

        $file = $uploadedFile->storeAs($folder, $filename.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        // $this->resizeImage($file,800,400);

        return $file;
    }

    public function uploadImage($model, UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null, $thumb)
    {
        if($model->images)
        {
            foreach($model->images as $image)
            {
                $this->checkImage($image->image, $model);
                $this->checkImage($image->thumbnail, $model);
            }
        }
        $imageFolder = $folder.'image/';
        $file = $uploadedFile->storeAs($imageFolder, $filename.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

        if($thumb)
        {
            $thumbFolder = $folder.'thumbnail/';
            $thumbnail = $uploadedFile->storeAs($thumbFolder, $filename.'.'.$uploadedFile->getClientOriginalExtension(), $disk);

            $this->resizeImage($thumbnail, 400,400);
        }
        return $file;
    }
}