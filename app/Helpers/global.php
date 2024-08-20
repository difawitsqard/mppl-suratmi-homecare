<?php

use Illuminate\Support\Facades\Cache;
use App\Models\CompanyInfo;

if (!function_exists('getCompanyInfo')) {
  function getCompanyInfo()
  {
    $companyInfo = CompanyInfo::first();
    return $companyInfo;
  }
}

if (!function_exists('formatRupiah')) {
  function formatRupiah($amount)
  {
    return number_format($amount, 0, ',', '.');
  }
}
