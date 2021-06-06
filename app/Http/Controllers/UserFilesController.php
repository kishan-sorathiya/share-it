<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserFileUploadRequest;
use App\Models\UserFiles;
use Illuminate\Support\Facades\Storage;
use DataTables;

class UserFilesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('download','show');
        view()->share('title', 'File Upload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(request()->ajax()) {
            $userfiles = UserFiles::where('user_id', auth()->id())->orderBy('id','desc')->get();
            return Datatables::of($userfiles)
                ->editColumn('created_at', function ($userfiles) {
                    return date('d M, Y H:i A', strtotime($userfiles->created_at));
                })
                ->addColumn('action', function ($userfiles) {
                    $deleteurl = route('userfiles.destroy', [$userfiles->id]);
                    $shareurl = route('userfiles.show', [$userfiles->uuid]);
                    
                    return '<button class="btn btn-primary share" data-share-url="' . $shareurl . '"><i class="fa fa-share"></i></button>
                            <a class="btn btn-danger delete" href="' . $deleteurl . '"><i class="fa fa-trash-o"></i></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('userfiles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('userfiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFileUploadRequest $request)
    {
        if($request->hasFile('userfiles')) {
            $file = $request->file('userfiles');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $mime_type = $file->getClientMimeType();
            $size = $file->getSize();
            try{
                $path = Storage::disk('public')->put('userFiles', $file);
                auth()->user()->userFiles()->create([
                    'filename' => $filename,
                    'extension' => $extension,
                    'path' => $path,
                    'size' => $size,
                    'mime_type' => $mime_type,
                ]);
                return redirect()->route('userfiles.index')->with('success', trans('message.add'));
            }catch(\Exception $e){
                return redirect()->back()->with('error', trans('message.error'));
            }
        }
        return redirect()->back()->with('error', trans('message.file_notfound'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show(UserFiles $uuid)
    {
        if($uuid) {
            view()->share('title', 'Download File');
            return view('userfiles.download', compact('uuid'));
        }
        return redirect()->back()->with('error', trans('message.file_notfound'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userfile = UserFiles::where('id', $id)->first();
        if ($userfile) {
            \Storage::disk('public')->delete($userfile->path);
            $userfile->delete();   
            return redirect()->route('userfiles.index')->with('success', trans('message.delete'));
        }
        return redirect()->back()->with('error', trans('message.error'));
    }

    /**
     * Download the specified resource.
     *
     * @param UserFiles $uuid
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(UserFiles $uuid)
    {
        if($uuid) {
            $uuid->increment('download');
            
            return response()->download(public_path('uploads/'.$uuid->path), $uuid->file_name);
        }
        return redirect()->back()->with('error', trans('message.file_notfound'));
    }
}
