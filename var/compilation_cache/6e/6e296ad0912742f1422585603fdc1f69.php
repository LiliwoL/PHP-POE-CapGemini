<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* stagiaire/list.html.twig */
class __TwigTemplate_591e252d39f03d40caf46b8e1cd98745 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $this->loadTemplate("_header.html.twig", "stagiaire/list.html.twig", 1)->display($context);
        // line 2
        echo "
<h1>La liste des stagiaires</h1>
<table class=\"table\">
    <thead>
        <tr>
        <th scope=\"col\">#</th>
        <th scope=\"col\">Nom</th>
        </tr>
    </thead>
    <tbody>
        ";
        // line 13
        echo "
        ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["stagiaires"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["stagiaire"]) {
            // line 15
            echo "            <tr>
                <th scope=\"row\">
                    ";
            // line 17
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stagiaire"], "identifiant", [], "any", false, false, false, 17), "html", null, true);
            echo "
                </th>
                <td>
                    ";
            // line 20
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["stagiaire"], "nom", [], "any", false, false, false, 20), "html", null, true);
            echo "
                </td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['stagiaire'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo "  </tbody>
</table>

";
        // line 27
        $this->loadTemplate("_footer.html.twig", "stagiaire/list.html.twig", 27)->display($context);
    }

    public function getTemplateName()
    {
        return "stagiaire/list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  83 => 27,  78 => 24,  68 => 20,  62 => 17,  58 => 15,  54 => 14,  51 => 13,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stagiaire/list.html.twig", "/var/www/html/ENI_PHP/templates/stagiaire/list.html.twig");
    }
}
