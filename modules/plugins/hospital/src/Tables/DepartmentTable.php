<?php

namespace EG\Hospital\Tables;

use EG\Base\Enums\BaseStatusEnum;
use EG\Hospital\Models\Department;
use EG\Hospital\Repositories\Interfaces\DepartmentInterface;
use EG\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Auth;
use RvMedia;
use Html;
use BaseHelper;

class DepartmentTable extends TableAbstract
{

    protected $hasActions = true;

    protected $hasFilter = true;


    public function __construct(DataTables $table, UrlGenerator $urlGenerator, DepartmentInterface $departmentRepository)
    {
        $this->repository = $departmentRepository;
        $this->setOption('id', 'table-departments');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['departments.edit', 'departments.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax()
    {
        $data = $this->table
                ->eloquent($this->query())
                ->editColumn('name', function ($item) {

                    if (!Auth::user()->hasPermission('departments.edit')) {
                        return $item->name;
                    }
                    return Html::link(route('departments.edit', $item->id), $item->name);
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
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('departments.edit', 'departments.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }


    public function query()
    {
        $model = $this->repository->getModel();
        $select = [
            'hs_departments.id',
            'hs_departments.name',
            'hs_departments.image',
            'hs_departments.created_at',
            'hs_departments.status',
        ];
        $query = $model->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));

    }

    public function columns()
    {
        return [
            'id'    => [
                'name'  => 'hs_departments.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image' => [
                'name'  => 'hs_departments.image',
                'title' => trans('core/base::tables.image'),
                'width' => '70px',
                'orderable' => false,
            ],
            'name'       => [
                'name'  => 'hs_departments.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'hs_departments.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
                'class' => 'text-center',
            ],
            'status'     => [
                'name'  => 'hs_departments.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
                'class' => 'text-center',
                'orderable' => false,
            ],
        ];
    }

    public function buttons()
    {
        $buttons = $this->addCreateButton(route('departments.create'), 'departments.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Department::class);
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('departments.deletes'), 'departments.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'departments.name'       => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'departments.status'     => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
        ];
    }

    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
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
