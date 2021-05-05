<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\UserDocumentsReviewed;
use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use App\Notifications\UserDocumentsApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserDocumentsController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'review_status' => ['bail', 'required', 'string', 'in:approved,rejected'],
            'review_message' => ['bail', 'present', 'string', 'nullable'],
        ])->validate();

        $document = UserDocument::findOrFail($id);

        $document->update([
            'reviewed_by' => $request->user()->id,
            'review_status' => $request['review_status'],
            'review_message' => $request['review_message'],
            'reviewed_at' => now(),
        ]);

        UserDocumentsReviewed::dispatch($document);
    }
}
