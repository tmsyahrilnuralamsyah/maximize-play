<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua data
        $member = Member::orderBy('id', 'desc')->get();

        // Ambil pilihan untuk upline
        $upline = Member::whereNull('downline1')->orWhereNull('downline2')->select('no_id', 'nama')->get();

        return view('index', ['member' => $member, 'upline' => $upline]);
    }

    public function tambahMember(Request $request)
    {
        // cek kesamaan id
        $cek = Member::find($request->no_id);
        if ($cek != null) {
            return redirect()->back()->with('error', 'Data dengan No ID ini sudah ada')->withInput();
        }

        // tambahkan data
        $jumlah = Member::count();

        Member::create([
            'no_id' => $request->no_id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'upline' => $request->upline
    	]);

        if ($jumlah > 0) {
            $upline = explode(' - ', $request->upline)[0] ?? '';
            $down = Member::where('no_id', $upline)->first();
            if ($down->downline1 == null) {
                $down->downline1 = $request->no_id . " - " . $request->nama;
                $down->save();
            } elseif ($down->downline2 == null) {
                $down->downline2 = $request->no_id . " - " . $request->nama;
                $down->save();
            }
        }

    	return redirect()->back()->with('success', 'Data member berhasil ditambah')->withInput();
    }

    public function editMember($id, Request $request)
    {
        // cek supaya tidak bisa pilih upline sendiri
        $member = Member::find($id);
        $upline = explode(' - ', $request->upline)[0] ?? '';
        if ($upline == $member->no_id) {
            return redirect()->back()->with('error', 'Data tidak dapat diubah')->withInput();
        }

        // mengubah data
        $member->no_id = $request->no_id;
        $member->nama = $request->nama;
        $member->alamat = $request->alamat;
        $member->no_telp = $request->no_telp;
        if ($request->upline != null) {
            // menghapus upline sebelumnya
            $upline_lama = explode(' - ', $member->upline)[0] ?? '';
            $lama = Member::where('no_id', $upline_lama)->first();
            if ($lama->downline1 != $request->upline) {
                $lama->downline1 = null;
                $lama->save();
            } elseif ($lama->downline2 != $request->upline) {
                $lama->downline2 = null;
                $lama->save();
            }

            // ubah upline
            $member->upline = $request->upline;

            // hapus downline sebelumnya
            $down = Member::where('no_id', $upline)->first();
            if ($down->downline1 == null) {
                $down->downline1 = $request->no_id . " - " . $request->nama;
                $down->save();
            } elseif ($down->downline2 == null) {
                $down->downline2 = $request->no_id . " - " . $request->nama;
                $down->save();
            }
        }
        $member->save();

        return redirect()->back()->with('success', 'Data member berhasil diubah')->withInput();
    }

    public function hapusMember($id)
    {
        // menghapus data
        $member = Member::find($id);
        $member->delete();
        return redirect()->back()->with('success', 'Data member berhasil dihapus')->withInput();
    }
}
