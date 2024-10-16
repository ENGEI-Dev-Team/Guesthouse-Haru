<?php
namespace App\Http\Controllers;

use App\Http\Controllers\IcaController;
use App\Services\IcalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    public function index()
    {
        return view('user.reservation');
    }
    
}
