<?php

namespace EG\Hospital\Http\Controllers;

use EG\Base\Events\BeforeEditContentEvent;
use EG\Base\Events\CreatedContentEvent;
use EG\Base\Events\DeletedContentEvent;
use EG\Base\Events\UpdatedContentEvent;
use EG\Base\Forms\FormBuilder;
use EG\Base\Http\Controllers\BaseController;
use EG\Base\Http\Responses\BaseHttpResponse;
use EG\Base\Traits\HasDeleteManyItemsTrait;
use EG\Hospital\Forms\AppointmentForm;
use EG\Hospital\Http\Requests\AppointmentRequest;
use EG\Hospital\Repositories\Interfaces\AppointmentInterface;
use EG\Hospital\Tables\AppointmentTable;
use Illuminate\Http\Request;
use Exception;
use Assets2;

class AppointmentController extends BaseController
{
    use HasDeleteManyItemsTrait;

    protected $appointmentRepository;

    public function __construct(AppointmentInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function index(AppointmentTable $table)
    {
        page_title()->setTitle(trans('plugins/hospital::hospital.appointments'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/hospital::appointment.create'));

        Assets2::addScripts(['moment', 'datetimepicker'])
                ->addStyles(['datetimepicker'])
                ->addScriptsDirectly([
                    'vendor/core/plugins/hospital/js/hospital.js',
                ]);


        return $formBuilder->create(AppointmentForm::class)->renderForm();
    }


    public function store(AppointmentRequest $request, BaseHttpResponse $response)
    {
        $appointment = $this->appointmentRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(HOSPITAL_Appointment_MODULE_SCREEN_NAME, $request, $appointment));

        return $response
                ->setPreviousUrl(route('appointments.index'))
                ->setNextUrl(route('appointments.edit', $appointment->id))
                ->setMessage(trans('core/base::notices.create_success_message'));
    }


    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $appointment = $this->appointmentRepository->findOrFail($id);

        Assets2::addScripts(['moment', 'datetimepicker'])
            ->addStyles(['datetimepicker'])
            ->addScriptsDirectly([
                'vendor/core/plugins/hospital/js/hospital.js',
            ]);

        event(new BeforeEditContentEvent($request, $appointment));

        page_title()->setTitle(trans('plugins/hospital::appointments.edit') . ' " ' . $appointment->name . '"');

        return $formBuilder->create(AppointmentForm::class, ['model' => $appointment])->renderForm();
    }

    public function update($id, AppointmentRequest $request, BaseHttpResponse $response)
    {
        $appointment = $this->appointmentRepository->findOrFail($id);
        $appointment->fill($request->input());
        $this->appointmentRepository->createOrUpdate($appointment);
        event(new UpdatedContentEvent(HOSPITAL_Appointment_MODULE_SCREEN_NAME, $request, $appointment));  // This event will go to make slug

        return $response
                ->setPreviousUrl(route('appointments.index'))
                ->setMessage(trans('core/base::notices.update_success_message'));

    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $appointment = $this->appointmentRepository->findOrFail($id);
            $this->appointmentRepository->delete($appointment);
            event(new DeletedContentEvent(HOSPITAL_Appointment_MODULE_SCREEN_NAME, $request, $appointment));
            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $this->executeDeleteItems($request, $response, $this->appointmentRepository, HOSPITAL_Appointment_MODULE_SCREEN_NAME);
    }
}
