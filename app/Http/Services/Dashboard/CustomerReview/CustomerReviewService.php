<?php

namespace App\Http\Services\Dashboard\CustomerReview;
use App\Repository\CustomerReviewRepositoryInterface;
use App\Repository\ImageRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Services\Mutual\FileManagerService;
use Illuminate\Support\Facades\DB;

class CustomerReviewService
{
    public function __construct(
        private readonly CustomerReviewRepositoryInterface $customerReviewRepository,
        private readonly FileManagerService  $fileManagerService,
        private readonly ImageRepositoryInterface $imageRepository,
    )
    {
    }

    public function index()
    {
        $customerReviews = $this->customerReviewRepository->getAllCustomerReviewsDashboard(10);
        return view('dashboard.site.customerReviews.index', compact('customerReviews'));
    }

    public function create()
    {
        return view('dashboard.site.customerReviews.create');
    }

    public function store($request)
    {
        try
        {
            DB::beginTransaction();
            $data = $request->except('image');
            $customerReview = $this->customerReviewRepository->create($data);
            $this->uploadImage($request->image, $customerReview);
            DB::commit();
            return redirect()->route('customer-reviews.index')->with(['success' => __('messages.created_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function uploadImage($image, $customerReview)
    {
        if ($image)
        {
            $newImage = $this->fileManagerService->handle("image", "customerReviews/images");
            $photo = $this->imageRepository->make(['path' => $newImage]);
            $customerReview->image()->save($photo);
        }
    }

    public function deleteImage($customerReview)
    {
        $customerReview->image()->delete();
    }
    public function show($id)
    {
        $customerReview = $this->customerReviewRepository->getById($id);
        return view('dashboard.site.customerReviews.show', compact('customerReview'));
    }
    public function edit($id)
    {
        $customerReview = $this->customerReviewRepository->getById($id);
        return view('dashboard.site.customerReviews.edit', compact('customerReview'));
    }

    public function update($request, $id)
    {
        try
        {
            DB::beginTransaction();
            $customerReview = $this->customerReviewRepository->getById($id);
            $data = $request->except('image');
            $this->customerReviewRepository->update($id, $data);
            if($request->image)
            {
                $this->deleteImage($customerReview);
                $this->uploadImage($request->image, $customerReview);
            }
            DB::commit();
            return redirect()->route('customer-reviews.index')->with(['success' => __('messages.updated_successfully')]);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }

    public function destroy($id)
    {
        try
        {
            $this->customerReviewRepository->delete($id);
            return redirect()->back()->with(['success' => __('messages.deleted_successfully')]);
        }
        catch (\Exception $e)
        {
            return back()->with(['error' => __('messages.Something went wrong')]);
        }
    }
}
