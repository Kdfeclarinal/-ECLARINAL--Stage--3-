<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Project;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class MemberProjectController extends Controller
{
    public function assign(Request $request) {
        $validatedData = $request->validate([
            'member_ids' => 'required|array|exists:members,id', 
            'project_ids' => 'required|array|exists:projects,id', 
            'assigned_at' => 'required|date', 
        ]);

        $members = Member::whereIn('id', $validatedData['member_ids'])->get();
        $projects = Project::whereIn('id', $validatedData['project_ids'])->get();

        foreach ($projects as $project) {
            $project->members()->syncWithoutDetaching($validatedData['member_ids'], ['assigned_at' => $validatedData['assigned_at']]);
        }

        return response()->json(['message' => 'Member/s assigned to project/s successfully'], 200);
    }

    public function remove(Request $request)
    {
        $validatedData = $request->validate([
            'member_ids' => 'required|array|exists:members,id', 
            'project_ids' => 'required|array|exists:projects,id',
        ]);

        $projects = Project::whereIn('id', $validatedData['project_ids'])->get();

        foreach ($projects as $project) {
            $project->members()->detach($validatedData['member_ids']);
        }

        return response()->json(['message' => 'Members removed from project successfully'], 200);
    }

    public function getProjectMembers($id){
        
        $project = Project::with('members')->find($id);

    if (!$project) {
        return response()->json(['message' => 'Project not found.'], 404);
    }

    $members = $project->members->map(function ($member) {
        return [
            'id' => $member->id,
            'name' => $member->name,
            'role' => $member->role,
            'assigned_at' => $member->pivot->assigned_at, 
        ];
    });

    return response()->json(['data' => $members], 200);
    }

    public function getMemberProjects($id){

        $member = Member::with('projects')->find($id);

    if(!$member) {
            return response()->json(['message' => 'Member not found'], 404);
    }

    $projects = $member->projects->map(function ($project) {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'description' => $project->description,
            'assigned_at' => $project->pivot->assigned_at, 
        ];
    });

        return response()->json(['data' => $projects], 200);
    }


}
