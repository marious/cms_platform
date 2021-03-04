<?php

namespace EG\Hospital\Tables;

use Carbon\Carbon;
use EG\Base\Enums\BaseStatusEnum;
use EG\Hospital\Models\Appointment;
use EG\Hospital\Models\Doctor;
use EG\Hospital\Repositories\Interfaces\AppointmentInterface;
use EG\Hospital\Repositories\Interfaces\DepartmentInterface;
use EG\Hospital\Repositories\Interfaces\DoctorInterface;
use EG\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Auth;
use RvMedia;
use Html;
use BaseHelper;

class AppointmentTAble extends TableAbstract
{

    protected $hasActions = true;

    protected $hasFilter = true;

    protected $departmentRepository;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, AppointmentInterface $appointmentInterface, DepartmentInterface $departmentRepository)
    {
        $this->repository = $appointmentInterface;
        $this->setOption('id', 'table-appointments');
        $this->departmentRepository = $departmentRepository;
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['appointments.edit', 'appointments.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {

                if (!Auth::user()->hasPermission('appointments.edit')) {
                    return $item->name;
                }
                return Html::link(route('appointments.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('department_id', function ($item) {
                return $item->department ? $item->department->name   : '';
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('appointments.edit', 'appointments.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }


    public function query()
    {
        $model = $this->repository->getModel();
        $select = [
            'hs_appointments.id',
            'hs_appointments.patient_name',
            'hs_appointments.patient_phone',
            'hs_appointments.created_at',
            'hs_appointments.department_id',
        ];
        $query = $model
            ->with([
                'department' => function ($query) {
                    $query->select(['id', 'name']);
                }
            ])
            ->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));

    }

    public function columns()
    {
        return [
            'id'    => [
                'name'  => 'hs_appointments.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'patient_name' => [
                'name'  => 'hs_appointments.patient_name',
                'title' => trans('plugins/hospital::appointment.form.patient_name'),
                'width' => '400px',
                'class' => 'no-sort text-center',
                'orderable' => false,
            ],
            'patient_phone'       => [
                'name'  => 'hs_appointments.patient_phone',
                'title' => trans('plugins/hospital::appointment.form.patient_phone'),
                'class' => 'text-left',
                'orderable' => false,
            ],
            'department_id'  => [
                'name'      => 'hs_appointments.department_id',
                'title'     => trans('plugins/hospital::hospital.department'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'created_at' => [
                'name'  => 'hs_appointments.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
                'class' => 'text-center',
            ],
        ];
    }

    public function buttons()
    {
        $buttons = $this->addCreateButton(route('appointments.create'), 'appointments.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Appointment::class);
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('appointments.deletes'), 'appointments.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'hs_appointments.department_id' => [
                'title'     => trans('plugins/hospital::hospital.department'),
                'type'      => 'select-search',
                'validate'  => 'required',
                'callback'  => 'getDepartments',
            ],
        ];
    }

    public function getDepartments(): array
    {
        $data = app(DepartmentInterface::class)->getAllDepartmentsForSelect(
            ['status'    => BaseStatusEnum::PUBLISHED],
            [],
            ['id', 'name']
        );
        // remove the first item in array
        return array_slice($data, 1, null, true);
    }

    public function applyFilterCondition($query, string $key, string $operator, ?string $value)
    {
        switch ($key) {
            case 'department':
                if (!$value) {
                    break;
                }
                return $query->join('hs_departments', 'hs_appointments.department_id', '=', 'hs_departments.id')
                    ->where('hs_appointments.department_id', $value);
        }
        return parent::applyFilterCondition($query, $key, $operator, $value);
    }


    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
        if ($inputKey === 'department') {
            $item->department()->sync([$inputValue]);
            return $item;
        }

        return parent::saveBulkChangeItem($item, $inputKey, $inputValue);
    }

    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }


}
