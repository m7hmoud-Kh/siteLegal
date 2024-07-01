<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Client;
use App\Models\Faq;
use App\Models\Message;
use App\Models\Process;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $servicesCount = Service::count();
        $blogsCount = Blog::count();
        $faqCount = Faq::count();
        $messageCount = Message::count();
        $clientCount = Client::count();
        $processCount = Process::count();

        return response()->json([
            'data' => [
                'serviceCount' => $servicesCount,
                'blosCount' => $blogsCount,
                'faqCount' => $faqCount,
                'messageCount' => $messageCount,
                'clientCount' => $clientCount,
                'processCount' => $processCount
            ]
        ]);
    }
}
