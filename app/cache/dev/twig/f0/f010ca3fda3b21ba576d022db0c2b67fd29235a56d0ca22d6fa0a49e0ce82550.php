<?php

/* Admin/Dashboard/index.html.twig */
class __TwigTemplate_51e7e9f8e0b643469b6ac41ffe2436c98a1469f6acb7409c0221c817097b16e0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("Admin/layout.html.twig", "Admin/Dashboard/index.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "Admin/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_de4b3d22b172ca79500b1ce5a72054d096c308dc804d67aeff97b589692a4af2 = $this->env->getExtension("native_profiler");
        $__internal_de4b3d22b172ca79500b1ce5a72054d096c308dc804d67aeff97b589692a4af2->enter($__internal_de4b3d22b172ca79500b1ce5a72054d096c308dc804d67aeff97b589692a4af2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "Admin/Dashboard/index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_de4b3d22b172ca79500b1ce5a72054d096c308dc804d67aeff97b589692a4af2->leave($__internal_de4b3d22b172ca79500b1ce5a72054d096c308dc804d67aeff97b589692a4af2_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_8c54e150fa1fd11f1c9bdbc8ae5b6136045e52483aeebf3fd8547b0f9f6f3a14 = $this->env->getExtension("native_profiler");
        $__internal_8c54e150fa1fd11f1c9bdbc8ae5b6136045e52483aeebf3fd8547b0f9f6f3a14->enter($__internal_8c54e150fa1fd11f1c9bdbc8ae5b6136045e52483aeebf3fd8547b0f9f6f3a14_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <div class=\"row\">
        <div class=\"col-lg-12\">
            <h1 class=\"page-header\">Dashboard <small>Control panel</small></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class=\"row\">
        <div class=\"col-lg-4 col-md-6\">
            ";
        // line 13
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("AppBundle:Admin\\Dashboard:dashboardProjects", array("max" => 5)));
        // line 16
        echo "
        </div>
    </div>

    <div class=\"row\">
        <div class=\"col-lg-4 col-md-6\">
            ";
        // line 22
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("AppBundle:Admin\\Dashboard:dashboardUsers", array("max" => 5)));
        // line 25
        echo "
        </div>

        <div class=\"col-lg-4 col-md-6\">
            ";
        // line 29
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("AppBundle:Admin\\Dashboard:dashboardFiles", array("max" => 5)));
        // line 32
        echo "
        </div>
    </div>

    <div class=\"row\">
        <div class=\"col-lg-4 col-md-6\">
            ";
        // line 38
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("AppBundle:Admin\\Dashboard:dashboardBackups", array("max" => 5)));
        // line 41
        echo "
        </div>
    </div>
";
        
        $__internal_8c54e150fa1fd11f1c9bdbc8ae5b6136045e52483aeebf3fd8547b0f9f6f3a14->leave($__internal_8c54e150fa1fd11f1c9bdbc8ae5b6136045e52483aeebf3fd8547b0f9f6f3a14_prof);

    }

    public function getTemplateName()
    {
        return "Admin/Dashboard/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 41,  79 => 38,  71 => 32,  69 => 29,  63 => 25,  61 => 22,  53 => 16,  51 => 13,  40 => 4,  34 => 3,  11 => 1,);
    }
}
/* {% extends 'Admin/layout.html.twig' %}*/
/* */
/* {% block content %}*/
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             <h1 class="page-header">Dashboard <small>Control panel</small></h1>*/
/*         </div>*/
/*         <!-- /.col-lg-12 -->*/
/*     </div>*/
/* */
/*     <div class="row">*/
/*         <div class="col-lg-4 col-md-6">*/
/*             {{ render(controller(*/
/*             'AppBundle:Admin\\Dashboard:dashboardProjects',*/
/*             { 'max': 5 }*/
/*             )) }}*/
/*         </div>*/
/*     </div>*/
/* */
/*     <div class="row">*/
/*         <div class="col-lg-4 col-md-6">*/
/*             {{ render(controller(*/
/*             'AppBundle:Admin\\Dashboard:dashboardUsers',*/
/*             { 'max': 5 }*/
/*             )) }}*/
/*         </div>*/
/* */
/*         <div class="col-lg-4 col-md-6">*/
/*             {{ render(controller(*/
/*             'AppBundle:Admin\\Dashboard:dashboardFiles',*/
/*             { 'max': 5 }*/
/*             )) }}*/
/*         </div>*/
/*     </div>*/
/* */
/*     <div class="row">*/
/*         <div class="col-lg-4 col-md-6">*/
/*             {{ render(controller(*/
/*             'AppBundle:Admin\\Dashboard:dashboardBackups',*/
/*             { 'max': 5 }*/
/*             )) }}*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
/* */
