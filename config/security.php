<?php

declare(strict_types=1);

use App\Models\Providers\ProviderServices;
use App\Models\Specialities\Specialisations;
use App\Models\User;
use App\Models\Callings\Calling;
use App\Models\Callings\CallingPatients;
use Medico\Modules\Changelog\Models\Changelog;
use Phrantiques\Security\Core\Algorithms\PermitWhenApplicableAndPermittedAndNotDenied;
use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Core\Algorithms\DenyOverrides;
use Phrantiques\Security\Core\Algorithms\DenyUnlessPermit;
use Phrantiques\Security\Core\Algorithms\PermitUnlessDeny;
use Phrantiques\Security\Core\Algorithms\PermitWhenPermittedAndNotDenied;
use Phrantiques\Security\Core\Assertions\LessAssertion;
use Phrantiques\Security\Core\Assertions\EqualAssertion;
use Phrantiques\Security\Core\Assertions\GreaterAssertion;
use Phrantiques\Security\Core\Assertions\NotEqualAssertion;
use Phrantiques\Security\Core\Assertions\LessEqualAssertion;
use Phrantiques\Security\Core\Assertions\ContainsAnyAssertion;
use Phrantiques\Security\Core\Assertions\ContainsAllAssertion;
use Phrantiques\Security\Core\Assertions\GreaterEqualAssertion;
use Phrantiques\Security\Core\PropertyHolders\UserPropertyHolder;
use Phrantiques\Security\Core\PropertyHolders\CallingPropertyHolder;
use Phrantiques\Security\Core\PropertyHolders\PatientPropertyHolder;

