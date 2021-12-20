<?php

namespace App\Http\Controllers;

use App\Models\FullCalendar;
use Illuminate\Http\Request;

class FullCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        if($request->ajax()) {
       
             $data = FullCalendar::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get();
  
             return response()->json($data);
        }
  
        return view('fullcalender.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [ 
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'colorCode' => $request->colorCode
                ];
        $event = FullCalendar::create($data);   
        return response()->json($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FullCalendar  $fullCalendar
     * @return \Illuminate\Http\Response
     */
    public function show(FullCalendar $fullCalendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FullCalendar  $fullCalendar
     * @return \Illuminate\Http\Response
     */
    public function edit(FullCalendar $fullCalendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FullCalendar  $fullCalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $fullCalendar_id)
    {
        $fullCalendar = FullCalendar::find($fullCalendar_id);

        $data = $request->validate([
                    'title' => 'nullable',
                    'start' => 'nullable|date',
                    'end' => 'nullable|date',
                    'colorCode' => 'nullable',
                ]);
        $fullCalendar->update($data);  
        return response()->json($fullCalendar);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FullCalendar  $fullCalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy($fullCalendar_id)
    {
        $fullCalendar = FullCalendar::find($fullCalendar_id);
        $event = $fullCalendar->delete();
        return response()->json($event);
    }
}
