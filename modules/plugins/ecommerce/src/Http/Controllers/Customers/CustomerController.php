<?php

namespace EG\Ecommerce\Http\Controllers\Customers;

use EG\Base\Events\BeforeEditContentEvent;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use EG\Ecommerce\Http\Requests\CustomerCreateRequest;
use EG\Ecommerce\Http\Requests\CustomerEditRequest;
use EG\Ecommerce\Repositories\Interfaces\CustomerInterface;
use EG\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use EG\Ecommerce\Tables\CustomerTable;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Ecommerce\Forms\CustomersForm;
use EG\Base\Forms\FormBuilder;
use Assets2;

class CustomerController extends BaseController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var CustomerInterface
     */
    protected $customerRepository;

    /**
     * @param CustomerInterface $customerRepository
     */
    public function __construct(CustomerInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param CustomerTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(CustomerTable $table)
    {
        page_title()->setTitle(trans('plugins/ecommerce::customers.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/ecommerce::customers.create'));

        Assets2::addScriptsDirectly('vendor/core/plugins/ecommerce/js/customer.js');

        return $formBuilder->create(CustomersForm::class)->remove('is_change_password')->renderForm();
    }

    /**
     * @param CustomerCreateRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(CustomerCreateRequest $request, BaseHttpResponse $response)
    {
        $request->merge(['password' => bcrypt($request->input('password'))]);
        $customer = $this->customerRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(CUSTOMER_MODULE_SCREEN_NAME, $request, $customer));

        return $response
            ->setPreviousUrl(route('customer.index'))
            ->setNextUrl(route('customer.edit', $customer->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $customer = $this->customerRepository->findOrFail($id);
        Assets2::addScriptsDirectly('vendor/core/plugins/ecommerce/js/customer.js');
        event(new BeforeEditContentEvent($request, $customer));
        page_title()->setTitle(trans('plugins/ecommerce::customers.edit', ['name' => $customer->name]));
        $customer->password = null;

        return $formBuilder->create(CustomersForm::class, ['model' => $customer])->renderForm();
    }

    /**
     * @param $id
     * @param CustomerCreateRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, CustomerEditRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_change_password') == 1) {
            $request->merge(['password' => bcrypt($request->input('password'))]);
            $data = $request->input();
        } else {
            $data = $request->except('password');
        }

        $customer = $this->customerRepository->createOrUpdate($data, ['id' => $id]);

        event(new UpdatedContentEvent(CUSTOMER_MODULE_SCREEN_NAME, $request, $customer));

        return $response
            ->setPreviousUrl(route('customer.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $customer = $this->customerRepository->findOrFail($id);
            $this->customerRepository->delete($customer);
            event(new DeletedContentEvent(CUSTOMER_MODULE_SCREEN_NAME, $request, $customer));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->customerRepository, CUSTOMER_MODULE_SCREEN_NAME);
    }
}
