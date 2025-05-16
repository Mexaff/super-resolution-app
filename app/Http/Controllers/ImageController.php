<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function processImage(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'method' => 'required'
        ]);

        // Завантаження зображення
        $image = $request->file('image');
        $path = $image->store('uploads', 'public');

        $filename = $image->hashName();

        $imagePath = "D:/os/domains/super-resolution-app/public/storage/uploads/" . $filename;
        $outputPath = base_path('public/storage/uploads/results/' . $image->hashName());

        if($request['method'] == 'CNN') {
            $pythonScriptPath = base_path('scripts/CNN/super_resolve.py'); // шлях до скрипта
            $modelPath = "D:/os/domains/super-resolution-app/scripts/CNN/model_epoch_x4.pth";
            $command = escapeshellcmd("python $pythonScriptPath --input_image $imagePath --model $modelPath --output_filename $outputPath --cuda");
        } else {
            $pythonScriptPath = base_path('scripts/esrgan.py'); // шлях до скрипта
            $command = escapeshellcmd("python $pythonScriptPath --input_image $imagePath --output_filename $outputPath");
        }

        ini_set('max_execution_time', 3600); // 3600 seconds = 60 minutes
        set_time_limit(3600);

        $output = shell_exec($command);

        if (file_exists($outputPath)) {
            unlink(base_path('public/storage/uploads/') . $filename);
            return response()->download($outputPath)->deleteFileAfterSend();
        }

        return response()->json(['error' => 'Processing failed.'], 500);
    }
}
