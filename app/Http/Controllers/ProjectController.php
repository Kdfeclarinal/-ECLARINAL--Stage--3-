<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225', 
            'description' => 'nullable|string|max:225'
        ]);

        //custom validation 
        if($validator->fails()) {
            return response()->json([
                'message'=>'Invalid input',
                'errors'=> $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $project = Project::create($validatedData);

        return response()->json([
            'messsage' => 'Project added successfully.',
            'data' => $project,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'description' => 'required|string|max:225',
        ]);

         //custom validation 
            if($validator->fails()) {
                return response()->json([
                    'message'=>'Invalid input',
                    'errors'=> $validator->errors(),
                ], 422);
            }
    
        $validatedData = $validator->validated();
        $project = Project::find($id);

        if(!$project) {
            return response()->json(['error' => 'Project not Found'], 404);
        }

        $project->update($validatedData);

        return response()->json(['message' => 'Project Updated Successfully.',
                                 'project' => $project], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_ids' => 'required|array', //multiple projects can be deleted
            'project_ids.*' => 'integer',
        ]);

        //custom validation 
            if($validator->fails()) {
                return response()->json([
                    'message'=>'Invalid input. Format should be [1,2]',
                    'errors'=> $validator->errors(),
                ], 422);
            }
        
        $validatedData = $validator->validated();
        $projectIds = $validatedData['project_ids'];

        $existingProjects = Project::whereIn('id', $projectIds)->pluck('id')->toArray();
        $notFoundIds = array_diff($projectIds, $existingProjects);

        if (!empty($existingProjects)) {
            Project::destroy($existingProjects);
        }

        return response()->json([
            'message' => !empty($notFoundIds) ? 'Some projects do not exist.' : 'Project/s deleted successfully.',
            'deleted_ids' => $existingProjects,
            'not_found_ids' => $notFoundIds
        ], 200);

    
    }
}
