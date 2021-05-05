<?php

namespace App\Http\Controllers\Web\Volunteer;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadUserDocument extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param $id
     * @param $file
     * @return StreamedResponse
     */
    public function __invoke(Request $request, $id, $file): StreamedResponse
    {
        $document = UserDocument::findOrFail($id);
        if ($file === 'liability') {
            return Storage::disk('s3')
                ->download("user-documents/{$document->liability_file_name}", "liability waiver {$document->created_at}");
        }
        if ($file === 'tax') {
            return Storage::disk('s3')
                ->download("user-documents/{$document->tax_file_name}", "W-9 tax form-{$document->created_at}");
        }
        abort(404);
    }
}
