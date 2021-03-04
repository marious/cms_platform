<?php
namespace EG\Hospital\Providers;

use Carbon\Laravel\ServiceProvider;
use EG\Base\Supports\Helper;
use EG\Base\Traits\LoadAndPublishTrait;
use EG\Hospital\Models\Appointment;
use EG\Hospital\Models\Department;
use EG\Hospital\Models\Doctor;
use EG\Hospital\Repositories\Caches\AppointmentCacheDecorator;
use EG\Hospital\Repositories\Caches\DepartmentCacheDecorator;
use EG\Hospital\Repositories\Caches\DoctorCacheDecorator;
use EG\Hospital\Repositories\Eloquent\AppointmentRepository;
use EG\Hospital\Repositories\Eloquent\DepartmentRepository;
use EG\Hospital\Repositories\Eloquent\DoctorRepository;
use EG\Hospital\Repositories\Interfaces\AppointmentInterface;
use EG\Hospital\Repositories\Interfaces\DepartmentInterface;
use EG\Hospital\Repositories\Interfaces\DoctorInterface;
use Event;
use Illuminate\Routing\Events\RouteMatched;

class HospitalServiceProvider extends ServiceProvider
{
    use LoadAndPublishTrait;

    public function register()
    {
        $this->app->bind(DepartmentInterface::class, function () {
            return new DepartmentCacheDecorator(new DepartmentRepository(new Department));
        });

        $this->app->bind(DoctorInterface::class, function () {
            return new DoctorCacheDecorator(new DoctorRepository(new Doctor));
        });

        $this->app->bind(AppointmentInterface::class, function () {
            return new AppointmentCacheDecorator(new AppointmentRepository(new Appointment));
        });


        Helper::autoload(__DIR__ . '/../../helpers');
    }

    public function boot()
    {
        $this->setNamespace('plugins/hospital')
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadRoutes(['web']);

        Event::listen(RouteMatched::class, function () {

            dashboard_menu()->registerItem([
                'id'    => 'cms-plugins-hospital',
                'priority' => 6,
                'parent_id' => null,
                'name' => 'plugins/hospital::hospital.hospital',
                'icon' => 'fa fa-hospital',
                'url' => '',
                'permissions' => ['departments.index'],
            ])
            ->registerItem([
                'id'            => 'cms-plugins-hospital.department',
                'priority'      => 1,
                'parent_id'     => 'cms-plugins-hospital',
                'name'          => 'plugins/hospital::hospital.departments',
                'icon'          => '',
                'url'           => route('departments.index'),
                'permissions'   => ['departments.index'],
            ])
            ->registerItem([
                'id'            => 'cms-plugins-hospital.department',
                'priority'      => 2,
                'parent_id'     => 'cms-plugins-hospital',
                'name'          => 'plugins/hospital::hospital.doctors',
                'icon'          => '',
                'url'           => route('doctors.index'),
                'permissions'   => ['doctors.index'],
            ])
            ->registerItem([
                'id'            => 'cms-plugins-hospital.department',
                'priority'      => 3,
                'parent_id'     => 'cms-plugins-hospital',
                'name'          => 'plugins/hospital::hospital.appointments',
                'icon'          => '',
                'url'           => route('appointments.index'),
                'permissions'   => ['appointments.index'],
            ]);

        });
    }
}
