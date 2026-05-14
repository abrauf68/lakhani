<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PlotExtra;
use App\Models\ProjectPlot;
use App\Models\Project;
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
            $plots = ProjectPlot::with('project')->get();
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
            $projects = Project::where('is_active', 'active')->get();
            return view('dashboard.plots.create', compact('projects'));
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
        // dd($request->all());
        $this->authorize('create plot');
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'block' => 'required|string|max:255',
            'plot_no' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'category' => 'required|in:residential,commercial,industrial',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            // 'extra' => 'nullable|array',
            // 'extra.*' => 'string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
            'has_extras' => 'nullable|boolean',
            'extra_key' => 'nullable|array',
            'extra_key.*' => 'nullable|string|max:255',
            'extra_value' => 'nullable|array',
            'extra_value.*' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('Plot Validation Failed', ['errors' => $validator->errors()]);
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', $validator->errors()->first());
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
            if ($request->has('has_extras') && $request->has('extra_key') && !empty($request->extra_key)) {
                $extras = [];
                foreach ($request->extra_key as $index => $key) {
                    if (!empty($key)) {
                        $extras[] = [
                            'key' => $key,
                            'value' => $request->extra_value[$index] ?? null
                        ];
                    }
                }
                $plot->extra = json_encode($extras);
            } else {
                $plot->extra = null;
            }

            if ($request->hasFile('image')) {
                $Image = $request->file('image');
                $Image_ext = $Image->getClientOriginalExtension();
                $Image_name = time() . '_image.' . $Image_ext;

                $Image_path = 'uploads/company/projects/plots';
                $Image->move(public_path($Image_path), $Image_name);
                $plot->image = $Image_path . "/" . $Image_name;
            }

            $plot->save();

            // Save extras to the plot_extras table
            if ($request->has('has_extras') && $request->has('extra_key') && !empty($request->extra_key)) {
                PlotExtra::where('project_plot_id', $plot->id)->delete();

                foreach ($request->extra_key as $index => $key) {
                    if (!empty($key)) {
                        PlotExtra::create([
                            'project_plot_id' => $plot->id,
                            'key' => $key,
                            'value' => $request->extra_value[$index] ?? null,
                        ]);
                    }
                }
            }

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
            $plot = ProjectPlot::with('extras')->findOrFail($id);
            $projects = Project::where('is_active', 'active')->get();
            return view('dashboard.plots.edit', compact('plot', 'projects'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max_size',
            'has_extras' => 'nullable|boolean',
            'extra_key' => 'nullable|array',
            'extra_key.*' => 'nullable|string|max:255',
            'extra_value' => 'nullable|array',
            'extra_value.*' => 'nullable|string|max:255',
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
            if ($request->has('has_extras') && $request->has('extra_key') && !empty($request->extra_key)) {
                $extras = [];
                foreach ($request->extra_key as $index => $key) {
                    if (!empty($key)) {
                        $extras[] = [
                            'key' => $key,
                            'value' => $request->extra_value[$index] ?? null
                        ];
                    }
                }
                $plot->extra = json_encode($extras);
            } else {
                $plot->extra = null;
            }

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


            PlotExtra::where('project_plot_id', $plot->id)->delete();

            // Add new extras only if checkbox is checked
            if ($request->has('has_extras') && $request->has('extra_key') && !empty($request->extra_key)) {
                foreach ($request->extra_key as $index => $key) {
                    if (!empty($key)) {
                        PlotExtra::create([
                            'project_plot_id' => $plot->id,
                            'key' => $key,
                            'value' => $request->extra_value[$index] ?? null,
                        ]);
                    }
                }
            }
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
            if($plot->customerPlotFiles()->exists()) {
                return redirect()->back()->with('error', 'Cannot delete plot with associated customers. Please delete the customers first.');
            }
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
