<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyInfoRequest;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $CompanyInfo = CompanyInfo::first();
        return view('dashboard.company-info.index', compact('CompanyInfo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    private function store($data)
    {
        $CompanyInfo = new CompanyInfo();
        $CompanyInfo->fill($data);
        $CompanyInfo->save();
        return redirect()->back()->with('success', 'Info perusahaan berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    private function update($data)
    {
        $CompanyInfo = CompanyInfo::first();
        $CompanyInfo->update($data);
        return redirect()->back()->with('success', 'Info perusahaan berhasil diperbarui.');
    }

    public function CreateOrUpdate(CompanyInfoRequest $request)
    {
        $CompanyInfo = CompanyInfo::first();
        if (!$CompanyInfo) {
            return $this->store($request->validated());
        } else {
            return $this->update($request->validated());
        }
    }
}
