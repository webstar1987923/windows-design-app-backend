<?php

/* :Admin/include:nav.html.twig */
class __TwigTemplate_b653b790b15fd2c6c500a889bccae8750cfd8de19067ae3d32a2f700d3f7563b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_10480b73d3776109d30470d4a396b8a53a7a783126af94d756473a0412aea95b = $this->env->getExtension("native_profiler");
        $__internal_10480b73d3776109d30470d4a396b8a53a7a783126af94d756473a0412aea95b->enter($__internal_10480b73d3776109d30470d4a396b8a53a7a783126af94d756473a0412aea95b_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Admin/include:nav.html.twig"));

        // line 1
        echo "<!-- Navigation -->
<nav class=\"navbar navbar-default navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">
    <div class=\"navbar-header\">
        <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
            <span class=\"sr-only\">Toggle navigation</span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
            <span class=\"icon-bar\"></span>
        </button>
        <a class=\"navbar-brand\" href=\"";
        // line 10
        echo $this->env->getExtension('routing')->getPath("admin_home");
        echo "\">Prossimo
            <small>administration</small>
        </a>
    </div>
    <!-- /.navbar-header -->

    <ul class=\"nav navbar-top-links navbar-left\">
        <li>
            <a href=\"http://app.prossimo.us/\">
                <i class=\"fa fa-bolt fa-fw\"></i> ProssimoAPP
            </a>
        </li>
    </ul>

    <ul class=\"nav navbar-top-links navbar-right\">
        <li class=\"dropdown\">
            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
                <i class=\"fa fa-bell fa-fw\"></i> <i class=\"fa fa-caret-down\"></i>
            </a>
            <ul class=\"dropdown-menu dropdown-alerts\">
                <li>
                    <a href=\"#\">
                        <div>
                            <i class=\"fa fa-user fa-fw\"></i> 3 New customers
                            <span class=\"pull-right text-muted small\">12 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class=\"divider\"></li>
                <li>
                    <a href=\"#\">
                        <div>
                            <i class=\"fa fa-tasks fa-fw\"></i> New Task
                            <span class=\"pull-right text-muted small\">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class=\"divider\"></li>
                <li>
                    <a class=\"text-center\" href=\"#\">
                        <strong>All appointments</strong>
                        <i class=\"fa fa-angle-right\"></i>
                    </a>
                </li>
            </ul>
            <!-- /.dropdown-alerts -->
        </li>
        <!-- /.dropdown -->
        <li class=\"dropdown\">
            <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">
                <i class=\"fa fa-user fa-fw\"></i> <i class=\"fa fa-caret-down\"></i>
            </a>
            <ul class=\"dropdown-menu dropdown-user\">
                <li><a href=\"";
        // line 63
        echo $this->env->getExtension('routing')->getPath("fos_user_profile_show");
        echo "\"><i class=\"fa fa-user fa-fw\"></i> User Profile</a>
                </li>
                <li><a href=\"";
        // line 65
        echo $this->env->getExtension('routing')->getPath("admin_settings");
        echo "\"><i class=\"fa fa-gear fa-fw\"></i> Settings</a>
                </li>
                <li class=\"divider\"></li>
                <li><a href=\"";
        // line 68
        echo $this->env->getExtension('routing')->getPath("fos_user_security_logout");
        echo "\"><i class=\"fa fa-sign-out fa-fw\"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class=\"navbar-default sidebar\" role=\"navigation\">
        <div class=\"sidebar-nav navbar-collapse\">
            <ul class=\"nav\" id=\"side-menu\">

                <li>
                    <a href=\"";
        // line 82
        echo $this->env->getExtension('routing')->getPath("admin_dashboard");
        echo "\" title=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("dashboard.description", array(), "AppBundle"), "html", null, true);
        echo "\"><i class=\"fa fa-dashboard fa-fw\"></i> ";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("dashboard.title", array(), "AppBundle"), "html", null, true);
        echo "</a>
                </li>

                <li>
                    <a href=\"#\"><i class=\"fa fa-wrench fa-fw\"></i> Objects<span class=\"fa arrow\"></span></a>
                    <ul class=\"nav nav-second-level\">
                        <li>
                            <a href=\"";
        // line 89
        echo $this->env->getExtension('routing')->getPath("admin_projects");
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.title", array(), "Entities"), "html", null, true);
        echo "</a>
                        </li>
                        <li>
                            <a href=\"";
        // line 92
        echo $this->env->getExtension('routing')->getPath("admin_users");
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("user.title", array(), "Entities"), "html", null, true);
        echo "</a>
                        </li>
                        <li>
                            <a href=\"";
        // line 95
        echo $this->env->getExtension('routing')->getPath("admin_files");
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("admin_files.title", array(), "AppBundle"), "html", null, true);
        echo "</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li>
                    <a href=\"#\"><i class=\"fa fa-gear fa-fw\"></i> Settings<span class=\"fa arrow\"></span></a>
                    <ul class=\"nav nav-second-level\">
                        <li>
                            <a href=\"";
        // line 105
        echo $this->env->getExtension('routing')->getPath("admin_settings_thumbnails");
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("setting.pages.thumbnails", array(), "AppBundle"), "html", null, true);
        echo "</a>
                        </li>
                        <li>
                            <a href=\"";
        // line 108
        echo $this->env->getExtension('routing')->getPath("admin_backup_settings");
        echo "\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("setting.pages.backups", array(), "AppBundle"), "html", null, true);
        echo "</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                ";
        // line 115
        echo "                ";
        // line 116
        echo "                ";
        // line 117
        echo "
                <li>
                    <a href=\"";
        // line 119
        echo $this->env->getExtension('routing')->getPath("admin_backup");
        echo "\" title=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("backup.description", array(), "AppBundle"), "html", null, true);
        echo "\"><i class=\"fa fa-database fa-fw\"></i> ";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("backup.title", array(), "AppBundle"), "html", null, true);
        echo "</a>
                </li>

                <li>
                    <a href=\"";
        // line 123
        echo $this->env->getExtension('routing')->getPath("nelmio_api_doc_index");
        echo "\" target=\"_blank\" title=\"API Documentation page. Will be opened in the new window\"><i class=\"fa fa-file-text fa-fw\"></i> API Documentation <i class=\"fa fa-external-link fa-fw\"></i></a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
