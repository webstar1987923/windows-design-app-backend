<?php

/* :Admin/Settings:thumbnails.html.twig */
class __TwigTemplate_bdbdd555fb90c80bd6c97d885cacb2b85e83e4e94be8214e00ce0a2af1a45304 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate(":Admin:layout.html.twig", ":Admin/Settings:thumbnails.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return ":Admin:layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_cdf980b5056c01388c3d704fff1e42ab8af2caf1cdaef5e15ce863b8862db81a = $this->env->getExtension("native_profiler");
        $__internal_cdf980b5056c01388c3d704fff1e42ab8af2caf1cdaef5e15ce863b8862db81a->enter($__internal_cdf980b5056c01388c3d704fff1e42ab8af2caf1cdaef5e15ce863b8862db81a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Admin/Settings:thumbnails.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_cdf980b5056c01388c3d704fff1e42ab8af2caf1cdaef5e15ce863b8862db81a->leave($__internal_cdf980b5056c01388c3d704fff1e42ab8af2caf1cdaef5e15ce863b8862db81a_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_ed708ff06893e56c2ee0a32cd51d1af38fd3302db82d8be98caf50a837ae1c0a = $this->env->getExtension("native_profiler");
        $__internal_ed708ff06893e56c2ee0a32cd51d1af38fd3302db82d8be98caf50a837ae1c0a->enter($__internal_ed708ff06893e56c2ee0a32cd51d1af38fd3302db82d8be98caf50a837ae1c0a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <div class=\"row\">
        <div class=\"col-lg-12\">
            <h1 class=\"page-header\">Settings
                <small>";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("setting.pages.thumbnails", array(), "AppBundle"), "html", null, true);
        echo "</small>
            </h1>
        </div>
        <!-- /.col-lg-12 -->

        <div class=\"col-lg-12\">
            ";
        // line 13
        $this->loadTemplate("::_flash.html.twig", ":Admin/Settings:thumbnails.html.twig", 13)->display($context);
        // line 14
        echo "        </div>
    </div>


    <div class=\"row\">
        <div class=\"col-lg-12\">
            ";
        // line 20
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "
        </div>
    </div>
";
        
        $__internal_ed708ff06893e56c2ee0a32cd51d1af38fd3302db82d8be98caf50a837ae1c0a->leave($__internal_ed708ff06893e56c2ee0a32cd51d1af38fd3302db82d8be98caf50a837ae1c0a_prof);

    }

    // line 25
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_6e2d7780db7d7906957efd0605f6aadff41c1fe34d783c8361a4ffef941c84e9 = $this->env->getExtension("native_profiler");
        $__internal_6e2d7780db7d7906957efd0605f6aadff41c1fe34d783c8361a4ffef941c84e9->enter($__internal_6e2d7780db7d7906957efd0605f6aadff41c1fe34d783c8361a4ffef941c84e9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 26
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script>
        \$(document).ready(function () {
            var \$widthInput = \$('.thumbnail-width');
            var \$saveRatioSelect = \$('.save-ratio-select');

            toggleWidthInputState();
            \$saveRatioSelect.on('change', function () {
                toggleWidthInputState();
            });

            function toggleWidthInputState() {
                parseInt(\$saveRatioSelect.val()) ?
                        \$widthInput.attr('disabled', true) :
                        \$widthInput.attr('disabled', false);
            }
        });
    </script>
";
        
        $__internal_6e2d7780db7d7906957efd0605f6aadff41c1fe34d783c8361a4ffef941c84e9->leave($__internal_6e2d7780db7d7906957efd0605f6aadff41c1fe34d783c8361a4ffef941c84e9_prof);

    }

    public function getTemplateName()
    {
        return ":Admin/Settings:thumbnails.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 26,  76 => 25,  65 => 20,  57 => 14,  55 => 13,  46 => 7,  41 => 4,  35 => 3,  11 => 1,);
    }
}
/* {% extends ':Admin:layout.html.twig' %}*/
/* */
/* {% block content %}*/
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             <h1 class="page-header">Settings*/
/*                 <small>{{ 'setting.pages.thumbnails' |trans({}, 'AppBundle') }}</small>*/
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
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             {{ form(form) }}*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
/* */
/* {% block javascripts %}*/
/*     {{ parent() }}*/
/*     <script>*/
/*         $(document).ready(function () {*/
/*             var $widthInput = $('.thumbnail-width');*/
/*             var $saveRatioSelect = $('.save-ratio-select');*/
/* */
/*             toggleWidthInputState();*/
/*             $saveRatioSelect.on('change', function () {*/
/*                 toggleWidthInputState();*/
/*             });*/
/* */
/*             function toggleWidthInputState() {*/
/*                 parseInt($saveRatioSelect.val()) ?*/
/*                         $widthInput.attr('disabled', true) :*/
/*                         $widthInput.attr('disabled', false);*/
/*             }*/
/*         });*/
/*     </script>*/
/* {% endblock %}*/
