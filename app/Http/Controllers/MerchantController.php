<?php

namespace App\Http\Controllers;

use App\Helpers\BaseResponse;
use App\Models\Merchant;
use Exception;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function show(Request $request)
    {
        try {
            $user = $request->user();
            $merchant = $user->merchant;

            return BaseResponse::success("Success retrieving merchant data", $merchant);
        } catch (Exception $error) {
            return BaseResponse::error("Error while retrieving merchant data", 500, $error->getMessage());
        }
    }

    public function verify(Request $request)
    {
        try {
            $user = $request->user();
            $merchant = Merchant::where("id_user", $user->id)->update([
                "applyForm" => "https://cdn.mfadlilhs.site/dpka/activities/banner/1732302890812-ASA.png",
                "ktp" => "https://cdn.mfadlilhs.site/dpka/activities/banner/1732302890812-ASA.png",
                "photo" => "https://cdn.mfadlilhs.site/dpka/activities/banner/1732302890812-ASA.png",
                "license" => "https://cdn.mfadlilhs.site/dpka/activities/banner/1732302890812-ASA.png",
                "npwp" => "https://cdn.mfadlilhs.site/dpka/activities/banner/1732302890812-ASA.png",
            ]);

            return BaseResponse::success("Success verify document", $merchant);
        } catch (Exception $error) {
            return BaseResponse::error("Error while verifying document", 500, $error->getMessage());
        }
    }
}
