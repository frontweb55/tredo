<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     *
     * @return DepartmentResource
     */
    public function index()
    {
        return response()->json(['data' => DepartmentResource::collection(Department::with('employees')->get())]);
    }


    /**
     * @param Request $request
     * @return DepartmentResource
     */
    public function store(DepartmentRequest $request)
    {
        Department::create($request->only('name'));

        return response()->json(['data' => DepartmentResource::collection(Department::with('employees')->get())]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return DepartmentResource
     */
    public function update(DepartmentRequest $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->name = $request->name;
        $department->save();

        return response()->json(['data' => DepartmentResource::collection(Department::with('employees')->get())]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return DepartmentResource
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        if ($department->employees()->count() > 0){
            return response()->json(['error' => 'В отделе есть сотрудники'], 403);
        }
        $department->delete();

        return response()->json(['data' => DepartmentResource::collection(Department::with('employees')->get())]);
    }
}