";
        
        $__internal_10480b73d3776109d30470d4a396b8a53a7a783126af94d756473a0412aea95b->leave($__internal_10480b73d3776109d30470d4a396b8a53a7a783126af94d756473a0412aea95b_prof);

    }

    public function getTemplateName()
    {
        return ":Admin/include:nav.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  200 => 123,  189 => 119,  185 => 117,  183 => 116,  181 => 115,  170 => 108,  162 => 105,  147 => 95,  139 => 92,  131 => 89,  117 => 82,  100 => 68,  94 => 65,  89 => 63,  33 => 10,  22 => 1,);
    }
}
/* <!-- Navigation -->*/
/* <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">*/
/*     <div class="navbar-header">*/
/*         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">*/
/*             <span class="sr-only">Toggle navigation</span>*/
/*             <span class="icon-bar"></span>*/
/*             <span class="icon-bar"></span>*/
/*             <span class="icon-bar"></span>*/
/*         </button>*/
/*         <a class="navbar-brand" href="{{ path('admin_home') }}">Prossimo*/
/*             <small>administration</small>*/
/*         </a>*/
/*     </div>*/
/*     <!-- /.navbar-header -->*/
/* */
/*     <ul class="nav navbar-top-links navbar-left">*/
/*         <li>*/
/*             <a href="http://app.prossimo.us/">*/
/*                 <i class="fa fa-bolt fa-fw"></i> ProssimoAPP*/
/*             </a>*/
/*         </li>*/
/*     </ul>*/
/* */
/*     <ul class="nav navbar-top-links navbar-right">*/
/*         <li class="dropdown">*/
/*             <a class="dropdown-toggle" data-toggle="dropdown" href="#">*/
/*                 <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>*/
/*             </a>*/
/*             <ul class="dropdown-menu dropdown-alerts">*/
/*                 <li>*/
/*                     <a href="#">*/
/*                         <div>*/
/*                             <i class="fa fa-user fa-fw"></i> 3 New customers*/
/*                             <span class="pull-right text-muted small">12 minutes ago</span>*/
/*                         </div>*/
/*                     </a>*/
/*                 </li>*/
/*                 <li class="divider"></li>*/
/*                 <li>*/
/*                     <a href="#">*/
/*                         <div>*/
/*                             <i class="fa fa-tasks fa-fw"></i> New Task*/
/*                             <span class="pull-right text-muted small">4 minutes ago</span>*/
/*                         </div>*/
/*                     </a>*/
/*                 </li>*/
/*                 <li class="divider"></li>*/
/*                 <li>*/
/*                     <a class="text-center" href="#">*/
/*                         <strong>All appointments</strong>*/
/*                         <i class="fa fa-angle-right"></i>*/
/*                     </a>*/
/*                 </li>*/
/*             </ul>*/
/*             <!-- /.dropdown-alerts -->*/
/*         </li>*/
/*         <!-- /.dropdown -->*/
/*         <li class="dropdown">*/
/*             <a class="dropdown-toggle" data-toggle="dropdown" href="#">*/
/*                 <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>*/
/*             </a>*/
/*             <ul class="dropdown-menu dropdown-user">*/
/*                 <li><a href="{{ path("fos_user_profile_show") }}"><i class="fa fa-user fa-fw"></i> User Profile</a>*/
/*                 </li>*/
/*                 <li><a href="{{ path("admin_settings") }}"><i class="fa fa-gear fa-fw"></i> Settings</a>*/
/*                 </li>*/
/*                 <li class="divider"></li>*/
/*                 <li><a href="{{ path("fos_user_security_logout") }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>*/
/*                 </li>*/
/*             </ul>*/
/*             <!-- /.dropdown-user -->*/
/*         </li>*/
/*         <!-- /.dropdown -->*/
/*     </ul>*/
/*     <!-- /.navbar-top-links -->*/
/* */
/*     <div class="navbar-default sidebar" role="navigation">*/
/*         <div class="sidebar-nav navbar-collapse">*/
/*             <ul class="nav" id="side-menu">*/
/* */
/*                 <li>*/
/*                     <a href="{{ path('admin_dashboard') }}" title="{{ 'dashboard.description' |trans({}, 'AppBundle') }}"><i class="fa fa-dashboard fa-fw"></i> {{ 'dashboard.title' |trans({}, 'AppBundle') }}</a>*/
/*                 </li>*/
/* */
/*                 <li>*/
/*                     <a href="#"><i class="fa fa-wrench fa-fw"></i> Objects<span class="fa arrow"></span></a>*/
/*                     <ul class="nav nav-second-level">*/
/*                         <li>*/
/*                             <a href="{{ path('admin_projects') }}">{{ 'projects.title' |trans({}, 'Entities') }}</a>*/
/*                         </li>*/
/*                         <li>*/
/*                             <a href="{{ path('admin_users') }}">{{ 'user.title' |trans({}, 'Entities') }}</a>*/
/*                         </li>*/
/*                         <li>*/
/*                             <a href="{{ path('admin_files') }}">{{ 'admin_files.title' |trans({}, 'AppBundle') }}</a>*/
/*                         </li>*/
/*                     </ul>*/
/*                     <!-- /.nav-second-level -->*/
/*                 </li>*/
/* */
/*                 <li>*/
/*                     <a href="#"><i class="fa fa-gear fa-fw"></i> Settings<span class="fa arrow"></span></a>*/
/*                     <ul class="nav nav-second-level">*/
/*                         <li>*/
/*                             <a href="{{ path('admin_settings_thumbnails') }}">{{ 'setting.pages.thumbnails' |trans({}, 'AppBundle') }}</a>*/
/*                         </li>*/
/*                         <li>*/
/*                             <a href="{{ path('admin_backup_settings') }}">{{ 'setting.pages.backups' |trans({}, 'AppBundle') }}</a>*/
/*                         </li>*/
/*                     </ul>*/
/*                     <!-- /.nav-second-level -->*/
/*                 </li>*/
/* */
/*                 {#<li>#}*/
/*                 {#<a href="{{ path('admin_settings') }}" title="{{ 'setting.description' |trans({}, 'AppBundle') }}"><i class="fa fa-gear fa-fw"></i> {{ 'setting.title' |trans({}, 'AppBundle') }}</a>#}*/
/*                 {#</li>#}*/
/* */
/*                 <li>*/
/*                     <a href="{{ path('admin_backup') }}" title="{{ 'backup.description' |trans({}, 'AppBundle') }}"><i class="fa fa-database fa-fw"></i> {{ 'backup.title' |trans({}, 'AppBundle') }}</a>*/
/*                 </li>*/
/* */
/*                 <li>*/
/*                     <a href="{{ path("nelmio_api_doc_index") }}" target="_blank" title="API Documentation page. Will be opened in the new window"><i class="fa fa-file-text fa-fw"></i> API Documentation <i class="fa fa-external-link fa-fw"></i></a>*/
/*                 </li>*/
/*             </ul>*/
/*         </div>*/
/*         <!-- /.sidebar-collapse -->*/
/*     </div>*/
/*     <!-- /.navbar-static-side -->*/
/* </nav>*/
/* */
