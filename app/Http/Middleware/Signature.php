<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Signature
{
    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.env') != 'production') {
            return $next($request);
        }
        // 得到 api-token
        $token = $request->hasHeader('api-token') ? $request->header('api-token') : $request->get('api-token');

        if (!$token) {
            return response()->json(['code' => 401, 'message' => '签名错误, 签名参数必填']);
        }

        $arr = explode('.', $token);
        if (count($arr) != 4) {
            return response()->json(['code' => 401, 'message' => '签名错误, 签名格式错误']);
        }

        list($access_key, $time, $str, $sign) = $arr;

        $roles = config('signature.roles');

        if (!isset($roles[$access_key])) {
            return response()->json(['code' => 401, 'message' => '签名错误, access_key 错误']);
        }

        $secret_key = $roles[$access_key]['secret_key'];

        $timeout = config('signature.timeout');
        if (time() - $time > $timeout) {
            return response()->json(['code' => 401, 'message' => '签名错误, 请求超时']);
        }

        if (strlen($str) != 6) {
            return response()->json(['code' => 401, 'message' => '签名错误, 字符串长度错误']);
        }

        if (!preg_match('/^\w+$/', $str)) {
            return response()->json(['code' => 401, 'message' => '签名错误, 字符串格式错误']);
        }

        $check_sign = $this->sign($str, $time, $secret_key);

        if ($sign != $check_sign) {
            return response()->json(['code' => 401, 'message' => '签名错误']);
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @param string  $role_name
     *
     * @return Request
     */
    public function bindParamsToRequest($request, string $role_name)
    {
        // 添加 role_name 到 $request 中
        if ($request->has('client_role')) {
            $request->offsetSet('_client_role', $request->get('client_role'));
        }
        $request->offsetSet('client_role', $role_name);

        return $request;
    }

    public function sign($str, $time, $secret_key)
    {
        return md5($str . '.' . $time .'.'.$secret_key);
    }

}
