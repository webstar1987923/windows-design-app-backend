<?php

/* Admin/Project/index.html.twig */
class __TwigTemplate_e252297932ded06a6b66d5cadc8f2d6909efb3450662dd9d51e48e2c3990573e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("Admin/layout.html.twig", "Admin/Project/index.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "Admin/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_e586d71677370352ebddef12b62fd1d83496e9e2563e23904602684b41192bb2 = $this->env->getExtension("native_profiler");
        $__internal_e586d71677370352ebddef12b62fd1d83496e9e2563e23904602684b41192bb2->enter($__internal_e586d71677370352ebddef12b62fd1d83496e9e2563e23904602684b41192bb2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "Admin/Project/index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_e586d71677370352ebddef12b62fd1d83496e9e2563e23904602684b41192bb2->leave($__internal_e586d71677370352ebddef12b62fd1d83496e9e2563e23904602684b41192bb2_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_8e292ffa8a188600403ac06bcdc9123c93ea2cef22ab4ac1d0bc0f4f5eb695f4 = $this->env->getExtension("native_profiler");
        $__internal_8e292ffa8a188600403ac06bcdc9123c93ea2cef22ab4ac1d0bc0f4f5eb695f4->enter($__internal_8e292ffa8a188600403ac06bcdc9123c93ea2cef22ab4ac1d0bc0f4f5eb695f4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <div class=\"row\">
        <div class=\"col-lg-12\">
            <h1 class=\"page-header\">";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.pages.index", array(), "AppBundle"), "html", null, true);
        echo "
                <small>List</small>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
        <div class=\"col-lg-12\">
            ";
        // line 12
        $this->loadTemplate("::_flash.html.twig", "Admin/Project/index.html.twig", 12)->display($context);
        // line 13
        echo "        </div>
    </div>

    <div class=\"row\">
        <div class=\"col-lg-12\">
            <div class=\"btn-group\">
                <a class=\"btn btn-success\" title=\"Create new project\" href=\"";
        // line 19
        echo $this->env->getExtension('routing')->getPath("admin_projects_create");
        echo "\">
                    <i class=\"glyphicon glyphicon-plus\"></i> ";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("actions.create", array(), "AppBundle"), "html", null, true);
        echo "
                </a>
                <a id=\"btn-clone\" class=\"btn btn-success\" title=\"Create new project from selected\" href=\"";
        // line 22
        echo $this->env->getExtension('routing')->getPath("admin_projects_create");
        echo "\">
                    <i class=\"glyphicon glyphicon-copy\"></i> ";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("actions.clone", array(), "AppBundle"), "html", null, true);
        echo "
                </a>
            </div>
        </div>
    </div>

    <br/>

    <div class=\"row\">
        <div class=\"col-lg-12\">
            <table class=\"records_list table table-striped\">
                <thead>
                <tr>
                    <th>
                        <div class=\"checkbox\">
                            <label>
                                <input type=\"checkbox\" id=\"select_all_projects\"> All
                            </label>
                        </div>
                    </th>
                    <th>";
        // line 43
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.fields.id", array(), "Entities"), "html", null, true);
        echo "</th>
                    <th>";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.fields.client_name", array(), "Entities"), "html", null, true);
        echo "</th>
                    <th>";
        // line 45
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.fields.client_company_name", array(), "Entities"), "html", null, true);
        echo "</th>
                    <th>";
        // line 46
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.fields.client_phone", array(), "Entities"), "html", null, true);
        echo "</th>
                    <th>";
        // line 47
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.fields.client_email", array(), "Entities"), "html", null, true);
        echo "</th>
                    <th>";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.fields.client_address", array(), "Entities"), "html", null, true);
        echo "</th>
                    <th>";
        // line 49
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.fields.project_name", array(), "Entities"), "html", null, true);
        echo "</th>
                    <th>";
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.fields.project_address", array(), "Entities"), "html", null, true);
        echo "</th>
                    <th>Related objects</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id=\"data-list\">
                ";
        // line 56
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["entities"]) ? $context["entities"] : $this->getContext($context, "entities")));
        foreach ($context['_seq'] as $context["_key"] => $context["entity"]) {
            // line 57
            echo "                    <tr>
                        <td>
                            <div class=\"checkbox\">
                                <label>
                                    <input type=\"checkbox\" name=\"selected[]\" value=\"";
            // line 61
            echo twig_escape_filter($this->env, $this->getAttribute($context["entity"], "getId", array(), "method"), "html", null, true);
            echo "\">
                                </label>
                            </div>
                        </td>
                        <td>";
            // line 65
            echo twig_escape_filter($this->env, $this->getAttribute($context["entity"], "getId", array(), "method"), "html", null, true);
            echo "</td>
                        <td>";
            // line 66
            echo twig_escape_filter($this->env, $this->getAttribute($context["entity"], "getClientName", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 67
            echo twig_escape_filter($this->env, $this->getAttribute($context["entity"], "getClientCompanyName", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 68
            echo twig_escape_filter($this->env, $this->getAttribute($context["entity"], "getClientPhone", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 69
            echo twig_escape_filter($this->env, $this->getAttribute($context["entity"], "getClientEmail", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 70
            echo twig_escape_filter($this->env, $this->getAttribute($context["entity"], "getClientAddress", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 71
            echo twig_escape_filter($this->env, $this->getAttribute($context["entity"], "getProjectName", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 72
            echo twig_escape_filter($this->env, $this->getAttribute($context["entity"], "getProjectAddress", array()), "html", null, true);
            echo "</td>
                        <td>
                            <ul class=\"list-inline list-unstyled\">
                                <li>
                                    <a class=\"label label-primary\" href=\"";
            // line 76
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_project_files", array("project_id" => $this->getAttribute($context["entity"], "getId", array(), "method"))), "html", null, true);
            echo "\">
                                        ";
            // line 77
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("projects.fields.files", array(), "Entities"), "html", null, true);
            echo "
                                    </a>
                                </li>
                            </ul>
                        </td>
                        <td class=\"btn-group\" style=\"width: 100px;\">
                            <a class=\"btn btn-success btn-sm\" href=\"";
            // line 83
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_projects_clone", array("id" => $this->getAttribute($context["entity"], "getId", array(), "method"))), "html", null, true);
            echo "\" title=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("actions.clone", array(), "AppBundle"), "html", null, true);
            echo "\">
                                <i class=\"glyphicon glyphicon-copy\"></i>
                            </a>
                            <a class=\"btn btn-warning btn-sm\" href=\"";
            // line 86
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_projects_update", array("id" => $this->getAttribute($context["entity"], "getId", array(), "method"))), "html", null, true);
            echo "\" title=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("actions.edit", array(), "AppBundle"), "html", null, true);
            echo "\">
                                <i class=\"glyphicon glyphicon-pencil\"></i>
                            </a>
                            <a class=\"btn btn-danger btn-sm\" href=\"";
            // line 89
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_projects_delete_confirm", array("id" => $this->getAttribute($context["entity"], "getId", array(), "method"))), "html", null, true);
            echo "\" title=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("actions.delete", array(), "AppBundle"), "html", null, true);
            echo "\">
                                <i class=\"glyphicon glyphicon-remove\"></i>
                            </a>
                        </td>

                    </tr>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['entity'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 96
        echo "                </tbody>
            </table>

            ";
        // line 100
        echo "            ";
        // line 101
        echo "            ";
        // line 102
        echo "            ";
        // line 103
        echo "

        </div>
    </div>


";
        
        $__internal_8e292ffa8a188600403ac06bcdc9123c93ea2cef22ab4ac1d0bc0f4f5eb695f4->leave($__internal_8e292ffa8a188600403ac06bcdc9123c93ea2cef22ab4ac1d0bc0f4f5eb695f4_prof);

    }

    // line 111
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_d069d7bfc6171d9c57bcdd24729bb01108e5a5a185d0f97b109443c411781058 = $this->env->getExtension("native_profiler");
        $__internal_d069d7bfc6171d9c57bcdd24729bb01108e5a5a185d0f97b109443c411781058->enter($__internal_d069d7bfc6171d9c57bcdd24729bb01108e5a5a185d0f97b109443c411781058_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 112
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script src=\"";
        // line 113
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/projects.js"), "html", null, true);
        echo "\"></script>
";
        
        $__internal_d069d7bfc6171d9c57bcdd24729bb01108e5a5a185d0f97b109443c411781058->leave($__internal_d069d7bfc6171d9c57bcdd24729bb01108e5a5a185d0f97b109443c411781058_prof);

    }

    public function getTemplateName()
    {
        return "Admin/Project/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  268 => 113,  263 => 112,  257 => 111,  244 => 103,  242 => 102,  240 => 101,  238 => 100,  233 => 96,  218 => 89,  210 => 86,  202 => 83,  193 => 77,  189 => 76,  182 => 72,  178 => 71,  174 => 70,  170 => 69,  166 => 68,  162 => 67,  158 => 66,  154 => 65,  147 => 61,  141 => 57,  137 => 56,  128 => 50,  124 => 49,  120 => 48,  116 => 47,  112 => 46,  108 => 45,  104 => 44,  100 => 43,  77 => 23,  73 => 22,  68 => 20,  64 => 19,  56 => 13,  54 => 12,  45 => 6,  41 => 4,  35 => 3,  11 => 1,);
    }
}
/* {% extends 'Admin/layout.html.twig' %}*/
/* */
/* {% block content %}*/
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             <h1 class="page-header">{{ 'projects.pages.index' |trans({}, 'AppBundle') }}*/
/*                 <small>List</small>*/
/*             </h1>*/
/*         </div>*/
/*         <!-- /.col-lg-12 -->*/
/*         <div class="col-lg-12">*/
/*             {% include '::_flash.html.twig' %}*/
/*         </div>*/
/*     </div>*/
/* */
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             <div class="btn-group">*/
/*                 <a class="btn btn-success" title="Create new project" href="{{ path('admin_projects_create') }}">*/
/*                     <i class="glyphicon glyphicon-plus"></i> {{ 'actions.create' |trans({}, 'AppBundle') }}*/
/*                 </a>*/
/*                 <a id="btn-clone" class="btn btn-success" title="Create new project from selected" href="{{ path('admin_projects_create') }}">*/
/*                     <i class="glyphicon glyphicon-copy"></i> {{ 'actions.clone' |trans({}, 'AppBundle') }}*/
/*                 </a>*/
/*             </div>*/
/*         </div>*/
/*     </div>*/
/* */
/*     <br/>*/
/* */
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             <table class="records_list table table-striped">*/
/*                 <thead>*/
/*                 <tr>*/
/*                     <th>*/
/*                         <div class="checkbox">*/
/*                             <label>*/
/*                                 <input type="checkbox" id="select_all_projects"> All*/
/*                             </label>*/
/*                         </div>*/
/*                     </th>*/
/*                     <th>{{ 'projects.fields.id' |trans({}, 'Entities') }}</th>*/
/*                     <th>{{ 'projects.fields.client_name' |trans({}, 'Entities') }}</th>*/
/*                     <th>{{ 'projects.fields.client_company_name' |trans({}, 'Entities') }}</th>*/
/*                     <th>{{ 'projects.fields.client_phone' |trans({}, 'Entities') }}</th>*/
/*                     <th>{{ 'projects.fields.client_email' |trans({}, 'Entities') }}</th>*/
/*                     <th>{{ 'projects.fields.client_address' |trans({}, 'Entities') }}</th>*/
/*                     <th>{{ 'projects.fields.project_name' |trans({}, 'Entities') }}</th>*/
/*                     <th>{{ 'projects.fields.project_address' |trans({}, 'Entities') }}</th>*/
/*                     <th>Related objects</th>*/
/*                     <th>Actions</th>*/
/*                 </tr>*/
/*                 </thead>*/
/*                 <tbody id="data-list">*/
/*                 {% for entity in entities %}*/
/*                     <tr>*/
/*                         <td>*/
/*                             <div class="checkbox">*/
/*                                 <label>*/
/*                                     <input type="checkbox" name="selected[]" value="{{ entity.getId() }}">*/
/*                                 </label>*/
/*                             </div>*/
/*                         </td>*/
/*                         <td>{{ entity.getId() }}</td>*/
/*                         <td>{{ entity.getClientName }}</td>*/
/*                         <td>{{ entity.getClientCompanyName }}</td>*/
/*                         <td>{{ entity.getClientPhone }}</td>*/
/*                         <td>{{ entity.getClientEmail }}</td>*/
/*                         <td>{{ entity.getClientAddress }}</td>*/
/*                         <td>{{ entity.getProjectName }}</td>*/
/*                         <td>{{ entity.getProjectAddress }}</td>*/
/*                         <td>*/
/*                             <ul class="list-inline list-unstyled">*/
/*                                 <li>*/
/*                                     <a class="label label-primary" href="{{ path('admin_project_files', {'project_id':entity.getId()} ) }}">*/
/*                                         {{ 'projects.fields.files' |trans({}, 'Entities') }}*/
/*                                     </a>*/
/*                                 </li>*/
/*                             </ul>*/
/*                         </td>*/
/*                         <td class="btn-group" style="width: 100px;">*/
/*                             <a class="btn btn-success btn-sm" href="{{ path('admin_projects_clone', {'id': entity.getId()}) }}" title="{{ 'actions.clone' |trans({}, 'AppBundle') }}">*/
/*                                 <i class="glyphicon glyphicon-copy"></i>*/
/*                             </a>*/
/*                             <a class="btn btn-warning btn-sm" href="{{ path('admin_projects_update', {'id': entity.getId()}) }}" title="{{ 'actions.edit' |trans({}, 'AppBundle') }}">*/
/*                                 <i class="glyphicon glyphicon-pencil"></i>*/
/*                             </a>*/
/*                             <a class="btn btn-danger btn-sm" href="{{ path('admin_projects_delete_confirm', {'id': entity.getId()}) }}" title="{{ 'actions.delete' |trans({}, 'AppBundle') }}">*/
/*                                 <i class="glyphicon glyphicon-remove"></i>*/
/*                             </a>*/
/*                         </td>*/
/* */
/*                     </tr>*/
/*                 {% endfor %}*/
/*                 </tbody>*/
/*             </table>*/
/* */
/*             {#<a href="#" class="btn btn-success">#}*/
/*             {#<i class="glyphicon glyphicon-plus-sign"></i>#}*/
/*             {#{{ 'actions.create' |trans({}, 'AppBundle') }}#}*/
/*             {#</a>#}*/
/* */
/* */
/*         </div>*/
/*     </div>*/
/* */
/* */
/* {% endblock %}*/
/* */
/* {% block javascripts %}*/
/*     {{ parent() }}*/
/*     <script src="{{ asset('js/admin/projects.js') }}"></script>*/
/* {% endblock %}*/
/* */
