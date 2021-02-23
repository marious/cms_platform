<?php
namespace EG\SimpleSlider\Tables;

use EG\Base\Enums\BaseStatusEnum;
use EG\SimpleSlider\Repositories\Interfaces\SimpleSliderInterface;
use EG\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Html;
use BaseHelper;

class SimpleSliderTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, SimpleSliderInterface $simpleSliderRepository)
    {
        $this->repository = $simpleSliderRepository;
        $this->setOption('id', 'simple-slider-table');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['simple-slider.edit', 'simple-slider.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('simple-slider.edit')) {
                    return $item->name;
                }

                return Html::link(route('simple-slider.edit', $item->id), $item->name);
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

        if (function_exists('shortcode')) {
            $data = $data->editColumn('key', function ($item) {
                return shortcode()->generateShortcode('simple-slider', ['key' => $item->key]);
            });
        }

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return $this->getOperations('simple-slider.edit', 'simple-slider.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function query()
    {
        $model = $this->repository->getModel();
        $select = [
            'simple_sliders.id',
            'simple_sliders.name',
            'simple_sliders.key',
            'simple_sliders.status',
            'simple_sliders.created_at',
        ];

        $query = $model->select($select);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
    }

    public function columns()
    {
        return [
            'id'         => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name'       => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'key'        => [
                'title' => trans('plugins/simple-slider::simple-slider.key'),
                'class' => 'text-left',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status'     => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    public function buttons()
    {
        $buttons = $this->addCreateButton(route('simple-slider.create'), 'simple-slider.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, SimpleSlider::class);
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('simple-slider.deletes'), 'simple-slider.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'simple_sliders.name'       => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'simple_sliders.key'        => [
                'title'    => trans('plugins/simple-slider::simple-slider.key'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'simple_sliders.status'     => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|' . RUle::in(BaseStatusEnum::values()),
            ],
            'simple_sliders.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
