<?php

namespace App\Services\Admin;



use App\Http\Requests\Admin\StoreFieldRequest;
use App\Http\Requests\Admin\UpdateFieldRequest;
use App\Models\Field;

class FieldService extends BaseService
{
    /**
     * All
     *
     * @return Field[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return Field::paginate(request()->input('per_page', $this->paginate_per_page));
    }

    /**
     * Create
     *
     * @param StoreFieldRequest $request
     * @return mixed
     */
    public function create(StoreFieldRequest $request)
    {
        $data = $request->validated();
        $field = Field::create($data);

        return $field::find($field->id);
    }

    /**
     * Get
     *
     * @param Field $field
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function get(Field $field)
    {
        return Field::find($field->id);
    }

    /**
     * Update
     *
     * @param UpdateFieldRequest $request
     * @param Field $field
     * @return mixed
     */
    public function update(UpdateFieldRequest $request, Field $field)
    {
        $data = $request->validated();
        $field->update($data);
        $field = Field::find($field->id);

        return $field;
    }

    /**
     * Delete
     *
     * @param Field $field
     * @return bool
     */
    public function delete(Field $field)
    {
        $field->delete();
        return true;
    }
}
