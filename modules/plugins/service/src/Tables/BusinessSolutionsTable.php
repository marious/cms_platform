<?php

namespace EG\Service\Tables;

use Auth;
use BaseHelper;
use EG\Base\Enums\BaseStatusEnum;
use EG\Service\Repositories\Interfaces\BusinessSolutionsInterface;
use EG\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use EG\Service\Models\Service;
use Html;

class BusinessSolutionsTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * BusinessSolutionsTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param BusinessSolutionsInterface $businessSolutionsRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, BusinessSolutionsInterface $businessSolutionsRepository)
    {
        $this->repository = $businessSolutionsRepository;
        $this->setOption('id', 'plugins-business-solutions-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['business-solutions.edit', 'business-solutions.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('business-solutions.edit')) {
                    return $item->name;
                }
                return Html::link(route('business-solutions.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('business-solutions.edit', 'business-solutions.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $select = [
            'business_solutions.id',
            'business_solutions.name',
            'business_solutions.description',
            'business_solutions.created_at',
            'business_solutions.status',
        ];

        $query = $model->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            'id' => [
                'name'  => 'business_solutions.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name'  => 'business_solutions.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'description' => [
                'name'  => 'business_solutions.description',
                'title' => trans('Description'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'name'  => 'business_solutions.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name'  => 'business_solutions.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('business-solutions.create'), 'service.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Service::class);
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('service.deletes'), 'service.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'business_solutions.name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'business_solutions.status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'business_solutions.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->getBulkChanges();
    }
}
