<?php

/* :Admin/Dashboard/Widgets:files.widget.html.twig */
class __TwigTemplate_c1db8dc7956a6e8efe301558cf6b3f32122430da6cbc9f520a5667f8455cdeaf extends Twig_Template
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
        $__internal_c1c7701d965084ebdd4e1824509338cd6c79910afe9e6377462996723e23a05d = $this->env->getExtension("native_profiler");
        $__internal_c1c7701d965084ebdd4e1824509338cd6c79910afe9e6377462996723e23a05d->enter($__internal_c1c7701d965084ebdd4e1824509338cd6c79910afe9e6377462996723e23a05d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Admin/Dashboard/Widgets:files.widget.html.twig"));

        // line 1
        echo "<div class=\"panel panel-default\">
    <div class=\"panel-heading\">
        <div class=\"row\">
            <div class=\"col-xs-3\">
                <i class=\"fa fa-file fa-5x\"></i>
            </div>
            <div class=\"col-xs-9 text-right\">
                <div class=\"huge\">Files</div>
                <div>Total files count: ";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["view_model"]) ? $context["view_model"] : $this->getContext($context, "view_model")), "files_count", array()), "html", null, true);
        echo "</div>
            </div>
        </div>
    </div>
    <a href=\"";
        // line 13
        echo $this->env->getExtension('routing')->getPath("admin_files");
        echo "\">
        <div class=\"panel-footer\">
            <span class=\"pull-left\">All files</span>
            <span class=\"pull-right\"><i class=\"fa fa-arrow-circle-right\"></i></span>
            <div class=\"clearfix\"></div>
        </div>
    </a>
</div>
";
        
        $__internal_c1c7701d965084ebdd4e1824509338cd6c79910afe9e6377462996723e23a05d->leave($__internal_c1c7701d965084ebdd4e1824509338cd6c79910afe9e6377462996723e23a05d_prof);

    }

    public function getTemplateName()
    {
        return ":Admin/Dashboard/Widgets:files.widget.html.twig";
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
/*                 <i class="fa fa-file fa-5x"></i>*/
/*             </div>*/
/*             <div class="col-xs-9 text-right">*/
/*                 <div class="huge">Files</div>*/
/*                 <div>Total files count: {{ view_model.files_count }}</div>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/*     <a href="{{ path('admin_files') }}">*/
/*         <div class="panel-footer">*/
/*             <span class="pull-left">All files</span>*/
/*             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>*/
/*             <div class="clearfix"></div>*/
/*         </div>*/
/*     </a>*/
/* </div>*/
/* */
