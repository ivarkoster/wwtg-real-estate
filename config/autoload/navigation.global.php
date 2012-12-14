<?php

return array(
    // All navigation-related configuration is collected in the 'navigation' key
    'navigation' => array(

        // The DefaultNavigationFactory we configured in (1) uses 'default' as the sitemap key
        'default' => array(

            // And finally, here is where we define our page hierarchy
            'PhotoAlbum' => array(
                'label' => 'Photo Album',
                'route' => 'photoalbum',
                'pages' => array(
                    'home' => array(
                        'label' => 'Dashboard',
                        'route' => 'photoalbum',
                    ),
                    'Admin' => array(
                        'label' => 'Admin',
                        'route' => 'photoAlbumAdmin',
                    ),
                ),
            ),
        ),
        'admin' => array(
            //And finally, here is where we define our page hierarchy
            'Resident' => array(
                'label' => 'Residents',
                'route' => 'zfcadmin/resident-admin',
                'pages' => array(
                    'Add' => array(
                        'label' => 'Add Resident',
                        'route' => 'add',
                    ),
                    'Delete' => array(
                        'label' => 'Delete Resident',
                        'route' => 'delete',
                    ),
                ),
            ),
            'Broker' => array(
                'label' => 'Brokers',
                'route' => 'zfcadmin/broker',
                'pages' => array(
                    'Add' => array(
                        'label' => 'Add Resident',
                        'route' => 'add',
                    ),
                    'Delete' => array(
                        'label' => 'Delete Resident',
                        'route' => 'delete',
                    ),
                ),
            ),
        ),
    ),
);
