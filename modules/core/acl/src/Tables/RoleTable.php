<?php
namespace EG\ACL\Tables;

use Html;
use BaseHelper;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use EG\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use EG\ACL\Repositories\Interfaces\RoleInterface;
use EG\ACL\Repositories\Interfaces\UserInterface;

class RoleTable extends TableAbstract
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
     * @var UserInterface
     */
    protected $userRepository;

    public function __construct(
      DataTables $table,
      UrlGenerator $urlGenerator,
      RoleInterface $roleRepository,
      UserInterface $userRepository
  ) {
      $this->repository = $roleRepository;
      $this->userRepository = $userRepository;
      $this->setOption('id', 'table-roles');
      parent::__construct($table, $urlGenerator);

      if (!Auth::user()->hasAnyPermission(['roles.edit', 'roles.destroy'])) {
          $this->hasOperations = false;
          $this->hasActions = false;
      }
  }

  public function ajax()
  {
      $data = $this->table
          ->eloquent($this->query())
          ->editColumn('name', function ($item) {
              if (!Auth::user()->hasPermission('roles.edit')) {
                  return $item->name;
              }

              return Html::link(route('roles.edit', $item->id), $item->name);
          })
          ->editColumn('checkbox', function ($item) {
              return $this->getCheckbox($item->id);
          })
          ->editColumn('created_at', function ($item) {
              return BaseHelper::formatDate($item->created_at);
          })
          ->editColumn('created_by', function ($item) {
              return $item->author->getFullName();
          });

      return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
          ->addColumn('operations', function ($item) {
              return $this->getOperations('roles.edit', 'roles.destroy', $item);
          })
          ->escapeColumns([])
          ->make(true);
  }


  public function query()
  {
      $model = $this->repository->getModel();
      $select = [
          'roles.id',
          'roles.name',
          'roles.description',
          'roles.created_at',
          'roles.created_by',
      ];

      $query = $model
          ->with('author')
          ->select($select);

      return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model, $select));
  }

  public function columns()
  {
      return [
          'id'          => [
              'name'  => 'roles.id',
              'title' => trans('core/base::tables.id'),
              'width' => '20px',
          ],
          'name'        => [
              'name'  => 'roles.name',
              'title' => trans('core/base::tables.name'),
          ],
          'description' => [
              'name'  => 'roles.description',
              'title' => trans('core/base::tables.description'),
              'class' => 'text-left',
          ],
          'created_at'  => [
              'name'  => 'roles.created_at',
              'title' => trans('core/base::tables.created_at'),
              'width' => '100px',
          ],
          'created_by'  => [
              'name'  => 'roles.created_by',
              'title' => trans('core/acl::permissions.created_by'),
              'width' => '100px',
          ],
      ];
  }

  public function buttons()
  {
      $buttons = $this->addCreateButton(route('roles.create'), 'roles.create');

      return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Role::class);
  }


  public function bulkActions(): array
  {
      return $this->addDeleteAction(route('roles.deletes'), 'roles.destroy', parent::bulkActions());
  }

  public function getBulkChanges(): array
  {
      return [
          'roles.name' => [
              'title'    => trans('core/base::tables.name'),
              'type'     => 'text',
              'validate' => 'required|max:120',
          ],
      ];
  }
}
