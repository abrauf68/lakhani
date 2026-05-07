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
            'cheque_no'             => 'required_if:payment_method,cheque|string|max:50',
            'bank_name'             => 'required_if:payment_method,bank_transfer|string|max:50',
            'bank_branch'           => 'required_if:payment_method,bank_transfer|string|max:50',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
            $billing = Billing::lockForUpdate()->findOrFail($payment->billing_id);

            // 🔹 Reverse payment effect
            $billing->paid_amount -= $payment->amount;
            $billing->remaining_amount += $payment->amount;

            // 🔹 Fix negative issues
            if ($billing->paid_amount < 0) {
                $billing->paid_amount = 0;
            }

            if ($billing->remaining_amount < 0) {
                $billing->remaining_amount = 0;
            }

            // 🔹 Update status
            if ($billing->remaining_amount == 0 && $billing->paid_amount > 0) {
                $billing->status = 'paid';
            } elseif ($billing->paid_amount > 0) {
                $billing->status = 'partial';
            } else {
                $billing->status = 'unpaid';
            }

            $billing->save();

            // 🔹 Delete payment
            $payment->delete();

            $adminUsers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'super-admin']);
            })->get();

            app('notificationService')->notifyUsers(
                $adminUsers,
                'Payment of Rs. ' . $payment->amount . ' deleted for Bill #' . $billing->bill_no . ' by ' . auth()->user()->name,
                'payments',
                $payment->id
            );

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
}
