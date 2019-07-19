<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileInputController extends Controller
{
    protected $types = [
        'image' => ['png', 'jpeg', 'gif'],
        'html' => [],
        'text' => ['txt'],
        'office' => ['docx', 'xlsx', 'xls'],
        'gdocs' => [],
        'video' => ['mp4'],
        'audio' => ['mp3'],
        'flash' => [],
        'object' => [],
        'pdf' => [],
        'other' => []
    ];

    public function upload(Request $request)
    {
        if (!$request->hasFile('files')) {
            return response()->json([]);
        }

        $path = $request->input('path', 'file-input/'.date('Y-m-d'));
        $preview = [];
        $config = [];
        $files = $request->file('files');
        if (!is_array($files)) {
            $files = [$files];
        }
        foreach ($files as $key=>$file) {
            $new_path = $file->store($path);
            $file_url = Storage::url($new_path);

            array_push($preview, $file_url);

            array_push($config, [
                'key' => $new_path,
                'caption' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'type' => $this->getTypes($file->extension()),
                'filetype' => $file->getMimeType(),
                'downloadUrl' => $file_url,
            ]);
        }
        $out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];

        return response()->json($out);
    }

    public function delete(Request $request)
    {
        Storage::delete($request->input('key'));
        return $this->success();
    }

    protected function getTypes($string)
    {
        foreach ($this->types as $key => $items) {
            if (in_array($string, $items)) {
                return $key;
            }
        }
        return 'object';
    }
}
