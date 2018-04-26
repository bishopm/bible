<?php

namespace Bishopm\Bible\Http\Controllers;

use Bishopm\Bible\Repositories\MeetingsRepository;
use Bishopm\Bible\Repositories\SocietiesRepository;
use App\Http\Controllers\Controller;
use Bishopm\Bible\Http\Requests\CreateMeetingRequest;
use Bishopm\Bible\Http\Requests\UpdateMeetingRequest;

class MeetingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $meeting;
    private $societies;

    public function __construct(MeetingsRepository $meeting, SocietiesRepository $societies)
    {
        $this->meeting = $meeting;
        $this->societies = $societies;
    }

    public function index()
    {
        $meetings = $this->meeting->all();
        return view('bible::meetings.index', compact('meetings'));
    }

    public function edit($meeting)
    {
        $societies = $this->societies->all();
        $meeting=$this->meeting->find($meeting);
        return view('bible::meetings.edit', compact('meeting', 'societies'));
    }

    public function create()
    {
        $societies = $this->societies->all();
        return view('bible::meetings.create', compact('societies'));
    }

    public function show(Meeting $meeting)
    {
        $data['meeting']=$meeting;
        return view('bible::meetings.show', $data);
    }

    public function store(CreateMeetingRequest $request)
    {
        $data=$request->all();
        $data['meetingdatetime']=strtotime($data['meetingdatetime']);
        $this->meeting->create($data);

        return redirect()->route('admin.meetings.index')
            ->withSuccess('New meeting added');
    }
    
    public function update($meeting, UpdateMeetingRequest $request)
    {
        $data=$request->all();
        $data['meetingdatetime']=strtotime($data['meetingdatetime']);
        $this->meeting->update($meeting, $data);
        return redirect()->route('admin.meetings.index')->withSuccess('Meeting has been updated');
    }

    public function destroy($meeting)
    {
        $this->meeting->destroy($meeting);
        return redirect()->route('admin.meetings.index')->withSuccess('Meeting has been deleted');
    }
}
