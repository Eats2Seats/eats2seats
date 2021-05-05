<?php

namespace App\Http\Controllers\Web\Volunteer;

use App\Facades\FileName;
use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class UserDocumentController extends Controller
{
    public function __construct()
    {
        // Prevent users with approved documents from accessing these pages
        $this->middleware(function ($request, $next) {
            if ($request->user()->documents_approved_at) {
                return Redirect::route('volunteer.dashboard');
            }
           return $next($request);
        });

        // Prevent users without documents from accessing the index page
        $this->middleware(function ($request, $next) {
            if ($request->user()->documents()->count() === 0) {
                return Redirect::route('volunteer.user-documents.create');
            }
            return $next($request);
        })->only('index');

        // Prevent users with pending documents from accessing the create page
        $this->middleware(function ($request, $next) {
            if ($request->user()->documents()->latest()->first()?->review_status === 'pending') {
                return Redirect::route('volunteer.user-documents.index');
            }
            return $next($request);
        })->only('create');
    }

    public function index(Request $request)
    {
        $documents = $request
            ->user()
            ->documents()
            ->latest()
            ->get()
            ->transform(function ($submission) {
                return [
                    'id' => $submission->id,
                    'review_status' => $submission->review_status,
                    'review_message' => $submission->review_message,
                    'created_at' => Carbon::parse($submission->created_at)->isoFormat('MMM Do, h:mm a'),
                    'reviewed_at' => Carbon::parse($submission->reviewed_at)->isoFormat('MMM Do, h:mm a'),
                ];
            });

        return Inertia::render('Volunteer/UserDocument/Index', [
            'latest' => $documents->first(),
            'all' => $documents,
        ]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Volunteer/UserDocument/Create', [
            'is_previous' => $request->user()->documents()->count() > 0,
        ]);
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function store(Request $request)
    {
        if (Gate::denies('upload-user-documents')) {
            abort(403, 'You have already uploaded your legal documents. Please wait for them to be reviewed.');
        }

        Validator::make($request->all(), [
            'liability_file' => ['bail', 'required', 'file', 'mimes:pdf', 'max:1000'],
            'tax_file' => ['bail', 'required', 'file', 'mimes:pdf', 'max:1000']
        ])->validate();

        $liabilityPath = with($request->file('liability_file'), function (UploadedFile $file) {
            $name = FileName::generate($file);
            return $file->storeAs('user-documents', $name, [
                'disk' => 's3',
                'visibility' => 'private',
            ]);
        });

        $taxPath = with($request->file('tax_file'), function (UploadedFile $file) {
            $name = FileName::generate($file);
            return $file->storeAs('user-documents', $name, [
                'disk' => 's3',
                'visibility' => 'private',
            ]);
        });

        try {
            UserDocument::create([
                'user_id' => $request->user()->id,
                'liability_file_name' => basename($liabilityPath),
                'liability_file_url' => Storage::disk('s3')->url($liabilityPath),
                'tax_file_name' => basename($taxPath),
                'tax_file_url' => Storage::disk('s3')->url($taxPath),
                'reviewed_by' => null,
                'review_status' => 'pending',
                'review_message' => null,
                'reviewed_at' => null,
            ]);
        }
        catch (Exception $e) {
            Storage::disk('s3')
                ->delete([
                    $liabilityPath,
                    $taxPath,
                ]);

            throw $e;
        }

        return redirect(route('volunteer.user-documents.index'));
    }
}
