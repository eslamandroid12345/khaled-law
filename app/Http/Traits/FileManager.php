<?php

namespace App\Http\Traits;

trait FileManager
{
    /**
     * Validates the file from the request & persists it into storage
     * @param String $requestAttributeName from request
     * @param String $folder
     * @param String $disk
     * @return String $path
     */
    public function upload($requestAttributeName = null, $folder = '', $disk = 'public'){
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid()){
            $path = 'storage/'.request()->file($requestAttributeName)->store($folder, $disk);
        }
        return $path;
    }

    /**
     * Validates the file from the request & persists it into storage then unlink old one
     * @param String $requestAttributeName from request
     * @param String $folder
     * @param String $oldPath
     * @return String $path
     */
    public function updateFile($requestAttributeName = null, $folder = '',$oldPath){
        $path = null;
        if(request()->hasFile($requestAttributeName) && request()->file($requestAttributeName)->isValid()){
            $path = $this->upload($requestAttributeName,$folder);
            if(file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        return $path;
    }
    public function uploadFile($file, $folder = '', $disk = 'public'){
        $path = null;
        $path = 'storage/'.$file->store($folder, $disk);
        return $path;
    }

    /**
     * Delete the file from the path
     * @param String $oldPath
     */

    public function deleteFile($oldPath){
        if(file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    public function uploadMorphImages($images = [], $object, $folder = '', $disk = 'public')
    {
        try {
            foreach ($images as $image) {
                $path = 'storage/' . $image->store($folder, $disk);
                $object->images()->create([
                    'path' => $path,
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function uploadMorphOneImage($image, $object, $folder = '', $disk = 'public')
    {
        try {
            $path = 'storage/' . $image->store($folder, $disk);
            $object->image()->create([
                'path' => $path,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteMorphOneImage($object)
    {
        if ($object->image !== null) {
            $this->deleteFile($object->image?->path);
        }
        $object->image?->delete();
    }

    public function deleteMorphImages($object)
    {
        if ($object->images !== null) {
            foreach ($object->images as $image) {
                $this->deleteFile($image?->path);
            }
        }
        $object->images()?->delete();
    }
}
