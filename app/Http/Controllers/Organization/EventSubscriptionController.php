<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\{Event, user};
use App\Services\EventService;
use Illuminate\Http\Request;

class EventSubscriptionController extends Controller
{
    public function store(Event $event, Request $request)
    {
        $user = User::findOrFail($request->user_id);

        // VERIFICÃO
        if(EventService::userSubscripbedOnEvent($user, $event)) {
            return back()->with('warning', 'Este participante já está inscrito neste evento!');
        }

        if(EventService::eventEndDsteHasPassed($event)) {
            return back()->with('warning', 'Operação inválida! O evento já ocorreu!');
        }

        
        if(EventService::eventParticipantsLimitHasReached($event)) {
            return back()->with('warning', 'Não é possível se inscrever no evento, pois o limite de pariticipantes já foi atingido');
        }

        $user->events()->attach($event->id);

        return back()->with('success', 'Incrição no evento realizada com sucesso!');
    }

    public function destroy(Event $event, User $user)
    {
        if(EventService::eventEndDsteHasPassed($event)) {
            return back()->with('warning', 'Operação inválida! O evento já ocorreu!');
        }

        if(!EventService::userSubscripbedOnEvent($user, $event)) {
            return back()->with('warning', 'O paerticipante não está inscrito no evento!');
        }

        $user->events()->detach($event->id);

        return back()->with('success', 'Inscrição removida com sucesso!');

        
    }
}
