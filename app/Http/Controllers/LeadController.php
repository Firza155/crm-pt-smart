<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller untuk manajemen Lead oleh Sales
class LeadController extends Controller
{
    //Menampilkan daftar lead milik sales yang login
    public function index()
    {
        $leads = Lead::where('created_by', Auth::id())
            ->latest()
            ->get();

        return response()->json($leads);
    }

    //Form create (sementara dummy)
    public function create()
    {
        return response()->json([
            'message' => 'Form create lead (frontend belum dibuat)'
        ]);
    }

    //Menyimpan lead baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        // Simpan lead milik sales yang login
        $lead = Lead::create([
            ...$validated,
            'created_by' => Auth::id(),
            'status'     => 'new',
        ]);

        return response()->json([
            'message' => 'Lead berhasil dibuat',
            'data'    => $lead
        ], 201);
    }

    //Menampilkan detail lead (ownership wajib)
    public function show(Lead $lead)
    {
        $this->authorizeLead($lead);

        return response()->json($lead);
    }

    //Form edit (dummy)
    public function edit(Lead $lead)
    {
        $this->authorizeLead($lead);

        return response()->json([
            'message' => 'Form edit lead (frontend belum dibuat)',
            'data'    => $lead
        ]);
    }

    //Update lead
    public function update(Request $request, Lead $lead)
    {
        $this->authorizeLead($lead);

        // Lead yang sudah converted tidak boleh diubah
        if ($lead->status !== 'new') {
            abort(403, 'Lead sudah menjadi customer dan tidak bisa diubah');
        }

        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        $lead->update($validated);

        return response()->json([
            'message' => 'Lead berhasil diperbarui',
            'data'    => $lead
        ]);
    }

    //Hapus lead
    public function destroy(Lead $lead)
    {
        $this->authorizeLead($lead);

        if ($lead->status !== 'new') {
            abort(403, 'Lead yang sudah menjadi customer tidak bisa dihapus');
        }

        $lead->delete();

        return response()->json([
            'message' => 'Lead berhasil dihapus'
        ]);
    }

    //Helper: cek ownership lead
    private function authorizeLead(Lead $lead)
    {
        if ($lead->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke lead ini');
        }
    }
}
