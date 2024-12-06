<?php

namespace App\Http\Controllers;

use App\Mail\JobPosted;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{

    public function index()
    {
        // $jobs = Job::all();
        // $jobs = Job::with('employer')->get();
        // $jobs = Job::with('employer')->paginate(3);
        // $jobs = Job::with('employer')->simplePaginate(3);
        $jobs = Job::with('employer')->latest()->simplePaginate(3);
        return view('jobs.index', [
            'jobs' => $jobs
        ]);

    // return ['foo' => 'bar'];
    // return 'About Page';
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store()
    {
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);

        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1
        ]);

        // Mail::to($job->employer->user)->send(
        //     new JobPosted($job)
        // );

        Mail::to($job->employer->user)->queue(
            new JobPosted($job)
        );

        // dd(request()->all());
        // dd(request('title'));

        return redirect('/jobs');
    }

    public function show(Job $job)
    {
        // $job = Job::find($id);
        // dd($job);
        return view('jobs.show', ['job' => $job]);
    }

    public function edit(Job $job)
    {
        // $job = Job::find($id);


        // if(Auth::guest()) {
        //     redirect('/login');
        // }

        // if($job->employer->user->isNot(Auth::user())) {
        //     abort(403);
        // }

        // Gate::authorize('edit-job', $job);

        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Job $job)
    {
        // validate
        request()->validate([
            'title' => ['required', 'min:3'],
            'salary' => ['required']
        ]);


    // authorize (On hold...)
        // Gate::authorize('edit-job', $job);

    //update the job
    // $job = Job::findOrFail($id);

    // $job->title = request('title');
    // $job->salary = request('salary');
    // $job->save();

    //<==>

    $job->update([
        'title' => request('title'),
        'salary' => request('salary')
    ]);

    return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job)
    {
        // authorize (On hold...)
        // Gate::authorize('edit-job', $job);

        // $job = Job::find($id);
        $job->delete();
        return redirect('/jobs');
    }
}