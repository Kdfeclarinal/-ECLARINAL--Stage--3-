<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
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
    public function addMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'role' => 'required|string|max:225',
        ]);

        //custom validation
        if($validator->fails()) {
            return response()->json([
                'message'=>'Invalid input',
                'errors'=> $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $member = Member::create($validatedData);

        return response()->json([
            'messsage' => 'Member added successfully.',
            'data' => $member,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function updateMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:225',
            'role' => 'required|string|max:225',
        ]);

        //custom validation
        if($validator->fails()) {
            return response()->json([
                'message'=>'Invalid input',
                'errors'=> $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $member = Member::find($id);

        if(!$member) {
            return response()->json(['error' => 'Member not Found'], 404);
        }

        $member->update($validatedData);

        return response()->json(['message' => 'Member Updated Successfully.',
                                 'member' => $member], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'member_ids' => 'required|array', //I used array so multiple members can be deleted
            'member_ids.*' => 'integer',
        ]);

        //custom validation
        if($validator->fails()) {
            return response()->json([
                'message'=>'Invalid input. Format should be [1,2]',
                'errors'=> $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $memberIds = $validatedData['member_ids'];

        $existingMembers = Member::whereIn('id', $memberIds)->pluck('id')->toArray();
        $notFoundIds = array_diff($memberIds, $existingMembers);

        if (!empty($existingMembers)) {
            Member::destroy($existingMembers);
        }

        return response()->json([
            'message' => !empty($notFoundIds) ? 'Some members do not exist.' : 'Member/s deleted successfully.',
            'deleted_ids' => $existingMembers,
            'not_found_ids' => $notFoundIds
        ], 200);

    }
}