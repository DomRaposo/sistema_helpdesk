<?php

namespace App\Repositories;


use App\Models\Ticket;

class TicketRepository
{
    public function getAll()
    {
        return Ticket::all();
    }

    public function getByStatus($status)
    {
        return Ticket::where('status', $status)->get();
    }

    public function find($id)
    {
        return Ticket::find($id);
    }

    public function create(array $data)
    {
        return Ticket::create($data);
    }

    public function update($ticket, $data)
    {
        return $ticket->update($data);
    }

    public function delete($ticket)
    {
        return $ticket->delete();
    }

    public function countByStatus($status)
    {
        return Ticket::where('status', $status)->count();
    }


    public function filterByStatus($status){
        return Ticket::where('status', $status)->get();
    }

}
