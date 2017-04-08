<?php

/* :Admin/include:footer.html.twig */
class __TwigTemplate_5d0784b7077f0d113fd588f7ab1329f6d26fe32d1f5da99ead3116b11d36c75f extends Twig_Template
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
        $__internal_c39c0cb08173e9c9c35687ec41645a31f29854c998146dac9cc3901d47601f4d = $this->env->getExtension("native_profiler");
        $__internal_c39c0cb08173e9c9c35687ec41645a31f29854c998146dac9cc3901d47601f4d->enter($__internal_c39c0cb08173e9c9c35687ec41645a31f29854c998146dac9cc3901d47601f4d_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Admin/include:footer.html.twig"));

        // line 1
        echo "<footer class=\"footer\">
    <div class=\"container-fluid\">
        <div class=\"row\">
            <div class=\"col-lg-8 text-right\">
                <p>
                    <strong>Prossimo.us</strong> running on Symfony ";
        // line 6
        echo twig_escape_filter($this->env, twig_constant("Symfony\\Component\\HttpKernel\\Kernel::VERSION"), "html", null, true);
        echo "
                </p>
            </div>
            <div class=\"col-lg-4\">
                <p>
                    &copy; Prossimo LLC<br />
                    ";
        // line 12
        if ((twig_date_converter($this->env) > twig_date_converter($this->env, "2016-01-01T00:00:00"))) {
            echo "2015&ndash;";
        }
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo " All rights reserved
                </p>
            </div>
        </div>
    </div>
</footer>";
        
        $__internal_c39c0cb08173e9c9c35687ec41645a31f29854c998146dac9cc3901d47601f4d->leave($__internal_c39c0cb08173e9c9c35687ec41645a31f29854c998146dac9cc3901d47601f4d_prof);

    }

    public function getTemplateName()
    {
        return ":Admin/include:footer.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 12,  29 => 6,  22 => 1,);
    }
}
/* <footer class="footer">*/
/*     <div class="container-fluid">*/
/*         <div class="row">*/
/*             <div class="col-lg-8 text-right">*/
/*                 <p>*/
/*                     <strong>Prossimo.us</strong> running on Symfony {{ constant('Symfony\\Component\\HttpKernel\\Kernel::VERSION') }}*/
/*                 </p>*/
/*             </div>*/
/*             <div class="col-lg-4">*/
/*                 <p>*/
/*                     &copy; Prossimo LLC<br />*/
/*                     {% if date() > date('2016-01-01T00:00:00') %}2015&ndash;{%  endif %}{{ 'now'|date('Y') }} All rights reserved*/
/*                 </p>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/* </footer>*/
