<?php
namespace EG\Base\Http\Controllers;

use EG\Base\Supports\Language;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


}
