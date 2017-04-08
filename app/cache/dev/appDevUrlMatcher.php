<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        if (0 === strpos($pathinfo, '/admin')) {
            if (0 === strpos($pathinfo, '/admin/backup')) {
                // admin_backup
                if (rtrim($pathinfo, '/') === '/admin/backup') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_backup;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'admin_backup');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BackupController::indexAction',  '_route' => 'admin_backup',);
                }
                not_admin_backup:

                // admin_backup_process
                if ($pathinfo === '/admin/backup/process') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_backup_process;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BackupController::backupProcessAction',  '_route' => 'admin_backup_process',);
                }
                not_admin_backup_process:

                // admin_backup_settings
                if ($pathinfo === '/admin/backup/settings') {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_admin_backup_settings;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\BackupController::backupSettingsAction',  '_route' => 'admin_backup_settings',);
                }
                not_admin_backup_settings:

            }

            // admin_dashboard
            if ($pathinfo === '/admin/dashboard') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_admin_dashboard;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\DashboardController::indexAction',  '_route' => 'admin_dashboard',);
            }
            not_admin_dashboard:

            if (0 === strpos($pathinfo, '/admin/files')) {
                // admin_files
                if (rtrim($pathinfo, '/') === '/admin/files') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_files;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'admin_files');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\FilesController::indexAction',  '_route' => 'admin_files',);
                }
                not_admin_files:

                // admin_files_delete
                if (preg_match('#^/admin/files/(?P<uuid>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_admin_files_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_files_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\FilesController::deleteAction',));
                }
                not_admin_files_delete:

                if (0 === strpos($pathinfo, '/admin/files/link_')) {
                    // admin_files_link_to_user
                    if (0 === strpos($pathinfo, '/admin/files/link_user_files') && preg_match('#^/admin/files/link_user_files/(?P<user_id>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_files_link_to_user')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\FilesController::linkFilesToUserAction',));
                    }

                    // admin_files_link_to_project
                    if (0 === strpos($pathinfo, '/admin/files/link_project_files') && preg_match('#^/admin/files/link_project_files/(?P<project_id>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_files_link_to_project')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\FilesController::linkFilesToProjectAction',));
                    }

                }

                if (0 === strpos($pathinfo, '/admin/files/temp')) {
                    // admin_files_clear_temp
                    if ($pathinfo === '/admin/files/temp/clear') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_files_clear_temp;
                        }

                        return array (  'keep_age' => 600,  '_controller' => 'AppBundle\\Controller\\Admin\\FilesController::clearTempAction',  '_route' => 'admin_files_clear_temp',);
                    }
                    not_admin_files_clear_temp:

                    // admin_files_delete_temp
                    if (preg_match('#^/admin/files/temp/(?P<uuid>[^/]++)/delete$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_files_delete_temp;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_files_delete_temp')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\FilesController::deleteTempFile',));
                    }
                    not_admin_files_delete_temp:

                }

                // admin_files_create
                if ($pathinfo === '/admin/files/create') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_files_create;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\FilesController::createAction',  '_route' => 'admin_files_create',);
                }
                not_admin_files_create:

            }

            // admin_home
            if (rtrim($pathinfo, '/') === '/admin') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_admin_home;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'admin_home');
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Admin\\IndexController::indexAction',  '_route' => 'admin_home',);
            }
            not_admin_home:

            if (0 === strpos($pathinfo, '/admin/projects')) {
                // admin_projects
                if (rtrim($pathinfo, '/') === '/admin/projects') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_projects;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'admin_projects');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectController::indexAction',  '_route' => 'admin_projects',);
                }
                not_admin_projects:

                if (0 === strpos($pathinfo, '/admin/projects/create')) {
                    // admin_projects_create
                    if ($pathinfo === '/admin/projects/create') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_projects_create;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectController::createAction',  '_route' => 'admin_projects_create',);
                    }
                    not_admin_projects_create:

                    // admin_projects_create_handler
                    if ($pathinfo === '/admin/projects/create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_admin_projects_create_handler;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectController::createHandlerAction',  '_route' => 'admin_projects_create_handler',);
                    }
                    not_admin_projects_create_handler:

                }

                // admin_projects_clone
                if (preg_match('#^/admin/projects/(?P<id>[^/]++)/clone$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_projects_clone;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_projects_clone')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectController::cloneAction',));
                }
                not_admin_projects_clone:

                // admin_projects_clone_handler
                if ($pathinfo === '/admin/projects/clone') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_admin_projects_clone_handler;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectController::cloneHandlerAction',  '_route' => 'admin_projects_clone_handler',);
                }
                not_admin_projects_clone_handler:

                // admin_projects_update
                if (preg_match('#^/admin/projects/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_projects_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_projects_update')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectController::updateAction',));
                }
                not_admin_projects_update:

                // admin_projects_update_handler
                if (preg_match('#^/admin/projects/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_admin_projects_update_handler;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_projects_update_handler')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectController::updateHandlerAction',));
                }
                not_admin_projects_update_handler:

                // admin_projects_delete_confirm
                if (preg_match('#^/admin/projects/(?P<id>[^/]++)/deleteconfirm$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_projects_delete_confirm;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_projects_delete_confirm')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectController::deleteConfirmAction',));
                }
                not_admin_projects_delete_confirm:

                // admin_projects_delete
                if (preg_match('#^/admin/projects/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_admin_projects_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_projects_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectController::deleteAction',));
                }
                not_admin_projects_delete:

                // admin_project_files
                if (preg_match('#^/admin/projects/(?P<project_id>[^/]++)/files/?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_project_files;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'admin_project_files');
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_project_files')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectFileController::indexAction',));
                }
                not_admin_project_files:

                // admin_project_files_create
                if (preg_match('#^/admin/projects/(?P<project_id>[^/]++)/files/create$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_project_files_create;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_project_files_create')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectFileController::createAction',));
                }
                not_admin_project_files_create:

                // admin_project_files_delete
                if (preg_match('#^/admin/projects/(?P<project_id>[^/]++)/files/(?P<uuid>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_project_files_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_project_files_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\ProjectFileController::deleteAction',));
                }
                not_admin_project_files_delete:

            }

            if (0 === strpos($pathinfo, '/admin/se')) {
                // admin_security_token
                if ($pathinfo === '/admin/security/token') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_security_token;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\SecurityController::generateToken',  '_route' => 'admin_security_token',);
                }
                not_admin_security_token:

                if (0 === strpos($pathinfo, '/admin/settings')) {
                    // admin_settings
                    if ($pathinfo === '/admin/settings') {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_admin_settings;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\SettingsController::editAction',  '_route' => 'admin_settings',);
                    }
                    not_admin_settings:

                    // admin_settings_thumbnails
                    if ($pathinfo === '/admin/settings/thumbnails') {
                        if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                            goto not_admin_settings_thumbnails;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\SettingsController::thumbnailsAction',  '_route' => 'admin_settings_thumbnails',);
                    }
                    not_admin_settings_thumbnails:

                }

            }

            if (0 === strpos($pathinfo, '/admin/users')) {
                // admin_users
                if (rtrim($pathinfo, '/') === '/admin/users') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_users;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'admin_users');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::indexAction',  '_route' => 'admin_users',);
                }
                not_admin_users:

                if (0 === strpos($pathinfo, '/admin/users/create')) {
                    // admin_users_create
                    if ($pathinfo === '/admin/users/create') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_admin_users_create;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::createAction',  '_route' => 'admin_users_create',);
                    }
                    not_admin_users_create:

                    // admin_users_create_handler
                    if ($pathinfo === '/admin/users/create') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_admin_users_create_handler;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::createHandlerAction',  '_route' => 'admin_users_create_handler',);
                    }
                    not_admin_users_create_handler:

                }

                // admin_users_delete
                if (preg_match('#^/admin/users/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_admin_users_delete;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_users_delete')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::deleteAction',));
                }
                not_admin_users_delete:

                // admin_users_update
                if (preg_match('#^/admin/users/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_users_update;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_users_update')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::updateAction',));
                }
                not_admin_users_update:

                // admin_users_update_handler
                if (preg_match('#^/admin/users/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_admin_users_update_handler;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_users_update_handler')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::updateHandlerAction',));
                }
                not_admin_users_update_handler:

                // admin_users_toggle_lock
                if (preg_match('#^/admin/users/(?P<id>[^/]++)/togglelock$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_admin_users_toggle_lock;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_users_toggle_lock')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::toggleLockAction',));
                }
                not_admin_users_toggle_lock:

                // admin_users_toggle_enable
                if (preg_match('#^/admin/users/(?P<id>[^/]++)/toggleenable$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_admin_users_toggle_enable;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_users_toggle_enable')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::toggleEnableAction',));
                }
                not_admin_users_toggle_enable:

                // admin_users_change_password
                if (preg_match('#^/admin/users/(?P<id>[^/]++)/change_password$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_users_change_password;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_users_change_password')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::changePasswordAction',));
                }
                not_admin_users_change_password:

                // admin_users_change_password_handler
                if (preg_match('#^/admin/users/(?P<id>[^/]++)/change_password$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_admin_users_change_password_handler;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_users_change_password_handler')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserController::changePasswordHandlerAction',));
                }
                not_admin_users_change_password_handler:

                // admin_user_files
                if (preg_match('#^/admin/users/(?P<user_id>[^/]++)/files/?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_admin_user_files;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'admin_user_files');
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_user_files')), array (  '_controller' => 'AppBundle\\Controller\\Admin\\UserFileController::indexAction',));
                }
                not_admin_user_files:

            }

        }

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_homepage;
            }

            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\Frontend\\IndexController::indexAction',  '_route' => 'homepage',);
        }
        not_homepage:

        // get_dictionaries_full
        if ($pathinfo === '/api/dictionaries/full-tree') {
            return array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryController::getDictionariesFulltreeAction',  '_route' => 'get_dictionaries_full',);
        }

        // app_rest_users_postregister
        if ($pathinfo === '/register') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_app_rest_users_postregister;
            }

            return array (  '_controller' => 'AppBundle\\Controller\\Rest\\UsersController::postRegisterAction',  '_route' => 'app_rest_users_postregister',);
        }
        not_app_rest_users_postregister:

        if (0 === strpos($pathinfo, '/api')) {
            if (0 === strpos($pathinfo, '/api/projects')) {
                // remove_projects
                if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/remove$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_remove_projects;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'remove_projects')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectsController::removeProjectsAction',  '_format' => 'json',));
                }
                not_remove_projects:

                // get_projects
                if ($pathinfo === '/api/projects') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_projects;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectsController::getProjectsAction',  '_format' => 'json',  '_route' => 'get_projects',);
                }
                not_get_projects:

                // get_project
                if (preg_match('#^/api/projects/(?P<project_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_project;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_project')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectsController::getProjectAction',  '_format' => 'json',));
                }
                not_get_project:

                // post_projects
                if ($pathinfo === '/api/projects') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_post_projects;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectsController::postProjectsAction',  '_format' => 'json',  '_route' => 'post_projects',);
                }
                not_post_projects:

                // put_project
                if (preg_match('#^/api/projects/(?P<project_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_put_project;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_project')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectsController::putProjectAction',  '_format' => 'json',));
                }
                not_put_project:

                // put_project_files
                if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/files$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_put_project_files;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_project_files')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectsController::putProjectFilesAction',  '_format' => 'json',));
                }
                not_put_project_files:

                // delete_projects
                if (preg_match('#^/api/projects/(?P<project_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_delete_projects;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_projects')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectsController::deleteProjectsAction',  '_format' => 'json',));
                }
                not_delete_projects:

                // get_projects_files
                if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/files$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_projects_files;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_projects_files')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectFilesController::getFilesAction',  '_format' => 'json',));
                }
                not_get_projects_files:

                // project_reorder_units
                if (preg_match('#^/api/projects/(?P<project_id>\\d+)/reorder_units$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'project_reorder_units')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectUnitsController::reorderAction',  '_format' => 'json',));
                }

                // project_reorder_accessories
                if (preg_match('#^/api/projects/(?P<project_id>\\d+)/reorder_accessories$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'project_reorder_accessories')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectAccessoriesController::reorderAction',  '_format' => 'json',));
                }

            }

            if (0 === strpos($pathinfo, '/api/reorder_')) {
                // filling_types_reorder
                if ($pathinfo === '/api/reorder_fillingtypes') {
                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\FillingTypesController::reorderAction',  '_format' => 'json',  '_route' => 'filling_types_reorder',);
                }

                // profile_reorder
                if ($pathinfo === '/api/reorder_profiles') {
                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProfilesController::reorderAction',  '_format' => 'json',  '_route' => 'profile_reorder',);
                }

            }

            if (0 === strpos($pathinfo, '/api/pro')) {
                if (0 === strpos($pathinfo, '/api/projects')) {
                    // remove_projects_units
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/units/(?P<unit_id>[^/]++)/remove$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_remove_projects_units;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'remove_projects_units')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectUnitsController::removeUnitsAction',  '_format' => 'json',));
                    }
                    not_remove_projects_units:

                    // get_projects_units
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/units$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_projects_units;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_projects_units')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectUnitsController::getUnitsAction',  '_format' => 'json',));
                    }
                    not_get_projects_units:

                    // get_projects_unit
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/units/(?P<unit_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_projects_unit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_projects_unit')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectUnitsController::getUnitAction',  '_format' => 'json',));
                    }
                    not_get_projects_unit:

                    // post_projects_units
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/units$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_post_projects_units;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_projects_units')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectUnitsController::postUnitsAction',  '_format' => 'json',));
                    }
                    not_post_projects_units:

                    // put_projects_unit
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/units/(?P<unit_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_put_projects_unit;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_projects_unit')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectUnitsController::putUnitAction',  '_format' => 'json',));
                    }
                    not_put_projects_unit:

                    // delete_projects_units
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/units/(?P<unit_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_delete_projects_units;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_projects_units')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectUnitsController::deleteUnitsAction',  '_format' => 'json',));
                    }
                    not_delete_projects_units:

                    // post_projects_unit_options
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/units/(?P<unit_id>[^/]++)/options$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_post_projects_unit_options;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_projects_unit_options')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectUnitsController::postUnitOptionsAction',  '_format' => 'json',));
                    }
                    not_post_projects_unit_options:

                    // remove_projects_accessories
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/accessories/(?P<accessory_id>[^/]++)/remove$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_remove_projects_accessories;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'remove_projects_accessories')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectAccessoriesController::removeAccessoriesAction',  '_format' => 'json',));
                    }
                    not_remove_projects_accessories:

                    // reorder_projects
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/reorder$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PATCH') {
                            $allow[] = 'PATCH';
                            goto not_reorder_projects;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'reorder_projects')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectAccessoriesController::reorderAction',  '_format' => 'json',));
                    }
                    not_reorder_projects:

                    // get_projects_accessories
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/accessories$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_projects_accessories;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_projects_accessories')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectAccessoriesController::getAccessoriesAction',  '_format' => 'json',));
                    }
                    not_get_projects_accessories:

                    // get_projects_accessory
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/accessories/(?P<accessory_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_projects_accessory;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_projects_accessory')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectAccessoriesController::getAccessoryAction',  '_format' => 'json',));
                    }
                    not_get_projects_accessory:

                    // post_projects_accessories
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/accessories$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_post_projects_accessories;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_projects_accessories')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectAccessoriesController::postAccessoriesAction',  '_format' => 'json',));
                    }
                    not_post_projects_accessories:

                    // put_projects_accessory
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/accessories/(?P<accessory_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_put_projects_accessory;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_projects_accessory')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectAccessoriesController::putAccessoryAction',  '_format' => 'json',));
                    }
                    not_put_projects_accessory:

                    // delete_projects_accessories
                    if (preg_match('#^/api/projects/(?P<project_id>[^/]++)/accessories/(?P<accessory_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_delete_projects_accessories;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_projects_accessories')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProjectAccessoriesController::deleteAccessoriesAction',  '_format' => 'json',));
                    }
                    not_delete_projects_accessories:

                }

                if (0 === strpos($pathinfo, '/api/profiles')) {
                    // remove_profiles
                    if (preg_match('#^/api/profiles/(?P<profile_id>[^/]++)/remove$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_remove_profiles;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'remove_profiles')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProfilesController::removeProfilesAction',  '_format' => 'json',));
                    }
                    not_remove_profiles:

                    // get_profiles
                    if ($pathinfo === '/api/profiles') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_profiles;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProfilesController::getProfilesAction',  '_format' => 'json',  '_route' => 'get_profiles',);
                    }
                    not_get_profiles:

                    // get_profile
                    if (preg_match('#^/api/profiles/(?P<profile_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_get_profile;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_profile')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProfilesController::getProfileAction',  '_format' => 'json',));
                    }
                    not_get_profile:

                    // post_profiles
                    if ($pathinfo === '/api/profiles') {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_post_profiles;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProfilesController::postProfilesAction',  '_format' => 'json',  '_route' => 'post_profiles',);
                    }
                    not_post_profiles:

                    // put_profile
                    if (preg_match('#^/api/profiles/(?P<profile_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'PUT') {
                            $allow[] = 'PUT';
                            goto not_put_profile;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_profile')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProfilesController::putProfileAction',  '_format' => 'json',));
                    }
                    not_put_profile:

                    // delete_profiles
                    if (preg_match('#^/api/profiles/(?P<profile_id>[^/]++)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_delete_profiles;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_profiles')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\ProfilesController::deleteProfilesAction',  '_format' => 'json',));
                    }
                    not_delete_profiles:

                }

            }

            // dictionary_reorder
            if ($pathinfo === '/api/reorder_dictionaries') {
                return array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryController::reorderAction',  '_format' => 'json',  '_route' => 'dictionary_reorder',);
            }

            if (0 === strpos($pathinfo, '/api/dictionaries')) {
                // remove_dictionary
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)/remove$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_remove_dictionary;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'remove_dictionary')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryController::removeDictionaryAction',  '_format' => 'json',));
                }
                not_remove_dictionary:

                // post_dictionaries
                if ($pathinfo === '/api/dictionaries') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_post_dictionaries;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryController::postDictionariesAction',  '_format' => 'json',  '_route' => 'post_dictionaries',);
                }
                not_post_dictionaries:

                // put_dictionary
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_put_dictionary;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_dictionary')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryController::putDictionaryAction',  '_format' => 'json',));
                }
                not_put_dictionary:

                // get_dictionaries
                if ($pathinfo === '/api/dictionaries') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_dictionaries;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryController::getDictionariesAction',  '_format' => 'json',  '_route' => 'get_dictionaries',);
                }
                not_get_dictionaries:

                // get_dictionaries_fulltree
                if ($pathinfo === '/api/dictionaries/fulltree') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_dictionaries_fulltree;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryController::getDictionariesFulltreeAction',  '_format' => 'json',  '_route' => 'get_dictionaries_fulltree',);
                }
                not_get_dictionaries_fulltree:

                // get_dictionary
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_dictionary;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_dictionary')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryController::getDictionaryAction',  '_format' => 'json',));
                }
                not_get_dictionary:

                // delete_dictionary
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_delete_dictionary;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_dictionary')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryController::deleteDictionaryAction',  '_format' => 'json',));
                }
                not_delete_dictionary:

                // dictionary_reorder_entries
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)/reorder_entries$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'dictionary_reorder_entries')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryEntryController::reorderAction',  '_format' => 'json',));
                }

                // reorder_dictionary
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)/reorder$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PATCH') {
                        $allow[] = 'PATCH';
                        goto not_reorder_dictionary;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'reorder_dictionary')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryEntryController::reorderAction',  '_format' => 'json',));
                }
                not_reorder_dictionary:

                // get_dictionary_entries
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)/entries$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_dictionary_entries;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_dictionary_entries')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryEntryController::getEntriesAction',  '_format' => 'json',));
                }
                not_get_dictionary_entries:

                // get_dictionary_entry
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)/entries/(?P<entry_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_dictionary_entry;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_dictionary_entry')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryEntryController::getEntryAction',  '_format' => 'json',));
                }
                not_get_dictionary_entry:

                // post_dictionary_entries
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)/entries$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_post_dictionary_entries;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'post_dictionary_entries')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryEntryController::postEntriesAction',  '_format' => 'json',));
                }
                not_post_dictionary_entries:

                // put_dictionary_entry
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)/entries/(?P<entry_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_put_dictionary_entry;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_dictionary_entry')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryEntryController::putEntryAction',  '_format' => 'json',));
                }
                not_put_dictionary_entry:

                // delete_dictionary_entry
                if (preg_match('#^/api/dictionaries/(?P<dictionary_id>[^/]++)/entries/(?P<entry_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_delete_dictionary_entry;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_dictionary_entry')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\DictionaryEntryController::deleteEntryAction',  '_format' => 'json',));
                }
                not_delete_dictionary_entry:

            }

            // remove_fillingtypes
            if (0 === strpos($pathinfo, '/api/fillingtypes') && preg_match('#^/api/fillingtypes/(?P<filling_type_id>[^/]++)/remove$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_remove_fillingtypes;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'remove_fillingtypes')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FillingTypesController::removeFillingtypesAction',  '_format' => 'json',));
            }
            not_remove_fillingtypes:

            // reorder
            if ($pathinfo === '/api/reorder') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_reorder;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Rest\\FillingTypesController::reorderAction',  '_format' => 'json',  '_route' => 'reorder',);
            }
            not_reorder:

            if (0 === strpos($pathinfo, '/api/fillingtypes')) {
                // get_fillingtypes
                if ($pathinfo === '/api/fillingtypes') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_fillingtypes;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\FillingTypesController::getFillingtypesAction',  '_format' => 'json',  '_route' => 'get_fillingtypes',);
                }
                not_get_fillingtypes:

                // get_fillingtype
                if (preg_match('#^/api/fillingtypes/(?P<filling_type_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_fillingtype;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_fillingtype')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FillingTypesController::getFillingtypeAction',  '_format' => 'json',));
                }
                not_get_fillingtype:

                // post_fillingtypes
                if ($pathinfo === '/api/fillingtypes') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_post_fillingtypes;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\FillingTypesController::postFillingtypesAction',  '_format' => 'json',  '_route' => 'post_fillingtypes',);
                }
                not_post_fillingtypes:

                // put_fillingtype
                if (preg_match('#^/api/fillingtypes/(?P<filling_type_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_put_fillingtype;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_fillingtype')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FillingTypesController::putFillingtypeAction',  '_format' => 'json',));
                }
                not_put_fillingtype:

                // delete_fillingtypes
                if (preg_match('#^/api/fillingtypes/(?P<filling_type_id>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_delete_fillingtypes;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_fillingtypes')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FillingTypesController::deleteFillingtypesAction',  '_format' => 'json',));
                }
                not_delete_fillingtypes:

            }

            // get_users_current
            if ($pathinfo === '/api/users/current') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_get_users_current;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Rest\\UsersController::getUsersCurrentAction',  '_format' => 'json',  '_route' => 'get_users_current',);
            }
            not_get_users_current:

            // post_register
            if ($pathinfo === '/api/register') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_post_register;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\Rest\\UsersController::postRegisterAction',  '_format' => 'json',  '_route' => 'post_register',);
            }
            not_post_register:

            if (0 === strpos($pathinfo, '/api/files')) {
                // remove_files
                if (preg_match('#^/api/files/(?P<uuid>[^/]++)/remove$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_remove_files;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'remove_files')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FilesController::removeFilesAction',  '_format' => 'json',));
                }
                not_remove_files:

                // get_files
                if ($pathinfo === '/api/files') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_files;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\FilesController::getFilesAction',  '_format' => 'json',  '_route' => 'get_files',);
                }
                not_get_files:

                // get_file
                if (preg_match('#^/api/files/(?P<uuid>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_file;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_file')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FilesController::getFileAction',  '_format' => 'json',));
                }
                not_get_file:

                // put_file
                if (preg_match('#^/api/files/(?P<uuid>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'PUT') {
                        $allow[] = 'PUT';
                        goto not_put_file;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'put_file')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FilesController::putFileAction',  '_format' => 'json',));
                }
                not_put_file:

                // delete_files
                if (preg_match('#^/api/files/(?P<uuid>[^/]++)$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'DELETE') {
                        $allow[] = 'DELETE';
                        goto not_delete_files;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_files')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FilesController::deleteFilesAction',  '_format' => 'json',));
                }
                not_delete_files:

                // post_files
                if ($pathinfo === '/api/files') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_post_files;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\FilesController::postFilesAction',  '_format' => 'json',  '_route' => 'post_files',);
                }
                not_post_files:

                // post_files_handler
                if ($pathinfo === '/api/files/handlers') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_post_files_handler;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\Rest\\FilesController::postFilesHandlerAction',  '_format' => 'json',  '_route' => 'post_files_handler',);
                }
                not_post_files_handler:

                // get_files_download
                if (preg_match('#^/api/files/(?P<uuid>[^/]++)/download$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_files_download;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_files_download')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FilesController::getFilesDownloadAction',  '_format' => 'json',));
                }
                not_get_files_download:

                // get_files_thumbnail
                if (preg_match('#^/api/files/(?P<uuid>[^/]++)/thumbnail$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_get_files_thumbnail;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'get_files_thumbnail')), array (  '_controller' => 'AppBundle\\Controller\\Rest\\FilesController::getFilesThumbnailAction',  '_format' => 'json',));
                }
                not_get_files_thumbnail:

            }

            if (0 === strpos($pathinfo, '/api/pdf')) {
                // pdf_tools_split_n_merge
                if ($pathinfo === '/api/pdf/splitmerge') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_pdf_tools_split_n_merge;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PdfController::splitAndMergeAction',  '_route' => 'pdf_tools_split_n_merge',);
                }
                not_pdf_tools_split_n_merge:

                // pdf_tools_extract_table
                if ($pathinfo === '/api/pdf/exctracttable') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_pdf_tools_extract_table;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\PdfController::extractTableAction',  '_route' => 'pdf_tools_extract_table',);
                }
                not_pdf_tools_extract_table:

            }

        }

        // nelmio_api_doc_index
        if (0 === strpos($pathinfo, '/doc') && preg_match('#^/doc(?:/(?P<view>[^/]++))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_nelmio_api_doc_index;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'nelmio_api_doc_index')), array (  '_controller' => 'Nelmio\\ApiDocBundle\\Controller\\ApiDocController::indexAction',  'view' => 'default',));
        }
        not_nelmio_api_doc_index:

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // fos_user_security_login
                if ($pathinfo === '/login') {
                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::loginAction',  '_route' => 'fos_user_security_login',);
                }

                // fos_user_security_check
                if ($pathinfo === '/login_check') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_security_check;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::checkAction',  '_route' => 'fos_user_security_check',);
                }
                not_fos_user_security_check:

            }

            // fos_user_security_logout
            if ($pathinfo === '/logout') {
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\SecurityController::logoutAction',  '_route' => 'fos_user_security_logout',);
            }

        }

        if (0 === strpos($pathinfo, '/profile')) {
            // fos_user_profile_show
            if (rtrim($pathinfo, '/') === '/profile') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_fos_user_profile_show;
                }

                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fos_user_profile_show');
                }

                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::showAction',  '_route' => 'fos_user_profile_show',);
            }
            not_fos_user_profile_show:

            // fos_user_profile_edit
            if ($pathinfo === '/profile/edit') {
                return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ProfileController::editAction',  '_route' => 'fos_user_profile_edit',);
            }

        }

        if (0 === strpos($pathinfo, '/re')) {
            if (0 === strpos($pathinfo, '/register')) {
                // fos_user_registration_register
                if (rtrim($pathinfo, '/') === '/register') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'fos_user_registration_register');
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::registerAction',  '_route' => 'fos_user_registration_register',);
                }

                if (0 === strpos($pathinfo, '/register/c')) {
                    // fos_user_registration_check_email
                    if ($pathinfo === '/register/check-email') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_fos_user_registration_check_email;
                        }

                        return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::checkEmailAction',  '_route' => 'fos_user_registration_check_email',);
                    }
                    not_fos_user_registration_check_email:

                    if (0 === strpos($pathinfo, '/register/confirm')) {
                        // fos_user_registration_confirm
                        if (preg_match('#^/register/confirm/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirm;
                            }

                            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_registration_confirm')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmAction',));
                        }
                        not_fos_user_registration_confirm:

                        // fos_user_registration_confirmed
                        if ($pathinfo === '/register/confirmed') {
                            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                                $allow = array_merge($allow, array('GET', 'HEAD'));
                                goto not_fos_user_registration_confirmed;
                            }

                            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\RegistrationController::confirmedAction',  '_route' => 'fos_user_registration_confirmed',);
                        }
                        not_fos_user_registration_confirmed:

                    }

                }

            }

            if (0 === strpos($pathinfo, '/resetting')) {
                // fos_user_resetting_request
                if ($pathinfo === '/resetting/request') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_request;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::requestAction',  '_route' => 'fos_user_resetting_request',);
                }
                not_fos_user_resetting_request:

                // fos_user_resetting_send_email
                if ($pathinfo === '/resetting/send-email') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_fos_user_resetting_send_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::sendEmailAction',  '_route' => 'fos_user_resetting_send_email',);
                }
                not_fos_user_resetting_send_email:

                // fos_user_resetting_check_email
                if ($pathinfo === '/resetting/check-email') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_fos_user_resetting_check_email;
                    }

                    return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::checkEmailAction',  '_route' => 'fos_user_resetting_check_email',);
                }
                not_fos_user_resetting_check_email:

                // fos_user_resetting_reset
                if (0 === strpos($pathinfo, '/resetting/reset') && preg_match('#^/resetting/reset/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                        goto not_fos_user_resetting_reset;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'fos_user_resetting_reset')), array (  '_controller' => 'FOS\\UserBundle\\Controller\\ResettingController::resetAction',));
                }
                not_fos_user_resetting_reset:

            }

        }

        // fos_user_change_password
        if ($pathinfo === '/profile/change-password') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_user_change_password;
            }

            return array (  '_controller' => 'FOS\\UserBundle\\Controller\\ChangePasswordController::changePasswordAction',  '_route' => 'fos_user_change_password',);
        }
        not_fos_user_change_password:

        // api_login_check
        if ($pathinfo === '/api/login_check') {
            return array('_route' => 'api_login_check');
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
