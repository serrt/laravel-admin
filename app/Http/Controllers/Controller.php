<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function json($data, $code = Response::HTTP_OK, $message = '')
    {
        $result = ['data' => $data, 'code' => $code, 'message' => $message];
        return response()->json($result);
    }

    public function success($data = [], $message = '')
    {
        return $this->json($data, Response::HTTP_OK, $message);
    }

    public function error($message = '', $code = Response::HTTP_BAD_REQUEST)
    {
        return $this->json([], $code, $message);
    }
}
