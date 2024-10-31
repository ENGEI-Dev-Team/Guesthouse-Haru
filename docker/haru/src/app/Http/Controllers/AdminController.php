<?php

namespace App\Http\Controllers;

use App\DDD\Contact\UseCase\CreateContactUseCase;
use App\DDD\Contact\infrastructure\EloquentContactRepository;
use App\DDD\Contact\UseCase\deleteContactUseCase;
use App\DDD\Contact\UseCase\FilterContactUseCase;
use App\DDD\Contact\UseCase\UpdateContactStatusUseCase;
use App\Models\Blog;
use App\Http\Controllers\AdminCalendarController;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    private $createContactUseCase;
    private $filterContactUseCase;
    private $updateContactStatusUseCase; 
    private $contactRepository; 
    private $deleteContactUseCase;


    public function __construct(
        EloquentContactRepository $contactRepository,
        CreateContactUseCase $createContactUseCase, 
        FilterContactUseCase $filterContactUseCase,
        UpdateContactStatusUseCase $updateContactStatusUseCase,
        DeleteContactUseCase $deleteContactUseCase
    ) {
        $this->contactRepository = $contactRepository; 
        $this->createContactUseCase = $createContactUseCase;
        $this->filterContactUseCase = $filterContactUseCase;
        $this->updateContactStatusUseCase = $updateContactStatusUseCase;
        $this->deleteContactUseCase = $deleteContactUseCase;
    }

    public function index(Request $request)
    {
        $latestBlogs = Blog::latest()->take(6)->get();

        $contactController = new ContactController(
            $this->contactRepository,  
            $this->createContactUseCase, 
            $this->filterContactUseCase, 
            $this->updateContactStatusUseCase,
            $this->deleteContactUseCase
        );

        $contact = $contactController->dashboard($request);

        $calendarController = new AdminCalendarController();
        $bookedDates = $calendarController->fetchEventData(); 

        return view('admin.dashboard', compact('latestBlogs','contact', 'bookedDates'));
    }
}
