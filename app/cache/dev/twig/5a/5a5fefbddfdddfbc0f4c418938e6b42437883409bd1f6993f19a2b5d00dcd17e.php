<?php

/* Admin/Backup/index.html.twig */
class __TwigTemplate_eb01f8fa24a63f90bce9424796246e4a08860dbb7cf36374434cff2f2b9faea5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate(":Admin:layout.html.twig", "Admin/Backup/index.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return ":Admin:layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_ef1bea39148885880495f065d7d98cbf0869719a38161e251607c49863706a06 = $this->env->getExtension("native_profiler");
        $__internal_ef1bea39148885880495f065d7d98cbf0869719a38161e251607c49863706a06->enter($__internal_ef1bea39148885880495f065d7d98cbf0869719a38161e251607c49863706a06_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "Admin/Backup/index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_ef1bea39148885880495f065d7d98cbf0869719a38161e251607c49863706a06->leave($__internal_ef1bea39148885880495f065d7d98cbf0869719a38161e251607c49863706a06_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_89afae23fdafae7df68b9407ccebc292b77a571780690d7921e5b6810c8f4c68 = $this->env->getExtension("native_profiler");
        $__internal_89afae23fdafae7df68b9407ccebc292b77a571780690d7921e5b6810c8f4c68->enter($__internal_89afae23fdafae7df68b9407ccebc292b77a571780690d7921e5b6810c8f4c68_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <div class=\"row\">
        <div class=\"col-lg-12\">
            <h1 class=\"page-header\">
                ";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("backup.title", array(), "AppBundle"), "html", null, true);
        echo " <small>";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("backup.description", array(), "AppBundle"), "html", null, true);
        echo "</small>
                <a class=\"btn pull-right\" href=\"";
        // line 8
        echo $this->env->getExtension('routing')->getPath("admin_backup_settings");
        echo "\"><i class=\"glyphicon glyphicon-cog\"></i> Settings</a>
            </h1>
        </div>
        <!-- /.col-lg-12 -->

        <div class=\"col-lg-12\">
            ";
        // line 14
        $this->loadTemplate("::_flash.html.twig", "Admin/Backup/index.html.twig", 14)->display($context);
        // line 15
        echo "        </div>
    </div>


    <!-- Backup section navigation -->
    <div class=\"row\">
        <ol class=\"breadcrumb\">
            <li class=\"active\"><i class=\"fa fa-database fa-fw\"></i> ";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("backup.title", array(), "AppBundle"), "html", null, true);
        echo "</li>
        </ol>
    </div><!-- /Backup section navigation -->

    <div class=\"row\">
        <div class=\"btn-group\" role=\"group\" aria-label=\"...\">
            <a class=\"btn btn-info\" href=\"";
        // line 28
        echo $this->env->getExtension('routing')->getPath("admin_backup_process");
        echo "\"><i class=\"fa fa-plus-circle fa-fw\"></i> Create backup</a>
        </div>
    </div>

    <div class=\"row\">
        <table class=\"table\">
            <caption>Backup list</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Backup</th>
                    <th>Size (in Bytes)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            ";
        // line 44
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["backup_files"]) ? $context["backup_files"] : $this->getContext($context, "backup_files")));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["file"]) {
            // line 45
            echo "                <tr>
                    <td>";
            // line 46
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "</td>
                    <td>";
            // line 47
            echo twig_escape_filter($this->env, $this->getAttribute($context["file"], "basename", array()), "html", null, true);
            echo "</td>
                    <td>";
            // line 48
            echo twig_escape_filter($this->env, $this->getAttribute($context["file"], "filesize", array()), "html", null, true);
            echo "</td>
                    <td>
                        <a class=\"btn btn-info btn-sm\" href=\"#\"
                           title=\"";
            // line 51
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("actions.download", array(), "AppBundle"), "html", null, true);
            echo " ";
            echo twig_escape_filter($this->env, $this->getAttribute($context["file"], "basename", array()), "html", null, true);
            echo "\">
                            <i class=\"glyphicon glyphicon-download\"></i>&nbsp;###";
            // line 52
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("actions.download", array(), "AppBundle"), "html", null, true);
            echo "
                        </a>
                        <a class=\"btn btn-success btn-sm\" href=\"#\">
                            <i class=\"glyphicon glyphicon-circle-arrow-up\"></i>&nbsp;###Restore
                        </a>

                        <a class=\"btn btn-danger btn-sm\" href=\"#\">
                            <i class=\"glyphicon glyphicon-remove\"></i>&nbsp;###";
            // line 59
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("actions.delete", array(), "AppBundle"), "html", null, true);
            echo "
                        </a>
                        <a class=\"btn btn-default btn-sm\" href=\"#\">
                            <i class=\"glyphicon glyphicon-send\"></i>&nbsp;###SendToGDrive
                        </a>
                    </td>
                </tr>
            ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['file'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 67
        echo "            </tbody>
        </table>
        <p>* Backup catalog: <strong>";
        // line 69
        echo twig_escape_filter($this->env, (isset($context["backup_catalog_path"]) ? $context["backup_catalog_path"] : $this->getContext($context, "backup_catalog_path")), "html", null, true);
        echo "</strong></p>
    </div>
";
        
        $__internal_89afae23fdafae7df68b9407ccebc292b77a571780690d7921e5b6810c8f4c68->leave($__internal_89afae23fdafae7df68b9407ccebc292b77a571780690d7921e5b6810c8f4c68_prof);

    }

    public function getTemplateName()
    {
        return "Admin/Backup/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  175 => 69,  171 => 67,  149 => 59,  139 => 52,  133 => 51,  127 => 48,  123 => 47,  119 => 46,  116 => 45,  99 => 44,  80 => 28,  71 => 22,  62 => 15,  60 => 14,  51 => 8,  45 => 7,  40 => 4,  34 => 3,  11 => 1,);
    }
}
/* {% extends ':Admin:layout.html.twig' %}*/
/* */
/* {% block content %}*/
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             <h1 class="page-header">*/
/*                 {{ 'backup.title' |trans({}, 'AppBundle') }} <small>{{ 'backup.description' |trans({}, 'AppBundle') }}</small>*/
/*                 <a class="btn pull-right" href="{{ path('admin_backup_settings') }}"><i class="glyphicon glyphicon-cog"></i> Settings</a>*/
/*             </h1>*/
/*         </div>*/
/*         <!-- /.col-lg-12 -->*/
/* */
/*         <div class="col-lg-12">*/
/*             {% include '::_flash.html.twig' %}*/
/*         </div>*/
/*     </div>*/
/* */
/* */
/*     <!-- Backup section navigation -->*/
/*     <div class="row">*/
/*         <ol class="breadcrumb">*/
/*             <li class="active"><i class="fa fa-database fa-fw"></i> {{ 'backup.title' |trans({}, 'AppBundle') }}</li>*/
/*         </ol>*/
/*     </div><!-- /Backup section navigation -->*/
/* */
/*     <div class="row">*/
/*         <div class="btn-group" role="group" aria-label="...">*/
/*             <a class="btn btn-info" href="{{ path('admin_backup_process') }}"><i class="fa fa-plus-circle fa-fw"></i> Create backup</a>*/
/*         </div>*/
/*     </div>*/
/* */
/*     <div class="row">*/
/*         <table class="table">*/
/*             <caption>Backup list</caption>*/
/*             <thead>*/
/*                 <tr>*/
/*                     <th>#</th>*/
/*                     <th>Backup</th>*/
/*                     <th>Size (in Bytes)</th>*/
/*                     <th>Actions</th>*/
/*                 </tr>*/
/*             </thead>*/
/*             <tbody>*/
/*             {% for file in backup_files %}*/
/*                 <tr>*/
/*                     <td>{{ loop.index }}</td>*/
/*                     <td>{{ file.basename }}</td>*/
/*                     <td>{{ file.filesize }}</td>*/
/*                     <td>*/
/*                         <a class="btn btn-info btn-sm" href="#"*/
/*                            title="{{ 'actions.download' |trans({}, 'AppBundle') }} {{ file.basename }}">*/
/*                             <i class="glyphicon glyphicon-download"></i>&nbsp;###{{ 'actions.download' |trans({}, 'AppBundle') }}*/
/*                         </a>*/
/*                         <a class="btn btn-success btn-sm" href="#">*/
/*                             <i class="glyphicon glyphicon-circle-arrow-up"></i>&nbsp;###Restore*/
/*                         </a>*/
/* */
/*                         <a class="btn btn-danger btn-sm" href="#">*/
/*                             <i class="glyphicon glyphicon-remove"></i>&nbsp;###{{ 'actions.delete' |trans({}, 'AppBundle') }}*/
/*                         </a>*/
/*                         <a class="btn btn-default btn-sm" href="#">*/
/*                             <i class="glyphicon glyphicon-send"></i>&nbsp;###SendToGDrive*/
/*                         </a>*/
/*                     </td>*/
/*                 </tr>*/
/*             {% endfor %}*/
/*             </tbody>*/
/*         </table>*/
/*         <p>* Backup catalog: <strong>{{ backup_catalog_path }}</strong></p>*/
/*     </div>*/
/* {% endblock %}*/
/* */
