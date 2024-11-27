<?php

namespace App\Http\Services\Dashboard\Info;

use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\FileManager;
use App\Repository\InfoRepositoryInterface;
use Illuminate\Support\Facades\DB;
use function App\delete_model;
use function App\store_model;
use function App\update_model;

class InfoService
{
    use FileManager;
    public function __construct(private InfoRepositoryInterface $infoRepository,private FileManagerService $fileManagerService)
    {

    }

    public function edit()
    {
        $text = $this->infoRepository->getText();
        $images = $this->infoRepository->getImages();
        return view('dashboard.site.infos.edit', compact('text','images'));
    }

    public function update($request )
    {
        DB::beginTransaction();
        try {
            $this->updateText($request->text);
            $this->updateImages($request->images);
            DB::commit();
            return redirect()->back()->with(['success' => __('messages.updated_successfully')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
    public function updateText($array){
        if(!empty($array)){
            foreach ($array as $key => $value){
                $this->infoRepository->updateValues($key,$value);
            }
        }
    }
    public function updateImages($array){
        if(!empty($array)){
            foreach ($array as $key => $value){
                $value=$this->fileManagerService->handle('images.' . $key , folderName : 'images/info_control');
                $this->infoRepository->updateValues($key,$value);
            }
        }
    }
}
