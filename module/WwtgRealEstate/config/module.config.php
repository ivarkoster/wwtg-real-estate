<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'WwtgRealEstate\Controller\RealEstate' => 'WwtgRealEstate\Controller\RealEstateController',
            'WwtgRealEstate\Controller\RealEstateBroker' => 'WwtgRealEstate\Controller\RealEstateBrokerController',
            'WwtgRealEstate\Controller\AdminResident' => 'WwtgRealEstate\Controller\AdminResidentController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'wwtg-real-estate' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/real-estate',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'WwtgRealEstate\Controller',
                        'controller'    => 'RealEstate',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action][/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            //dependency: ZfcAdmin module
            //configure child routes for the zfcAdmin module (vendor/zf-commons/zfc-admin/config/module.config.php
            'zfcadmin' => array(
                'child_routes' => array(
                    'resident-admin' => array(
                        'type' => 'segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route' => '/resident[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'WwtgRealEstate\Controller',
                                'controller' => 'AdminResident',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'wwtgrealestate' => __DIR__ . '/../view',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                )
            ),
            'orm_default' => array(
                'drivers' => array(__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'),
            ),
        ),
    ),
);
