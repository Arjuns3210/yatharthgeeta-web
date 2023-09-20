<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventImageRequest;
use App\Models\Event;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EventImageController extends Controller
{
    
    /**
     * Show the form for creating a new resource.
     *
     * @param $eventId
     * @return Application|Factory|View|Response
     */
    public function create($eventId)
    {
        $localeLanguage = \App::getLocale();
        if (str_contains($localeLanguage, 'en')) {
            $localeLanguage = 'en';
        } else {
            $localeLanguage = 'hi';
        }
        $data['event'] = Event::with([
            'translations' => function ($query) use ($localeLanguage) {
                $query->where('locale', $localeLanguage);
            },
        ])->where('id', $eventId)->first();
        
        $data['eventImages'] = $data['event']->getMedia(Event::EVENT_IMAGES);
        
        return view('backend/event_images/add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateEventImageRequest  $request
     * @return Response
     */
    public function store(CreateEventImageRequest $request)
    {
        try {
            $input = $request->all();
            $input['event_id'] = $input['event_id'] ?? '';
            $event = Event::find($input['event_id']);
            if (! empty($event) && ! empty($input['event_images'])) {
                // for store multiple document upload
                foreach ($input['event_images'] as $eventImage) {
                    storeMedia($event, $eventImage, Event::EVENT_IMAGES);
                }
            }
            
            successMessage('Data Saved successfully', []);
            
        } catch (\Exception $e) {
            Log::error("Something Went Wrong. Error: ".$e->getMessage());

            errorMessage("Something Went Wrong.");
        }
    }
}
