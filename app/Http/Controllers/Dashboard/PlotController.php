<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProjectPlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view plot');
        try {
            $plots = ProjectPlot::all();
            return view('dashboard.plots.index', compact('plots'));
        } catch (\Throwable $th) {
            Log::error('Plots Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create plot');
        try {
            return view('dashboard.plots.create');
        } catch (\Throwable $th) {
            Log::error('Plots Create Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create plot');
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'block' => 'required|string|max:255',
            'plot_no' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'category' => 'required|in:residential,commercial,industrial',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'extra' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }

        try {
            DB::beginTransaction();
            $plot = new ProjectPlot();
            $plot->project_id = $request->project_id;
            $plot->block = $request->block;
            $plot->plot_no = $request->plot_no;
            $plot->size = $request->size;
            $plot->category = $request->category;
            $plot->price = $request->price;
            $plot->description = $request->description;
            $plot->extra = json_encode($request->extra);

            if ($request->hasFile('image')) {
                $Image = $request->file('image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_image.' . $Image_ext;

                $Image_path = 'uploads/company/projects/plots';
                $Image->move(public_path($Image_path), $Image_name);
                $plot->image = $Image_path . "/" . $Image_name;
            }

            $plot->save();

            DB::commit();
            return redirect()->route('dashboard.plots.index')->with('success', 'Plot Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Plot Store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            // throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $this->authorize('view plot');
        try {
            $plot = ProjectPlot::where('slug', $slug)->first();
            return view('frontend.pages.plot-details', compact('plot'));
        } catch (\Throwable $th) {
            Log::error('Plot Show Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update plot');
        try {
            $plot = ProjectPlot::findOrFail($id);
            return view('dashboard.plots.edit', compact('plot'));
        } catch (\Throwable $th) {
            Log::error('Plot Edit Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('update plot');
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'block' => 'required|string|max:255',
            'plot_no' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'category' => 'required|in:residential,commercial,industrial',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'extra' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $plot = ProjectPlot::findOrFail($id);
            $plot->project_id = $request->project_id;
            $plot->block = $request->block;
            $plot->plot_no = $request->plot_no;
            $plot->size = $request->size;
            $plot->category = $request->category;
            $plot->price = $request->price;
            $plot->description = $request->description;
            $plot->extra = json_encode($request->extra);

            if ($request->hasFile('image')) {
                if (isset($plot->image) && File::exists(public_path($plot->image))) {
                    File::delete(public_path($plot->image));
                }
                $Image = $request->file('image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_image.' . $Image_ext;

                $Image_path = 'uploads/company/projects/plots';
                $Image->move(public_path($Image_path), $Image_name);
                $plot->image = $Image_path . "/" . $Image_name;
            }
            $plot->save();
            return redirect()->route('dashboard.plots.index')->with('success', 'Plot Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Plot Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete plot');
        try {
            $plot = ProjectPlot::findOrFail($id);
            if (isset($plot->image) && File::exists(public_path($plot->image))) {
                File::delete(public_path($plot->image));
            }
            $plot->delete();
            return redirect()->back()->with('success', 'Plot Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Plot Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
