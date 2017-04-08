<?php

/* :Admin/Dashboard/Widgets:projects.widget.html.twig */
class __TwigTemplate_d146e1ca65a01521c377ee9fe0aa5bb50719ee0ca25633faa2654c1fd6ad21dd extends Twig_Template
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
        $__internal_5be78b0f1374250dfaf0e70f6ca2b797da12c3d721f97fc60735db919ed6bd3e = $this->env->getExtension("native_profiler");
        $__internal_5be78b0f1374250dfaf0e70f6ca2b797da12c3d721f97fc60735db919ed6bd3e->enter($__internal_5be78b0f1374250dfaf0e70f6ca2b797da12c3d721f97fc60735db919ed6bd3e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Admin/Dashboard/Widgets:projects.widget.html.twig"));

        // line 1
        echo "<div class=\"panel panel-green\">
    <div class=\"panel-heading\">
        <div class=\"row\">
            <div class=\"col-xs-3\">
                <i class=\"fa fa-suitcase fa-5x\"></i>
            </div>
            <div class=\"col-xs-9 text-right\">
                <div class=\"huge\">Projects</div>
                <div>Total projects count: ";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["view_model"]) ? $context["view_model"] : $this->getContext($context, "view_model")), "projects_count", array()), "html", null, true);
        echo "</div>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-xs-12\">
                <a href=\"";
        // line 14
        echo $this->env->getExtension('routing')->getPath("admin_projects_create");
        echo "\" style=\"color: #FFF;\" title=\"Create new project\"><i class=\"fa fa-plus\"></i> ";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.pages.create", array(), "AppBundle"), "html", null, true);
        echo "</a>
            </div>
        </div>
    </div>
    <a href=\"";
        // line 18
        echo $this->env->getExtension('routing')->getPath("admin_projects");
        echo "\">
        <div class=\"panel-footer\">
            <span class=\"pull-left\">All projects</span>
            <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
            <div class=\"clearfix\"></div>
        </div>
    </a>
</div>
";
        
        $__internal_5be78b0f1374250dfaf0e70f6ca2b797da12c3d721f97fc60735db919ed6bd3e->leave($__internal_5be78b0f1374250dfaf0e70f6ca2b797da12c3d721f97fc60735db919ed6bd3e_prof);

    }

    public function getTemplateName()
    {
        return ":Admin/Dashboard/Widgets:projects.widget.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 18,  40 => 14,  32 => 9,  22 => 1,);
    }
}
/* <div class="panel panel-green">*/
/*     <div class="panel-heading">*/
/*         <div class="row">*/
/*             <div class="col-xs-3">*/
/*                 <i class="fa fa-suitcase fa-5x"></i>*/
/*             </div>*/
/*             <div class="col-xs-9 text-right">*/
/*                 <div class="huge">Projects</div>*/
/*                 <div>Total projects count: {{ view_model.projects_count }}</div>*/
/*             </div>*/
/*         </div>*/
/*         <div class="row">*/
/*             <div class="col-xs-12">*/
/*                 <a href="{{ path('admin_projects_create') }}" style="color: #FFF;" title="Create new project"><i class="fa fa-plus"></i> {{ 'projects.pages.create'|trans({}, 'AppBundle') }}</a>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/*     <a href="{{ path('admin_projects') }}">*/
/*         <div class="panel-footer">*/
/*             <span class="pull-left">All projects</span>*/
/*             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>*/
/*             <div class="clearfix"></div>*/
/*         </div>*/
/*     </a>*/
/* </div>*/
/* */
