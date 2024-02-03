<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackgroundRemoverController extends Controller
{
    public function removeBackground(Request $request)
    {
        try {
//            $request->validate([
//                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//            ]);

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();

            $uploadDirectory = public_path('uploads');
            $processedDirectory = public_path('processed');
            $pythonScriptPath = base_path('python_scripts/remove_background.py');

            if (!File::isDirectory($uploadDirectory)) {
                File::makeDirectory($uploadDirectory, 0777, true, true);
            }

            if (!File::isDirectory($processedDirectory)) {
                File::makeDirectory($processedDirectory, 0777, true, true);
            }

            // Move the uploaded file to the uploads directory
            $image->move($uploadDirectory, $imageName);

            // Define paths after moving the file
            $inputImagePath = "{$uploadDirectory}/{$imageName}";
            $outputImagePath = "{$processedDirectory}/{$imageName}";

            // Change the working directory to the directory containing your Python script
            chdir(base_path('python_scripts'));

            // Call Python script asynchronously using shell
            $command = "python.exe {$pythonScriptPath} {$inputImagePath} {$outputImagePath}";
            shell_exec($command);

            return response()->json(['message' => 'Image uploaded and processing started']);
        } catch (\Throwable $th) {
            dd(
                $th->getMessage(),
                $th->getLine(),
                $th->getFile()
            );
        }
    }
}
