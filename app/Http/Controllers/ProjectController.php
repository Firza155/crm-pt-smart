<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller untuk pengajuan Project oleh Sales
class ProjectController extends Controller
{
    //Menampilkan data untuk form create project 
    public function create(Lead $lead)
    {
        //Pastikan lead milik sales yang login
        if ($lead->created_by !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengajukan project dari lead ini');
        }

        //Pastikan lead belum punya project
        if ($lead->project) {
            abort(403, 'Lead ini sudah memiliki project');
        }

        //Pastikan lead belum converted
        if ($lead->status === 'converted') {
            abort(403, 'Lead sudah menjadi customer');
        }

        //Ambil daftar product (nanti untuk dropdown frontend)
        $products = Product::all();

       return response()->json([
            'lead'     => $lead,
            'products' => $products,
        ]);
    }

    //Menyimpan project baru
    public function store(Request $request)
    {
        // Validasi input dasar
        $validated = $request->validate([
            'lead_id'    => 'required|exists:leads,id',
            'product_id' => 'required|exists:products,id',
            'notes'      => 'nullable|string',
        ]);

        $lead = Lead::findOrFail($validated['lead_id']);

        //Ownership check
        if ($lead->created_by !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengajukan project dari lead ini');
        }

        //Business rules
        if ($lead->project) {
            abort(403, 'Lead ini sudah memiliki project');
        }

        if ($lead->status === 'converted') {
            abort(403, 'Lead sudah menjadi customer');
        }

        //Simpan project (pending)
        $project = Project::create([
            'lead_id'    => $lead->id,
            'product_id' => $validated['product_id'],
            'notes'      => $validated['notes'] ?? null,
            'status'     => 'pending',
        ]);

        //Update status lead
        $lead->update([
            'status' => 'on_progress',
        ]);

        return response()->json([
            'message' => 'Project berhasil diajukan dan menunggu approval manager',
            'data'    => $project,
        ], 201);
    }


    //Menampilkan daftar project pending untuk manager
    public function index()
    {
        $projects = Project::with(['lead', 'product'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        
        return response()->json($projects);
    }

    //Manager menyetujui project
    public function approve(Project $project)
    {
        // Pastikan project masih pending
        if ($project->status !== 'pending') {
            abort(403, 'Project ini sudah diproses');
        }

        $project->update([
            'status'      => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        //Jalankan konversi Lead → Customer (STEP 7)
        $this->convertLeadToCustomer($project);

        return response()->json([
            'message' => 'Project berhasil disetujui dan customer berhasil dibuat',
            'data'    => $project,
        ]);
    }

    //Manager menolak project
    public function reject(Project $project)
    {
        // Pastikan project masih pending
        if ($project->status !== 'pending') {
            abort(403, 'Project ini sudah diproses');
        }

        $project->update([
            'status'      => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return response()->json([
            'message' => 'Project berhasil ditolak',
            'data'    => $project,
        ]);
    }

    //Konversi Lead menjadi Customer (SYSTEM LOGIC)
    private function convertLeadToCustomer(Project $project)
    {
        $lead = $project->lead;

        //Cegah konversi ganda
        if ($lead->customer) {
            return;
        }

        //Buat customer dari data lead
        $customer = \App\Models\Customer::create([
            'lead_id' => $lead->id,
            'name'    => $lead->name,
            'phone'   => $lead->phone,
            'email'   => $lead->email,
            'address' => $lead->address,
        ]);

        //Buat layanan aktif customer
        \App\Models\CustomerService::create([
            'customer_id' => $customer->id,
            'product_id'  => $project->product_id,
            'start_date'  => now()->toDateString(),
            'status'      => 'active',
        ]);

        //Update status lead → converted
        $lead->update([
            'status' => 'converted',
        ]);
    }
}
