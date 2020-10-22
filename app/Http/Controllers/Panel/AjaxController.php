<?php

namespace App\Http\Controllers\Panel;

use App\Models\Spec;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Ramsey\Uuid\Uuid;

class AjaxController
{

    public function deleteRecord()
    {

        $type = request()->input('type');
        $id = request()->input('id');


        $orm = get_model_by_name($type);

        if (is_null($type) || is_null($type) || is_null($orm)) {
            return response()->json([
                'result'  => 'error',
                'message' => 'Gerekli parametreler eksik!',

            ]);
        }

        $record = $orm::find($id);
        $record->delete();

        return response()->json([
            'result'  => 'success',
            'message' => 'Kayit silindi!',
        ]);
    }

    public function updateStatus()
    {

        $type = request()->input('type');
        $id = request()->input('id');
        $status = request()->input('status') ?? 0;

        $orm = get_model_by_name($type);

        if (is_null($type) || is_null($type) || is_null($orm)) {
            return response()->json([
                'result'  => 'error',
                'message' => 'Gerekli parametreler eksik!',

            ]);
        }

        $record = $orm::find($id);
        $record->status = $status;
        $result = $record->save();


        return response()->json([
            'result'  => 'success',
            'message' => 'Kayit guncellendi!',
        ]);
    }

    public function uploadImage()
    {

        $file = request()->file('file');
        $type = request()->input('type');

        if (!in_array($type, ['spec', 'event', 'user', 'admin', 'other','center'])) {

            return response()->json([
                'result'  => 'error',
                'message' => 'Wrong type',
            ]);

        }


        $validator = \Validator::make(request()->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'result'  => 'error',
                'message' => $validator->errors(),
            ]);

        }

        $mime = strtolower($file->getMimeType());
        $size = $file->getSize();
        $extension = $file->getClientOriginalExtension();;

        if (in_array($mime, ['image/jpeg', 'image/jpg', 'image/png'])) {

            $new_name = Carbon::now()->format('Ymd_Hi_u') . '_' . ip2long(request()->ip()) . '.' . $extension;

            $destination_path = 'uploads/' . $type . '/' . $new_name;

            try {

                $image = Image::make($file);

                $image->resize(1920, 1920, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg', 80);

                Storage::disk('local')->put($destination_path, $image, 'public');

            } catch (\Exception $e) {

                return response()->json([
                    'meta' => [
                        'flag'    => 'error',
                        'message' => $e->getMessage()
                    ],
                ]);
            }

            $response = [
                'result'  => 'success',
                'message' => 'ok',
                'file'    => [
                    'name'             => $file->getClientOriginalName(),
                    'extension'        => $extension,
                    'size'             => $size,
                    'mime_type'        => $mime,
                    'destination_path' => $destination_path,
                    'new_name'         => $new_name,
                    'full_name'        => get_uploaded_file_url($destination_path),
                ],
            ];

            return response()->json($response);

        }

        return response()->json([
            'meta' => [
                'flag'    => 'error',
                'code'    => 400,
                'type'    => 'parameter_error',
                'message' => 'Invalid file type',

            ]
        ]);

    }

}
