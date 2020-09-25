<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Http\Resources\Jobs\JobsCollection;
use App\Http\Resources\Jobs\JobResource;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search   = request()->keyword;
        $from     = request()->from;
        $to       = request()->to;

        $latest   = Job::latest();
        if($search){
            $latest = $latest->where('name', 'LIKE', '%'.$search.'%');
        }

        if($from || $to){
            $latest = $latest->whereBetween('salary', [$from, $to]);
        }

        return $latest->with('user')
                        ->paginate(10)
                        ->appends(request()->query());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|min:2',
            'description'    => 'required',
            'salary'         => 'required|numeric',
            'apply_before'   => 'required|date',
            'tags'           => 'required|string'

        ]);

        $job = auth()->user()->jobs()->create([
            'name'           => $data['name'],
            'description'    => $data['description'],
            'salary'         => $data['salary'],
            'apply_before'   => $data['apply_before'],
            'tags'           => $data['tags']
        ]);
        
        return response(['job' => $job], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return new JobResource($job);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $data = $request->validate([
            'name'           => 'required|string|min:2',
            'description'    => 'required',
            'salary'         => 'required|numeric',
            'apply_before'   => 'required|date',
            'tags'           => 'required|string'

        ]);

        $job->update([
            'name'           => $data['name'],
            'description'    => $data['description'],
            'salary'         => $data['salary'],
            'apply_before'   => $data['apply_before'],
            'tags'           => $data['tags']
        ]);

        return response(['job' => $job], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        $job->delete();
        return response(['job' => $job], 204);
    }
}
