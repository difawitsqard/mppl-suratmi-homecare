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
