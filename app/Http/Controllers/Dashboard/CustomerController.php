<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPlotFile;
use App\Models\Payment;
use App\Models\ProjectPlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view customer');
        try {
            $customers = Customer::get();
            return view('dashboard.customers.index', compact('customers'));
        } catch (\Throwable $th) {
            Log::error('Customers Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create customer');
        try {
            $plots = ProjectPlot::with('project', 'extras')->where('status', 'unsold')->get();
            return view('dashboard.customers.create', compact('plots'));
        } catch (\Throwable $th) {
            Log::error('Customers Create Failed', ['error' => $th->getMessage()]);
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
        $this->authorize('create customer');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'father_husband_name' => 'required|string|max:255',
            'cnic' => 'required|string|max:255',
            'nominee' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'plot_id' => 'required|exists:project_plots,id',
            'file_no' => 'required_if:plot_id,exists:project_plots,id|string|max:255',
            'booked_by' => 'nullable|string|max:255',
            'total_cost' => 'required_if:plot_id,exists:project_plots,id|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'remaining_amount' => 'nullable|numeric|min:0',
            'booking_date' => 'required_if:plot_id,exists:project_plots,id|date',
        ]);

        if ($validator->fails()) {
            Log::error('Plot Validation Failed', ['errors' => $validator->errors()]);
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->father_husband_name = $request->father_husband_name;
            $customer->cnic = $request->cnic;
            $customer->nominee = $request->nominee;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();

            if($request->has('plot_id')) {
                $plot = ProjectPlot::find($request->plot_id);

                if(!$plot || $plot->status != 'unsold' || $plot->customerPlotFiles()->exists()) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Selected plot is not available for booking. Please choose another plot.');
                }

                $customerPlotFile = new CustomerPlotFile();
                $customerPlotFile->customer_id = $customer->id;
                $customerPlotFile->project_plot_id = $request->plot_id;
                $customerPlotFile->file_no = $request->file_no;
                $customerPlotFile->booked_by = $request->booked_by;
                $customerPlotFile->total_cost = $request->total_cost;
                $customerPlotFile->discount = $request->discount;
                $customerPlotFile->paid_amount = 0.00;
                $customerPlotFile->remaining_amount = $request->remaining_amount;
                $customerPlotFile->booking_date = $request->booking_date;
                $customerPlotFile->save();

                // Update plot status to sold
                $plot->status = 'sold';
                $plot->save();
            }

            DB::commit();
            return redirect()->route('dashboard.customers.index')->with('success', 'Customer Created Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Customer Store Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            // throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->authorize('view customer');
        try {
            $customer = Customer::where('id', $id)->first();
            return view('dashboard.customers.show', compact('customer'));
        } catch (\Throwable $th) {
            Log::error('Customer Show Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update customer');
        try {
            $customer = Customer::findOrFail($id);
            return view('dashboard.customers.edit', compact('customer'));
        } catch (\Throwable $th) {
            Log::error('Customer Edit Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update customer');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'father_husband_name' => 'required|string|max:255',
            'cnic' => 'required|string|max:255',
            'nominee' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $customer = Customer::findOrFail($id);
            $customer->name = $request->name;
            $customer->father_husband_name = $request->father_husband_name;
            $customer->cnic = $request->cnic;
            $customer->nominee = $request->nominee;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();
            return redirect()->route('dashboard.customers.index')->with('success', 'Customer Updated Successfully');
        } catch (\Throwable $th) {
            Log::error('Customer Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete customer');
        try {
            $customer = Customer::findOrFail($id);
            if($customer->customerPlotFiles()->exists()) {
                return redirect()->back()->with('error', 'Cannot delete customer with associated plot files. Please delete the plot files first.');
            }
            $customer->delete();
            return redirect()->back()->with('success', 'Customer Deleted Successfully');
        } catch (\Throwable $th) {
            Log::error('Customer Delete Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}
