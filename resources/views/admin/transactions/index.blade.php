@extends('layouts.app-admin')

@section('title', 'Kelola Transaksi')

@section('section')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Kelola Transaksi</h1>

        @if (isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $error }}
            </div>
        @endif

        <!-- Filter Status -->
        <div class="mb-6">
            <div class="flex space-x-4">
                <a href="{{ route('admin.transactions.index') }}"
                    class="px-4 py-2 {{ !request('status') ? 'bg-blue-200' : 'bg-gray-200' }} rounded-lg hover:bg-gray-300">
                    Semua ({{ $transactions ? $transactions->count() : 0 }})
                </a>
                <a href="{{ route('admin.transactions.index', ['status' => 'pending']) }}"
                    class="px-4 py-2 {{ request('status') == 'pending' ? 'bg-yellow-200' : 'bg-gray-200' }} rounded-lg hover:bg-yellow-300">
                    Pending ({{ $transactions ? $transactions->where('status', 'pending')->count() : 0 }})
                </a>
                <a href="{{ route('admin.transactions.index', ['status' => 'approved']) }}"
                    class="px-4 py-2 {{ request('status') == 'approved' ? 'bg-green-200' : 'bg-gray-200' }} rounded-lg hover:bg-green-300">
                    Approved ({{ $transactions ? $transactions->where('status', 'approved')->count() : 0 }})
                </a>
                <a href="{{ route('admin.transactions.index', ['status' => 'rejected']) }}"
                    class="px-4 py-2 {{ request('status') == 'rejected' ? 'bg-red-200' : 'bg-gray-200' }} rounded-lg hover:bg-red-300">
                    Rejected ({{ $transactions ? $transactions->where('status', 'rejected')->count() : 0 }})
                </a>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Frame
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Used/Download
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bukti Bayar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($transactions && $transactions->count() > 0)
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $transaction->order_id ?? 'N/A' }}
                                        @if ($transaction->status == 'approved' && isset($transaction->frame_id))
                                            <br>
                                            <a href="{{ route('booth', ['frame_id' => $transaction->frame_id, 'order_id' => $transaction->order_id]) }}"
                                                target="_blank" class="text-blue-600 hover:text-blue-900 text-xs">
                                                Lihat Link
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($transaction->frame)
                                            {{ $transaction->frame->name }}
                                        @else
                                            {{ 'Frame Deleted' }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction->email ?: 'Tidak ada' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if (method_exists($transaction, 'getFormattedAmountAttribute'))
                                            {{ $transaction->formatted_amount }}
                                        @else
                                            Rp {{ number_format($transaction->amount ?? 0, 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($transaction->status == 'pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($transaction->status == 'approved')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex flex-col space-y-1">
                                            <span
                                                class="px-2 py-1 text-xs {{ $transaction->is_used ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded">
                                                {{ $transaction->is_used ? 'Used' : 'Not Used' }}
                                            </span>
                                            <span
                                                class="px-2 py-1 text-xs {{ $transaction->is_download ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded">
                                                {{ $transaction->is_download ? 'Downloaded' : 'Not Downloaded' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($transaction->payment_proof)
                                            <button onclick="viewPaymentProof('{{ $transaction->payment_proof }}')"
                                                class="text-blue-600 hover:text-blue-900">
                                                Lihat Bukti
                                            </button>
                                        @else
                                            <span class="text-gray-400">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if ($transaction->status == 'pending')
                                            <div class="flex space-x-2">
                                                <button onclick="approveTransaction({{ $transaction->id }})"
                                                    class="text-green-600 hover:text-green-900">
                                                    Approve
                                                </button>
                                                <button onclick="rejectTransaction({{ $transaction->id }})"
                                                    class="text-red-600 hover:text-red-900">
                                                    Reject
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Belum ada transaksi
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Payment Proof Modal -->
    <div id="paymentProofModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-2xl mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Bukti Pembayaran</h3>
                <button onclick="closePaymentProofModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <img id="paymentProofImage" src="" alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg">
        </div>
    </div>

    <script>
        function viewPaymentProof(imagePath) {
            document.getElementById('paymentProofImage').src = '/storage/' + imagePath;
            document.getElementById('paymentProofModal').classList.remove('hidden');
            document.getElementById('paymentProofModal').classList.add('flex');
        }

        function closePaymentProofModal() {
            document.getElementById('paymentProofModal').classList.add('hidden');
            document.getElementById('paymentProofModal').classList.remove('flex');
        }

        async function approveTransaction(transactionId) {
            if (!confirm('Apakah Anda yakin ingin menyetujui transaksi ini?')) return;

            try {
                const response = await fetch(`/admin/transactions/${transactionId}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert('Transaksi berhasil disetujui!');
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
            }
        }

        async function rejectTransaction(transactionId) {
            if (!confirm('Apakah Anda yakin ingin menolak transaksi ini?')) return;

            try {
                const response = await fetch(`/admin/transactions/${transactionId}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    alert('Transaksi berhasil ditolak!');
                    location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan: ' + error.message);
            }
        }

        // Close modal when clicking outside
        document.getElementById('paymentProofModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePaymentProofModal();
            }
        });
    </script>
@endsection
