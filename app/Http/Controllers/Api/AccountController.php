<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Models\PasswordResetCodeMail;

class AccountController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'TenKH' => 'required|string|max:50',
            'GioiTinh' => 'boolean',
            'SDT' => 'required|digits:10',
            'MatKhau' => 'required|string|min:6|confirmed',
            'Email' => 'required|email|max:100|unique:tbl_KhachHang,Email',
        ]);

        $customer = Customer::create([
            'TenKH' => $request->TenKH,
            'GioiTinh' => $request->GioiTinh ?? 1,
            'SDT' => $request->SDT,
            'MatKhau' => Hash::make($request->MatKhau),
            'TrangThai' => 1,
            'Email' => $request->Email,
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công!',
            'customer' => [
                'MaKH' => $customer->MaKH,
                'TenKH' => $customer->TenKH,
                'Email' => $customer->Email,
                'SDT' => $customer->SDT
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
            'MatKhau' => 'required|string',
        ]);

        $customer = Customer::where('Email', $request->Email)->first();

        if (!$customer || !Hash::check($request->MatKhau, $customer->MatKhau)) {
            return response()->json([
                'message' => 'Thông tin đăng nhập không chính xác.'
            ], 401);
        }

        if ($customer->TrangThai == 0) {
            return response()->json([
                'message' => 'Tài khoản đã bị khóa.'
            ], 403);
        }

        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'customer' => [
                'MaKH' => $customer->MaKH,
                'TenKH' => $customer->TenKH,
                'GioiTinh' => (bool) ($customer->GioiTinh ?? true),
                'Email' => $customer->Email,
                'SDT' => $customer->SDT
            ]
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'Email' => 'required|email'
        ]);

        $customer = Customer::where('Email', $request->Email)->first();

        if (!$customer) {
            return response()->json([
                'message' => 'Email không tồn tại'
            ],404);
        }

        $code = random_int(100000,999999);

        $cacheKey = 'password_reset_' . strtolower(trim($request->Email));

        Cache::put($cacheKey,$code,now()->addMinutes(10));

        Mail::to($customer->Email)->send(new PasswordResetCodeMail($code));

        return response()->json([
            'message' => 'Mã xác thực đã gửi vào email'
        ]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'Email' => 'required|email',
            'code' => 'required|digits:6',
            'MatKhau' => 'required|min:6|confirmed'
        ]);

        $customer = Customer::where('Email',$request->Email)->first();

        if(!$customer){
            return response()->json([
                'message'=>'Email không tồn tại'
            ],404);
        }

        $cacheKey = 'password_reset_' . strtolower(trim($request->Email));

        $savedCode = Cache::get($cacheKey);

        if(!$savedCode || $savedCode != $request->code){
            return response()->json([
                'message'=>'Mã xác thực không hợp lệ hoặc đã hết hạn'
            ],422);
        }

        $customer->update([
            'MatKhau'=>Hash::make($request->MatKhau)
        ]);

        Cache::forget($cacheKey);

        return response()->json([
            'message'=>'Đặt lại mật khẩu thành công'
        ]);
    }
}