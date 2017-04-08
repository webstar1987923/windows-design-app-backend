<?php

/* :Admin/Dashboard/Widgets:backups.widget.html.twig */
class __TwigTemplate_2e9ae4d348d5796f19938178a6b7f2306b43c9f19f0fb2d25dcd951b8fadb487 extends Twig_Template
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
        $__internal_8330ff40f82d15bfdb647cd069f12635df5c1b7cdcb380d0a0949ef27f5257de = $this->env->getExtension("native_profiler");
        $__internal_8330ff40f82d15bfdb647cd069f12635df5c1b7cdcb380d0a0949ef27f5257de->enter($__internal_8330ff40f82d15bfdb647cd069f12635df5c1b7cdcb380d0a0949ef27f5257de_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Admin/Dashboard/Widgets:backups.widget.html.twig"));

        // line 1
        echo "<div class=\"panel panel-primary\">
    <div class=\"panel-heading\">
        <div class=\"row\">
            <div class=\"col-xs-3\">
                <i class=\"fa fa-database fa-5x\"></i>
            </div>
            <div class=\"col-xs-9 text-right\">
                <div class=\"huge\">Backups</div>
                <div>Backups count: ";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["view_model"]) ? $context["view_model"] : $this->getContext($context, "view_model")), "backups_count", array()), "html", null, true);
        echo " (#TODO)</div>
                <div>Last backup date: ";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["view_model"]) ? $context["view_model"] : $this->getContext($context, "view_model")), "backups_last_date", array()), "html", null, true);
        echo " (#TODO)</div>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-xs-12\">
                <a href=\"";
        // line 15
        echo $this->env->getExtension('routing')->getPath("admin_backup_process");
        echo "\" style=\"color: #FFF;\" title=\"Create backup\"><i class=\"fa fa-plus\"></i>  Create backup</a><br />
                <a href=\"#\" style=\"color: #FFF;\" title=\"Download latest backup file\"><i class=\"fa fa-download\"></i> Download latest (#TODO)</a>
            </div>
        </div>
    </div>
    <a href=\"";
        // line 20
        echo $this->env->getExtension('routing')->getPath("admin_backup");
        echo "\">
        <div class=\"panel-footer\">
            <span class=\"pull-left\">All backups</span>
            <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
            <div class=\"clearfix\"></div>
        </div>
    </a>
</div>
";
        
        $__internal_8330ff40f82d15bfdb647cd069f12635df5c1b7cdcb380d0a0949ef27f5257de->leave($__internal_8330ff40f82d15bfdb647cd069f12635df5c1b7cdcb380d0a0949ef27f5257de_prof);

    }

    public function getTemplateName()
    {
        return ":Admin/Dashboard/Widgets:backups.widget.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 20,  44 => 15,  36 => 10,  32 => 9,  22 => 1,);
    }
}
/* <div class="panel panel-primary">*/
/*     <div class="panel-heading">*/
/*         <div class="row">*/
/*             <div class="col-xs-3">*/
/*                 <i class="fa fa-database fa-5x"></i>*/
/*             </div>*/
/*             <div class="col-xs-9 text-right">*/
/*                 <div class="huge">Backups</div>*/
/*                 <div>Backups count: {{ view_model.backups_count }} (#TODO)</div>*/
/*                 <div>Last backup date: {{ view_model.backups_last_date }} (#TODO)</div>*/
/*             </div>*/
/*         </div>*/
/*         <div class="row">*/
/*             <div class="col-xs-12">*/
/*                 <a href="{{ path('admin_backup_process') }}" style="color: #FFF;" title="Create backup"><i class="fa fa-plus"></i>  Create backup</a><br />*/
/*                 <a href="#" style="color: #FFF;" title="Download latest backup file"><i class="fa fa-download"></i> Download latest (#TODO)</a>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/*     <a href="{{ path('admin_backup') }}">*/
/*         <div class="panel-footer">*/
/*             <span class="pull-left">All backups</span>*/
/*             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>*/
/*             <div class="clearfix"></div>*/
/*         </div>*/
/*     </a>*/
/* </div>*/
/* */
