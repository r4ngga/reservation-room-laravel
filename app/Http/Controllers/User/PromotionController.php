<?php

namespace App\Http\Controllers\User;

use App\Log;
use App\Promotions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    /**
     * Display all available promotions for users
     */
    public function index()
    {
        $promotions = Promotions::where('status', 1)
            ->where('enable', 1)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.promotion.index', compact('promotions'));
    }

    /**
     * Show promotion purchase page
     */
    public function purchase($id)
    {
        $promotion = Promotions::findOrFail($id);
        $random_string = $this->generateRandomString(10);
        $set_value = Str::random(7);

        return view('client.promotion.purchase', compact('promotion', 'set_value', 'random_string'));
    }

    /**
     * Process promotion purchase
     */
    public function purchasePromotion(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'code_purchase' => 'required',
            'promotion_id' => 'required',
            'payment' => 'required|numeric',
        ]);

        // Insert purchase into promotion_purchases table
        DB::table('promotion_purchases')->insert([
            'code_purchase' => $request->code_purchase,
            'user_id' => $auth->id_user,
            'promotion_id' => $request->promotion_id,
            'payment' => $request->payment,
            'status_payment' => 'unpaid',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Create log
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'POST';
        $logs->description = 'purchase a promotion';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = '-';
        $logs->data_new = json_encode($request->all());
        $logs->save();

        return redirect()->route('client')->with('notify', 'Success! You have purchased a promotion. Please complete the payment.');
    }

    /**
     * Display unpaid promotion purchases
     */
    public function unpaidList()
    {
        $user = Auth::user();

        $purchases = DB::table('promotion_purchases')
            ->join('users', 'promotion_purchases.user_id', '=', 'users.id_user')
            ->join('promotions', 'promotion_purchases.promotion_id', '=', 'promotions.id')
            ->select('promotion_purchases.*', 'users.name', 'promotions.name as promotion_name', 'promotions.description')
            ->where('promotion_purchases.user_id', $user->id_user)
            ->where('promotion_purchases.status_payment', 'unpaid')
            ->orderBy('promotion_purchases.created_at', 'desc')
            ->get();

        return view('client.promotion.unpaid_list', compact('purchases'));
    }

    /**
     * Show payment page for promotion purchase
     */
    public function payment($id)
    {
        $user = Auth::user();

        $purchase = DB::table('promotion_purchases')
            ->join('users', 'promotion_purchases.user_id', '=', 'users.id_user')
            ->join('promotions', 'promotion_purchases.promotion_id', '=', 'promotions.id')
            ->select('promotion_purchases.*', 'users.name', 'users.email', 'promotions.name as promotion_name', 'promotions.description as promotion_description')
            ->where('promotion_purchases.id', $id)
            ->first();

        return view('client.promotion.payment', compact('purchase'));
    }

    /**
     * Process promotion payment confirmation
     */
    public function confirmPayment(Request $request)
    {
        $auth = Auth::user();
        $now = Carbon::now();

        $request->validate([
            'purchase_id' => 'required',
            'photo_transfer' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);

        $oldPurchase = DB::table('promotion_purchases')->where('id', $request->purchase_id)->first();

        if ($request->photo_transfer) {
            $imgName = $request->photo_transfer->getClientOriginalName() . '-' . time() . '.' . $request->photo_transfer->extension();
            $request->photo_transfer->move(public_path('images'), $imgName);
        }

        $check_img = isset($request->photo_transfer) ? $imgName : null;

        DB::table('promotion_purchases')->where('id', $request->purchase_id)->update([
            'status_payment' => 'paid',
            'photo_transfer' => $check_img,
            'updated_at' => $now,
        ]);

        // Create log
        $logs = new Log();
        $logs->user_id = $auth->id_user;
        $logs->action = 'PUT';
        $logs->description = 'confirm payment for promotion purchase';
        $logs->role = $auth->role;
        $logs->log_time = $now;
        $logs->data_old = json_encode($oldPurchase);
        $logs->data_new = json_encode(['status_payment' => 'paid']);
        $logs->save();

        return redirect()->route('client')->with('notify', 'Payment confirmed! Your promotion is now active.');
    }

    /**
     * Display promotion purchase history
     */
    public function history()
    {
        $auth = Auth::user();

        $purchases = DB::table('promotion_purchases')
            ->join('users', 'promotion_purchases.user_id', '=', 'users.id_user')
            ->join('promotions', 'promotion_purchases.promotion_id', '=', 'promotions.id')
            ->select('promotion_purchases.*', 'users.name', 'promotions.name as promotion_name', 'promotions.start_date', 'promotions.end_date')
            ->where('promotion_purchases.user_id', $auth->id_user)
            ->orderBy('promotion_purchases.created_at', 'desc')
            ->get();

        return view('client.promotion.history', compact('purchases'));
    }

    /**
     * Generate random string for purchase code
     */
    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
