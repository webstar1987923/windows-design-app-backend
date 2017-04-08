<?php

/* :Admin/Dashboard/Widgets:users.widget.html.twig */
class __TwigTemplate_c933c988e6a163618515b4aa08e7ec49cffa888bec780526986fadbc9cfcaa5e extends Twig_Template
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
        $__internal_c92458a0d67a452c85d96d3431803a9fa6c507aa591742ff922da6d26fd53ae0 = $this->env->getExtension("native_profiler");
        $__internal_c92458a0d67a452c85d96d3431803a9fa6c507aa591742ff922da6d26fd53ae0->enter($__internal_c92458a0d67a452c85d96d3431803a9fa6c507aa591742ff922da6d26fd53ae0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Admin/Dashboard/Widgets:users.widget.html.twig"));

        // line 1
        echo "<div class=\"panel panel-default\">
    <div class=\"panel-heading\">
        <div class=\"row\">
            <div class=\"col-xs-3\">
                <i class=\"fa fa-user fa-5x\"></i>
            </div>
            <div class=\"col-xs-9 text-right\">
                <div class=\"huge\">Users</div>
                <div>Total users count: ";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["view_model"]) ? $context["view_model"] : $this->getContext($context, "view_model")), "users_count", array()), "html", null, true);
        echo "</div>
            </div>
        </div>
    </div>
    <a href=\"";
        // line 13
        echo $this->env->getExtension('routing')->getPath("admin_users");
        echo "\">
        <div class=\"panel-footer\">
            <span class=\"pull-left\">All users</span>
            <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
            <div class=\"clearfix\"></div>
        </div>
    </a>
</div>
";
        
        $__internal_c92458a0d67a452c85d96d3431803a9fa6c507aa591742ff922da6d26fd53ae0->leave($__internal_c92458a0d67a452c85d96d3431803a9fa6c507aa591742ff922da6d26fd53ae0_prof);

    }

    public function getTemplateName()
    {
        return ":Admin/Dashboard/Widgets:users.widget.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 13,  32 => 9,  22 => 1,);
    }
}
/* <div class="panel panel-default">*/
/*     <div class="panel-heading">*/
/*         <div class="row">*/
/*             <div class="col-xs-3">*/
/*                 <i class="fa fa-user fa-5x"></i>*/
/*             </div>*/
/*             <div class="col-xs-9 text-right">*/
/*                 <div class="huge">Users</div>*/
/*                 <div>Total users count: {{ view_model.users_count }}</div>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/*     <a href="{{ path('admin_users') }}">*/
/*         <div class="panel-footer">*/
/*             <span class="pull-left">All users</span>*/
/*             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>*/
/*             <div class="clearfix"></div>*/
/*         </div>*/
/*     </a>*/
/* </div>*/
/* */
