<?php

namespace App\Http\Controllers\api\Admin;

use App\Models\Review;
use App\Models\Product;
use App\Models\ReviewReply;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ReviewResource;

class ReviewController extends Controller
{
    use ApiResponse;
    /*
        request:
        product_id
        rate  1|2|3|4|5|null(lấy hết)
    */
    public function index(Request $request)
    {
        $rate = $request->query('rate');
        $productId = $request->query('product_id');
        // dd($productItemId);
        $product = Product::query()->with('productItems')->where('id', $productId)->first();
        if (!$product) {
            return $this->error("Không tìm thấy sản phẩm", ['Sản phẩm không tồn tại'], 404);
        } else {

            $productItemId = $product->productItems->pluck('id')->toArray();
            if ((int) $rate == 1) {
                $query = Review::with(['productItem', 'reviewImages', 'user'])->whereIn('product_item_id', $productItemId)
                    ->where('rate', 1)
                    ->orderBy("created_at", "desc");
            } else if ((int) $rate == 2) {
                $query = Review::with(['productItem', 'reviewImages', 'user'])->whereIn('product_item_id', $productItemId)
                    ->where('rate', 2)
                    ->orderBy("created_at", "desc");
            } else if ((int) $rate == 3) {
                $query = Review::with(['productItem', 'reviewImages', 'user'])->whereIn('product_item_id', $productItemId)
                    ->where('rate', 3)
                    ->orderBy("created_at", "desc");
            } else if ((int) $rate == 4) {
                $query = Review::with(['productItem', 'reviewImages', 'user'])->whereIn('product_item_id', $productItemId)
                    ->where('rate', 4)
                    ->orderBy("created_at", "desc");
            } else if ((int) $rate == 5) {
                $query = Review::with(['productItem', 'reviewImages', 'user'])->whereIn('product_item_id', $productItemId)
                    ->where('rate', 5)
                    ->orderBy("created_at", "desc");
            } else {
                $query = Review::with(['productItem', 'reviewImages', 'user'])->whereIn('product_item_id', $productItemId)
                    ->orderBy("created_at", "desc");
            }
            $reviews = $query->paginate(10);

            return  ReviewResource::collection($reviews)->additional([
                'review_rate' =>  min(round($product->reviews()->withoutGlobalScopes()->avg('rate'), 0), 5),
                'total_review' => $product->reviews()->count(),
                'total_review_1' => $product->reviews()->where('rate', 1)->count(),
                'total_review_2' => $product->reviews()->where('rate', 2)->count(),
                'total_review_3' => $product->reviews()->where('rate', 3)->count(),
                'total_review_4' => $product->reviews()->where('rate', 4)->count(),
                'total_review_5' => $product->reviews()->where('rate', 5)->count(),
            ]);
        }
    }
    /*
    request:
        review_id
        is_active 0|1
    */
    # Ẩn đánh giá của client
    public function hidden(Request $request)
    {
        try {
            $review = Review::find($request->review_id);
            if (!$review) {
                return $this->error("Không tìm thấy đánh giá", ['review_id' => "Đánh giá không tồn tại"], 404);
            }
            $review->is_active = $request->is_active;
            $review->save();
            return $this->success("Đánh giá đã được ẩn thành công", new ReviewResource($review));
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }
}
