<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;

/**
 * Class EmployeeController
 * @package App\Http\Controllers
 */
class EmployeeController extends Controller
{

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return response()->json(['data' => EmployeeResource::collection(Employee::with('departments')->orderByDesc('created_at')->get())]);
    }


    /**
     * @param EmployeeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EmployeeRequest $request)
    {
        $employee = Employee::create($request->except('departments'));
        $employee->departments()->sync($request->get('departments'));

        return response()->json(['data' => EmployeeResource::collection(Employee::with('departments')->orderByDesc('created_at')->get())]);
    }


    /**
     * @param EmployeeRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::findOrFail($id);
        Employee::where('id', $id)->update($request->only('name', 'surname', 'patronymic', 'gender', 'wage'));
        $employee->departments()->sync($request->get('departments'));

        return response()->json(['data' => EmployeeResource::collection(Employee::with('departments')->orderByDesc('created_at')->get())]);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(['data' => EmployeeResource::collection(Employee::with('departments')->orderByDesc('created_at')->get())]);
    }
}
