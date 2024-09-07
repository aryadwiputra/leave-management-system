<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($type = null, $status = null)
    {
        $leaves = Leave::with('user')
            ->when($type, function ($query) use ($type) {
                if ($type === 'sakit' || $type === 'izin') {
                    // Kondisi khusus untuk type sakit atau izin
                    return $query->whereIn('type', ['sakit', 'izin']);
                }
                // Kondisi umum untuk type lainnya
                return $query->where('type', $type);
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->get();

        return view('pages.leaves.index', compact('leaves', 'type', 'status'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($type = null)
    {
        $user = Auth::user();

        // leaders selain auth user
        $leaders = User::where('id', '!=', Auth::user()->id)->get();

        return view('pages.leaves.create', compact('user', 'type', 'leaders'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'leader_id' => 'required',
            'type' => 'required',
            'start' => 'required',
            'end' => 'required',
            'description' => 'required',
        ]);

        $leave = new Leave();
        $leave->user_id = $request->user_id;
        $leave->leader_id = $request->leader_id;
        $leave->type = $request->type;
        $leave->date = date('Y-m-d');
        // Set start dan end berdasarkan type leave
        if ($request->type == 'lembur') {
            // Format tanggal dan waktu untuk leave type 'lembur'
            $leave->start = $request->date . ' ' . $request->start;
            $leave->end = $request->date . ' ' . $request->end;
        } else {
            // Format tanggal dan waktu untuk leave type lainnya
            $leave->start = $request->start;
            $leave->end = $request->end;
        }
        $leave->description = $request->description;
        $leave->status = 'pending';
        $leave->save();

        if ($request->type == 'sakit') {
            // Simpan file attachment ke dalam direktori 'attachments' di storage publik
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');

                // Simpan file attachment dengan nama asli file ke dalam direktori 'attachments'
                $path = $attachment->storeAs('attachments', $attachment->getClientOriginalName(), 'public');

                // Buat instance LeaveAttachment dan simpan ke database
                $leaveAttachment = new LeaveAttachment();
                $leaveAttachment->leave_id = $leave->id;
                $leaveAttachment->path = $path; // Gunakan atribut 'path' dari migration
                $leaveAttachment->save();
            }
        }


        switch ($leave->type) {
            case 'cuti':
                return redirect()->route('dashboard.leaves.index', ['type' => 'cuti'])->with('success', 'Cuti berhasil dibuat');
            case 'sakit':
                return redirect()->route('dashboard.leaves.index', ['type' => 'sakit'])->with('success', 'Cuti sakit berhasil dibuat');
            case 'izin':
                return redirect()->route('dashboard.leaves.index', ['type' => 'ijin'])->with('success', 'Izin berhasil dibuat');
            case 'lembur':
                return redirect()->route('dashboard.leaves.index', ['type' => 'lembur'])->with('success', 'Lembur berhasil dibuat');
            case 'dinas':
                return redirect()->route('dashboard.leaves.index', ['type' => 'dinas'])->with('success', 'Izin dinas berhasil dibuat');
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
        //
    }

    public function updateStatus(Request $request)
    {
        $leave = Leave::find($request->id);
        $leave->status = $request->status;
        $leave->save();

        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }
}
