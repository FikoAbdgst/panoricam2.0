<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Transaction;
use App\Models\Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        if (Session::has('admin_id')) {
            return redirect('/admin/dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('admin_id', $admin->id);
            Session::put('admin_name', $admin->name);
            Session::put('admin_email', $admin->email);
            return redirect('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout()
    {
        Session::forget(['admin_id', 'admin_name', 'admin_email']);
        return redirect('/admin/login');
    }

    public static function checkAdminLogin()
    {
        return Session::has('admin_id');
    }

    public function transactions(Request $request)
    {
        try {
            $query = Transaction::with('frame');

            // Filter by status
            if ($request->has('status') && $request->status !== 'all' && $request->status !== null) {
                $query->where('status', $request->status);
            }

            $transactions = $query->orderBy('created_at', 'desc')->get();
            return view('admin.transactions.index', compact('transactions'));
        } catch (\Exception $e) {
            Log::error('Error in transactions method: ' . $e->getMessage());
            $transactions = collect();
            return view('admin.transactions.index', compact('transactions'))->with('error', 'An error occurred');
        }
    }

    // Simplified method untuk approve transaction dengan email
    public function approveTransaction($id)
    {
        try {
            $transaction = Transaction::with('frame')->findOrFail($id);

            if ($transaction->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi ini sudah diproses sebelumnya.'
                ], 400);
            }

            // Update status transaksi
            $transaction->update([
                'status' => 'approved',
                'approved_at' => now()
            ]);

            // Kirim email jika ada email
            $emailSent = false;
            if ($transaction->email) {
                $emailSent = $this->sendEmail($transaction);
            }

            $message = 'Transaksi berhasil disetujui.';
            if ($transaction->email) {
                $message .= $emailSent ? ' Email konfirmasi telah dikirim.' : ' Namun gagal mengirim email.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'email_sent' => $emailSent
            ]);
        } catch (\Exception $e) {
            Log::error('Error approving transaction: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses transaksi.'
            ], 500);
        }
    }

    // Simplified email method
    private function sendEmail($transaction)
    {
        try {
            // Generate booth link
            $boothLink = route('booth', [
                'frame_id' => $transaction->frame_id,
                'order_id' => $transaction->order_id
            ]);

            $frameName = $transaction->frame ? $transaction->frame->name : 'Frame tidak tersedia';
            $amount = $transaction->formatted_amount ?? 'Rp ' . number_format($transaction->amount, 0, ',', '.');

            // Simple HTML email content
            $htmlContent = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <div style='background: #4CAF50; color: white; padding: 20px; text-align: center;'>
                    <h1>Pembayaran Disetujui!</h1>
                </div>
                <div style='padding: 20px; background: #f9f9f9;'>
                    <h2>Halo!</h2>
                    <p>Pembayaran Anda telah diverifikasi dan disetujui.</p>
                    
                    <h3>Detail Transaksi:</h3>
                    <p><strong>Order ID:</strong> {$transaction->order_id}</p>
                    <p><strong>Frame:</strong> {$frameName}</p>
                    <p><strong>Amount:</strong> {$amount}</p>
                    <p><strong>Status:</strong> Approved</p>
                    
                    <p>Akses photo booth Anda:</p>
                    <p style='text-align: center; margin: 20px 0;'>
                        <a href='{$boothLink}' style='background: #4CAF50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                            Akses Photo Booth
                        </a>
                    </p>
                    
                    <p>Link langsung: <a href='{$boothLink}'>{$boothLink}</a></p>
                  ngrok  <p><em>Simpan link ini untuk mengakses photo booth Anda.</em></p>
                </div>
                <div style='text-align: center; padding: 20px; color: #666; font-size: 12px;'>
                    Email otomatis, jangan balas.
                </div>
            </div>";

            // Send email using Mail::html (Laravel's simplest method)
            Mail::html($htmlContent, function ($message) use ($transaction) {
                $message->to($transaction->email)
                    ->subject('Pembayaran Disetujui - Order #' . $transaction->order_id);
            });

            Log::info('Email sent successfully to: ' . $transaction->email);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
            return false;
        }
    }

public function rejectTransaction($id)
{
    try {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi ini sudah diproses sebelumnya.'
            ], 400);
        }

        $transaction->update(['status' => 'rejected']);

        // Kirim email notifikasi jika ada email
        $emailSent = false;
        if ($transaction->email) {
            $emailSent = $this->sendRejectionEmail($transaction);
        }

        $message = 'Transaksi berhasil ditolak.';
        if ($transaction->email) {
            $message .= $emailSent ? ' Email pemberitahuan telah dikirim.' : ' Namun gagal mengirim email pemberitahuan.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'email_sent' => $emailSent
        ]);
    } catch (\Exception $e) {
        Log::error('Error rejecting transaction: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat memproses transaksi.'
        ], 500);
    }
}

private function sendRejectionEmail($transaction)
{
    try {
        // Generate booth link (meskipun transaksi ditolak, link bisa tetap disertakan untuk referensi)
        $boothLink = route('booth', [
            'frame_id' => $transaction->frame_id,
            'order_id' => $transaction->order_id
        ]);

        $frameName = $transaction->frame ? $transaction->frame->name : 'Frame tidak tersedia';
        $amount = $transaction->formatted_amount ?? 'Rp ' . number_format($transaction->amount, 0, ',', '.');

        // HTML email content untuk transaksi ditolak
        $htmlContent = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background: #f44336; color: white; padding: 20px; text-align: center;'>
                <h1>Transaksi Ditolak</h1>
            </div>
            <div style='padding: 20px; background: #f9f9f9;'>
                <h2>Halo!</h2>
                <p>Kami informasikan bahwa pembayaran Anda untuk transaksi berikut telah ditolak.</p>
                
                <h3>Detail Transaksi:</h3>
                <p><strong>Order ID:</strong> {$transaction->order_id}</p>
                <p><strong>Frame:</strong> {$frameName}</p>
                <p><strong>Amount:</strong> {$amount}</p>
                <p><strong>Status:</strong> Rejected</p>
                
                <p>Alasan penolakan mungkin karena kesalahan pembayaran atau verifikasi. Silakan hubungi dukungan pelanggan untuk informasi lebih lanjut.</p>
                
                <p style='text-align: center; margin: 20px 0;'>
                    <a href='mailto:panoricam5@gmail.com' style='background: #f44336; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                        Hubungi Dukungan
                    </a>
                </p>
                
                <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
            </div>
            <div style='text-align: center; padding: 20px; color: #666; font-size: 12px;'>
                Email otomatis, jangan balas.
            </div>
        </div>";

        // Send email using Mail::html
        Mail::html($htmlContent, function ($message) use ($transaction) {
            $message->to($transaction->email)
                ->subject('Transaksi Ditolak - Order #' . $transaction->order_id);
        });

        Log::info('Email rejection sent successfully to: ' . $transaction->email);
        return true;
    } catch (\Exception $e) {
        Log::error('Failed to send rejection email: ' . $e->getMessage());
        return false;
    }
}
}
