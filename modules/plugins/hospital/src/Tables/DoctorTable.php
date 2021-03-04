<?php

namespace EG\Hospital\Tables;

use Carbon\Carbon;
use EG\Base\Enums\BaseStatusEnum;
use EG\Hospital\Models\Doctor;
use EG\Hospital\Repositories\Interfaces\DepartmentInterface;
use EG\Hospital\Repositories\Interfaces\DoctorInterface;
use EG\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Auth;
use RvMedia;
use Html;
use BaseHelper;

class DoctorTable extends TableAbstract
{

    protected $hasActions = true;

    protected $hasFilter = true;

    protected $departmentRepository;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, DoctorInterface $doctorRepository, DepartmentInterface $departmentRepository)
    {
        $this->repository = $doctorRepository;
        $this->setOption('id', 'table-doctors');
        $this->departmentRepository = $departmentRepository;
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['doctors.edit', 'doctors.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax()
    {
        $data = $this->table
                ->eloquent($this->query())
                ->editColumn('name', function ($item) {

                    if (!Auth::user()->hasPermission('doctors.edit')) {
                        return $item->name;
                    }
                    return Html::link(route('doctors.edit', $item->id), $item->name);
                })
                ->editColumn('image', function ($item) {
                   if ($this->request()->input('action') == 'csv') {
                       return RvMedia::getImageUrl($item->image, null, false, RvMedia::getDefaultImage());
                   }

                    if ($this->request()->input('action') == 'excel') {
                        return RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage());
                    }

                    return Html::image(RvMedia::getImageUrl($item->image, 'thumb', false, RvMedia::getDefaultImage()),
                        $item->name, ['width' => 50]);
                })
                ->editColumn('checkbox', function ($item) {
                    return $this->getCheckbox($item->id);
                })
                ->editColumn('created_at', function ($item) {
                    return BaseHelper::formatDate($item->created_at);
                })
                ->editColumn('status', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return $item->status->getValue();
                }
                return $item->status->toHtml();
            })
            ->editColumn('department_id', function ($item) {
               return $item->department ? $item->department->name  : '';
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('doctors.edit', 'doctors.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }


    public function query()
    {
        $model = $this->repository->getModel();
        $select = [
            'hs_doctors.id',
            'hs_doctors.name',
            'hs_doctors.image',
            'hs_doctors.created_at',
            'hs_doctors.status',
            'hs_doctors.department_id',
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
                'name'  => 'hs_doctors.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image' => [
                'name'  => 'hs_doctors.image',
                'title' => trans('core/base::tables.image'),
                'width' => '70px',
                'orderable' => false,
            ],
            'name'       => [
                'name'  => 'hs_doctors.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'department_id'  => [
                'name'      => 'hs_doctors.department_id',
                'title'     => trans('plugins/hospital::hospital.department'),
                'width'     => '150px',
                'class'     => 'no-sort text-center',
                'orderable' => false,
            ],
            'created_at' => [
                'name'  => 'hs_doctors.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
                'class' => 'text-center',
            ],
            'status'     => [
                'name'  => 'hs_doctors.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
                'class' => 'text-center',
                'orderable' => false,
            ],
        ];
    }

    public function buttons()
    {
        $buttons = $this->addCreateButton(route('doctors.create'), 'doctors.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Doctor::class);
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('doctors.deletes'), 'doctors.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
//            'hs_doctors.name'       => [
//                'title'    => trans('core/base::tables.name'),
//                'type'     => 'text',
//                'validate' => 'required|max:120',
//            ],
            'hs_doctors.status'     => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'hs_doctors.department_id' => [
                'title'     => trans('plugins/hospital::hospital.department'),
                'type'      => 'select-search',
                'validate'  => 'required',
                'callback'  => 'getDepartments',
            ],
        ];
    }

    public function getDepartments(): array
    {
//        return $this->departmentRepository->pluck('hs_departments.name', 'hs_departments.id');
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
            case 'doctors.created_at':
                if (!$value) {
                    break;
                }
                $value = Carbon::createFromFormat(config('core.base.general.date_format.date'), $value)->toDateString();
                return $query->whereDate($key, $operator, $value);
            case 'department':
                if (!$value) {
                    break;
                }
                return $query->join('hs_departments', 'hs_doctors.department_id', '=', 'hs_departments.id')
                            ->where('hs_doctors.department_id', $value);
        }
        return parent::applyFilterCondition($query, $key, $operator, $value);
    }


    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
        if ($inputKey === 'department') {
            $item->department()->sync([$inputValue]);
            return $item;
        }
//        if ($inputKey === 'hs_doctors.name') {
//            $item->name = $inputValue;
//        }
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
