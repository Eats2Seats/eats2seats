<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\UserDocumentsReviewed;
use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use App\Notifications\UserDocumentsApprovedNotification;
use App\Queries\Admin\UserDocumentsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class UserDocumentsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Admin/UserDocument/Index', [
            'user_documents' => UserDocumentsTable::generateResponse('documents', 15, $request->toArray())
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'review_status' => ['bail', 'required', 'string', 'in:approved,rejected'],
            'review_message' => ['bail', 'required_if:review_status,rejected', 'string', 'nullable'],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        $document = UserDocument::findOrFail($id);

        $document->update([
            'reviewed_by' => $request->user()->id,
            'review_status' => $request['review_status'],
            'review_message' => $request['review_message'],
            'reviewed_at' => now(),
        ]);

        UserDocumentsReviewed::dispatch($document);

       return back();
    }
}
