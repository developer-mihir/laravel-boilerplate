<?php

namespace App\Http\Controllers;

use App\Models\Brackets\OrganizationLink;
use App\Models\CarHasAttachment;
use App\Repositories\CarsRepository;
use Gamerz\v1\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarsController extends Controller
{
    protected $cars_repository;

    public function __construct(CarsRepository $cars_repository)
    {
        $this->cars_repository = $cars_repository;
    }

    public function index(Request $request)
    {
        try {
            $cars = $this->cars_repository->getCars();

            if($request->ajax()){
                return response()
                    ->json([
                        'success' => true,
                        'code' => 200,
                        'message' => 'Cars have been retrieved.',
                        'data' => $cars->toArray()
                    ]);
            }

            return view('cars.index', compact('cars'));
        } catch (\Exception $e) {
            if($request->ajax()){
                return response()
                    ->json([
                        'success' => false,
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ]);
            }

            return redirect()
                ->route('cars.index')
                ->with('notification', ['type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    public function create()
    {
        return view('cars.manage');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('attachments');
            $validator = Validator::make($data, array('title' => 'required'));
            if ($validator->fails()) {
                return redirect()
                    ->route('cars.create')
                    ->withInput()
                    ->with('notification', ['type' => 'danger', 'message' => implode('<br>', $validator->getMessageBag()->all())]);
            }

            $data['added_by']  = auth()->user()->id;
            $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 0;

            $car = $this->cars_repository->store($data);

            $attachments = $request->get('attachments', []);
            if (!empty($attachments)) {
                foreach ($attachments as $key => $attachment) {
                    $attachment_name = '';
                    if (!empty($request->file('attachments')[ $key ]['name'])) {
                        $attachment_name = $request->file('attachments')[ $key ]['name']->getClientOriginalName();
                        $request->file('attachments')[ $key ]['name']->move(public_path('uploads/cars'), $attachment_name);
                    }

                    CarHasAttachment::create([
                        'car_id' => $car->id,
                        'name'   => $attachment_name
                    ]);
                }
            }

            DB::commit();
            return redirect()
                ->route('cars.index')
                ->withInput()
                ->with('notification', ['type' => 'success', 'message' => 'Car has been added.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('cars.index')
                ->withInput()
                ->with('notification', ['type' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $car = $this->cars_repository->getCarById($id);
            return view('cars.show', compact('car'));
        } catch (\Exception $e) {
            return redirect()
                ->route('cars.index')
                ->with('notification', [
                    'type'    => 'danger',
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function edit($id)
    {
        try {
            $car = $this->cars_repository->getCarById($id);
            return view('cars.manage', compact('car'));
        } catch (\Exception $e) {
            return redirect()
                ->route('cars.index')
                ->with('notification', [
                    'type'    => 'danger',
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data      = $request->except('_method', 'attachments');
            $validator = Validator::make($data, array('title' => 'required'));
            if ($validator->fails()) {
                return redirect()
                    ->route('cars.edit', ['id' => $id])
                    ->withInput()
                    ->with('notification', [
                        'type'    => 'danger',
                        'message' => implode('<br>', $validator->getMessageBag()->all())
                    ]);
            }

            $data['is_active'] = isset($data['is_active']) ? $data['is_active'] : 0;
            $this->cars_repository->update($data, $id);

            CarHasAttachment::where('car_id', $id)->delete();
            $attachments = $request->get('attachments', []);
            if (!empty($attachments)) {
                foreach ($attachments as $key => $attachment) {
                    $attachment_name = !empty($request->get('attachments')[ $key ]['old_name'])
                        ? $request->get('attachments')[ $key ]['old_name']
                        : '';
                    if (!empty($request->file('attachments')[ $key ]['name'])) {
                        $old_picture = $request->get('attachments')[ $key ]['old_name'];
                        if (isset($old_picture) && !empty($old_picture)) {
                            unlink(public_path('uploads/cars/' . $old_picture));
                        }
                        $attachment_name = $request->file('attachments')[ $key ]['name']->getClientOriginalName();
                        $request->file('attachments')[ $key ]['name']->move(public_path('uploads/cars'), $attachment_name);
                    }

                    CarHasAttachment::create([
                        'car_id' => $id,
                        'name'   => $attachment_name
                    ]);
                }
            }

            DB::commit();
            return redirect()
                ->route('cars.index')
                ->withInput()
                ->with('notification', [
                    'type'    => 'success',
                    'message' => 'Car has been updated.'
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('cars.index')
                ->withInput()
                ->with('notification', [
                    'type'    => 'danger',
                    'message' => $e->getMessage()
                ]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->cars_repository->delete($id);
            return redirect()
                ->route('cars.index')
                ->with('notification', [
                    'type'    => 'success',
                    'message' => 'Car has been removed.'
                ]);
        } catch (\Exception $e) {
            return redirect()
                ->route('cars.index')
                ->with('notification', [
                    'type'    => 'danger',
                    'message' => $e->getMessage()
                ]);
        }
    }
}
