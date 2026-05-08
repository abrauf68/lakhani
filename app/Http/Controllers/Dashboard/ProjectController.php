<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view project');
        try {
            $projects = Project::all();
            return view('dashboard.projects.index', compact('projects'));
        } catch (\Throwable $th) {
            Log::error('Projects Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create project');
        try {
            return view('dashboard.projects.create');
        } catch (\Throwable $th) {
            Log::error('Projects Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create project');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
            'water_mark_image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $project = new Project();
            $project->name = $request->name;
            $project->slug = Str::slug($request->name) . '-' . time();
            $project->description = $request->description;
            $project->country = 'Pakistan';
            $project->address = $request->address;

            if ($request->hasFile('main_image')) {
                $Image = $request->file('main_image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_main_image.' . $Image_ext;

                $Image_path = 'uploads/company/projects';
                $Image->move(public_path($Image_path), $Image_name);
                $project->main_image = $Image_path . "/" . $Image_name;
            }

            if ($request->hasFile('water_mark_image')) {
                $Image = $request->file('water_mark_image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_water_mark_image.' . $Image_ext;

                $Image_path = 'uploads/company/projects';
                $Image->move(public_path($Image_path), $Image_name);
                $project->water_mark_image = $Image_path . "/" . $Image_name;
            }

            $project->save();

            DB::commit();
            return redirect()->route('dashboard.projects.index')->with('success', 'Project Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Project Store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $this->authorize('view project');
        try {
            $project = Project::where('slug', $slug)->first();
            return view('frontend.pages.property-details', compact('project'));
        } catch (\Throwable $th) {
            Log::error('Project Show Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update project');
        try {
            $project = Project::findOrFail($id);
            return view('dashboard.projects.edit', compact('project'));
        } catch (\Throwable $th) {
            Log::error('Project Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $this->authorize('update project');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
            'water_mark_image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $project = Project::findOrFail($id);
            $project->name = $request->name;
            $project->slug = Str::slug($request->name) . '-' . time();
            $project->description = $request->description;
            $project->address = $request->address;

            if ($request->hasFile('main_image')) {
                if (isset($project->main_image) && File::exists(public_path($project->main_image))) {
                    File::delete(public_path($project->main_image));
                }
                $Image = $request->file('main_image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_main_image.' . $Image_ext;

                $Image_path = 'uploads/company/projects';
                $Image->move(public_path($Image_path), $Image_name);
                $project->main_image = $Image_path . "/" . $Image_name;
            }

            if ($request->hasFile('water_mark_image')) {
                if (isset($project->water_mark_image) && File::exists(public_path($project->water_mark_image))) {
                    File::delete(public_path($project->water_mark_image));
                }
                $Image = $request->file('water_mark_image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_water_mark_image.' . $Image_ext;

                $Image_path = 'uploads/company/projects';
                $Image->move(public_path($Image_path), $Image_name);
                $project->water_mark_image = $Image_path . "/" . $Image_name;
            }
            $project->save();
            return redirect()->route('dashboard.projects.index')->with('success', 'Project Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Project Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete project');
        try {
            $project = Project::findOrFail($id);
            if($project->plots()->exists()) {
                return redirect()->back()->with('error', "Project can't be deleted because it has associated plots");
            }
            if (isset($project->main_image) && File::exists(public_path($project->main_image))) {
                File::delete(public_path($project->main_image));
            }
            $project->delete();
            return redirect()->back()->with('success', 'Project Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Project Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function updateStatus(string $id)
    {
        $this->authorize('update project');
        try {
            $project = Project::findOrFail($id);
            $message = $project->is_active == 'active' ? 'Project Deactivated Successfully' : 'Project Activated Successfully';
            if ($project->is_active == 'active') {
                $project->is_active = 'inactive';
                $project->save();
            } else {
                $project->is_active = 'active';
                $project->save();
            }
            return redirect()->back()->with('success', $message);
        } catch (\Throwable $th) {
            Log::error('Project Status Updation Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            // throw $th;
        }
    }
}
