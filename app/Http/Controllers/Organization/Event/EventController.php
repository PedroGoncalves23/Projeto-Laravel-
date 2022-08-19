<?php

namespace App\Http\Controllers\Organization\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\Event\EventRequest;
use App\Models\{Event, User};
use Illuminate\Auth\Events\Validated;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::query();

        if(isset($request->search) && $request->search !== '') {
            $events->where('name', 'like', '%'.$request->search.'%');
        }

        return view('organization.events.index', [
            'events' => $events->paginate(5),
            'search' => isset($request->search) ? $request->search : ''
        ]);
    }

    public function create()
    {
        return view('organization.events.create');
    }

    public function store(EventRequest $request)
    {
        Event::create($request->validated());

        return redirect()
            ->route('organization.events.index')
            ->with('success', 'Evento cadastrado com sucesso!');
    }

    public function show(Event $event)
    {
        return view('organization.events.show', [
             'event' => $event,
             'eventStartDateHasPassed' => EventService::eventStartDateHasPassed($event),
             'eventEndDateHasPassed' => EventService::eventEndDsteHasPassed($event),
             'allParticipantsUsers' => User::query()
                ->whereDoesntHave('events', function($query) use ($event){
                    $query->where('id',$event->id);
                })
                ->get()
        ]);
    }

    public function edit(Event $event) 
    {
        return view('organization.events.edit', [
            'event' => $event
        ]);
    }

    public function update(Event $event, EventRequest $request)
    {
        $event->update($request->Validated());

        return redirect()->route('organization.events.index')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('organization.events.index')->with('success', 'Evento deletado com sucesso!');
    }
}
