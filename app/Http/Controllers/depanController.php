<?php

namespace App\Http\Controllers;

use App\Models\halaman;
use App\Models\riwayat;
use Illuminate\Http\Request;

class depanController extends Controller
{
    public function index()
    {
        $about_id = get_meta_value('_halaman_about');
        $about_data = halaman::find($about_id);

        $interest_id = get_meta_value('_halaman_interest');
        $interest_data = halaman::find($interest_id);

        $award_id = get_meta_value('_halaman_award');
        $award_data = halaman::find($award_id);

        $experience_data = riwayat::where('tipe', 'experience')->get();
        $education_data = riwayat::where('tipe', 'education')->get();

        return view('depan.index', [
            'about' => $about_data,
            'interest' => $interest_data,
            'award' => $award_data,
            'experience' => $experience_data,
            'education' => $education_data
        ]);
    }
}