return [
    'effects' => [
        Security::EVALUATION_EFFECT_PERMIT => 'Разрешить',
        Security::EVALUATION_EFFECT_DENY   => 'Запретить',
    ],

    'assertions' => [
        EqualAssertion::class        => 'Равен',
        NotEqualAssertion::class     => 'Не равен',
        GreaterAssertion::class      => 'Больше',
        LessAssertion::class         => 'Меньше',
        ContainsAllAssertion::class  => 'Содержит все значения',
        ContainsAnyAssertion::class  => 'Содержит одно из значений',
        GreaterEqualAssertion::class => 'Больше либо равен',
        LessEqualAssertion::class    => 'Меньше либо равен',
    ],

    'algorithms' => [
        PermitWhenApplicableAndPermittedAndNotDenied::class => 'Разрешено, если применимо, разрешено и не запрещено',
        PermitWhenPermittedAndNotDenied::class              => 'Разрешено, если разрешено и не запрещено',
        DenyOverrides::class                                => 'Разрешено, если никто не запретил',
        DenyUnlessPermit::class                             => 'Разрешено, если один разрешил',
        PermitUnlessDeny::class                             => 'Разрешено, если не запрещено',
    ],

    'actions' => [
        Security::ACTION_CREATE => 'Созание',
        Security::ACTION_READ   => 'Чтение',
        Security::ACTION_EDIT   => 'Изменение',
        Security::ACTION_DELETE => 'Удаление',
    ],

    'property_types' => [
        Security::PROPERTY_TYPE_SUBJECT  => 'Субъект',
        Security::PROPERTY_TYPE_RESOURCE => 'Ресурс',
        Security::PROPERTY_TYPE_RAW      => 'Значение',
    ],

    'property_holders' => [
        User::class                       => UserPropertyHolder::class,
        User\Anonymous::class             => UserPropertyHolder::class,
        User\Doctor::class                => UserPropertyHolder::class,
        User\ProviderDirector::class      => UserPropertyHolder::class,
        User\ProviderAdministrator::class => UserPropertyHolder::class,
        User\PatientManager::class        => UserPropertyHolder::class,
        User\Operator::class              => UserPropertyHolder::class,
        User\FinanceManager::class        => UserPropertyHolder::class,
        User\ContentManager::class        => UserPropertyHolder::class,
        User\Administrator::class         => UserPropertyHolder::class,
        Calling::class                    => CallingPropertyHolder::class,
        CallingPatients::class            => PatientPropertyHolder::class,
    ],

    'entities' => [
        Security::PROPERTY_TYPE_SUBJECT => [
            User::class => [
                'name' => 'Пользователь',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\Anonymous::class => [
                'name' => 'Анонимный пользователь',
                'properties' => [
                    'ip' => 'IP адрес'
                ],
            ],

            User\Doctor::class => [
                'name' => 'Доктор',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\Administrator::class => [
                'name' => 'Администратор',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\ContentManager::class => [
                'name' => 'Контент-менеджер',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\FinanceManager::class => [
                'name' => 'Финансовый менеджер',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\Operator::class => [
                'name' => 'Оператор',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\PatientManager::class => [
                'name' => 'Клиент мобильного приложения',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\ProviderAdministrator::class => [
                'name' => 'Администратор провайдера',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\ProviderDirector::class => [
                'name' => 'Директор провайдера',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],
        ],

        Security::PROPERTY_TYPE_RESOURCE => [
            User::class => [
                'name' => 'Пользователь',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\Doctor::class => [
                'name' => 'Доктор',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\Administrator::class => [
                'name' => 'Администратор',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\ContentManager::class => [
                'name' => 'Контент-менеджер',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\FinanceManager::class => [
                'name' => 'Финансовый менеджер',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\Operator::class => [
                'name' => 'Оператор',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\PatientManager::class => [
                'name' => 'Клиент мобильного приложения',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\ProviderAdministrator::class => [
                'name' => 'Администратор провайдера',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            User\ProviderDirector::class => [
                'name' => 'Директор провайдера',

                'properties' => [
                    'id'         => 'Идентификатор',
                    'created_at' => 'Дата создания',
                    'fio'        => 'ФИО',
                    'login'      => 'Логин',
                    'id_prov'    => 'Провайдер',
                    'email'      => 'Электронная почта',
                    'phone'      => 'Номер телефона',
                    'roles'      => 'Роли',
                ],
            ],

            Calling::class => [
                'name' => 'Вызов',

                'properties' => [
                    'id'             => 'Идентификатор',
                    'created_at'     => 'Дата создания',
                    'address'        => 'Адрес',
                    'last_stat'      => 'Статус',
                    'complaint'      => 'Жалоба',
                    'doctor_comment' => 'Комментарий доктора',
                    'services'       => 'Предоставленные услуги',
                    'id_user'        => 'Доктор',
                    'id_patient'     => 'Пациент',
                    'id_creator'     => 'Создатель',
                    'id_prov'        => 'Провайдер',
                    'id_spec'        => 'Специализация',
                ],
            ],

            CallingPatients::class => [
                'name' => 'Пациент',

                'properties' => [
                    'id'           => 'Идентификатор',
                    'id_prov'      => 'Провайдер',
                    'last_name'    => 'Фамилия',
                    'first_name'   => 'Имя',
                    'middle_name'  => 'Отчество',
                    'born'         => 'Дата рождения',
                    'email'        => 'Электронная почта',
                    'phone'        => 'Номер телефона',
                ],
            ],

            Changelog::class => [
                'name' => 'Список изменений',

                'properties' => [
                    'index'         => 'Идентификатор',
                    'action'        => 'Действие',
                    'user_id'       => 'Пользователь',
                    'user_ip'       => 'IP',
                    'entity_id'     => 'Идентификатор изменяемой сущности',
                    'entity_type'   => 'Класс изменяемой сущности',
                    'before'        => 'Состояние до',
                    'after'         => 'Состояние после',
                ],
            ],

            Specialisations::class => [
                'name' => 'Специализация',

                'properties' => [
                    'id'   => 'Идентификатор',
                    'name' => 'Название',
                ],
            ],

            ProviderServices::class => [
                'name' => 'Услуга',

                'properties' => [
                    'id'      => 'Идентификатор',
                    'id_prov' => 'Провайдер',
                    'name'    => 'Название',
                ],
            ],
        ],
    ],
];
