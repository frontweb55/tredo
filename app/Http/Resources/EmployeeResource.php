<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $return = [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'gender' => $this->gender,
            'gender_text' => ($this->gender == 'male') ? 'Мужской' : 'Женский',
            'departments' => $this->departments()->pluck('name')->implode(', '),
            'selectDepartments' => $this->departments()->pluck('departments.id')->toArray()
        ];
        if ($this->wage){
            $return['wage'] = $this->wage;
        }
        if ($this->patronymic){
            $return['patronymic'] = $this->patronymic;
        }

        return $return;
    }
}
