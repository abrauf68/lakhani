<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CustomerPlotFile;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view payment');
        try {
            $payments = Payment::withRelations()->latestPayments()->get();
            return view('dashboard.payments.index', compact('payments'));
        } catch (\Throwable $th) {
            Log::error("Payment Index Failed:" . $th->getMessage());
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create payment');
        try {
            $customerPlotFiles = CustomerPlotFile::forPaymentCreation()->get();
            // dd($customerPlotFiles);
            return view('dashboard.payments.create', compact('customerPlotFiles'));
        } catch (\Throwable $th) {
            Log::error("Payment Create Failed:" . $th->getMessage());
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->authorize('create payment');

        $validator = Validator::make($request->all(), [
            'customer_plot_file_id' => 'required|exists:customer_plot_files,id',
            'amount'                => 'required|numeric|min:0.01',
            'ref_no'                => 'required|string|max:255',
            'received_by'           => 'required|string|max:255',
            'payment_date'          => 'required|date',
            'payment_method'        => 'required|in:cash,cheque,bank_transfer',
            'cheque_no'             => 'required_if:payment_method,cheque|nullable|string|max:50',
            'bank_name'             => 'required_if:payment_method,bank_transfer|nullable|string|max:50',
            'bank_branch'           => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

            $customerPlotFile = CustomerPlotFile::lockForUpdate()->findOrFail($request->customer_plot_file_id);

            if ($customerPlotFile->status === 'paid') {
                return back()->with('error', 'This customer plot file is already fully paid.');
            }

            if ($request->amount > $customerPlotFile->remaining_amount) {
                return back()->with('error', 'Amount cannot exceed remaining amount.');
            }

            $payment = new Payment();
            $payment->customer_plot_file_id = $customerPlotFile->id;
            $payment->amount = $request->amount;
            $payment->ref_no = $request->ref_no;
            $payment->received_by = $request->received_by;
            $payment->payment_date = $request->payment_date;
            $payment->payment_method = $request->payment_method;
            $payment->bank_name = $request->bank_name ?? null;
            $payment->bank_branch = $request->bank_branch ?? null;
            $payment->cheque_no = $request->cheque_no ?? null;
            $payment->save();

            // $adminUsers = User::whereHas('roles', function ($query) {
            //     $query->whereIn('name', ['admin', 'super-admin']);
            // })->get();
            // app('notificationService')->notifyUsers(
            //     $adminUsers,
            //     'New payment of Rs. ' . $payment->amount . ' received for File #' . $customerPlotFile->file_no . ' by ' . auth()->user()->name,
            //     'payments',
            //     $payment->id
            // );

            $customerPlotFile->paid_amount += $request->amount;
            $customerPlotFile->remaining_amount -= $request->amount;

            $customerPlotFile->remaining_amount = round($customerPlotFile->remaining_amount, 2);

            if ($customerPlotFile->remaining_amount <= 0) {
                $customerPlotFile->remaining_amount = 0;
                $customerPlotFile->payment_status = 'paid';

                // app('notificationService')->notifyUsers(
                //     $adminUsers,
                //     'File #' . $customerPlotFile->file_no . ' has been fully paid by ' . auth()->user()->name,
                //     'customer_plot_files',
                //     $customerPlotFile->id
                // );
            } elseif ($customerPlotFile->paid_amount > 0) {
                $customerPlotFile->payment_status = 'partial';
            } else {
                $customerPlotFile->payment_status = 'unpaid';
            }

            $customerPlotFile->save();

            DB::commit();

            return redirect()
                ->route('dashboard.payments.index')
                ->with('success', 'Payment added successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Payment Store Failed', [
                'error' => $th->getMessage()
            ]);

            return back()->with('error', 'Something went wrong! Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('view payment');
        try {
            $payment = Payment::with('customerPlotFile.customer', 'customerPlotFile.projectPlot')->findOrFail($id);

            return view('dashboard.payments.show', compact(
                'payment'
            ));
        } catch (\Throwable $th) {
            Log::error("Payment Show Failed:" . $th->getMessage());
            return redirect()->back()->with(
                'error',
                "Something went wrong! Please try again later"
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('update payment');

        try {

            $payment = Payment::findOrFail($id);

            $customerPlotFiles = CustomerPlotFile::forPaymentCreation()->get();

            $customerPlotFile = CustomerPlotFile::find($payment->customer_plot_file_id);

            // Append current customer plot file if not exists
            if ($customerPlotFile && !$customerPlotFiles->contains('id', $customerPlotFile->id)) {
                $customerPlotFiles->push($customerPlotFile);
            }

            return view('dashboard.payments.edit', compact(
                'customerPlotFiles',
                'payment'
            ));
        } catch (\Throwable $th) {

            Log::error("Payment Edit Failed:" . $th->getMessage());

            return redirect()->back()->with(
                'error',
                "Something went wrong! Please try again later"
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('update payment');

        $validator = Validator::make($request->all(), [
            'customer_plot_file_id' => 'required|exists:customer_plot_files,id',
            'amount'                => 'required|numeric|min:0.01',
            'ref_no'                => 'required|string|max:255',
            'received_by'           => 'required|string|max:255',
            'payment_date'          => 'required|date',
            'payment_method'        => 'required|in:cash,cheque,bank_transfer',
            'cheque_no'             => 'required_if:payment_method,cheque|nullable|string|max:50',
            'bank_name'             => 'required_if:payment_method,bank_transfer|nullable|string|max:50',
            'bank_branch'           => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $validator->errors()->first());
        }

        try {

            DB::beginTransaction();

            $payment = Payment::lockForUpdate()->findOrFail($id);

            $oldCustomerPlotFile = CustomerPlotFile::lockForUpdate()
                ->findOrFail($payment->customer_plot_file_id);

            $newCustomerPlotFile = CustomerPlotFile::lockForUpdate()
                ->findOrFail($request->customer_plot_file_id);

            /*
            |--------------------------------------------------------------------------
            | Revert Old Payment Effect
            |--------------------------------------------------------------------------
            */

            $oldCustomerPlotFile->paid_amount -= $payment->amount;
            $oldCustomerPlotFile->remaining_amount += $payment->amount;

            $oldCustomerPlotFile->paid_amount = round($oldCustomerPlotFile->paid_amount, 2);
            $oldCustomerPlotFile->remaining_amount = round($oldCustomerPlotFile->remaining_amount, 2);

            /*
            |--------------------------------------------------------------------------
            | Validate New Amount
            |--------------------------------------------------------------------------
            */

            if ($request->amount > $newCustomerPlotFile->remaining_amount) {

                // If same file then allow old payment amount
                if ($oldCustomerPlotFile->id == $newCustomerPlotFile->id) {

                    $allowedAmount = $newCustomerPlotFile->remaining_amount + $payment->amount;

                    if ($request->amount > $allowedAmount) {
                        return back()->with(
                            'error',
                            'Amount cannot exceed remaining amount.'
                        );
                    }

                } else {

                    return back()->with(
                        'error',
                        'Amount cannot exceed remaining amount.'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Apply New Payment Effect
            |--------------------------------------------------------------------------
            */

            $newCustomerPlotFile->paid_amount += $request->amount;
            $newCustomerPlotFile->remaining_amount -= $request->amount;

            $newCustomerPlotFile->paid_amount = round($newCustomerPlotFile->paid_amount, 2);
            $newCustomerPlotFile->remaining_amount = round($newCustomerPlotFile->remaining_amount, 2);

            /*
            |--------------------------------------------------------------------------
            | Update Payment Statuses
            |--------------------------------------------------------------------------
            */

            foreach ([$oldCustomerPlotFile, $newCustomerPlotFile] as $file) {

                if ($file->remaining_amount <= 0) {

                    $file->remaining_amount = 0;
                    $file->payment_status = 'paid';

                } elseif ($file->paid_amount > 0) {

                    $file->payment_status = 'partial';

                } else {

                    $file->payment_status = 'unpaid';
                }

                $file->save();
            }

            /*
            |--------------------------------------------------------------------------
            | Update Payment
            |--------------------------------------------------------------------------
            */

            $payment->customer_plot_file_id = $request->customer_plot_file_id;
            $payment->amount = $request->amount;
            $payment->ref_no = $request->ref_no;
            $payment->received_by = $request->received_by;
            $payment->payment_date = $request->payment_date;
            $payment->payment_method = $request->payment_method;
            $payment->bank_name = $request->bank_name ?? null;
            $payment->bank_branch = $request->bank_branch ?? null;
            $payment->cheque_no = $request->cheque_no ?? null;

            $payment->save();

            DB::commit();

            return redirect()
                ->route('dashboard.payments.index')
                ->with('success', 'Payment updated successfully');

        } catch (\Throwable $th) {

            DB::rollBack();

            Log::error('Payment Update Failed', [
                'error' => $th->getMessage()
            ]);

            return back()->with(
                'error',
                'Something went wrong! Please try again.'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('delete payment');

        try {
            DB::beginTransaction();

            $payment = Payment::findOrFail($id);

            // 🔹 Get related billing
            $customerPlotFile = CustomerPlotFile::lockForUpdate()
                ->findOrFail($payment->customer_plot_file_id);

            // 🔹 Reverse payment effect
            $customerPlotFile->paid_amount -= $payment->amount;
            $customerPlotFile->remaining_amount += $payment->amount;

            // 🔹 Fix negative issues
            if ($customerPlotFile->paid_amount < 0) {
                $customerPlotFile->paid_amount = 0;
            }

            if ($customerPlotFile->remaining_amount < 0) {
                $customerPlotFile->remaining_amount = 0;
            }

            // 🔹 Update status
            if ($customerPlotFile->remaining_amount == 0 && $customerPlotFile->paid_amount > 0) {
                $customerPlotFile->status = 'paid';
            } elseif ($customerPlotFile->paid_amount > 0) {
                $customerPlotFile->status = 'partial';
            } else {
                $customerPlotFile->status = 'unpaid';
            }

            $customerPlotFile->save();

            // 🔹 Delete payment
            $payment->delete();

            // $adminUsers = User::whereHas('roles', function ($query) {
            //     $query->whereIn('name', ['admin', 'super-admin']);
            // })->get();

            // app('notificationService')->notifyUsers(
            //     $adminUsers,
            //     'Payment of Rs. ' . $payment->amount . ' deleted for File #' . $customerPlotFile->file_no . ' by ' . auth()->user()->name,
            //     'payments',
            //     $payment->id
            // );

            DB::commit();

            return redirect()
                ->route('dashboard.payments.index')
                ->with('success', 'Payment Deleted Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error("Payment Delete Failed: " . $th->getMessage());

            return redirect()->back()
                ->with('error', "Something went wrong! Please try again later");
        }
    }


    public function verifyPayment($id)
    {
        try {
            // Use eager loading to reduce database queries
            $payment = Payment::with([
                'customerPlotFile.customer',
                'customerPlotFile.projectPlot.project'
            ])->findOrFail($id);

            $customerPlotFile = $payment->customerPlotFile;
            $customer = $customerPlotFile->customer;
            $plot = $customerPlotFile->projectPlot;
            $project = $plot->project;

            // Calculate financials if not stored
            $totalCost = $customerPlotFile->total_cost;
            $discount = $customerPlotFile->discount;
            $paidAmount = $customerPlotFile->paid_amount;
            $balanceDue = $customerPlotFile->remaining_amount;

            // Get all payments for transaction history
            $payments = Payment::where('customer_plot_file_id', $customerPlotFile->id)
                ->orderBy('payment_date', 'desc')
                ->get();

            return view('frontend.invoice', compact(
                'payment',
                'customerPlotFile',
                'customer',
                'plot',
                'project',
                'totalCost',
                'discount',
                'paidAmount',
                'balanceDue',
                'payments'
            ));

        } catch (\Throwable $th) {
            Log::error("Payment Verification Failed: " . $th->getMessage());
            return redirect()->back()
                ->with('error', "Something went wrong! Please try again later");
        }
    }
}
