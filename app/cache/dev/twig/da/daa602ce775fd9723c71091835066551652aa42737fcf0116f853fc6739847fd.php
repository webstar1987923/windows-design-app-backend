<?php

/* Admin/Backup/settings.html.twig */
class __TwigTemplate_78d814b37992c55b68ee5ff98e7e6278d7ea30d750ab17e9a64f79896e7ab7d3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate(":Admin:layout.html.twig", "Admin/Backup/settings.html.twig", 1);
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
        $__internal_31790c8321e95317ac9fa3e43269a595db96fb03296f500800fe387be22311b3 = $this->env->getExtension("native_profiler");
        $__internal_31790c8321e95317ac9fa3e43269a595db96fb03296f500800fe387be22311b3->enter($__internal_31790c8321e95317ac9fa3e43269a595db96fb03296f500800fe387be22311b3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "Admin/Backup/settings.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_31790c8321e95317ac9fa3e43269a595db96fb03296f500800fe387be22311b3->leave($__internal_31790c8321e95317ac9fa3e43269a595db96fb03296f500800fe387be22311b3_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_ed5a01348610248d628f5bc0a4a28c3ffdc725916a7703a0a3fec7326584066a = $this->env->getExtension("native_profiler");
        $__internal_ed5a01348610248d628f5bc0a4a28c3ffdc725916a7703a0a3fec7326584066a->enter($__internal_ed5a01348610248d628f5bc0a4a28c3ffdc725916a7703a0a3fec7326584066a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <div class=\"row\">
        <div class=\"col-lg-12\">
            <h1 class=\"page-header\">";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("backup.title", array(), "AppBundle"), "html", null, true);
        echo " <small>";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("backup.description", array(), "AppBundle"), "html", null, true);
        echo "</small></h1>
        </div>
        <!-- /.col-lg-12 -->

        <div class=\"col-lg-12\">
            ";
        // line 11
        $this->loadTemplate("::_flash.html.twig", "Admin/Backup/settings.html.twig", 11)->display($context);
        // line 12
        echo "        </div>
    </div>

    <!-- Backup section navigation -->
    <div class=\"row\">
        <div class=\"col-lg-12\">
            <ol class=\"breadcrumb\">
                <li><a href=\"";
        // line 19
        echo $this->env->getExtension('routing')->getPath("admin_backup");
        echo "\" title=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("backup.description", array(), "AppBundle"), "html", null, true);
        echo "\"><i class=\"fa fa-database fa-fw\"></i> ";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("backup.title", array(), "AppBundle"), "html", null, true);
        echo "</a></li>
                <li class=\"active\">Settings</li>
            </ol>
        </div>
    </div><!-- /Backup section navigation -->

    <div class=\"row\">
        ";
        // line 26
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "
    </div>
";
        
        $__internal_ed5a01348610248d628f5bc0a4a28c3ffdc725916a7703a0a3fec7326584066a->leave($__internal_ed5a01348610248d628f5bc0a4a28c3ffdc725916a7703a0a3fec7326584066a_prof);

    }

    public function getTemplateName()
    {
        return "Admin/Backup/settings.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  79 => 26,  65 => 19,  56 => 12,  54 => 11,  44 => 6,  40 => 4,  34 => 3,  11 => 1,);
    }
}
/* {% extends ':Admin:layout.html.twig' %}*/
/* */
/* {% block content %}*/
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             <h1 class="page-header">{{ 'backup.title' |trans({}, 'AppBundle') }} <small>{{ 'backup.description' |trans({}, 'AppBundle') }}</small></h1>*/
/*         </div>*/
/*         <!-- /.col-lg-12 -->*/
/* */
/*         <div class="col-lg-12">*/
/*             {% include '::_flash.html.twig' %}*/
/*         </div>*/
/*     </div>*/
/* */
/*     <!-- Backup section navigation -->*/
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             <ol class="breadcrumb">*/
/*                 <li><a href="{{ path('admin_backup') }}" title="{{ 'backup.description' |trans({}, 'AppBundle') }}"><i class="fa fa-database fa-fw"></i> {{ 'backup.title' |trans({}, 'AppBundle') }}</a></li>*/
/*                 <li class="active">Settings</li>*/
/*             </ol>*/
/*         </div>*/
/*     </div><!-- /Backup section navigation -->*/
/* */
/*     <div class="row">*/
/*         {{ form(form) }}*/
/*     </div>*/
/* {% endblock %}*/
/* */
